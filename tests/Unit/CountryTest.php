<?php 

declare(strict_types=1);

namespace Hamed\Countries\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Hamed\Countries\Repository\CountryRepository;
use Symfony\Component\Serializer\Tests\Annotation\GroupsTest;

class CountryTest extends TestCase
{
    /** @var CountryRepository */
    protected $countryRepository;

    protected function setUp()
    {
        $this->countryRepository = new CountryRepository();
    }

    public function testGetAllCountries()
    {
        $countries = $this->countryRepository->getAll();
        $this->assertNotEmpty($countries);
    }
}