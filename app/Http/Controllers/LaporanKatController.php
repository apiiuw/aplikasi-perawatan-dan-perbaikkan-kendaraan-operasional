<?php

namespace App\Http\Controllers;

use App\Services\LapKatGoogleSheetService;
use Illuminate\Http\Request;

class LaporanKatController extends Controller
{
    protected $googleSheetService;

    public function __construct(LapKatGoogleSheetService $googleSheetService)
    {
        $this->googleSheetService = $googleSheetService;
    }

    public function index(Request $request)
    {
        // Ambil semua parameter pencarian dari request
        $searchQuery = $request->input('search'); // Ambil query pencarian dari input
        $laporan = $this->googleSheetService->searchLaporanData($searchQuery); // Panggil fungsi search
        $kendaraan = $this->googleSheetService->getKendaraanData();

        // Kirim data ke view 'laporan.kategori'
        return view('laporan.kategori', [
            'active' => 'laporan.kategori',
            'title' => 'Laporan Kategori',
            'laporan' => $laporan,
            'kendaraan' => $kendaraan // Tambahkan kendaraan ke view
        ]);
    }

    public function search(Request $request)
    {
        // Ambil semua data laporan
        $laporan = Laporan::all();
        
        // Hitung total data
        $totalData = $laporan->count();
    
        // Lakukan pencarian berdasarkan input dari form
        $filteredLaporan = $laporan; // Ganti ini dengan logika pencarian yang sebenarnya
        // Misalnya:
        if ($request->has('jenis_perawatan')) {
            $filteredLaporan = $filteredLaporan->where('jenis_perawatan', $request->jenis_perawatan);
        }
    
        if ($request->has('kendaraan')) {
            $filteredLaporan = $filteredLaporan->where('kendaraan', $request->kendaraan);
        }
    
        // Hitung jumlah data yang ditemukan
        $filteredCount = $filteredLaporan->count();
    
        // Kirim data ke view
        return view('laporan.kategori', [
            'laporan' => $filteredLaporan,
            'totalData' => $totalData,
            'filteredCount' => $filteredCount,
            'kendaraan' => ['Mobil', 'Motor'], // Ganti ini dengan data kendaraan yang sesuai
        ]);
    }
    
}
