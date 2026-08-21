<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialLoginController;

// All user routes will be prefixed with /user
Route::group(['prefix' => 'user'], function () {
    require_once __DIR__.'/user.php';
});

require_once __DIR__.'/admin.php';

// Redirect root to /user/home
Route::redirect('/', '/user/home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Social login
Route::get('/auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])->name('social#login');
Route::get('/auth/{provider}/callback', [SocialLoginController::class, 'callBack'])->name('social#callBack');

require __DIR__.'/auth.php';