<?php

declare(strict_types=1);

namespace Hamed\Countries\Tests\Unit\Repository;

use Hamed\Countries\Http\Client;
use Hamed\Countries\Model\Country;
use Hamed\Countries\Model\Currency;
use Hamed\Countries\Normalizer\CountryNormalizer;
use Hamed\Countries\Repository\CountryRepository;
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
            /** @var Currency $currency */
            $this->assertInstanceOf(Country::class, $country);
            $this->assertEquals('Berlin', $country->getCapital()[0]);
        }
    }

    public function testGetCountriesByCode()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'alpha/de'])
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
                    "cca2": "DE",
                    "cca3": "DEU",
                    "ccn3": "276",
                    "capital": [
                        "Berlin"
                    ]
                }
            ]'
            );

        $countries = $this->countryRepository->getByCode('de');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            /** @var Currency $currency */
            $this->assertInstanceOf(Country::class, $country);
            $this->assertEquals('DE', $country->getCca2());
            $this->assertEquals('276', $country->getCcn3());
            $this->assertEquals('DEU', $country->getCca3());
        }
    }

    public function testGetCountriesByCurrency()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'currency/euro'])
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
                "cca2": "DE",
                "cca3": "DEU",
                "ccn3": "276",
                "capital": [
                    "Berlin"
                ],
                "currencies": { 
                    "EUR": {
                        "name": "Euro",
                        "symbol": "€"   
                    }
                }
            }
        ]'
            );

        $countries = $this->countryRepository->getByCurrency('euro');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
            foreach ($country->getCurrencies() as $currency) {
                /** @var Currency $currency */
                $this->assertEquals('Euro', $currency->getName());
                $this->assertEquals('€', $currency->getSymbol());
            }
        }
    }

    public function testGetCountriesByDemonym()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'demonym/german'])
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
                "cca2": "DE",
                "cca3": "DEU",
                "ccn3": "276",
                "capital": [
                    "Berlin"
                ],
                "currencies": { 
                    "EUR": {
                        "name": "Euro",
                        "symbol": "€"   
                    }
                },
                "demonyms": {
                    "eng": {
                        "f": "German",
                        "m": "German"
                    },
                    "fra": {
                        "f": "Allemande",
                        "m": "Allemand"
                    }
                }        
            }
        ]'
            );


        $countries = $this->countryRepository->getByDemonym('german');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            /** @var Country $country */
            $this->assertInstanceOf(Country::class, $country);
            foreach ($country->getDemonyms() as $key => $demonym) {
                if ($key === 'eng') {
                    $this->assertEquals('German', $demonym->getF());
                    $this->assertEquals('German', $demonym->getM());
                }
                if ($key === 'fra') {
                    $this->assertEquals('Allemande', $demonym->getF());
                    $this->assertEquals('Allemand', $demonym->getM());
                }
            }
        }
    }

    public function testGetCountriesByFullName()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'name/germany?fullText=true'])
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
            "cca2": "DE",
            "cca3": "DEU",
            "ccn3": "276",
            "capital": [
                "Berlin"
            ],
            "currencies": { 
                "EUR": {
                    "name": "Euro",
                    "symbol": "€"   
                }
            },
            "demonyms": {
                "eng": {
                    "f": "German",
                    "m": "German"
                },
                "fra": {
                    "f": "Allemande",
                    "m": "Allemand"
                }
            }        
        }
    ]'
            );

        $countries = $this->countryRepository->getByFullName('germany');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            /** @var Country $country */
            $this->assertInstanceOf(Country::class, $country);
            $this->assertEquals('Germany', $country->getName()->getCommon());
            $this->assertEquals('Federal Republic of Germany', $country->getName()->getOfficial());
            $this->assertEquals('Berlin', $country->getCapital()[0]);
        }
    }

    public function testGetCountriesByLanguage()
    {

        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'lang/german'])
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
        "cca2": "DE",
        "cca3": "DEU",
        "ccn3": "276",
        "capital": [
            "Berlin"
        ],
        "currencies": { 
            "EUR": {
                "name": "Euro",
                "symbol": "€"   
            }
        },
        "demonyms": {
            "eng": {
                "f": "German",
                "m": "German"
            },
            "fra": {
                "f": "Allemande",
                "m": "Allemand"
            }
        },
        "languages": {
            "deu": "German"
        }        
    }
]'
            );

        $countries = $this->countryRepository->getByLanguage('german');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            /** @var Country $country */
            $this->assertInstanceOf(Country::class, $country);
            foreach ($country->getLanguages() as $key => $language) {
                $this->assertEquals('deu', $key);
                $this->assertEquals('German', $language->getName());
            }
        }
    }

    public function testGetCountriesByName()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'name/germany'])
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
    "cca2": "DE",
    "cca3": "DEU",
    "ccn3": "276",
    "capital": [
        "Berlin"
    ],
    "currencies": { 
        "EUR": {
            "name": "Euro",
            "symbol": "€"   
        }
    },
    "demonyms": {
        "eng": {
            "f": "German",
            "m": "German"
        },
        "fra": {
            "f": "Allemande",
            "m": "Allemand"
        }
    },
    "languages": {
        "deu": "German"
    }        
}
]'
            );

        $countries = $this->countryRepository->getByName('germany');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            /** @var Country $country */
            $this->assertInstanceOf(Country::class, $country);
            $this->assertEquals('Germany', $country->getName()->getCommon());
            $this->assertEquals('Federal Republic of Germany', $country->getName()->getOfficial());
            $this->assertEquals('Berlin', $country->getCapital()[0]);
        }
    }

    public function testGetCountriesByRegion()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'region/europe'])
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
    "cca2": "DE",
    "cca3": "DEU",
    "ccn3": "276",
    "capital": [
        "Berlin"
    ],
    "currencies": { 
        "EUR": {
            "name": "Euro",
            "symbol": "€"   
        }
    },
    "demonyms": {
        "eng": {
            "f": "German",
            "m": "German"
        },
        "fra": {
            "f": "Allemande",
            "m": "Allemand"
        }
    },
    "languages": {
        "deu": "German"
    },
    "region": "Europe"       
}
]'
            );

        $countries = $this->countryRepository->getByRegion('europe');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            /** @var Country $country */
            $this->assertInstanceOf(Country::class, $country);
            $this->assertEquals('Europe', $country->getRegion());
        }
    }

    public function testGetCountriesBySubregion()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'subregion/Western Europe'])
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
    "cca2": "DE",
    "cca3": "DEU",
    "ccn3": "276",
    "capital": [
        "Berlin"
    ],
    "currencies": { 
        "EUR": {
            "name": "Euro",
            "symbol": "€"   
        }
    },
    "demonyms": {
        "eng": {
            "f": "German",
            "m": "German"
        },
        "fra": {
            "f": "Allemande",
            "m": "Allemand"
        }
    },
    "languages": {
        "deu": "German"
    },
    "region": "Europe",
    "subregion": "Western Europe"
}
]'
            );

        $countries = $this->countryRepository->getBySubregion('Western Europe');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            /** @var Country $country */
            $this->assertInstanceOf(Country::class, $country);
            $this->assertEquals('Western Europe', $country->getSubregion());
        }
    }

    public function testGetCountriesByTranslation()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'translation/germany'])
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
    "cca2": "DE",
    "cca3": "DEU",
    "ccn3": "276",
    "capital": [
        "Berlin"
    ],
    "currencies": { 
        "EUR": {
            "name": "Euro",
            "symbol": "€"   
        }
    },
    "demonyms": {
        "eng": {
            "f": "German",
            "m": "German"
        },
        "fra": {
            "f": "Allemande",
            "m": "Allemand"
        }
    },
    "languages": {
        "deu": "German"
    },
    "region": "Europe",
    "subregion": "Western Europe",
    "translations": {
        "per": {
            "official": "جمهوری فدرال آلمان",
            "common": "آلمان"
        },
        "ita": {
            "official": "Repubblica federale di Germania",
            "common": "Germania"
        }
    }
}
]'
            );

        $countries = $this->countryRepository->getByTranslation('germany');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            /** @var Country $country */
            $this->assertInstanceOf(Country::class, $country);
            $this->assertEquals('Germany', $country->getName()->getCommon());
            $this->assertEquals('Federal Republic of Germany', $country->getName()->getOfficial());
            $this->assertEquals('Berlin', $country->getCapital()[0]);
            $this->assertCount(2, $country->getTranslations());
        }
    }
}
