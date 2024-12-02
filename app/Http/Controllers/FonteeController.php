<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Services\FonteeService;


class FonteeService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('FONTEE_API_KEY'); // Tambahkan API key di .env
    }

    public function sendWhatsAppMessage($phoneNumber, $message)
    {
        $url = 'https://api.fontee.id/send-message';

        $response = $this->client->post($url, [
            'headers' => [
                'Authorization' => "Bearer {$this->apiKey}",
            ],
            'form_params' => [
                'phone' => $phoneNumber,
                'message' => $message,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
