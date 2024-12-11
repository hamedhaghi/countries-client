<?php

declare(strict_types=1);

namespace Hamed\Countries\Tests\Model;

use Hamed\Countries\Model\Currency;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class CurrencyTest extends TestCase
{
    public function testCurrency()
    {
        $currency = new Currency('Euro', '€');
        $this->assertInstanceOf(Currency::class, $currency);
        $this->assertEquals('Euro', $currency->getName());
        $this->assertEquals('€', $currency->getSymbol());
        $this->assertNotEquals('Dollar', $currency->getName());
        $this->assertNotEquals('$', $currency->getSymbol());
    }
}
