<?php

use App\Http\Controllers\AnimeUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/animes', [AnimeController::class, 'index'])->name('animes');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/anime/{animeId}/watched', [AnimeUserController::class, 'markAsWatched'])->name('anime.markAsWatched');
    Route::get('/anime/watched', [AnimeUserController::class, 'watchedList'])->name('anime.watchedList');
    Route::get('/anime/backlog', [AnimeUserController::class, 'backlogList'])->name('anime.backlogList');
});

require __DIR__.'/auth.php';
