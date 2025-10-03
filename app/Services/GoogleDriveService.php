<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;

class GoogleDriveService
{
    protected $client;
    protected $service;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setApplicationName('Laravel Google Drive');
        $this->client->setScopes([Drive::DRIVE_READONLY]);

        // Pastikan credentials.json ada di storage/app/
        $this->client->setAuthConfig(storage_path('app/credentials.json'));
        $this->client->setAccessType('offline');

        $this->service = new Drive($this->client);
    }

    /**
     * List files dari folder tertentu
     * @param string|null $folderId
     * @return array
     */
    public function listFiles($folderId = null)
    {
        $params = [
            'pageSize' => 100,
            'fields'   => 'files(id, name, webViewLink, mimeType)',
            'q'        => 'trashed=false'
        ];

        // Jika folderId diberikan
        if ($folderId) {
            $params['q'] = "'$folderId' in parents and trashed=false";
        }

        $results = $this->service->files->listFiles($params);
        return $results->getFiles();
    }
}
