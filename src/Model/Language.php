<?php

declare(strict_types=1);

namespace Hamed\Countries\Model;

class Language
{
    /** @var string */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /** @return string */
    public function getName(): string
    {
        return $this->name;
    }
}
