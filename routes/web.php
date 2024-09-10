<?php

use Illuminate\Support\Facades\Route;

// Route untuk halaman login
Route::get('/login', function () {
    return view('login.index', [
        "active" => "beranda",
        "title" => "Login",
    ]);
})->name('login')->middleware('guest');

// Route yang mengharuskan pengguna login terlebih dahulu
Route::middleware(['auth'])->group(function () {
    Route::get('/beranda', function () {
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

// Route fallback untuk mengarahkan ke login jika rute tidak ditemukan
Route::fallback(function () {
    return redirect()->route('login');
});
