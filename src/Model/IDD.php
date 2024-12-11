<?php

declare(strict_types=1);

namespace Hamed\Countries\Model;

class IDD
{
    /** @var string */
    private $root;

    /** @var array<int,string> */
    private $suffixes;

    /**
     * @param array<int,string> $suffixes
     */
    public function __construct(string $root, array $suffixes)
    {
        $this->root = $root;
        $this->suffixes = $suffixes;
    }

    public function getRoot(): string
    {
        return $this->root;
    }

    /**
     * @return array<int,string>
     */
    public function getSuffixes(): array
    {
        return $this->suffixes;
    }
}
