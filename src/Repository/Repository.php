<?php

declare(strict_types=1);

namespace Hamed\Countries\Repository;

use Hamed\Countries\Http\Client;
use Symfony\Component\Serializer\SerializerInterface;

abstract class Repository
{
    /** @var Client */
    protected $client;

    /** @var SerializerInterface */
    protected $serializer;

    public function __construct(
        Client $client,
        SerializerInterface $serializer
    ) {
        $this->client = $client;
        $this->serializer = $serializer;
    }

    /**
     * @param string $data
     * @param string $class
     * @return object|array
     */
    protected function deserialize(string $data, string $class)
    {
        return $this->serializer->deserialize($data, $class, 'json');
    }
}
