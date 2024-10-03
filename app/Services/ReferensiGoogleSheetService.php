<?php

namespace App\Services;

use GuzzleHttp\Client;

class ReferensiGoogleSheetService
{
    protected $client;
    protected $spreadsheetId;

    public function __construct()
    {
        $this->client = new Client();
        $this->spreadsheetId = env('GOOGLE_SHEETS_SPREADSHEET_ID');
    }

    private function getAccessToken()
    {
        // Set credentials dari environment
        $credentials = [
            'type' => env('GOOGLE_SERVICE_ACCOUNT_TYPE'),
            'project_id' => env('GOOGLE_SERVICE_ACCOUNT_PROJECT_ID'),
            'private_key_id' => env('GOOGLE_SERVICE_ACCOUNT_PRIVATE_KEY_ID'),
            'private_key' => str_replace("\\n", "\n", env('GOOGLE_SERVICE_ACCOUNT_PRIVATE_KEY')),
            'client_email' => env('GOOGLE_SERVICE_ACCOUNT_CLIENT_EMAIL'),
            'client_id' => env('GOOGLE_SERVICE_ACCOUNT_CLIENT_ID'),
            'auth_uri' => env('GOOGLE_SERVICE_ACCOUNT_AUTH_URI'),
            'token_uri' => env('GOOGLE_SERVICE_ACCOUNT_TOKEN_URI'),
            'auth_provider_x509_cert_url' => env('GOOGLE_SERVICE_ACCOUNT_AUTH_PROVIDER_CERT_URL'),
            'client_x509_cert_url' => env('GOOGLE_SERVICE_ACCOUNT_CLIENT_CERT_URL'),
        ];

        $client = new \Google\Client();
        $client->setAuthConfig($credentials);
        $client->setScopes(['https://www.googleapis.com/auth/spreadsheets']);

        // Ambil token dari credentials
        $accessToken = $client->fetchAccessTokenWithAssertion();

        return $accessToken['access_token'];
    }

    public function getSheetData($range)
    {
        $response = $this->client->request('GET', 'https://sheets.googleapis.com/v4/spreadsheets/' . $this->spreadsheetId . '/values/' . $range, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data['values'] ?? [];
    }

    private function getLastRowNumber($range)
    {
        $data = $this->getSheetData($range);
        $lastRow = end($data);
        return $lastRow ? (int)$lastRow[0] : 0;
    }

    public function updateCell($cellRange, $value)
    {
        $values = [
            [$value]
        ];

        // Kirim request untuk memperbarui satu sel di Google Sheets
        $this->client->request('PUT', 'https://sheets.googleapis.com/v4/spreadsheets/' . $this->spreadsheetId . '/values/' . $cellRange, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
            ],
            'query' => [
                'valueInputOption' => 'RAW',
            ],
            'json' => [
                'values' => $values,
            ],
        ]);
    }

    public function addRow($type, $data)
    {
        $ranges = [
            'merk_kendaraan' => 'Referensi!A5:B9999',
            'jenis_perawatan' => 'Referensi!D5:E9999',
            'bahan_bakar' => 'Referensi!G5:H9999',
            'bulan' => 'Referensi!J5:K9999',
            'tahun' => 'Referensi!M5:N9999',
        ];

        if (!array_key_exists($type, $ranges)) {
            throw new \InvalidArgumentException("Invalid type: $type");
        }

        $range = $ranges[$type];
        $lastRowNumber = $this->getLastRowNumber($range) + 1;

        $values = array_merge([$lastRowNumber], $data); // Tambahkan nomor baris di depan data
        $values = array_chunk($values, count($data) + 1);

        $this->client->request('POST', 'https://sheets.googleapis.com/v4/spreadsheets/' . $this->spreadsheetId . '/values/' . $range . ':append', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
            ],
            'query' => [
                'valueInputOption' => 'RAW',
            ],
            'json' => [
                'values' => $values,
            ]
        ]);
    }

    public function updateRow($type, $rowNumber, $data)
    {
        $ranges = [
            'merk_kendaraan' => 'Referensi!A',
            'jenis_perawatan' => 'Referensi!D',
            'bahan_bakar' => 'Referensi!G',
            'bulan' => 'Referensi!J',
            'tahun' => 'Referensi!M',
        ];
    
        if (!array_key_exists($type, $ranges)) {
            throw new \InvalidArgumentException("Invalid type: $type");
        }
    
        $range = $ranges[$type];
    
        $rowIndex = $rowNumber + 4;
    
        $values = [
            [$rowNumber, $data['column2']]
        ];
    
        // Mengirim request untuk memperbarui data di Google Sheets
        $this->client->request('PUT', 'https://sheets.googleapis.com/v4/spreadsheets/' . $this->spreadsheetId . '/values/' . $range . $rowIndex . ':B' . $rowIndex, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
            ],
            'query' => [
                'valueInputOption' => 'RAW',
            ],
            'json' => [
                'values' => $values,
            ]
        ]);
    }
    
    public function deleteRow($type, $rowIndex)
    {
        $ranges = [
            'merk_kendaraan' => 'Referensi!A' . ($rowIndex + 4) . ':B' . ($rowIndex + 4),
            'jenis_perawatan' => 'Referensi!D' . ($rowIndex + 4) . ':E' . ($rowIndex + 4),
            'bahan_bakar' => 'Referensi!G' . ($rowIndex + 4) . ':H' . ($rowIndex + 4),
            'bulan' => 'Referensi!J' . ($rowIndex + 4) . ':K' . ($rowIndex + 4),
            'tahun' => 'Referensi!M' . ($rowIndex + 4) . ':N' . ($rowIndex + 4),
        ];

        if (!array_key_exists($type, $ranges)) {
            throw new \InvalidArgumentException("Invalid type: $type");
        }

        $range = $ranges[$type];

        $values = [
            ["", ""]
        ];

        $this->client->request('PUT', 'https://sheets.googleapis.com/v4/spreadsheets/' . $this->spreadsheetId . '/values/' . $range, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
            ],
            'query' => [
                'valueInputOption' => 'RAW',
            ],
            'json' => [
                'values' => $values
            ]
        ]);
    }
}
