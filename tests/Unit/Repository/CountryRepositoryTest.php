<?php

declare(strict_types=1);

namespace Hamed\Countries\Tests\Unit\Repository;

use PHPUnit\Framework\TestCase;
use Hamed\Countries\Repository\CountryRepository;
use PHPUnit\Framework\MockObject\MockObject;
use GuzzleHttp\ClientInterface;
use Hamed\Countries\Tests\Fixture\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class CountryRepositoryTest extends TestCase
{
    /** @var ClientInterface|MockObject */
    protected $client;

    /** @var ResponseInterface|MockObject */
    protected $response;

    /** @var StreamInterface|MockObject */
    protected $stream;

    /** @var CountryRepository */
    protected $countryRepository;

    /** @var string */
    protected $data;

    protected function setUp()
    {
        $this->client = $this->createMock(ClientInterface::class);
        $this->response = $this->createMock(ResponseInterface::class);
        $this->stream = $this->createMock(StreamInterface::class);
        $this->countryRepository = new CountryRepository($this->client);
        $this->data = Response::get();
    }

    public function testGetAllCountries()
    {
        $this->client->expects($this->once())
        ->method('request')
        ->with('GET', 'all')
        ->willReturn($this->response);

        $this->response->expects($this->once())
        ->method('getBody')
        ->willReturn($this->stream);

        $this->stream->expects($this->once())
        ->method('getContents')
        ->willReturn($this->data);

        $countries = $this->countryRepository->getAll();
        
        $this->assertNotEmpty($countries);
    }
}
