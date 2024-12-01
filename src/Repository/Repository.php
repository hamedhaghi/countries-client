<?php

declare(strict_types=1);

namespace Hamed\Countries\Repository;

use GuzzleHttp\ClientInterface;
use Hamed\Countries\Normalizer\CountryNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class Repository
{
    /** @var ClientInterface */
    protected $http;

    /** @var Serializer */
    protected $serializer;

    public function __construct(
        ClientInterface $http
    ) {
        $this->http = $http;
        $this->serializer = new Serializer([
            new CountryNormalizer(),
            new ObjectNormalizer(),
            new ArrayDenormalizer(),
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
