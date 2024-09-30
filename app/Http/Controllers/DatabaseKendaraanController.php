<?php

namespace App\Http\Controllers;

use App\Services\GoogleSheetService;
use Illuminate\Http\Request;

class DatabaseKendaraanController extends Controller
{
    protected $googleSheetService;

    public function __construct(GoogleSheetService $googleSheetService)
    {
        $this->googleSheetService = $googleSheetService;
    }

    public function index()
    {
        $ranges = [
            'data_kendaraan' => 'DatabaseKendaraan!A4:AB9999', // Pastikan untuk mencakup semua kolom yang Anda butuhkan
        ];
    
        $data = [];
        foreach ($ranges as $key => $range) {
            $sheetData = $this->googleSheetService->getSheetData($range);
            if (is_array($sheetData) && count($sheetData) > 0) {
                $data[$key] = $sheetData; // Simpan data berdasarkan kunci
            } else {
                $data[$key] = []; // Atur ke array kosong jika tidak ada data
            }
        }
    
        return view('database.kendaraan', [
            'data' => $data,
            'title' => 'Database Kendaraan',
            'active' => 'database.kendaraan',
        ]);
    }
         

    public function store(Request $request, $type)
    {
        $this->googleSheetService->addRow($type, $request->except('_token'));
        return redirect()->route('databaseKendaraan.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $type, $rowIndex)
    {
        $this->googleSheetService->updateRow($type, $rowIndex, $request->except('_token'));
        return redirect()->route('databaseKendaraan.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($type, $rowIndex)
    {
        $this->googleSheetService->deleteRow($type, $rowIndex);
        return redirect()->route('databaseKendaraan.index')->with('success', 'Data berhasil dihapus');
    }    
}
