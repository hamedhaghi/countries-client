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
        $countries = $this->deserialize($response->getBody()->getContents(), Country::class);
        var_dump($countries);
        die;
        if (!is_array($countries)) {
            return [];
        }

        return $countries;
    }
}
