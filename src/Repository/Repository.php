<?php

declare(strict_types=1);

namespace Hamed\Countries\Repository;

use GuzzleHttp\ClientInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Serializer\SerializerInterface;

abstract class Repository
{
    /** @var ClientInterface */
    protected $http;

    /** @var SerializerInterface */
    protected $serializer;

    /** @var FilesystemAdapter */
    protected $cacheAdapter;

    public function __construct(
        ClientInterface $http,
        SerializerInterface $serializer,
        FilesystemAdapter $cacheAdapter
    ) {
        $this->http = $http;
        $this->serializer = $serializer;
        $this->cacheAdapter = $cacheAdapter;
    }

    /**
     * @param mixed $data
     * @return string
     */
    protected function serialize($data): string
    {
        return $this->serializer->serialize($data, 'json');
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

    protected function getResponse(string $uri): string
    {
        if (static::$isCachable) {
            $cacheItem = $this->cacheAdapter->getItem($uri);
            if (!$cacheItem->isHit()) {
                $data = $this->http->request('GET', $uri)->getBody()->getContents();
                $cacheItem->set($data);
                $this->cacheAdapter->save($cacheItem);
                return $data;
            }
        }
        
        return $this->http->request('GET', $uri)->getBody()->getContents();
    }
}
