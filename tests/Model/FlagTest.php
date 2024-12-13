<?php

declare(strict_types=1);

namespace Hamed\Countries\Tests\Model;

use Hamed\Countries\Model\Flag;
use PHPUnit\Framework\TestCase;

class FlagTest extends TestCase
{
    public function testFlag()
    {
        $flag = new Flag('png', 'svg', 'alt');
        $this->assertInstanceOf(Flag::class, $flag);
        $this->assertEquals('png', $flag->getPng());
        $this->assertEquals('svg', $flag->getSvg());
        $this->assertEquals('alt', $flag->getAlt());
        $this->assertNotEquals('svg', $flag->getPng());
    }
}
