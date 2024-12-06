<?php

declare(strict_types=1);

namespace Hamed\Countries\Tests\Unit\Repository;

use Hamed\Countries\Http\Client;
use Hamed\Countries\Repository\Repository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

class RepositoryTest extends TestCase
{
    /** @var Client|MockObject */
    protected $client;

    /** @var SerializerInterface|MockObject */
    protected $serializer;

    protected function setUp()
    {
        $this->client = $this->createMock(Client::class);
        $this->serializer = $this->createMock(SerializerInterface::class);
    }

    public function testDeserialize()
    {
        $this->serializer->method('deserialize')
            ->with(...['{"key": "value"}', 'SomeClass', 'json'])
            ->willReturn((object)['key' => 'value']);

        $repository = new class($this->client, $this->serializer) extends Repository {
            public function test() {
                return $this->deserialize('{"key": "value"}', 'SomeClass');
            }
        };

        $result = $repository->test();
    
        $this->assertEquals((object)['key' => 'value'], $result);
    }
}