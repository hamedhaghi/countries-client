<?php

declare(strict_types=1);

namespace Hamed\Countries\Tests\Model;

use Hamed\Countries\Model\Name;
use Hamed\Countries\Model\NativeName;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class NameTest extends TestCase
{
    public function testName()
    {
        $name = new Name(
            'Germany',
            'Federal Republic of Germany',
            [
                new NativeName(
                    'Bundesrepublik Deutschland',
                    'Deutschland'
                ),
            ]
        );

        $this->assertInstanceOf(Name::class, $name);
        $this->assertEquals('Germany', $name->getCommon());
        $this->assertEquals('Federal Republic of Germany', $name->getOfficial());
        $this->assertNotEmpty($name->getNativeName());
        $this->assertInstanceOf(NativeName::class, $name->getNativeName()[0]);
        $this->assertEquals('Bundesrepublik Deutschland', $name->getNativeName()[0]->getCommon());
        $this->assertEquals('Deutschland', $name->getNativeName()[0]->getOfficial());
        $this->assertNotEquals('UK', $name->getCommon());
    }
}
