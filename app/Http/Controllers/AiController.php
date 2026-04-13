<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\ActivityLogger;

class AiController extends Controller
{
    /**
     * Memanggil Gemini API untuk membuat caption dan hashtag
     */
    public function generateCaption(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:500'
        ]);

        $apiKey = config('services.gemini.api_key');
        
        if (!$apiKey) {
            return response()->json(['success' => false, 'message' => 'API Key Gemini belum diatur di .env']);
        }

        $systemPrompt = "Kamu adalah Social Media Manager profesional. Buatkan caption sosial media yang menarik, kreatif, dan engaging berdasarkan topik dari user. Berikan juga 5-8 hashtag yang relevan dan viral di akhir. Gunakan gaya bahasa kasual tapi profesional (gunakan emoji secukupnya).";
        $userPrompt = "Topik konten: " . $request->prompt;

        try {
            $cleanApiKey = trim($apiKey);
            
            // PERBAIKAN: Gunakan model gemini-2.5-flash rilis standar resmi
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$cleanApiKey}";
            
            // PERBAIKAN: Tambahkan fungsi retry(3, 2000) untuk mengatasi masalah High Demand sementara
            // Sistem akan mencoba ulang 3 kali dengan jeda 2 detik (2000 ms) jika server Google sibuk
            $response = Http::retry(3, 2000)->withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, [
                'systemInstruction' => [
                    'parts' => [
                        ['text' => $systemPrompt]
                    ]
                ],
                'contents' => [
                    [
                        'role' => 'user', 
                        'parts' => [
                            ['text' => $userPrompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $result = $response->json();
                $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';
                
                // Merapikan format Markdown dari AI ke HTML
                $text = preg_replace('/\*\*(.*?)\*\*/', '<b>$1</b>', $text); 
                $text = preg_replace('/\*(.*?)\*/', '<i>$1</i>', $text);     
                $htmlText = nl2br($text); 

                // Catat Log
                if (class_exists(ActivityLogger::class)) {
                    ActivityLogger::log('Prompt', 'ai_generate', 'Menggunakan AI untuk generate caption: ' . substr($request->prompt, 0, 50));
                }

                return response()->json(['success' => true, 'data' => $htmlText]);
            }

            // Tangkap pesan error dari Google jika gagal
            $errorData = $response->json();
            $googleErrorMessage = $errorData['error']['message'] ?? 'Server Google menolak request.';

            // Ubah pesan error menjadi lebih ramah pengguna jika server sedang High Demand
            if (str_contains(strtolower($googleErrorMessage), 'high demand')) {
                $googleErrorMessage = 'Server AI Google saat ini sedang sangat sibuk (High Demand). Sistem telah mencoba mengulang otomatis namun masih penuh. Silakan tunggu beberapa detik dan coba klik tombol kembali.';
            }

            return response()->json(['success' => false, 'message' => 'Error Google AI: ' . $googleErrorMessage]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Koneksi lokal ke Google AI gagal: ' . $e->getMessage()]);
        }
    }
}