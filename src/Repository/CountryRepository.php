<?php

declare(strict_types=1);

namespace Hamed\Countries\Repository;

use Hamed\Countries\Model\Country;

class CountryRepository extends Repository
{
    public function getAll(): array
    {
        $response = $this->http->request('GET', 'all');
        return $this->deserialize($response->getBody()->getContents(), Country::class . '[]');
    }

    public function getByCapital(string $capital): array
    {
        $response = $this->http->request('GET', 'capital/' . $capital);
        return $this->deserialize($response->getBody()->getContents(), Country::class . '[]');
    }

    public function getByCode(string $code): array
    {
        $response = $this->http->request('GET', 'alpha/' . $code);
        return $this->deserialize($response->getBody()->getContents(), Country::class . '[]');
    }

    public function getByCurrency(string $currency): array
    {
        $response = $this->http->request('GET', 'currency/' . $currency);
        return $this->deserialize($response->getBody()->getContents(), Country::class . '[]');
    }

    public function getByDemonym(string $demonym): array
    {
        $response = $this->http->request('GET', 'demonym/' . $demonym);
        return $this->deserialize($response->getBody()->getContents(), Country::class . '[]');
    }

    public function getByFullName(string $name): array
    {
        $response = $this->http->request('GET', 'name/' . $name . '?fullText=true');
        return $this->deserialize($response->getBody()->getContents(), Country::class . '[]');
    }

    public function getByLanguage(string $language): array
    {
        $response = $this->http->request('GET', 'lang/' . $language);
        return $this->deserialize($response->getBody()->getContents(), Country::class . '[]');
    }

    public function getByName(string $name): array
    {
        $response = $this->http->request('GET', 'name/' . $name);
        return $this->deserialize($response->getBody()->getContents(), Country::class . '[]');
    }

    public function getByRegion(string $region): array
    {
        $response = $this->http->request('GET', 'region/' . $region);
        return $this->deserialize($response->getBody()->getContents(), Country::class . '[]');
    }

    public function getBySubregion(string $subregion): array
    {
        $response = $this->http->request('GET', 'subregion/' . $subregion);
        return $this->deserialize($response->getBody()->getContents(), Country::class . '[]');
    }

    public function getByTranslation(string $translation): array
    {
        $response = $this->http->request('GET', 'translation/' . $translation);
        return $this->deserialize($response->getBody()->getContents(), Country::class . '[]');
    }
}
