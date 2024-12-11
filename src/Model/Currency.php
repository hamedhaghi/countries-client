<?php

declare(strict_types=1);

namespace Hamed\Countries\Model;

class Currency
{
    /** @var string */
    private $name;

    /** @var string */
    private $symbol;

    public function __construct(string $name, string $symbol)
    {
        $this->name = $name;
        $this->symbol = $symbol;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }
}
