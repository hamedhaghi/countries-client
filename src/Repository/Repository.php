<?php

declare(strict_types=1);

namespace Hamed\Countries\Repository;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use GuzzleHttp\Client;
use Dotenv\Dotenv;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

abstract class Repository
{
    /** @var Client */
    protected $http;

    /** @var Serializer */
    protected $serializer;

    public function __construct()
    {
        Dotenv::createImmutable(__DIR__ . '/../../')->load();
        $this->http = new Client([
            'base_uri' => getenv('REST_COUNTRIES_API_URL'),
            'headers' => [
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip, deflate',
            ],
        ]);
        $this->serializer = new Serializer([
            new ObjectNormalizer(),
        ], [
            new JsonEncoder(),
        ]);
    }

    /**
     * @param mixed $data
     * @return string
     */
    public function serialize($data): string
    {
        return $this->serializer->serialize($data, 'json');
    }

    /**
     * @param string $data
     * @param string $class
     * @return object|array
     */
    public function deserialize(string $data, string $class)
    {
        return $this->serializer->deserialize($data, $class, 'json');
    }
}
