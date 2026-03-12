    <?php

    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    */

    // Halaman Dasbor Utama
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // Halaman Board Planning
    Route::get('/board-planning', function () {
    return view('boardplanning.indexboard'); 
    })->name('board.index');
    // Route untuk create planning
    Route::get('/board-planning/create', function () {
        return view('boardplanning/createplanning');
    })->name('board.create');

    Route::get('/calendar', function () {
        return view('calendernotes/calendernotesindex');
    })->name('calendar.index');