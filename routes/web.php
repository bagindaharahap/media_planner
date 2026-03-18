<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\NoteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Dasbor Utama
Route::get('/', function () {
    $plannings = \App\Models\Planning::all();
    return view('dashboard', compact('plannings'));
});

Route::get('/dashboard', function () {
    $plannings = \App\Models\Planning::all();
    return view('dashboard', compact('plannings'));
})->name('dashboard');

// Halaman Kalender & Notes
Route::get('/calendar', function () {
    // Fetch plannings data same as board planning
    $plannings = \App\Models\Planning::all();
    return view('calendernotes.calendernotesindex', compact('plannings'));
})->name('calendar.index');

// Route untuk melihat & mengedit notes
Route::get('/calendar/notes/{note}', [NoteController::class, 'show'])->name('calendar.notes.show');
Route::get('/calendar/notes/{note}/edit', [NoteController::class, 'edit'])->name('calendar.notes.edit');

// ---------------------------------------------------------
// ROUTE UNTUK BOARD PLANNING (Gunakan Controller Semua)
// ---------------------------------------------------------
Route::get('/board-planning', [PlanningController::class, 'index'])->name('board.index');
Route::post('/board-planning', [PlanningController::class, 'store'])->name('board.store');
Route::put('/board-planning/{id}', [PlanningController::class, 'update'])->name('board.update');
Route::delete('/board-planning/{id}', [PlanningController::class, 'destroy'])->name('board.destroy');

// CATATAN: Route '/board-planning/create' DIHAPUS karena kita menggunakan Modal Pop-up di halaman index.

Route::post('/board-planning/upload-media', [\App\Http\Controllers\PlanningController::class, 'uploadMedia'])->name('board.uploadMedia');



// Pastikan rute ini berada di dalam middleware auth jika aplikasi Anda butuh login
Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');


Route::get('/dashboard', function () {
    $plannings = \App\Models\Planning::all(); // Mengambil semua data dari database
    return view('dashboard', compact('plannings'));
})->name('dashboard');

// **2. Pastikan Board Planning Anda Sudah Terhubung API (Bukan Data Palsu/Dummy)**
// Jika Anda membuka file `board.blade.php`, periksa fungsi `init()` dan tombol *Create*-nya. Jika Anda menemukan kode `this.tasks.push({ ... data simulasi ... })`, itu berarti halaman Board Anda **masih menggunakan data dummy yang tidak disimpan ke MySQL**.

// Anda harus mengubah fungsi simpan di file *board* agar menggunakan fungsi `fetch()` ke rute Laravel (seperti `POST /api/plannings`), persis seperti yang kita terapkan saat membuat halaman Kalender kemarin. Jika data sudah sukses masuk ke database MySQL, otomatis Dasbor Anda akan langsung membacanya!
