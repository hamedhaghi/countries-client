<?php

declare(strict_types=1);

namespace Hamed\Countries\Model;

class Flag
{
    /** @var string */
    private $png;

    /** @var string */
    private $svg;

    /** @var string */
    private $alt;

    public function __construct(string $png, string $svg, string $alt)
    {
        $this->png = $png;
        $this->svg = $svg;
        $this->alt = $alt;
    }

    public function getPng(): string
    {
        return $this->png;
    }

    public function getSvg(): string
    {
        return $this->svg;
    }

    public function getAlt(): string
    {
        return $this->alt;
    }
}
