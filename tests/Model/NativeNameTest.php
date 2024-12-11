<?php

declare(strict_types=1);

namespace Hamed\Countries\Tests\Model;

use Hamed\Countries\Model\NativeName;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class NativeNameTest extends TestCase
{
    public function testNativeName()
    {
        $nativeName = new NativeName('Deutschland', 'Bundesrepublik Deutschland');

        $this->assertInstanceOf(NativeName::class, $nativeName);
        $this->assertEquals('Deutschland', $nativeName->getCommon());
        $this->assertEquals('Bundesrepublik Deutschland', $nativeName->getOfficial());
        $this->assertNotEquals('UK', $nativeName->getCommon());
    }
}
