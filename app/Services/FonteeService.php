<?php

namespace App\Services;

use GuzzleHttp\Client;

class FonteeService
{
    protected $client;
    protected $apiUrl;
    protected $apiKey;

    public function __construct()
    {
        // Inisialisasi client Guzzle
        $this->client = new Client();
        
        // URL API dan API Key (sesuaikan dengan yang Anda miliki)
        $this->apiUrl = 'https://api.fontee.com/send-message'; // Gantilah dengan URL API yang sesuai
        $this->apiKey = env('FONTEE_API_KEY'); // Pastikan API key disimpan di file .env
    }

    /**
     * Kirim pesan WhatsApp
     *
     * @param string $phone
     * @param string $message
     * @return array
     */
    public function sendWhatsAppMessage($phone, $message)
    {
        try {
            $response = $this->client->post($this->apiUrl, [
                'json' => [
                    'api_key' => $this->apiKey,
                    'phone' => $phone,
                    'message' => $message
                ]
            ]);

            $responseBody = json_decode($response->getBody()->getContents(), true);

            return $responseBody;

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
