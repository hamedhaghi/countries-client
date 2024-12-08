<?php

declare(strict_types=1);

namespace Hamed\Countries\Factory;

use GuzzleHttp\Client;
use Hamed\Countries\Normalizer\CountryNormalizer;
use Hamed\Countries\Repository\CountryRepository;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CountryRepositoryFactory
{
    public static function init(
        bool $fromCache = false,
        int $cacheTTL = 0,
        string $uri = 'https://restcountries.com/v3.1/'
    ): CountryRepository {

        $client = new Client([
            'base_uri' => $uri,
            'headers' => [
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip, deflate',
                'Content-Type' => 'application/json; charset=utf-8',
            ],
        ]);

        $serializer = new Serializer([
            new CountryNormalizer(),
            new ObjectNormalizer(),
            new ArrayDenormalizer(),
        ], [
            new JsonEncoder(),
        ]);

        $cache = null;

        if ($fromCache) {
            $cache = new FilesystemAdapter(
                'countries',
                $cacheTTL,
                __DIR__ . '/../../var/cache'
            );
        }

        return new CountryRepository(
            $client,
            $serializer,
            $cache
        );
    }
}