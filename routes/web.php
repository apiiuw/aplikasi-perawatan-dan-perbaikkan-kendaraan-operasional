<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\IdentitasController;
use App\Http\Controllers\ReferensiController;
use App\Http\Controllers\DatabaseKendaraanController;
use App\Http\Controllers\DatabaseTransaksiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route untuk halaman register
Route::get('/register', function () {
    return view('register.index', [
        "active" => "beranda",
        "title" => "Register",
    ]);
});
Route::post('/register', [RegisterController::class, 'register'])->name('register'); // Route untuk memproses pendaftaran
//

// Route untuk login
Route::get('/login', function () {
    return view('login.index', [
        "active" => "beranda",
        "title" => "Login",
    ]);
})->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest'); // Untuk memproses login
Route::get('/auth/redirect', [LoginController::class, 'redirectToGoogle'])->name('google.login'); // Untuk login dengan Google
Route::get('/auth/callback', [LoginController::class, 'handleGoogleCallback']); // Untuk callback dari Google
//

// Route untuk logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');
//

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

    // Route untuk identitas
    Route::get('/identitas/edit', [IdentitasController::class, 'edit'])->name('identitas.edit');
    Route::put('/identitas/update', [IdentitasController::class, 'update'])->name('identitas.update');
    // 

    // Route untuk referensi page
    Route::get('/referensi', [ReferensiController::class, 'index'])->name('referensi.index');   // Untuk membuka halaman
    Route::post('/referensi/store/{type}', [ReferensiController::class, 'store'])->name('referensi.store'); // Untuk proses tambah data
    Route::post('/referensi/update/{type}/{rowIndex}', [ReferensiController::class, 'update'])->name('referensi.update');   // Untuk proses update data
    Route::delete('/referensi/destroy/{type}/{rowIndex}', [ReferensiController::class, 'destroy'])->name('referensi.destroy');  // Untuk proses hapus data
    // 

    // Route untuk laporan kategori
    Route::get('/laporan/kategori', function () {
        return view('laporan.kategori', [
            "active" => "laporan.kategori",
            "title" => "Laporan Kategori",
        ]);
    });
    //

    // Route untuk laporan transaksi
    Route::get('/laporan/transaksi', function () {
        return view('laporan.transaksi', [
            "active" => "laporan.transaksi",
            "title" => "Laporan Transaksi",
        ]);
    });
    //

    // Route untuk database kendaraan
    Route::get('/database/kendaraan', [DatabaseKendaraanController::class, 'index'])->name('database.kendaraan');   // Untuk membuka halaman
    Route::post('/database/kendaraan/update/{type}/{rowIndex}', [DatabaseKendaraanController::class, 'update'])->name('databaseKendaraan.update');  // Untuk proses update data
    Route::delete('/database/kendaraan/destroy/{type}/{rowIndex}', [DatabaseKendaraanController::class, 'destroy'])->name('databaseKendaraan.destroy'); // Untuk proses hapus data
    //

    // Route untuk database transaksi
    Route::get('/database/transaksi', [DatabaseTransaksiController::class, 'index'])->name('database.transaksi');   // Untuk membuka halaman
    Route::post('/database/transaksi/update/{type}/{rowIndex}', [DatabaseTransaksiController::class, 'update'])->name('databaseTransaksi.update');  // Untuk proses update data
    Route::delete('/database/transaksi/destroy/{type}/{rowIndex}', [DatabaseTransaksiController::class, 'destroy'])->name('databaseTransaksi.destroy'); // Untuk proses hapus data
    //

});
