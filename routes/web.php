<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route untuk halaman login
Route::get('/login', function () {
    return view('login.index', [
        "active" => "beranda",
        "title" => "Login",
    ]);
})->name('login')->middleware('guest');

// Route untuk memproses login
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');

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
    });

    Route::get('/peminjaman', function () {
        return view('peminjaman.index', [
            "active" => "peminjaman",
            "title" => "Peminjaman",
        ]);
    });
});
