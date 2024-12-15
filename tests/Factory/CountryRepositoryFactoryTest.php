<?php

declare(strict_types=1);

namespace Hamed\Countries\Tests\Factory;

use Hamed\Countries\Factory\CountryRepositoryFactory;
use Hamed\Countries\Repository\CountryRepository;
use PHPUnit\Framework\TestCase;

class CountryRepositoryFactoryTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        if (getenv('GITHUB_ACTIONS')) {
            $this->markTestSkipped('Skipping tests in GitHub Actions environment.');
        }
    }

    public function testInitWithoutCache()
    {
        $factory = new CountryRepositoryFactory();
        $this->assertInstanceOf(CountryRepository::class, $factory->init());
    }

    public function testInitWithCache()
    {
        $factory = new CountryRepositoryFactory();
        $this->assertInstanceOf(CountryRepository::class, $factory->isCachable()->init());
    }

    public function testGetAllCountriesWithoutCache()
    {
        $factory = new CountryRepositoryFactory();
        $this->assertNotEmpty($factory->init()->getAll());
    }

    public function testGetAllCountriesFromCache()
    {
        $factory = new CountryRepositoryFactory();
        $this->assertNotEmpty($factory->isCachable()->init()->getAll());
    }

    public function testGetCountriesByCapitalFromCache()
    {
        $factory = new CountryRepositoryFactory();
        $this->assertNotEmpty($factory->isCachable()->init()->getByCapital('berlin'));
    }

    public function testGetCountriesByCapitalFromCacheOnlyForTenSeconds()
    {
        $factory = new CountryRepositoryFactory();
        $this->assertNotEmpty($factory->isCachable()->setCacheTTL(10)->init()->getByCapital('berlin'));
    }

    public function testClearCacheTrue()
    {
        $factory = new CountryRepositoryFactory();
        $this->assertNotEmpty($factory->isCachable()->init()->getAll());
        $this->assertTrue($factory->clearCache());
    }

    public function testClearCacheFalse()
    {
        $factory = new CountryRepositoryFactory();
        $this->assertFalse($factory->clearCache());
    }
}
