<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route untuk halaman register
Route::get('/register', function () {
    return view('register.index', [
        "active" => "beranda",
        "title" => "Register",
    ]);
});

// Route untuk memproses pendaftaran
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// Route untuk halaman login
Route::get('/login', function () {
    return view('login.index', [
        "active" => "beranda",
        "title" => "Login",
    ]);
})->name('login')->middleware('guest');

// Route untuk memproses login
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');

// Route untuk login dengan Google
Route::get('/auth/redirect', [LoginController::class, 'redirectToGoogle'])->name('google.login');

// Route untuk callback dari Google
Route::get('/auth/callback', [LoginController::class, 'handleGoogleCallback']);

// Route untuk logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Route yang mengharuskan pengguna login terlebih dahulu
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('beranda.index', [
            "active" => "beranda",
            "title" => "Beranda",
        ]);
    })->name('beranda');

    Route::get('/peminjaman', function () {
        return view('peminjaman.index', [
            "active" => "peminjaman",
            "title" => "Peminjaman",
        ]);
    });
});
