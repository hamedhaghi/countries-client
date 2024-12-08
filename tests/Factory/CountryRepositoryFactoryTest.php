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
}