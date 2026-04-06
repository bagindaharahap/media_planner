<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PromptNoteController;
use App\Http\Controllers\LogController;
// PERBAIKAN: Tambahkan baris import ini agar Laravel mengenali TikTokController
use App\Http\Controllers\TikTokController;
use App\Http\Controllers\InstagramController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// AUTHENTICATION & PUBLIC ROUTES (Bebas Akses / Tanpa Login)
// ==========================================
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);


// ==========================================
// Halaman Terms, Privacy, dan Login Cepat (Harus diluar middleware auth)
// ==========================================
Route::get('/login-as/{id}', [AuthController::class, 'loginAsUser'])->name('login.as');
Route::get('/terms-conditions', function() { return view('terms'); })->name('terms');
Route::get('/privacy-policy', function() { return view('privacy'); })->name('privacy');


// ==========================================
// PROTECTED ROUTES (Wajib Login)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // Logout sebaiknya di dalam middleware karena butuh sesi aktif
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', function () {
        $plannings = \App\Models\Planning::all();

        // Ambil data Instagram dari API
        $instagramData = null;
        $accessToken = env('INSTAGRAM_ACCESS_TOKEN');
        $userId = env('INSTAGRAM_USER_ID');

        if (!empty($accessToken) && !empty($userId)) {
            try {
                $baseUrl = 'https://graph.instagram.com/';

                // Ambil profil dasar
                $profileResponse = \Illuminate\Support\Facades\Http::get("{$baseUrl}{$userId}", [
                    'fields' => 'id,username,account_type,media_count,followers_count,follows_count',
                    'access_token' => $accessToken
                ]);

                if ($profileResponse->successful()) {
                    $instagramData = $profileResponse->json();
                }

                // Ambil data media untuk engagement
                $mediaResponse = \Illuminate\Support\Facades\Http::get("{$baseUrl}{$userId}/media", [
                    'fields' => 'id,like_count,comments_count',
                    'limit' => 10,
                    'access_token' => $accessToken
                ]);

                if ($mediaResponse->successful()) {
                    $mediaData = $mediaResponse->json()['data'] ?? [];
                    $totalLikes = 0;
                    $totalComments = 0;
                    $totalPosts = count($mediaData);

                    foreach ($mediaData as $post) {
                        $totalLikes += $post['like_count'] ?? 0;
                        $totalComments += $post['comments_count'] ?? 0;
                    }

                    $instagramData['total_likes'] = $totalLikes;
                    $instagramData['total_comments'] = $totalComments;
                    $instagramData['total_posts'] = $totalPosts;
                    $instagramData['engagement_rate'] = $totalPosts > 0 ? round((($totalLikes + $totalComments) / $totalPosts) * 100, 2) : 0;
                }
            } catch (\Exception $e) {
                // Jika error, tetap lanjutkan tanpa data Instagram
            }
        }

        return view('dashboard', compact('plannings', 'instagramData'));
    })->name('dashboard');

    // ==========================================
    // BOARD PLANNING ROUTES
    // ==========================================
    Route::get('/board-planning', [PlanningController::class, 'index'])->name('board.index');
    Route::post('/board-planning', [PlanningController::class, 'store'])->name('board.store');
    Route::put('/board-planning/{id}', [PlanningController::class, 'update'])->name('board.update');
    Route::delete('/board-planning/{id}', [PlanningController::class, 'destroy'])->name('board.destroy');
    Route::post('/board-planning/upload-media', [PlanningController::class, 'uploadMedia'])->name('board.uploadMedia');

    // ==========================================
    // CALENDAR & NOTES ROUTES
    // ==========================================
    Route::get('/calendar', [PlanningController::class, 'calendar'])->name('calendar.index');
    
    Route::get('/calendar/notes/{note}', [NoteController::class, 'show'])->name('calendar.notes.show');
    Route::get('/calendar/notes/{note}/edit', [NoteController::class, 'edit'])->name('calendar.notes.edit');
    
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');

    // ==========================================
    // PROMPT NOTES ROUTES (Terintegrasi Database)
    // ==========================================
    Route::get('/prompt-notes', [PromptNoteController::class, 'index'])->name('prompt.index');
    Route::post('/prompt-notes', [PromptNoteController::class, 'store'])->name('prompt.store');
    Route::put('/prompt-notes/{id}', [PromptNoteController::class, 'update'])->name('prompt.update');
    Route::delete('/prompt-notes/{id}', [PromptNoteController::class, 'destroy'])->name('prompt.destroy');

    // ==========================================
    // LOGS ACTIVITY (Semua user yang login)
    // ==========================================
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');

    // ==========================================
    // MONITORING MEDIA SOSIAL (Instagram & TikTok)
    // ==========================================
    Route::get('/instagram', [InstagramController::class, 'index'])->name('instagram.index');

    Route::get('/tiktok', function () {
        return view('akun.tiktok');
    })->name('tiktok.index');

    // Rute Koneksi TikTok
    Route::get('/tiktok/connect', [TikTokController::class, 'redirectToTikTok'])->name('tiktok.connect');
    Route::get('/tiktok/callback', [TikTokController::class, 'handleCallback'])->name('tiktok.callback');

    Route::get('/instagram-monitoring', [InstagramController::class, 'index'])->name('instagram.monitoring');
    Route::get('/api/instagram-data', [InstagramController::class, 'getApiData'])->name('instagram.data');

    Route::get('/social-manage', function () {
        return view('akun.manage');
    })->name('manage.index');

    // ==========================================
    // USER MANAGEMENT ROUTES (Admin Only)
    // ==========================================
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/management-akun', [UserController::class, 'index'])->name('users.index');
        Route::post('/management-akun', [UserController::class, 'store'])->name('users.store');
        Route::put('/management-akun/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/management-akun/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

});