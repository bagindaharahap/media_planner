<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InstagramController extends Controller
{
    /**
     * Menampilkan halaman dashboard Instagram
     */
    public function index()
    {
        $accessToken = env('INSTAGRAM_ACCESS_TOKEN');
        $userId = env('INSTAGRAM_USER_ID');
        $baseUrl = 'https://graph.instagram.com/';

        $profileData = null;
        $mediaData = [];
        $apiError = null;

        if (empty($accessToken) || empty($userId)) {
            $apiError = 'Token atau User ID Instagram belum dikonfigurasi di .env';
        } else {
            try {
                // 1. Ambil Profil Dasar
                $profileResponse = Http::get("{$baseUrl}{$userId}", [
                    'fields' => 'id,username,account_type,media_count',
                    'access_token' => $accessToken
                ]);

                if ($profileResponse->successful()) {
                    $profileData = $profileResponse->json();
                } else {
                    $apiError = $profileResponse->json('error.message') ?? 'Gagal mengambil profil dari Instagram.';
                }

                // 2. Ambil Postingan Media (Reels & Feed)
                $mediaResponse = Http::get("{$baseUrl}{$userId}/media", [
                    'fields' => 'id,caption,media_type,media_url,thumbnail_url,permalink,timestamp',
                    'limit' => 8,
                    'access_token' => $accessToken
                ]);

                if ($mediaResponse->successful()) {
                    $mediaData = $mediaResponse->json()['data'] ?? [];
                }
            } catch (\Exception $e) {
                Log::error("Instagram Fetch Error: " . $e->getMessage());
                $apiError = "Terjadi kesalahan jaringan saat menghubungi API Instagram.";
            }
        }

        return view('instagram-monitoring', compact('profileData', 'mediaData', 'apiError'));
    }

    /**
     * Mengambil data dari Instagram Graph API
     * Endpoint ini akan dipanggil oleh JavaScript di frontend (AJAX)
     */
    public function getApiData()
    {
        $accessToken = env('INSTAGRAM_ACCESS_TOKEN');
        $userId = env('INSTAGRAM_USER_ID');
        $baseUrl = 'https://graph.instagram.com/';

        // Validasi konfigurasi .env
        if (empty($accessToken) || empty($userId)) {
            return response()->json([
                'success' => false,
                'message' => 'Konfigurasi INSTAGRAM_ACCESS_TOKEN atau INSTAGRAM_USER_ID belum diatur di .env'
            ], 500);
        }

        try {
            // 1. Request Data Profil Pengguna
            $profileResponse = Http::get("{$baseUrl}{$userId}", [
                'fields' => 'id,username,account_type,media_count',
                'access_token' => $accessToken
            ]);

            if ($profileResponse->failed()) {
                // Log error untuk keperluan debugging backend
                Log::error('Instagram API Profile Error: ' . $profileResponse->body());
                throw new \Exception('Gagal mengambil data profil dari Instagram.');
            }

            $profileData = $profileResponse->json();

            // 2. Request Data Media (Postingan & Reels)
            $mediaResponse = Http::get("{$baseUrl}{$userId}/media", [
                'fields' => 'id,caption,media_type,media_url,thumbnail_url,permalink,timestamp',
                'limit' => 8,
                'access_token' => $accessToken
            ]);

            if ($mediaResponse->failed()) {
                Log::error('Instagram API Media Error: ' . $mediaResponse->body());
                throw new \Exception('Gagal mengambil data media dari Instagram.');
            }

            $mediaData = $mediaResponse->json();

            // 3. Kembalikan data sukses ke frontend
            return response()->json([
                'success' => true,
                'profile' => $profileData,
                'media' => $mediaData['data'] ?? []
            ]);

        } catch (\Exception $e) {
            // Tangkap dan kembalikan pesan error
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}