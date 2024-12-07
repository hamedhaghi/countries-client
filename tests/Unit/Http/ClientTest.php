<?php

declare(strict_types=1);

namespace Hamed\Countries\Tests\Unit\Http;

use GuzzleHttp\ClientInterface;
use Hamed\Countries\Http\Client;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\Cache\Adapter\AbstractAdapter;

class ClientTest extends TestCase
{
    /** @var ClientInterface|MockObject */
    protected $http;

    /** @var ResponseInterface|MockObject */
    protected $response;

    /** @var StreamInterface|MockObject */
    protected $stream;

    /** @var AbstractAdapter|MockObject */
    protected $cacheAdapter;

    /** @var CacheItemInterface|MockObject */
    protected $cacheItem;

    protected function setUp()
    {
        $this->http = $this->createMock(ClientInterface::class);
        $this->response = $this->createMock(ResponseInterface::class);
        $this->stream = $this->createMock(StreamInterface::class);
        $this->cacheAdapter = $this->createMock(AbstractAdapter::class);
        $this->cacheItem = $this->createMock(CacheItemInterface::class);
    }

    public function testRequestWithoutCache()
    {
        $this->http->expects($this->once())
            ->method('request')
            ->with(...['GET', 'http://example.com'])
            ->willReturn($this->response);
        $client = new Client($this->http);
        $client->request('GET', 'http://example.com');
        $this->assertInstanceOf(ResponseInterface::class, $client->getResponse());
        $this->assertSame($this->response, $client->getResponse());
    }

    public function testRequestWithCacheWithNoHit()
    {
        $data = '{"key": "value"}';

        $this->cacheAdapter->expects($this->once())
            ->method('getItem')
            ->with(...['http://example.com'])
            ->willReturn($this->cacheItem);

        $this->cacheItem->expects($this->once())
            ->method('isHit')
            ->willReturn(false);

        $this->http->expects($this->once())
            ->method('request')
            ->with(...['GET', 'http://example.com'])
            ->willReturn($this->response);

        $this->cacheItem->expects($this->once())
            ->method('set')
            ->with(...[$data])
            ->willReturn($this->cacheItem);

        $this->response->expects($this->once())
            ->method('getBody')
            ->willReturn($this->stream);

        $this->stream->expects($this->once())
            ->method('getContents')
            ->willReturn($data);

        $this->cacheItem->expects($this->once())
            ->method('expiresAfter')
            ->with(...[100])
            ->willReturn($this->cacheItem);

        $this->cacheAdapter->expects($this->once())
            ->method('save')
            ->with(...[$this->cacheItem])
            ->willReturn(true);

        $this->cacheItem->expects($this->once())
            ->method('get')
            ->willReturn($data);

        $client = (new Client($this->http))
            ->setIsCachable(true)
            ->setCacheTTL(100)
            ->setCacheAdapter($this->cacheAdapter)
            ->request('GET', 'http://example.com');

        $this->assertInstanceOf(ResponseInterface::class, $client->getResponse());
        $this->assertSame($this->response, $client->getResponse());
        $this->assertSame($data, $client->getData());
    }

    public function testRequestWithCacheWithHit()
    {
        $data = '{"key": "value"}';

        $this->cacheAdapter->expects($this->once())
            ->method('getItem')
            ->with(...['http://example.com'])
            ->willReturn($this->cacheItem);

        $this->cacheItem->expects($this->once())
            ->method('isHit')
            ->willReturn(true);

        $this->cacheItem->expects($this->once())
            ->method('get')
            ->willReturn($data);

        $client = (new Client($this->http))
            ->setIsCachable(true)
            ->setCacheTTL(100)
            ->setCacheAdapter($this->cacheAdapter)
            ->request('GET', 'http://example.com');

        $this->assertSame($data, $client->getData());
    }
}