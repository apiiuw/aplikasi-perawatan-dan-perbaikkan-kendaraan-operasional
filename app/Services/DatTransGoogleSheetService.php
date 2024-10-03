<?php

namespace App\Services;

use GuzzleHttp\Client;

class DatTransGoogleSheetService
{
    protected $client;
    protected $spreadsheetId;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->spreadsheetId = env('GOOGLE_SHEETS_SPREADSHEET_ID');
        $this->apiKey = env('GOOGLE_SHEETS_API_KEY');
    }

    // Fungsi untuk mendapatkan data dari Google Sheets
    public function getSheetData($range)
    {
        $url = "https://sheets.googleapis.com/v4/spreadsheets/{$this->spreadsheetId}/values/{$range}?key={$this->apiKey}";
        
        try {
            $response = $this->client->get($url);
            $body = json_decode($response->getBody(), true);
            return $body['values'] ?? []; // Mengembalikan data sebagai array
        } catch (\Exception $e) {
            return []; // Mengembalikan array kosong jika terjadi kesalahan
        }
    }
}
