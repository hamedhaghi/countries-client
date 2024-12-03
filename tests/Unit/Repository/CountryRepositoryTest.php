<?php

declare(strict_types=1);

namespace Hamed\Countries\Tests\Unit\Repository;

use Hamed\Countries\Http\Client;
use Hamed\Countries\Model\Country;
use Hamed\Countries\Normalizer\CountryNormalizer;
use Hamed\Countries\Repository\CountryRepository;
use Hamed\Countries\Tests\Fixture\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class CountryRepositoryTest extends TestCase
{
    /** @var Client|MockObject */
    protected $client;

    /** @var SerializerInterface */
    protected $serializer;

    /** @var CountryRepository */
    protected $countryRepository;

    protected function setUp()
    {
        $this->client = $this->createMock(Client::class);
        $this->serializer = new Serializer([
            new CountryNormalizer(),
            new ObjectNormalizer(),
            new ArrayDenormalizer(),
        ], [
            new JsonEncoder(),
        ]);

        $this->countryRepository = new CountryRepository(
            $this->client,
            $this->serializer
        );
    }

    public function testGetAllCountries()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'all'])
            ->willReturn($this->client);

        $this->client
            ->expects($this->once())
            ->method('getData')
            ->willReturn('[
                {
                    "name": {
                        "common": "South Georgia",
                        "official": "South Georgia and the South Sandwich Islands",
                        "nativeName": {
                            "eng": {
                                "official": "South Georgia and the South Sandwich Islands",
                                "common": "South Georgia"
                            }
                        }
                    }
                },
                {
                    "name": {
                        "common": "Grenada",
                        "official": "Grenada",
                        "nativeName": {
                            "eng": {
                                "official": "Grenada",
                                "common": "Grenada"
                            }
                        }
                    }
                }
            ]'
        );

        $this->assertNotEmpty($this->countryRepository->getAll());
    }

    public function testGetCountriesByCapital()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'capital/berlin'])
            ->willReturn($this->client);

        $this->client
            ->expects($this->once())
            ->method('getData')
            ->willReturn('[
                {
                    "name": {
                        "common": "Germany",
                        "official": "Federal Republic of Germany",
                        "nativeName": {
                            "deu": {
                                "official": "Bundesrepublik Deutschland",
                                "common": "Deutschland"
                            }
                        }
                    },
                    "capital": [
                        "Berlin"
                    ]
                }
            ]'
        );

        $countries = $this->countryRepository->getByCapital('berlin');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
            $this->assertEquals('Berlin', $country->getCapital()[0]);
        }
    }

    public function testGetCountriesByCode()
    {
        $this->client->expects($this->once())
            ->method('request')
            ->with('GET', 'alpha/de')
            ->willReturn($this->response);

        $this->response->expects($this->once())
            ->method('getBody')
            ->willReturn($this->stream);

        $this->stream->expects($this->once())
            ->method('getContents')
            ->willReturn(Response::byCode());

        $countries = $this->countryRepository->getByCode('de');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
            $this->assertEquals('DE', $country->getCca2());
            $this->assertEquals('276', $country->getCcn3());
            $this->assertEquals('DEU', $country->getCca3());
        }
    }

    public function testGetCountriesByCurrency()
    {
        $this->client->expects($this->once())
            ->method('request')
            ->with('GET', 'currency/euro')
            ->willReturn($this->response);

        $this->response->expects($this->once())
            ->method('getBody')
            ->willReturn($this->stream);

        $this->stream->expects($this->once())
            ->method('getContents')
            ->willReturn(Response::byCurrency());

        $countries = $this->countryRepository->getByCurrency('euro');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
            foreach ($country->getCurrencies() as $currency) {
                $this->assertEquals('Euro', $currency->getName());
            }
        }
    }

    public function testGetCountriesByDemonym()
    {
        $this->client->expects($this->once())
            ->method('request')
            ->with('GET', 'demonym/german')
            ->willReturn($this->response);

        $this->response->expects($this->once())
            ->method('getBody')
            ->willReturn($this->stream);

        $this->stream->expects($this->once())
            ->method('getContents')
            ->willReturn(Response::byDemonym());

        $countries = $this->countryRepository->getByDemonym('german');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
            foreach ($country->getDemonyms() as $key => $demonym) {
                if ($key === 'eng') {
                    $this->assertEquals('German', $demonym->getF());
                    $this->assertEquals('German', $demonym->getM());
                }
            }
        }
    }

    public function testGetCountriesByFullName()
    {
        $this->client->expects($this->once())
            ->method('request')
            ->with('GET', 'name/germany?fullText=true')
            ->willReturn($this->response);

        $this->response->expects($this->once())
            ->method('getBody')
            ->willReturn($this->stream);

        $this->stream->expects($this->once())
            ->method('getContents')
            ->willReturn(Response::byFullName());

        $countries = $this->countryRepository->getByFullName('germany');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
            $this->assertEquals('Germany', $country->getName()->getCommon());
            $this->assertEquals('Federal Republic of Germany', $country->getName()->getOfficial());
            $this->assertEquals('Berlin', $country->getCapital()[0]);
        }
    }

    public function testGetCountriesByLanguage()
    {
        $this->client->expects($this->once())
            ->method('request')
            ->with('GET', 'lang/german')
            ->willReturn($this->response);

        $this->response->expects($this->once())
            ->method('getBody')
            ->willReturn($this->stream);

        $this->stream->expects($this->once())
            ->method('getContents')
            ->willReturn(Response::byLanguage());

        $countries = $this->countryRepository->getByLanguage('german');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
            foreach ($country->getLanguages() as $key => $language) {
                $this->assertEquals('de', $key);
                $this->assertEquals('German', $language->getName());
            }
        }
    }

    public function testGetCountriesByName()
    {
        $this->client->expects($this->once())
            ->method('request')
            ->with('GET', 'name/germany')
            ->willReturn($this->response);

        $this->response->expects($this->once())
            ->method('getBody')
            ->willReturn($this->stream);

        $this->stream->expects($this->once())
            ->method('getContents')
            ->willReturn(Response::byName());

        $countries = $this->countryRepository->getByName('germany');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
            $this->assertEquals('Germany', $country->getName()->getCommon());
            $this->assertEquals('Federal Republic of Germany', $country->getName()->getOfficial());
            $this->assertEquals('Berlin', $country->getCapital()[0]);
        }
    }

    public function testGetCountriesByRegion()
    {
        $this->client->expects($this->once())
            ->method('request')
            ->with('GET', 'region/europe')
            ->willReturn($this->response);

        $this->response->expects($this->once())
            ->method('getBody')
            ->willReturn($this->stream);

        $this->stream->expects($this->once())
            ->method('getContents')
            ->willReturn(Response::byRegion());

        $countries = $this->countryRepository->getByRegion('europe');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
            $this->assertEquals('Europe', $country->getRegion());
        }
    }

    public function testGetCountriesBySubregion()
    {
        $this->client->expects($this->once())
            ->method('request')
            ->with('GET', 'subregion/Western Europe')
            ->willReturn($this->response);

        $this->response->expects($this->once())
            ->method('getBody')
            ->willReturn($this->stream);

        $this->stream->expects($this->once())
            ->method('getContents')
            ->willReturn(Response::bySubregion());

        $countries = $this->countryRepository->getBySubregion('Western Europe');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
            $this->assertEquals('Western Europe', $country->getSubregion());
        }
    }

    public function testGetCountriesByTranslation()
    {
        $this->client->expects($this->once())
            ->method('request')
            ->with('GET', 'translation/germany')
            ->willReturn($this->response);

        $this->response->expects($this->once())
            ->method('getBody')
            ->willReturn($this->stream);

        $this->stream->expects($this->once())
            ->method('getContents')
            ->willReturn(Response::byTranslation());

        $countries = $this->countryRepository->getByTranslation('germany');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
            $this->assertEquals('Germany', $country->getName()->getCommon());
            $this->assertEquals('Federal Republic of Germany', $country->getName()->getOfficial());
            $this->assertEquals('Berlin', $country->getCapital()[0]);
        }
    }
}
