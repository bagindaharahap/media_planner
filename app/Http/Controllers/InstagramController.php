<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class InstagramController extends Controller
{
    public function redirectToMeta()
    {
        $appId = config('services.meta.client_id');
        $redirectUri = urlencode(route('instagram.callback')); 
        $state = Str::random(16); 
        
        session(['meta_oauth_state' => $state]);

        // URL Login Resmi Meta/Facebook
        $url = "https://www.facebook.com/v19.0/dialog/oauth" .
               "?client_id={$appId}" .
               "&redirect_uri={$redirectUri}" .
               "&state={$state}" .
               "&scope=instagram_basic,instagram_manage_insights,pages_show_list,pages_read_engagement";

        return redirect($url);
    }

    public function handleCallback(Request $request)
    {
        // Validasi state CSRF
        if ($request->state !== session('meta_oauth_state')) {
            return redirect()->route('instagram.index')->withErrors(['msg' => 'State tidak valid.']);
        }

        $code = $request->code;

        // Proses tukar 'code' dengan 'access_token' (Contoh)
        $response = Http::get('https://graph.facebook.com/v19.0/oauth/access_token', [
            'client_id'     => config('services.meta.client_id'),
            'client_secret' => config('services.meta.client_secret'),
            'redirect_uri'  => route('instagram.callback'),
            'code'          => $code,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $accessToken = $data['access_token'];
            
            // Simpan Token Anda di sini
            
            return redirect()->route('instagram.index')->with('success', 'Akun Instagram berhasil dihubungkan!');
        }

        return redirect()->route('instagram.index')->withErrors(['msg' => 'Gagal mendapatkan token akses Meta.']);
    }
}