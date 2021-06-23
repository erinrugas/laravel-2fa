<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\TwoFactorAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticateLogin'])->name('authenticate');

    Route::get('/two-factor-authentication', [TwoFactorAuthController::class, 'index'])->name('two-factor-authentication');
    Route::post('/two-factor-authentication', [TwoFactorAuthController::class, 'validateTwoFactor'])->name('two-factor-authentication.validate');

    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot-password');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'search'])->name('forgot-password.search');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'index'])->name('password.reset');
    Route::put('/reset-password/', [ResetPasswordController::class, 'update'])->name('password.update');
});


Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [UserController::class, 'index'])->name('profile');
    Route::put('/profile', [UserController::class, 'update'])->name('profile.update');
    Route::put('/profile/update-password', [UserController::class, 'updatePassword'])->name('profile.update.password');

    Route::post('/profile/enable-two-factor', [UserController::class, 'enableTwoFactorAuth'])->name('profile.enable-two-factor');
    Route::post('/profile/show-two-factor', [UserController::class, 'showRecoveryCode'])->name('profile.show-recovery-code');
    Route::post('/profile/disable-two-factor', [UserController::class, 'disableTwoFactorAuth'])->name('profile.disable-recovery-code');
    Route::post('/profile/generate-two-factor', [UserController::class, 'generateRecoveryCode'])->name('profile.generate-recovery-code');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
