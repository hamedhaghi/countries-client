<?php

declare(strict_types=1);

namespace Hamed\Countries\Model;

class NativeName
{
    /** @var string */
    private $common;

    /** @var string */
    private $official;

    public function __construct(string $common, string $official)
    {
        $this->common = $common;
        $this->official = $official;
    }

    public function getCommon(): string
    {
        return $this->common;
    }

    public function getOfficial(): string
    {
        return $this->official;
    }
}
