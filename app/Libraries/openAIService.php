<?php 

namespace App\Libraries;

use Config\Services;

class openAIService {

    private $apiKey;
    private $endpoint;

    public function __construct() {
        $this->apiKey = getenv('GEMINI_API_KEY');
        $this->endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemma-3-27b-it:generateContent?key=' . $this->apiKey;

        if (!$this->apiKey) {
            throw new \Exception('API KEY no encontrada');
        }

    }

    public function chat($prompt){


        $data = [
            "contents" => [
                "parts" => [
                    ["text" => $prompt]
                ]
            ]
        ];

        $ch = curl_init($this->endpoint);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ],
            CURLOPT_POSTFIELDS => json_encode($data)
        ]);

        $response = curl_exec($ch);
        // curl_close($ch);

        $result = json_decode($response, true);

        return $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Sin respuesta';
    }
}