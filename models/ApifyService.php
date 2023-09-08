<?php

namespace app\models;
use GuzzleHttp\Client;
class ApifyService {
    public $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.apify.com/v2/',
            'headers' => [
                // Замените <ВАШ_APIFY_API_TOKEN> на ваш настоящий токен
                'Authorization' => 'Bearer <apify_api_qcYOgdu2J9vcniWTvaYPHPQwX30z5g4zv8KD>',
            ]
        ]);
    }
}