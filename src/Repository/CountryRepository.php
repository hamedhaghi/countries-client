<?php

declare(strict_types=1);

namespace Hamed\Countries\Repository;

use Hamed\Countries\Model\Country;

class CountryRepository extends Repository
{
    /**
     * Get all countries
     * @return Country[]
     */
    public function getAll(): array
    {
        $response = $this->http->request('GET', 'all');
        return $this->deserialize($response->getBody()->getContents(), Country::class . '[]');
    }
}
