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
        // Mengambil data laporan dan kendaraan dari Google Sheets
        $laporan = $this->googleSheetService->getLaporanData();
        $kendaraan = $this->googleSheetService->getKendaraanData();
    
        // Mengirim data ke view 'laporan.kategori'
        return view('laporan.kategori', [
            'active' => 'laporan.kategori',
            'title' => 'Laporan Kategori',
            'laporan' => $laporan,
            'kendaraan' => $kendaraan // Tambahkan kendaraan ke view
        ]);
    }    

    public function search(Request $request)
    {
        // Ambil parameter dari request
        $periode = $request->input('periode');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $jenisPerawatan = $request->input('jenis_perawatan');
        $kendaraan = $request->input('kendaraan');
        $tanggalLaporan = $request->input('tanggal_laporan');
    
        // Ambil semua data laporan
        $laporan = $this->googleSheetService->getLaporanData();
    
        // Filter data berdasarkan input yang diterima
        $filteredLaporan = array_filter($laporan, function ($item) use ($periode, $bulan, $tahun, $jenisPerawatan, $kendaraan, $tanggalLaporan) {
            $isMatch = true;
    
            if ($periode == 'bulanan' && $bulan) {
                $isMatch = strpos(strtolower($item->tanggal), strtolower($bulan)) !== false;
            }
    
            if ($tahun) {
                $isMatch = $isMatch && strpos(strtolower($item->tanggal), strtolower($tahun)) !== false;
            }
    
            if ($jenisPerawatan) {
                $isMatch = $isMatch && strtolower($item->jenis_perawatan) == strtolower($jenisPerawatan);
            }
    
            if ($kendaraan) {
                $isMatch = $isMatch && strtolower($item->nomor_polisi) == strtolower($kendaraan);
            }
    
            if ($tanggalLaporan) {
                $isMatch = $isMatch && $item->tanggal == $tanggalLaporan;
            }
    
            return $isMatch;
        });
    
        // Mengembalikan data yang sudah difilter sebagai JSON
        return response()->json(['laporan' => $filteredLaporan]);
    }
    
}
