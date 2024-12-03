<?php

declare(strict_types=1);

namespace Hamed\Countries\Repository;

use Hamed\Countries\Model\Country;

class CountryRepository extends Repository
{
    public function getAll(): array
    {
        return $this->deserialize(
            $this->client->request('GET', 'all')->getData(),
            Country::class . '[]'
        );
    }

    public function getByCapital(string $capital): array
    {
        return $this->deserialize(
            $this->client->request('GET', 'capital/' . $capital)->getData()
            ,
            Country::class . '[]'
        );
    }

    public function getByCode(string $code): array
    {
        return $this->deserialize(
            $this->client->request('GET', 'alpha/' . $code)->getData(),
            Country::class . '[]'
        );
    }

    public function getByCurrency(string $currency): array
    {
        return $this->deserialize(
            $this->client->request('GET', 'currency/' . $currency)->getData(),
            Country::class . '[]'
        );
    }

    public function getByDemonym(string $demonym): array
    {
        return $this->deserialize(
            $this->client->request('GET', 'demonym/' . $demonym)->getData(),
            Country::class . '[]'
        );
    }

    public function getByFullName(string $name): array
    {
        return $this->deserialize(
            $this->client->request('GET', 'name/' . $name . '?fullText=true')->getData(),
            Country::class . '[]'
        );
    }

    public function getByLanguage(string $language): array
    {
        return $this->deserialize(
            $this->client->request('GET', 'lang/' . $language)->getData(),
            Country::class . '[]'
        );
    }

    public function getByName(string $name): array
    {
        ;
        return $this->deserialize(
            $this->client->request('GET', 'name/' . $name)->getData(),
            Country::class . '[]'
        );
    }

    public function getByRegion(string $region): array
    {
        return $this->deserialize(
            $this->client->request('GET', 'region/' . $region)->getData(),
            Country::class . '[]'
        );
    }

    public function getBySubregion(string $subregion): array
    {
        return $this->deserialize(
            $this->client->request('GET', 'subregion/' . $subregion)->getData(),
            Country::class . '[]'
        );
    }

    public function getByTranslation(string $translation): array
    {
        return $this->deserialize(
            $this->client->request('GET', 'translation/' . $translation)->getData(),
            Country::class . '[]'
        );
    }
}
