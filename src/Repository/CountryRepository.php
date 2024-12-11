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

    /**
     * @param string $uri
     * @return array|object
     * @throws RuntimeException
     */
    private function fetchData(string $uri)
    {
        if ($this->cache) {
            $cacheItem = $this->cache->getItem(md5($uri));
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

    /**
     * Get all countries
     * 
     * @return array
     * @throws RuntimeException
     */
    public function getAll(): array
    {
        return $this->fetchData('all');
    }

    /**
     * Get countries by capital
     * 
     * @param string $capital
     * @return array
     * @throws RuntimeException
     */
    public function getByCapital(string $capital): array
    {
        return $this->fetchData('capital/' . $capital);
    }

    /**
     * Get countries by code
     * 
     * @param string $code
     * @return array
     * @throws RuntimeException
     */
    public function getByCode(string $code): array
    {
        return $this->fetchData('alpha/' . $code);
    }

    /**
     * Get countries by currency
     * 
     * @param string $currency
     * @return array
     * @throws RuntimeException
     */
    public function getByCurrency(string $currency): array
    {
        return $this->fetchData('currency/' . $currency);
    }

    /**
     * Get countries by demonym
     * 
     * @param string $demonym
     * @return array
     * @throws RuntimeException
     */
    public function getByDemonym(string $demonym): array
    {
        return $this->fetchData('demonym/' . $demonym);
    }

    /**
     * Get countries by full name
     * 
     * @param string $name
     * @return array
     * @throws RuntimeException
     */
    public function getByFullName(string $name): array
    {
        return $this->fetchData('name/' . $name . '?fullText=true');
    }

    /**
     * Get countries by language
     * 
     * @param string $language
     * @return array
     * @throws RuntimeException
     */
    public function getByLanguage(string $language): array
    {
        return $this->fetchData('lang/' . $language);
    }

    /**
     * Get countries by name
     * 
     * @param string $name
     * @return array
     * @throws RuntimeException
     */
    public function getByName(string $name): array
    {
        return $this->fetchData('name/' . $name);
    }

    /**
     * Get countries by region
     * 
     * @param string $region
     * @return array
     * @throws RuntimeException
     */
    public function getByRegion(string $region): array
    {
        return $this->fetchData('region/' . $region);
    }

    /**
     * Get countries by subregion
     * 
     * @param string $subregion
     * @return array
     * @throws RuntimeException
     */
    public function getBySubregion(string $subregion): array
    {
        return $this->fetchData('subregion/' . $subregion);
    }

    /**
     * Get countries by translation
     * 
     * @param string $translation
     * @return array
     * @throws RuntimeException
     */
    public function getByTranslation(string $translation): array
    {
        return $this->fetchData('translation/' . $translation);
    }
}
