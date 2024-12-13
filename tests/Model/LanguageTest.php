<?php

declare(strict_types=1);

namespace Hamed\Countries\Tests\Model;

use Hamed\Countries\Model\Language;
use PHPUnit\Framework\TestCase;

class LanguageTest extends TestCase
{
    public function testLanguage()
    {
        $language = new Language('German');

        $this->assertInstanceOf(Language::class, $language);
        $this->assertEquals('German', $language->getName());
        $this->assertNotEquals('English', $language->getName());
    }
}
