<?php

declare(strict_types=1);

namespace Hamed\Countries\Tests\Model;

use Hamed\Countries\Model\IDD;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class IDDTest extends TestCase
{
    public function testIDD()
    {
        $idd = new IDD('1', ['2', '3']);
        $this->assertInstanceOf(IDD::class, $idd);
        $this->assertEquals('1', $idd->getRoot());
        $this->assertEquals(['2', '3'], $idd->getSuffixes());
        $this->assertNotEquals('2', $idd->getRoot());
    }
}
