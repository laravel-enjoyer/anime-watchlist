<?php

use App\Http\Controllers\AnimeController;
use App\Http\Controllers\AnimeSyncController;
use App\Http\Controllers\PlaylistController;
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
    return redirect(route('animes'));
});

Route::get('/animes', [AnimeController::class, 'index'])->name('animes');
Route::get('/anime/{id}', [AnimeController::class, 'show'])->name('anime.show');

Route::get('/animes/sync', [AnimeSyncController::class, 'sync'])->name('anime.sync');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/playlist', [PlaylistController::class, 'store'])->name('playlist.store');
});

require __DIR__.'/auth.php';
