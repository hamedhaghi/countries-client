<?php

declare(strict_types=1);

namespace Hamed\Countries\Tests\Fixture;

class Response
{
    public static function get(): string
    {
        return file_get_contents(__DIR__ . '/snapshots/all.json');
    }
}