<?php

namespace App\Http\Controllers;

use App\Services\GoogleSheetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferensiController extends Controller
{
    protected $googleSheetService;

    public function __construct(GoogleSheetService $googleSheetService)
    {
        $this->googleSheetService = $googleSheetService;
    }

    public function index()
    {
        $ranges = [
            'merk_kendaraan' => 'Referensi!A4:B9999',
            'jenis_perawatan' => 'Referensi!D4:E9999',
            'bahan_bakar' => 'Referensi!G4:H9999',
            'bulan' => 'Referensi!J4:K16',
            'tahun' => 'Referensi!M4:N16',
        ];

        $data = [];
        foreach ($ranges as $key => $range) {
            $data[$key] = $this->googleSheetService->getSheetData($range);
        }

        // Dapatkan data pengguna yang sedang login
        $user = Auth::user();
        $namaPengabiministrasi = $user->nama_pengabiministrasi;
        $jabatan = $user->jabatan;

        // Update kolom K29 dengan nama_pengabiministrasi dan K23 dengan jabatan
        $this->googleSheetService->updateCell('Referensi!K29', $namaPengabiministrasi);
        $this->googleSheetService->updateCell('Referensi!K23', $jabatan);

        return view('referensi.index', [
            'data' => $data,
            'title' => 'Referensi',
            'active' => 'referensi',
        ]);
    }

    public function store(Request $request, $type)
    {
        // Validasi dan simpan data ke Google Sheets berdasarkan tipe data
        $this->googleSheetService->addRow($type, $request->except('_token'));
        return redirect()->route('referensi.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $type, $rowIndex)
    {
        // Validasi dan update data di Google Sheets berdasarkan tipe data
        $this->googleSheetService->updateRow($type, $rowIndex, $request->except('_token'));
        return redirect()->route('referensi.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($type, $rowIndex)
    {
        // Hapus data dari Google Sheets berdasarkan tipe data
        $this->googleSheetService->deleteRow($type, $rowIndex);
        return redirect()->route('referensi.index')->with('success', 'Data berhasil dihapus');
    }
}
