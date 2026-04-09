<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Services\ActivityLogger;

class TikTokController extends Controller
{
    /**
     * Menampilkan Dashboard TikTok
     */
    public function index(Request $request)
    {
        $accessToken = Cache::get('tiktok_access_token');
        $tiktokProfile = null;
        $videoCount = 'N/A';
        $errorMessage = null;
        $connected = false;

        if ($accessToken) {
            try {
                // SANGAT PENTING: Hanya minta 3 field dasar ini dulu agar dijamin berhasil
                $fieldsParam = 'open_id,avatar_url,display_name';

                $profileResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken
                ])->get('https://open.tiktokapis.com/v2/user/info/', [
                    'fields' => $fieldsParam
                ]);

                $profileData = $profileResponse->json();

                // Cek jika API merespon sukses dan data user ada
                if ($profileResponse->successful() && isset($profileData['data']['user'])) {
                    $user = $profileData['data']['user'];
                    
                    // Map data dasar
                    $tiktokProfile = [
                        'display_name'   => $user['display_name'] ?? 'TikTok User',
                        'avatar'         => $user['avatar_url'] ?? null,
                        'open_id'        => $user['open_id'] ?? null,
                        
                        // Set statis karena kita belum menggunakan scope stats
                        'follower_count' => 'Butuh Izin',
                        'heart_count'    => 'Butuh Izin',
                        'video_count'    => 'Butuh Izin',
                    ];

                    $connected = true;
                } else {
                    $errorMessage = $profileData['error']['message'] ?? 'Sesi kedaluwarsa atau gagal mengambil data profil TikTok.';
                    if (isset($profileData['error']['code'])) {
                        Cache::forget('tiktok_access_token');
                        $connected = false;
                    }
                }
            } catch (\Exception $e) {
                $errorMessage = 'Koneksi ke server TikTok gagal: ' . $e->getMessage();
            }
        }

        return view('akun.tiktok', compact('tiktokProfile', 'connected', 'videoCount', 'errorMessage'));
    }

    /**
     * Langkah 1: Redirect request to TikTok's authorization server
     */
    public function redirectToTikTok()
    {
        // Langsung tembak ke env() untuk menghindari error jika config/services.php belum diatur
        $clientKey = env('TIKTOK_CLIENT_KEY'); 
        $redirectUri = route('tiktok.callback'); 
        
        $csrfState = Str::random(30); 
        session(['tiktok_oauth_state' => $csrfState]);

        // Pastikan hanya scope ini yang dipanggil
        $scopes = 'user.info.basic';

        $url = "https://www.tiktok.com/v2/auth/authorize/" .
               "?client_key={$clientKey}" .
               "&scope={$scopes}" .
               "&response_type=code" .
               "&redirect_uri=" . urlencode($redirectUri) .
               "&state={$csrfState}";

        return redirect($url);
    }

    /**
     * Langkah 2: Manage authorization response & Manage access token
     */
    public function handleCallback(Request $request)
    {
        if ($request->has('error')) {
            $errorDesc = $request->error_description ?? 'Akses ditolak atau dibatalkan oleh pengguna.';
            return redirect()->route('tiktok.index')->withErrors(['msg' => 'TikTok Auth Error: ' . $errorDesc]);
        }

        $savedState = session('tiktok_oauth_state');
        if (!$request->state || $request->state !== $savedState) {
            return redirect()->route('tiktok.index')->withErrors(['msg' => 'Peringatan Keamanan: State tidak cocok (Mencegah CSRF attack).']);
        }

        $code = $request->code;

        if (!$code) {
            return redirect()->route('tiktok.index')->withErrors(['msg' => 'Gagal mendapatkan Authorization Code dari TikTok.']);
        }

        try {
            // Langsung tembak ke env() untuk client_key dan client_secret
            $response = Http::asForm()->post('https://open.tiktokapis.com/v2/oauth/token/', [
                'client_key'    => env('TIKTOK_CLIENT_KEY'),
                'client_secret' => env('TIKTOK_CLIENT_SECRET'),
                'code'          => $code,
                'grant_type'    => 'authorization_code',
                'redirect_uri'  => route('tiktok.callback'),
            ]);

            $data = $response->json();

            if ($response->successful() && isset($data['access_token'])) {
                
                Cache::forever('tiktok_access_token', $data['access_token']);

                if (isset($data['refresh_token'])) {
                    Cache::forever('tiktok_refresh_token', $data['refresh_token']);
                }

                if (class_exists(ActivityLogger::class)) {
                    ActivityLogger::log('Auth', 'tiktok_connect', 'Berhasil menghubungkan API TikTok.');
                }

                return redirect()->route('tiktok.index')->with('success', 'Koneksi TikTok Berhasil! Data profil berhasil ditarik.');
            } else {
                $errorDetail = $data['error_description'] ?? ($data['message'] ?? 'Gagal menukar token.');
                return redirect()->route('tiktok.index')->withErrors(['msg' => 'API TikTok Error: ' . $errorDetail]);
            }

        } catch (\Exception $e) {
            return redirect()->route('tiktok.index')->withErrors(['msg' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }
    
    public function disconnect()
    {
        Cache::forget('tiktok_access_token');
        Cache::forget('tiktok_refresh_token');
        
        if (class_exists(ActivityLogger::class)) {
            ActivityLogger::log('Auth', 'tiktok_disconnect', 'Memutuskan koneksi API TikTok.');
        }
        
        return redirect()->route('tiktok.index')->with('success', 'Akun TikTok berhasil diputuskan.');
    }
}