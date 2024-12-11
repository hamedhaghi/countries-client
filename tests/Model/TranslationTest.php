<?php

declare(strict_types=1);

namespace Hamed\Countries\Tests\Model;

use Hamed\Countries\Model\Translation;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class TranslationTest extends TestCase
{
    public function testTranslation()
    {
        $translation = new Translation('Deautschland', 'Deutschland');

        $this->assertInstanceOf(Translation::class, $translation);
        $this->assertEquals('Deautschland', $translation->getCommon());
        $this->assertEquals('Deutschland', $translation->getOfficial());
        $this->assertNotEquals('UK', $translation->getCommon());
    }
}
