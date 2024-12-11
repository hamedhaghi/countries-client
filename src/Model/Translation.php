<?php

declare(strict_types=1);

namespace Hamed\Countries\Model;

class Translation
{
    /** @var string */
    private $official;

    /** @var string */
    private $common;

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
