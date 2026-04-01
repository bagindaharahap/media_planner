<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PromptNoteController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\TikTokController;
use App\Http\Controllers\InstagramController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// AUTHENTICATION & PUBLIC ROUTES
// ==========================================
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/login-as/{id}', [AuthController::class, 'loginAsUser'])->name('login.as');
Route::get('/terms-conditions', function() { return view('terms'); })->name('terms');
Route::get('/privacy-policy', function() { return view('privacy'); })->name('privacy');

// ==========================================
// PROTECTED ROUTES (Wajib Login)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', function () {
        $plannings = \App\Models\Planning::all();
        return view('dashboard', compact('plannings'));
    })->name('dashboard');

    // BOARD PLANNING
    Route::get('/board-planning', [PlanningController::class, 'index'])->name('board.index');
    Route::post('/board-planning', [PlanningController::class, 'store'])->name('board.store');
    Route::put('/board-planning/{id}', [PlanningController::class, 'update'])->name('board.update');
    Route::delete('/board-planning/{id}', [PlanningController::class, 'destroy'])->name('board.destroy');

    // CALENDAR & NOTES
    Route::get('/calendar', [PlanningController::class, 'calendar'])->name('calendar.index');
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');

    // PROMPT NOTES
    Route::get('/prompt-notes', [PromptNoteController::class, 'index'])->name('prompt.index');
    Route::post('/prompt-notes', [PromptNoteController::class, 'store'])->name('prompt.store');
    Route::put('/prompt-notes/{id}', [PromptNoteController::class, 'update'])->name('prompt.update');
    Route::delete('/prompt-notes/{id}', [PromptNoteController::class, 'destroy'])->name('prompt.destroy');

    // LOGS
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');

    // MONITORING
    Route::get('/instagram', function () {
        return view('akun.instagram');
    })->name('instagram.index');

    Route::get('/tiktok', function () {
        return view('akun.tiktok');
    })->name('tiktok.index');

    // MANAJEMEN INTEGRASI
    Route::get('/social-manage', function () {
        return view('akun.manage');
    })->name('manage.index');

    // TIKTOK OAUTH
    Route::get('/tiktok/connect', [TikTokController::class, 'redirectToTikTok'])->name('tiktok.connect');
    Route::get('/tiktok/callback', [TikTokController::class, 'handleCallback'])->name('tiktok.callback');

    // INSTAGRAM / META OAUTH
    Route::get('/instagram/connect', [InstagramController::class, 'redirectToMeta'])->name('instagram.connect');
    Route::get('/instagram/callback', [InstagramController::class, 'handleCallback'])->name('instagram.callback');

    // USER MANAGEMENT (Admin Only)
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/management-akun', [UserController::class, 'index'])->name('users.index');
    });
});