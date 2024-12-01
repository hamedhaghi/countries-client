<?php

declare(strict_types=1);

namespace Hamed\Countries\Tests\Fixture;

class Response
{
    public static function all(): string
    {
        return file_get_contents(__DIR__ . '/snapshots/all.json');
    }

    public static function byCapital(): string
    {
        return file_get_contents(__DIR__ . '/snapshots/capital.json');
    }

    public static function byCode(): string
    {
        return file_get_contents(__DIR__ . '/snapshots/code.json');
    }

    public static function byCurrency(): string
    {
        return file_get_contents(__DIR__ . '/snapshots/currency.json');
    }

    public static function byDemonym(): string
    {
        return file_get_contents(__DIR__ . '/snapshots/demonym.json');
    }

    public static function byFullName(): string
    {
        return file_get_contents(__DIR__ . '/snapshots/fullname.json');
    }

    public static function byLanguage(): string
    {
        return file_get_contents(__DIR__ . '/snapshots/language.json');
    }

    public static function byName(): string
    {
        return file_get_contents(__DIR__ . '/snapshots/name.json');
    }

    public static function byRegion(): string
    {
        return file_get_contents(__DIR__ . '/snapshots/region.json');
    }

    public static function bySubregion(): string
    {
        return file_get_contents(__DIR__ . '/snapshots/subregion.json');
    }

    public static function byTranslation(): string
    {
        return file_get_contents(__DIR__ . '/snapshots/translation.json');
    }
}
