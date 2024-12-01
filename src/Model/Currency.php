<?php

declare(strict_types=1);

namespace Hamed\Countries\Model;

class Currency
{
    /** @var string */
    private $name;

    /** @var string */
    private $symbol;

    /**
     * @param string $name
     * @param string $symbol
     * @return void
     */
    public function __construct(string $name, string $symbol)
    {
        $this->name = $name;
        $this->symbol = $symbol;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }
}
