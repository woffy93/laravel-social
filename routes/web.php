<?php

use App\Http\Controllers\LikeController;
use App\Http\Controllers\LinkController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/follow/{user}', [ProfileController::class, 'follow'])->name('follow');
    Route::delete('/unfollow/{user}', [ProfileController::class, 'unfollow'])->name('unfollow');
});
Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');


Route::middleware('auth')->group(function () {
    Route::post('like', [LikeController::class, 'like'])->name('like');
    Route::delete('like', [LikeController::class, 'removeLike'])->name('removeLike');
});
Route::get('/links/create', [LinkController::class, 'create'])->name('links.create')->middleware('auth');

Route::get('/links/create', [LinkController::class, 'create'])->name('links.create')->middleware('auth');
Route::get('/links', [LinkController::class, 'index'])->name('links.index');
Route::get('/links/favorites', [LinkController::class, 'indexFavorites'])->name('links.favorites');
Route::get('/links/{link}', [LinkController::class, 'show'])->name('links.show');
Route::post('/links', [LinkController::class, 'store'])->name('links.store')->middleware('auth');

require __DIR__.'/auth.php';
