<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanningController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Dasbor Utama
Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// Halaman Kalender & Notes
Route::get('/calendar', function () {
    return view('calendarnotes.calendarnotesindex'); // pastikan nama folder/file benar (sebelumnya Anda tulis calendernotes)
})->name('calendar.index');

// ---------------------------------------------------------
// ROUTE UNTUK BOARD PLANNING (Gunakan Controller Semua)
// ---------------------------------------------------------
Route::get('/board-planning', [PlanningController::class, 'index'])->name('board.index');
Route::post('/board-planning', [PlanningController::class, 'store'])->name('board.store');
Route::put('/board-planning/{id}', [PlanningController::class, 'update'])->name('board.update');
Route::delete('/board-planning/{id}', [PlanningController::class, 'destroy'])->name('board.destroy');

// CATATAN: Route '/board-planning/create' DIHAPUS karena kita menggunakan Modal Pop-up di halaman index.

Route::post('/board-planning/upload-media', [\App\Http\Controllers\PlanningController::class, 'uploadMedia'])->name('board.uploadMedia');