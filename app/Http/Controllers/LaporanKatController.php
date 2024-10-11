<?php

namespace App\Http\Controllers;

use App\Services\LapKatGoogleSheetService;

class LaporanKatController extends Controller
{
    protected $googleSheetService;

    public function __construct(LapKatGoogleSheetService $googleSheetService)
    {
        $this->googleSheetService = $googleSheetService;
    }

    public function index()
    {
        // Mengambil data laporan dari Google Sheets melalui service
        $laporan = $this->googleSheetService->getLaporanData();

        // Mengirim data ke view 'laporan.kategori' bersama dengan variabel 'active' dan 'title'
        return view('laporan.kategori', [
            'active' => 'laporan.kategori',  // Untuk menu yang aktif
            'title' => 'Laporan Kategori',   // Title yang digunakan di view
            'laporan' => $laporan            // Data laporan dari Google Sheets
        ]);
    }
}
