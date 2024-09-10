<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard.index',[
        "active" => "dashboard",
        "title" => "Dashboard",
    ]);
});

Route::get('/peminjaman', function () {
    return view('peminjaman.index',[
        "active" => "peminjaman",
        "title" => "Peminjaman",
    ]);
});