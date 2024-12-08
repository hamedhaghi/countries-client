<?php

declare(strict_types=1);

namespace Hamed\Countries\Tests\Model;

use Hamed\Countries\Model\CapitalInfo;
use PHPUnit\Framework\TestCase;


class CapitalInfoTest extends TestCase
{
    public function testCapitalInfo()
    {
        $captialInfo = new CapitalInfo(
            [1.22, 2.34, 53.00, 7]
        );

        $this->assertInstanceOf(CapitalInfo::class, $captialInfo);
        $this->assertNotEmpty($captialInfo->getLatlng());
        $this->assertCount(4, $captialInfo->getLatlng());
        $this->assertNotCount(3, $captialInfo->getLatlng());
    }
} 