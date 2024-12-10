<?php

declare(strict_types=1);

namespace Hamed\Countries\Tests\Repository;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Hamed\Countries\Model\Country;
use Hamed\Countries\Model\Currency;
use Hamed\Countries\Model\Demonym;
use Hamed\Countries\Model\Language;
use Hamed\Countries\Normalizer\CountryNormalizer;
use Hamed\Countries\Repository\CountryRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use RuntimeException;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class CountryRepositoryTest extends TestCase
{
    /** @var ClientInterface|MockObject */
    protected $client;

    /** @var ResponseInterface|MockObject */
    protected $response;

    /** @var StreamInterface|MockObject */
    protected $stream;

    /** @var AdapterInterface|MockObject */
    protected $cache;

    /** @var CacheItemInterface|MockObject */
    protected $cacheItem;

    /** @var SerializerInterface */
    protected $serializer;


    protected function setUp()
    {
        $this->client = $this->createMock(Client::class);
        $this->response = $this->createMock(ResponseInterface::class);
        $this->stream = $this->createMock(StreamInterface::class);
        $this->response->method('getBody')->willReturn($this->stream);
        $this->cache = $this->createMock(AdapterInterface::class);
        $this->cacheItem = $this->createMock(CacheItemInterface::class);
        $this->serializer = new Serializer([
            new CountryNormalizer(),
            new ObjectNormalizer(),
            new ArrayDenormalizer(),
        ], [
            new JsonEncoder(),
        ]);
    }

    public function testGetAllCountriesWithoutCacheWillThrowRuntimeException()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'all'])
            ->willThrowException(new RuntimeException('Failed to fetch data from API'));

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Failed to fetch data from API');

        (new CountryRepository($this->client, $this->serializer))->getAll();
    }

    public function testGetAllCountriesWithoutCache()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'all'])
            ->willReturn($this->response);

        $this->stream
            ->expects($this->once())
            ->method('getContents')
            ->willReturn('[{"name":{"common":"South Georgia","official":"South Georgia and the South Sandwich Islands","nativeName":{"eng":{"official":"South Georgia and the South Sandwich Islands","common":"South Georgia"}}}},{"name":{"common":"Grenada","official":"Grenada","nativeName":{"eng":{"official":"Grenada","common":"Grenada"}}}}]');

        $repository = new CountryRepository($this->client, $this->serializer);

        $this->assertNotEmpty($repository->getAll());
    }

    public function testGetAllCountriesWithoutCacheAndSetCacheInEveryRequest()
    {
        $this->cache->expects($this->once())
        ->method('getItem')
        ->with(...['all'])
        ->willReturn($this->cacheItem);

        $this->cacheItem->expects($this->once())
        ->method('isHit')
        ->willReturn(false);

        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'all'])
            ->willReturn($this->response);

        $data = '[{"name":{"common":"South Georgia","official":"South Georgia and the South Sandwich Islands","nativeName":{"eng":{"official":"South Georgia and the South Sandwich Islands","common":"South Georgia"}}}},{"name":{"common":"Grenada","official":"Grenada","nativeName":{"eng":{"official":"Grenada","common":"Grenada"}}}}]';

        $this->stream
            ->expects($this->once())
            ->method('getContents')
            ->willReturn($data);
        
        $this->cacheItem->expects($this->once())
        ->method('set')
        ->with(...[$data])
        ->willReturn($this->cacheItem);

        $this->cache->expects($this->once())
        ->method('save')
        ->willReturn(true);

        $repository = new CountryRepository($this->client, $this->serializer, $this->cache);

        $this->assertNotEmpty($repository->getAll());
        
    }

    public function testGetAllCountriesWithCache()
    {
        $this->cache->expects($this->once())
        ->method('getItem')
        ->with(...['all'])
        ->willReturn($this->cacheItem);
    
        $this->cacheItem->expects($this->once())
        ->method('isHit')
        ->willReturn(true);

        $this->cacheItem->expects($this->once())
        ->method('get')
        ->willReturn('[{"name":{"common":"South Georgia","official":"South Georgia and the South Sandwich Islands","nativeName":{"eng":{"official":"South Georgia and the South Sandwich Islands","common":"South Georgia"}}}},{"name":{"common":"Grenada","official":"Grenada","nativeName":{"eng":{"official":"Grenada","common":"Grenada"}}}}]');

        $repository = new CountryRepository($this->client, $this->serializer, $this->cache);

        $this->assertNotEmpty($repository->getAll());
    }

    public function testGetCountriesByCapitalWithoutCache()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'capital/berlin'])
            ->willReturn($this->response);

        $this->stream
            ->expects($this->once())
            ->method('getContents')
            ->willReturn('[{"name":{"common":"Germany","official":"Federal Republic of Germany","nativeName":{"deu":{"official":"Bundesrepublik Deutschland","common":"Deutschland"}}},"capital":["Berlin"]}]');

        $repository = new CountryRepository($this->client, $this->serializer);

        $countries = $repository->getByCapital('berlin');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
            $this->assertEquals('Berlin', $country->getCapital()[0]);
        }
    }

    public function testGetCountriesByCodeWithoutCache()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'alpha/de'])
            ->willReturn($this->response);

        $this->stream
            ->expects($this->once())
            ->method('getContents')
            ->willReturn('[{"name":{"common":"Germany","official":"Federal Republic of Germany","nativeName":{"deu":{"official":"Bundesrepublik Deutschland","common":"Deutschland"}}},"cca2":"DE","cca3":"DEU","ccn3":"276","capital":["Berlin"]}]');

        $repository = new CountryRepository($this->client, $this->serializer);

        $countries = $repository->getByCode('de');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
            $this->assertEquals('DE', $country->getCca2());
            $this->assertEquals('276', $country->getCcn3());
            $this->assertEquals('DEU', $country->getCca3());
        }
    }

    public function testGetCountriesByCurrencyWithoutCache()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'currency/euro'])
            ->willReturn($this->response);

        $this->stream
            ->expects($this->once())
            ->method('getContents')
            ->willReturn('[{"name":{"common":"Germany","official":"Federal Republic of Germany","nativeName":{"deu":{"official":"Bundesrepublik Deutschland","common":"Deutschland"}}},"cca2":"DE","cca3":"DEU","ccn3":"276","capital":["Berlin"],"currencies":{"EUR":{"name":"Euro","symbol":"€"}}}]');

        $repository = new CountryRepository($this->client, $this->serializer);

        $countries = $repository->getByCurrency('euro');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
            foreach ($country->getCurrencies() as $currency) {
                $this->assertInstanceOf(Currency::class, $currency);
                $this->assertEquals('Euro', $currency->getName());
                $this->assertEquals('€', $currency->getSymbol());
            }
        }
    }

    public function testGetCountriesByDemonymWithoutCache()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'demonym/german'])
            ->willReturn($this->response);

        $this->stream
            ->expects($this->once())
            ->method('getContents')
            ->willReturn('[{"name":{"common":"Germany","official":"Federal Republic of Germany","nativeName":{"deu":{"official":"Bundesrepublik Deutschland","common":"Deutschland"}}},"cca2":"DE","cca3":"DEU","ccn3":"276","capital":["Berlin"],"currencies":{"EUR":{"name":"Euro","symbol":"€"}},"demonyms":{"eng":{"f":"German","m":"German"},"fra":{"f":"Allemande","m":"Allemand"}}}]');

        $repository = new CountryRepository($this->client, $this->serializer);

        $countries = $repository->getByDemonym('german');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
            foreach ($country->getDemonyms() as $key => $demonym) {
                if ($key === 'eng') {
                    $this->assertInstanceOf(Demonym::class, $demonym);
                    $this->assertEquals('German', $demonym->getF());
                    $this->assertEquals('German', $demonym->getM());
                }
                if ($key === 'fra') {
                    $this->assertInstanceOf(Demonym::class, $demonym);
                    $this->assertEquals('Allemande', $demonym->getF());
                    $this->assertEquals('Allemand', $demonym->getM());
                }
            }
        }
    }

    public function testGetCountriesByFullNameWithoutCache()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'name/germany?fullText=true'])
            ->willReturn($this->response);

        $this->stream
            ->expects($this->once())
            ->method('getContents')
            ->willReturn('[{"name":{"common":"Germany","official":"Federal Republic of Germany","nativeName":{"deu":{"official":"Bundesrepublik Deutschland","common":"Deutschland"}}},"cca2":"DE","cca3":"DEU","ccn3":"276","capital":["Berlin"],"currencies":{"EUR":{"name":"Euro","symbol":"€"}},"demonyms":{"eng":{"f":"German","m":"German"},"fra":{"f":"Allemande","m":"Allemand"}}}]');

        $repository = new CountryRepository($this->client, $this->serializer);

        $countries = $repository->getByFullName('germany');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
            $this->assertEquals('Germany', $country->getName()->getCommon());
            $this->assertEquals('Federal Republic of Germany', $country->getName()->getOfficial());
            $this->assertEquals('Berlin', $country->getCapital()[0]);
        }
    }

    public function testGetCountriesByLanguageWithoutCache()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'lang/german'])
            ->willReturn($this->response);

        $this->stream
            ->expects($this->once())
            ->method('getContents')
            ->willReturn('[{"name":{"common":"Germany","official":"Federal Republic of Germany","nativeName":{"deu":{"official":"Bundesrepublik Deutschland","common":"Deutschland"}}},"cca2":"DE","cca3":"DEU","ccn3":"276","capital":["Berlin"],"currencies":{"EUR":{"name":"Euro","symbol":"€"}},"demonyms":{"eng":{"f":"German","m":"German"},"fra":{"f":"Allemande","m":"Allemand"}},"languages":{"deu":"German"}}]');

        $repository = new CountryRepository($this->client, $this->serializer);

        $countries = $repository->getByLanguage('german');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
            foreach ($country->getLanguages() as $key => $language) {
                $this->assertInstanceOf(Language::class, $language);
                $this->assertEquals('deu', $key);
                $this->assertEquals('German', $language->getName());
            }
        }
    }

    public function testGetCountriesByNameWithoutCache()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'name/germany'])
            ->willReturn($this->response);

        $this->stream
            ->expects($this->once())
            ->method('getContents')
            ->willReturn('[{"name":{"common":"Germany","official":"Federal Republic of Germany","nativeName":{"deu":{"official":"Bundesrepublik Deutschland","common":"Deutschland"}}},"cca2":"DE","cca3":"DEU","ccn3":"276","capital":["Berlin"],"currencies":{"EUR":{"name":"Euro","symbol":"€"}},"demonyms":{"eng":{"f":"German","m":"German"},"fra":{"f":"Allemande","m":"Allemand"}},"languages":{"deu":"German"}}]');

        $repository = new CountryRepository($this->client, $this->serializer);

        $countries = $repository->getByName('germany');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
            $this->assertEquals('Germany', $country->getName()->getCommon());
            $this->assertEquals('Federal Republic of Germany', $country->getName()->getOfficial());
            $this->assertEquals('Berlin', $country->getCapital()[0]);
        }
    }

    public function testGetCountriesByRegionWithoutCache()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'region/europe'])
            ->willReturn($this->response);

        $this->stream
            ->expects($this->once())
            ->method('getContents')
            ->willReturn('[{"name":{"common":"Germany","official":"Federal Republic of Germany","nativeName":{"deu":{"official":"Bundesrepublik Deutschland","common":"Deutschland"}}},"cca2":"DE","cca3":"DEU","ccn3":"276","capital":["Berlin"],"currencies":{"EUR":{"name":"Euro","symbol":"€"}},"demonyms":{"eng":{"f":"German","m":"German"},"fra":{"f":"Allemande","m":"Allemand"}},"languages":{"deu":"German"},"region":"Europe"}]');

        $repository = new CountryRepository($this->client, $this->serializer);

        $countries = $repository->getByRegion('europe');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
            $this->assertEquals('Europe', $country->getRegion());
        }
    }

    public function testGetCountriesBySubregionWithoutCache()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'subregion/Western Europe'])
            ->willReturn($this->response);

        $this->stream
            ->expects($this->once())
            ->method('getContents')
            ->willReturn('[{"name":{"common":"Germany","official":"Federal Republic of Germany","nativeName":{"deu":{"official":"Bundesrepublik Deutschland","common":"Deutschland"}}},"cca2":"DE","cca3":"DEU","ccn3":"276","capital":["Berlin"],"currencies":{"EUR":{"name":"Euro","symbol":"€"}},"demonyms":{"eng":{"f":"German","m":"German"},"fra":{"f":"Allemande","m":"Allemand"}},"languages":{"deu":"German"},"region":"Europe","subregion":"Western Europe"}]');

        $repository = new CountryRepository($this->client, $this->serializer);

        $countries = $repository->getBySubregion('Western Europe');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
            $this->assertEquals('Western Europe', $country->getSubregion());
        }
    }

    public function testGetCountriesByTranslationWithoutCache()
    {
        $this->client
            ->expects($this->once())
            ->method('request')
            ->with(...['GET', 'translation/germany'])
            ->willReturn($this->response);

        $this->stream
            ->expects($this->once())
            ->method('getContents')
            ->willReturn('[{"name":{"common":"Germany","official":"Federal Republic of Germany","nativeName":{"deu":{"official":"Bundesrepublik Deutschland","common":"Deutschland"}}},"cca2":"DE","cca3":"DEU","ccn3":"276","capital":["Berlin"],"currencies":{"EUR":{"name":"Euro","symbol":"€"}},"demonyms":{"eng":{"f":"German","m":"German"},"fra":{"f":"Allemande","m":"Allemand"}},"languages":{"deu":"German"},"region":"Europe","subregion":"Western Europe","translations":{"per":{"official":"جمهوری فدرال آلمان","common":"آلمان"},"ita":{"official":"Repubblica federale di Germania","common":"Germania"}}}]');

        $repository = new CountryRepository($this->client, $this->serializer);

        $countries = $repository->getByTranslation('germany');

        $this->assertNotEmpty($countries);

        foreach ($countries as $country) {
            $this->assertInstanceOf(Country::class, $country);
            $this->assertEquals('Germany', $country->getName()->getCommon());
            $this->assertEquals('Federal Republic of Germany', $country->getName()->getOfficial());
            $this->assertEquals('Berlin', $country->getCapital()[0]);
            $this->assertCount(2, $country->getTranslations());
        }
    }
}
