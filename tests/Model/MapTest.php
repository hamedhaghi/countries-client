<?php

declare(strict_types=1);

namespace Hamed\Countries\Tests\Model;

use Hamed\Countries\Model\Map;
use PHPUnit\Framework\TestCase;

class MapTest extends TestCase
{
    public function testMap()
    {
        $map = new Map('googleMaps', 'openStreetMap');

        $this->assertInstanceOf(Map::class, $map);
        $this->assertEquals('googleMaps', $map->getGoogleMaps());
        $this->assertEquals('openStreetMap', $map->getOpenStreetMaps());
        $this->assertNotEquals('openStreetMap', $map->getGoogleMaps());
    }
}