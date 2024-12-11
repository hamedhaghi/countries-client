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
    /** @var string */
    private $uri = 'https://restcountries.com/v3.1/';

    /** @var bool */
    private $isCachable = false;

    /** @var int */
    private $cacheTTL = 0;

    /** @var null|AdapterInterface */
    private $cache;

    /**
     * Set URI.  The default is https://restcountries.com/v3.1/.
     */
    public function setURI(string $uri): self
    {
        if (!trim($uri)) {
            return $this;
        }
        $this->uri = $uri;

        return $this;
    }

    /**
     * Enable caching.  The default is false.
     */
    public function isCachable(): self
    {
        $this->isCachable = true;

        return $this;
    }

    /**
     * Set cache TTL in seconds.  The default is 0 which means unlimited.
     */
    public function setCacheTTL(int $cacheTTL): self
    {
        $this->cacheTTL = $cacheTTL;

        return $this;
    }

    /**
     * Initialize the repository.
     */
    public function init(): CountryRepository
    {
        $client = new Client([
            'base_uri' => $this->uri,
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

        if ($this->isCachable) {
            $this->cache = new FilesystemAdapter(
                'countries',
                $this->cacheTTL,
                __DIR__.'/../../var/cache'
            );
        }

        return new CountryRepository(
            $client,
            $serializer,
            $this->cache
        );
    }

    /**
     * Clear all cached data.
     */
    public function clearCache(): bool
    {
        if ($this->cache) {
            return $this->cache->clear();
        }

        return false;
    }
}
