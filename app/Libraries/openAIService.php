<?php 

namespace App\Libraries;

use Config\Services;

class openAIService {

    private $apiKey;
    private $endpoint;

    public function __construct() {
        $this->apiKey = getenv('GEMINI_API_KEY');
    
        if (!$this->apiKey) {
            throw new \Exception('API KEY no encontrada');
        }
        $this->endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $this->apiKey;

    }

    public function chat($prompt){


        $data = [
            "contents" => [
                "parts" => [
                    [
                        "text" => $prompt
                    ]
                ]
            ],
            "generationConfig" => [
                "temperature" => 0
            ]
        ];

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $this->endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json'
            ],
            CURLOPT_POSTFIELDS => json_encode($data)
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception(
                'Error CURL: ' . curl_error($ch)
            );
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);
        $result = json_decode($response, true);

         if ($httpCode !== 200) {
            throw new \Exception(
                $result['error']['message']
                ?? 'Error desconocido'
            );
        }

        return $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Sin respuesta';
    }
}