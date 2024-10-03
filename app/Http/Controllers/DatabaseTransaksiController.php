<?php

namespace App\Http\Controllers;

use App\Services\DatTransGoogleSheetService; // Ubah sesuai nama service baru
use Illuminate\Http\Request;

class DatabaseTransaksiController extends Controller
{
    protected $googleSheetService;

    public function __construct(DatTransGoogleSheetService $googleSheetService) // Nama class service baru
    {
        $this->googleSheetService = $googleSheetService;
    }

    public function index()
    {
        // Mendapatkan data dari Google Sheets
        $dataTransaksi = $this->googleSheetService->getSheetData('DatabaseTransaksi!A4:BX'); // Sesuaikan range data
        
        // Inisialisasi variabel title dan active
        $title = 'Database Transaksi';
        $active = 'database.transaksi';
    
        // Cek apakah data transaksi tersedia
        if (is_array($dataTransaksi) && count($dataTransaksi) > 0) {
            return view('database.transaksi', [
                'data' => ['data_transaksi' => $dataTransaksi],
                'title' => $title,
                'active' => $active
            ]);
        } else {
            return view('database.transaksi', [
                'data' => ['data_transaksi' => []],
                'title' => $title,
                'active' => $active
            ]);
        }
    }
}
