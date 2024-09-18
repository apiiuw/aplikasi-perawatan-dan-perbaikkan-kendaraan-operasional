<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\IdentitasController;
use App\Http\Controllers\ReferensiController;
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

    Route::get('/identitas', function () {
        return view('identitas.index', [
            "active" => "identitas",
            "title" => "Identitas",
        ]);
    });

    // Route untuk menampilkan form edit identitas
    Route::get('/identitas/edit', [IdentitasController::class, 'edit'])->name('identitas.edit');
    // 

    // Route untuk melakukan update identitas
    Route::put('/identitas/update', [IdentitasController::class, 'update'])->name('identitas.update');
    // 

    Route::get('/referensi', [ReferensiController::class, 'show'])->name('referensi.show')->middleware('auth');

    Route::post('/referensi/update', [ReferensiController::class, 'update'])->name('referensi.update')->middleware('auth');

    Route::post('/referensi/add', [ReferensiController::class, 'add'])->name('referensi.add')->middleware('auth');

    Route::post('/referensi/remove', [ReferensiController::class, 'remove'])->name('referensi.remove');

    Route::get('/laporan/kategori', function () {
        return view('laporan.kategori', [
            "active" => "laporan.kategori",
            "title" => "Laporan Kategori",
        ]);
    });

    Route::get('/laporan/transaksi', function () {
        return view('laporan.transaksi', [
            "active" => "laporan.transaksi",
            "title" => "Laporan Transaksi",
        ]);
    });

    Route::get('/database/kendaraan', function () {
        return view('database.kendaraan', [
            "active" => "database.kendaraan",
            "title" => "Database Kendaraan",
        ]);
    });

    Route::get('/database/transaksi', function () {
        return view('database.transaksi', [
            "active" => "database.transaksi",
            "title" => "Database Transaksi",
        ]);
    });
});
