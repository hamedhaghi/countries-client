<?php

declare(strict_types=1);

namespace Hamed\Countries\Model;

class Demonym
{
    /** @var string */
    private $f;
    /** @var string */
    private $m;

    public function __construct(string $f, string $m)
    {
        $this->f = $f;
        $this->m = $m;
    }

    /** @return string */
    public function getF(): string
    {
        return $this->f;
    }

    /** @return string */
    public function getM(): string
    {
        return $this->m;
    }
}
