<?php

namespace App\Http\Controllers;

use App\Services\DatKenGoogleSheetService;
use Illuminate\Http\Request;

class DatabaseKendaraanController extends Controller
{
    protected $googleSheetService;

    public function __construct(DatKenGoogleSheetService $googleSheetService)
    {
        $this->googleSheetService = $googleSheetService;
    }

    public function index()
    {
        // Mendapatkan data dari Google Sheets
        $dataKendaraan = $this->googleSheetService->getSheetData('DatabaseKendaraan!A4:AB'); // Sesuaikan range data
        
        // Inisialisasi variabel title dan active
        $title = 'Database Kendaraan';
        $active = 'database.kendaraan';
    
        // Cek apakah data kendaraan tersedia
        if (is_array($dataKendaraan) && count($dataKendaraan) > 0) {
            return view('database.kendaraan', [
                'data' => ['data_kendaraan' => $dataKendaraan],
                'title' => $title,
                'active' => $active
            ]);
        } else {
            return view('database.kendaraan', [
                'data' => ['data_kendaraan' => []],
                'title' => $title,
                'active' => $active
            ]);
        }
    }
}
