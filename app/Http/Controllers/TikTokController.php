<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class TikTokController extends Controller
{
    /**
     * Langkah 1: Redirect ke TikTok Auth Page
     */
    public function redirectToTikTok()
    {
        $clientKey = config('services.tiktok.client_key');
        $redirectUri = urlencode(route('tiktok.callback')); // Harus sama dengan yang didaftarkan di TikTok Portal
        $csrfState = Str::random(16); // Untuk keamanan
        
        // Simpan state di session untuk divalidasi nanti
        session(['tiktok_oauth_state' => $csrfState]);

        // URL Login Resmi TikTok
        $url = "https://www.tiktok.com/v2/auth/authorize/" .
               "?client_key={$clientKey}" .
               "&scope=user.info.basic,video.list,video.publish" .
               "&response_type=code" .
               "&redirect_uri={$redirectUri}" .
               "&state={$csrfState}";

        return redirect($url);
    }

    /**
     * Langkah 2: Menangani data yang dikirim balik oleh TikTok
     */
    public function handleCallback(Request $request)
    {
        // Validasi state untuk mencegah serangan CSRF
        if ($request->state !== session('tiktok_oauth_state')) {
            return redirect()->route('tiktok.index')->withErrors(['msg' => 'Invalid state.']);
        }

        $code = $request->code;

        // Tukar 'code' dengan 'access_token'
        $response = Http::asForm()->post('https://open.tiktokapis.com/v2/oauth/token/', [
            'client_key'    => config('services.tiktok.client_key'),
            'client_secret' => config('services.tiktok.client_secret'),
            'code'          => $code,
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => route('tiktok.callback'),
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $accessToken = $data['access_token'];
            
            // SIMPAN TOKEN DI SINI:
            // Anda bisa simpan ke database atau file .env untuk digunakan semua karyawan
            // Contoh: \App\Models\Setting::updateOrCreate(['key' => 'tiktok_token'], ['value' => $accessToken]);

            return redirect()->route('tiktok.index')->with('success', 'TikTok account connected successfully!');
        }

        return redirect()->route('tiktok.index')->withErrors(['msg' => 'Failed to retrieve access token.']);
    }
}