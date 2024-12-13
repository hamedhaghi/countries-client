<?php

declare(strict_types=1);

namespace Hamed\Countries\Tests\Model;

use Hamed\Countries\Model\Demonym;
use PHPUnit\Framework\TestCase;

class DemonymTest extends TestCase
{
    public function testDemonym()
    {
        $demonym = new Demonym('German', 'German');
        $this->assertInstanceOf(Demonym::class, $demonym);
        $this->assertEquals('German', $demonym->getF());
        $this->assertEquals('German', $demonym->getM());
        $this->assertNotEquals('English', $demonym->getF());
        $this->assertNotEquals('English', $demonym->getM());
    }
}
