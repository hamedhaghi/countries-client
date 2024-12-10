<?php

declare(strict_types=1);

namespace Hamed\Countries\Tests\Factory;

use Hamed\Countries\Factory\CountryRepositoryFactory;
use Hamed\Countries\Repository\CountryRepository;
use PHPUnit\Framework\TestCase;


class CountryRepositoryFactoryTest extends TestCase
{
    public function testInitWithoutCache()
    {
        $this->assertInstanceOf(CountryRepository::class, CountryRepositoryFactory::init());
    }

    public function testInitWithCache()
    {
        $this->assertInstanceOf(CountryRepository::class, CountryRepositoryFactory::init(true));
    }

    public function testGetAllCountriesWithoutCache() {
        $this->assertNotEmpty(CountryRepositoryFactory::init()->getAll());
    }

    public function testGetAllCountriesFromCache() {
        $this->assertNotEmpty(CountryRepositoryFactory::init(true)->getAll());
    }

    public function testGetCountriesByCapitalFromCache() {
        $this->assertNotEmpty(CountryRepositoryFactory::init(true)->getByCapital('berlin'));
    }

    public function testGetCountriesByCapitalFromCacheOnlyForTenSeconds() {
        $this->assertNotEmpty(CountryRepositoryFactory::init(true, 10)->getByCapital('berlin'));
    }
}