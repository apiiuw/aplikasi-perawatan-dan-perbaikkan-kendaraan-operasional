<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;

class GoogleSheetService
{
    protected $client;
    protected $service;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuthConfig('assets\credentials\credentials.json'); // Path ke file credentials.json
        $this->client->addScope(Sheets::SPREADSHEETS_READONLY);
        $this->client->setAccessType('offline');
        $this->service = new Sheets($this->client);
    }

    public function readSheet($spreadsheetId, $range)
    {
        $response = $this->service->spreadsheets_values->get($spreadsheetId, $range);
        return $response->getValues();
    }
}
