<?php

use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

Dotenv::createImmutable(__DIR__ . '/../')->load();

$client = new \GuzzleHttp\Client();

$response = $client->get(getenv('REST_COUNTRIES_API_URL') . 'all', [
    'headers' => [
        'Accept' => 'application/json',
        'Accept-Charset' => 'utf-8',
        'Accept-Encoding' => 'gzip, deflate',
    ],
]);

$data = $response->getBody()->getContents();

if (json_decode($data) === null) {
    throw new RuntimeException('Invalid JSON data from API: ' . json_last_error_msg());
}

file_put_contents(__DIR__ . '/Fixture/snapshots/all.json', $data);
