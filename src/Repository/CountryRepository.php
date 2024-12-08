<?php

declare(strict_types=1);

namespace Hamed\Countries\Repository;

use Exception;
use GuzzleHttp\ClientInterface;
use Hamed\Countries\Model\Country;
use RuntimeException;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Serializer\SerializerInterface;

class CountryRepository implements RepositoryInterface
{
    /** @var ClientInterface */
    private $client;

    /** @var SerializerInterface */
    private $serializer;

    /** @var AdapterInterface|null */
    private $cache;

    public function __construct(
        ClientInterface $client,
        SerializerInterface $serializer,
        AdapterInterface $cache = null
    ) {
        $this->client = $client;
        $this->serializer = $serializer;
        $this->cache = $cache;
    }

    private function fetchData(string $uri): array
    {
        if ($this->cache) {
            $cacheItem = $this->cache->getItem($uri);
            if ($cacheItem->isHit()) {
                return $this->serializer->deserialize($cacheItem->get(), Country::class . '[]', 'json');
            }
        }

        try {
            $response = $this->client->request('GET', $uri);
            $data = $response->getBody()->getContents();
        } catch (Exception $e) {
            throw new RuntimeException('Failed to fetch data from API: ' . $e->getMessage());
        }
        
        if ($this->cache) {
            $cacheItem->set($data);
            $this->cache->save($cacheItem);
        }

        return $this->serializer->deserialize($data, Country::class . '[]', 'json');
    }

    public function getAll(): array
    {
        return $this->fetchData('all');
    }

    public function getByCapital(string $capital): array
    {
        return $this->fetchData('capital/' . $capital);
    }

    public function getByCode(string $code): array
    {
        return $this->fetchData('alpha/' . $code);
    }

    public function getByCurrency(string $currency): array
    {
        return $this->fetchData('currency/' . $currency);
    }

    public function getByDemonym(string $demonym): array
    {
        return $this->fetchData('demonym/' . $demonym);
    }

    public function getByFullName(string $name): array
    {
        return $this->fetchData('name/' . $name . '?fullText=true');
    }

    public function getByLanguage(string $language): array
    {
        return $this->fetchData('lang/' . $language);
    }

    public function getByName(string $name): array
    {
        return $this->fetchData('name/' . $name);
    }

    public function getByRegion(string $region): array
    {
        return $this->fetchData('region/' . $region);
    }

    public function getBySubregion(string $subregion): array
    {
        return $this->fetchData('subregion/' . $subregion);
    }

    public function getByTranslation(string $translation): array
    {
        return $this->fetchData('translation/' . $translation);
    }
}
