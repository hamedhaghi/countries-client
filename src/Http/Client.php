<?php

declare(strict_types=1);

namespace Hamed\Countries\Http;

use Exception;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Cache\Adapter\AbstractAdapter;

class Client
{
    /** @var ClientInterface */
    protected $http;

    /** @var string */
    protected $data;

    /** @var AbstractAdapter */
    protected $cacheAdapter;

    /** @var bool */
    protected $isCachable = false;

    /** @var int */
    protected $cacheTTL = 3600;

    /** @var ResponseInterface */
    protected $response;

    public function __construct(ClientInterface $http)
    {
        $this->http = $http;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function setCacheAdapter(AbstractAdapter $cacheAdapter): self
    {
        $this->cacheAdapter = $cacheAdapter;

        return $this;
    }

    public function setIsCachable(bool $isCachable): self
    {
        $this->isCachable = $isCachable;

        return $this;
    }

    public function setCacheTTL(int $cacheTTL): self
    {
        $this->cacheTTL = $cacheTTL;

        return $this;
    }

    /**
     * @param string $method
     * @param string $uri
     * @return self
     * @throws Exception
     */
    public function request(string $method, string $uri): self
    {
        if (!$this->isCachable) {
            $this->response = $this->http->request($method, $uri);
            return $this;
        }

        if (!$this->cacheAdapter) {
            throw new Exception('Cache adapter is not set');
        }

        $cacheItem = $this->cacheAdapter->getItem($uri);
        
        if (!$cacheItem->isHit()) {
            $this->response = $this->http->request($method, $uri);
            $cacheItem->set($this->response->getBody()->getContents())->expiresAfter($this->cacheTTL);
            $this->cacheAdapter->save($cacheItem);
        }

        $this->data = $cacheItem->get();

        return $this;
    }


}