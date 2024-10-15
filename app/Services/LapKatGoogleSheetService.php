<?php

namespace App\Services;

use GuzzleHttp\Client;

class LapKatGoogleSheetService
{
    protected $client;
    protected $spreadsheetId;
    protected $apiKey;

    public function __construct()
    {
        // Inisialisasi Guzzle Client
        $this->client = new Client();

        // Mengambil Spreadsheet ID dan API Key dari environment
        $this->spreadsheetId = env('GOOGLE_SHEETS_SPREADSHEET_ID');
        $this->apiKey = env('GOOGLE_SHEETS_API_KEY');
    }

    /**
     * Fungsi untuk mendapatkan data dari Google Sheets berdasarkan rentang
     * @param string $range
     * @return array
     */
    public function getSheetData($range)
    {
        $url = "https://sheets.googleapis.com/v4/spreadsheets/{$this->spreadsheetId}/values/{$range}?key={$this->apiKey}";
        
        try {
            $response = $this->client->get($url);
            $body = json_decode($response->getBody(), true);
    
            if (isset($body['values'])) {
                return $body['values']; // Mengembalikan data jika ada
            } else {
                \Log::error("Data tidak ditemukan dalam range: $range");
                return []; // Data kosong
            }
        } catch (\Exception $e) {
            \Log::error('Error mengambil data dari Google Sheets: ' . $e->getMessage());
            return []; // Mengembalikan array kosong jika terjadi kesalahan
        }
    }

    public function getKendaraanData()
    {
        // Tentukan range dari sheet DatabaseKendaraan
        $range = 'DatabaseKendaraan!B5:B1000'; // Ambil data mulai dari baris ke-5 hingga akhir
    
        // Panggil fungsi getSheetData untuk mengambil data
        $data = $this->getSheetData($range);
    
        // Array untuk menampung kendaraan
        $kendaraan = [];
    
        // Loop data dan masukkan ke array kendaraan
        foreach ($data as $row) {
            if (!empty($row[0])) {
                $kendaraan[] = $row[0]; // Kolom B menyimpan nama kendaraan
            }
        }
    
        return $kendaraan;
    }    

    /**
     * Fungsi untuk mengambil dan memformat data laporan dari Google Sheets
     * @return array
     */
    public function getLaporanData()
    {
        // Tentukan rentang data yang ingin diambil
        $range = 'DatabaseTransaksi!B5:BQ1000'; // Menggunakan rentang yang lebih besar
    
        // Panggil fungsi getSheetData untuk mengambil data dari Google Sheets
        $data = $this->getSheetData($range);
    
        // Inisialisasi array untuk menyimpan data laporan
        $laporan = [];
    
        // Looping melalui data yang didapatkan dan memformatnya
        foreach ($data as $i => $row) {
            // Pastikan ada cukup data untuk setiap kolom
            if (isset($row[0], $row[1], $row[2], $row[3], $row[4], $row[16], $row[30])) {
                $nomorPolisi = $row[0] ?? null; // Kolom B
                $tanggal = ($row[1] ?? '') . ' ' . ($row[2] ?? '') . ' ' . ($row[3] ?? ''); // Gabungkan tanggal dari kolom C, D, E
                $jenisPerawatan = $row[4] ?? null; // Kolom F
                $totalBiaya = $row[67] ?? null; // Kolom BQ, pastikan total_biaya adalah float
                $tempatTransaksi = $row[30] ?? null; // Kolom BD
        
                // Tambahkan data ke laporan jika nomor polisi tidak kosong
                if ($nomorPolisi) {
                    $laporan[] = (object)[
                        'nomor_polisi' => $nomorPolisi,
                        'tanggal' => $tanggal,
                        'jenis_perawatan' => $jenisPerawatan,
                        'total_biaya' => $totalBiaya,
                        'tempat_transaksi' => $tempatTransaksi,
                    ];
                }
            }
        }        
        return $laporan;
    }
    
}
