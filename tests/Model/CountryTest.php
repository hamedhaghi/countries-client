<?php

declare(strict_types=1);

namespace Hamed\Countries\Tests\Model;

use Hamed\Countries\Model\CapitalInfo;
use Hamed\Countries\Model\Car;
use Hamed\Countries\Model\Country;
use Hamed\Countries\Model\Demonym;
use Hamed\Countries\Model\Flag;
use Hamed\Countries\Model\IDD;
use Hamed\Countries\Model\Language;
use Hamed\Countries\Model\Map;
use Hamed\Countries\Model\Name;
use Hamed\Countries\Model\NativeName;
use Hamed\Countries\Model\Translation;
use PHPUnit\Framework\TestCase;
use stdClass;

class CountryTest extends TestCase
{
    public function testCountry()
    {
        $country = new Country(
            new Name(
                'Germany',
                'Federal Republic of Germany',
                [
                    new NativeName(
                        'Deutschland',
                        'Bundesrepublik Deutschland'
                    ),
                ]
            ),
            ['de'],
            'cca2',
            'ccn3',
            'cca3',
            true,
            'status',
            true,
            [
                'EUR' => [
                    'name' => 'Euro',
                    'symbol' => '€',
                ],
            ],
            new IDD('+49', []),
            ['Berlin'],
            ['Deutschland'],
            'Europe',
            'Europe',
            [
                'eng' => new Language('German'),
            ],
            [
                'ita' => new Translation(
                    'Repubblica federale di Germania',
                    'Germania'
                ),
            ],
            [49, 49],
            false,
            0,
            [
                'f' => new Demonym('German', 'Deutsch'),
                'm' => new Demonym('German', 'Deutsch'),
            ],
            'flag',
            new Map('googleMaps', 'openStreetMaps'),
            0,
            new Car(['a', 'b', 'c'], 'left'),
            ['UTC+01:00'],
            ['Europe'],
            new Flag('flag', 'png', 'alt'),
            new stdClass(),
            'monday',
            new CapitalInfo([1.22, 2.34, 53.00, 7])
        );

        $this->assertEquals('monday', $country->getStartOfWeek());
        $this->assertNotEmpty($country->getCoatOfArms());
        $this->assertNotEmpty($country->getFlags());
        $this->assertNotEmpty($country->getContinents());
        $this->assertNotEmpty($country->getTimezones());
        $this->assertEquals(0, $country->getPopulation());
        $this->assertInstanceOf(Map::class, $country->getMaps());
        $this->assertFalse($country->getLandlocked());
        $this->assertEquals(0, $country->getArea());
        $this->assertInstanceOf(Country::class, $country);
        $this->assertInstanceOf(Name::class, $country->getName());
        $this->assertInstanceOf(NativeName::class, $country->getName()->getNativeName()[0]);
        $this->assertContains('de', $country->getTld());
        $this->assertContains('cca2', $country->getCca2());
        $this->assertContains('ccn3', $country->getCcn3());
        $this->assertContains('cca3', $country->getCca3());
        $this->assertTrue($country->getIndependent());
        $this->assertEquals('status', $country->getStatus());
        $this->assertTrue($country->getUnMember());
        $this->assertNotEmpty($country->getCurrencies());
        $this->assertEquals('flag', $country->getFlag());
        $this->assertNotEmpty($country->getLatlng());
        $this->assertInstanceOf(IDD::class, $country->getIdd());
        $this->assertContains('Berlin', $country->getCapital());
        $this->assertContains('Deutschland', $country->getAltSpellings());
        $this->assertContains('Europe', $country->getRegion());
        $this->assertContains('Europe', $country->getSubregion());
        $this->assertInstanceOf(Language::class, $country->getLanguages()['eng']);
        $this->assertInstanceOf(Translation::class, $country->getTranslations()['ita']);
        $this->assertInstanceOf(Demonym::class, $country->getDemonyms()['f']);
        $this->assertInstanceOf(Demonym::class, $country->getDemonyms()['m']);
        $this->assertInstanceOf(Car::class, $country->getCar());
        $this->assertInstanceOf(CapitalInfo::class, $country->getCapitalInfo());
    }
}
