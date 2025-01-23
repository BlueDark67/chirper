<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('/chirps', ChirpController::class)
    ->only(['index','store', 'edit','update', 'destroy'])
    ->middleware(['auth','verified']);

Route::post('chirps/{chirp}/like', [ChirpController::class, 'like'])->name('chirps.like');
Route::delete('chirps/{chirp}/unlike', [ChirpController::class, 'unlike'])->name('chirps.unlike');


Route::post('/users/{user}/follow', [UserController::class, 'follow'])->name('users.follow');
Route::delete('/users/{user}/unfollow', [UserController::class, 'unfollow'])->name('users.unfollow');
require __DIR__.'/auth.php';
