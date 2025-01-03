<?php

declare(strict_types=1);

namespace Hamed\Countries\Model;

class Car
{
    /** @var array<int,string> */
    private $signs;

    /** @var string */
    private $side;

    /**
     * @param array<int,string> $signs
     * */
    public function __construct(array $signs, string $side)
    {
        $this->signs = $signs;
        $this->side = $side;
    }

    /**
     *  @return array<int,string>
     * */
    public function getSigns(): array
    {
        return $this->signs;
    }

    public function getSide(): string
    {
        return $this->side;
    }
}
