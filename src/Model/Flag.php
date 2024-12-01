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

    /**
     * @param string $png
     * @param string $svg
     * @param string $alt
     * @return void
     * */
    public function __construct(string $png, string $svg, string $alt)
    {
        $this->png = $png;
        $this->svg = $svg;
        $this->alt = $alt;
    }

    /**
     * @return string
     * */
    public function getPng(): string
    {
        return $this->png;
    }

    /**
     * @return string
     * */
    public function getSvg(): string
    {
        return $this->svg;
    }

    /**
     * @return string
     * */
    public function getAlt(): string
    {
        return $this->alt;
    }
}
