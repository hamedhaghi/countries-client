<?php

use Dotenv\Dotenv;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;
use Psr\Http\Message\ResponseInterface;

require_once __DIR__ . '/../vendor/autoload.php';

Dotenv::createImmutable(__DIR__ . '/../')->load();

$client = new Client([
    'base_uri' => getenv('REST_COUNTRIES_API_URL'),
    'headers' => [
        'Accept' => 'application/json',
        'Accept-Charset' => 'utf-8',
        'Accept-Encoding' => 'gzip, deflate',
    ],
]);

$promises = [
    'all' => $client->getAsync('all'),
    'name' => $client->getAsync('name/germany'),
    'fullname' => $client->getAsync('name/germany?fullText=true'),
    'code' => $client->getAsync('alpha/de'),
    'currency' => $client->getAsync('currency/euro'),
    'demonym' => $client->getAsync('demonym/german'),
    'language' => $client->getAsync('lang/de'),
    'capital' => $client->getAsync('capital/berlin'),
    'region' => $client->getAsync('region/europe'),
    'subregion' => $client->getAsync('subregion/western europe'),
    'translation' => $client->getAsync('translation/germany'),
];

$responses = Utils::unwrap($promises);

foreach ($responses as $key => $response) {
    /** @var ResponseInterface $response */
    file_put_contents(__DIR__ . "/Fixture/snapshots/$key.json", $response->getBody()->getContents());
}
