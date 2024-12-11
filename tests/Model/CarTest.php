<?php

declare(strict_types=1);

namespace Hamed\Countries\Tests\Model;

use Hamed\Countries\Model\Car;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class CarTest extends TestCase
{
    public function testCar()
    {
        $car = new Car(
            ['a', 'b', 'c'],
            'left'
        );
        $this->assertInstanceOf(Car::class, $car);
        $this->assertEquals(['a', 'b', 'c'], $car->getSigns());
        $this->assertEquals('left', $car->getSide());
        $this->assertNotEquals('right', $car->getSide());
    }
}
