<?php

declare(strict_types=1);

namespace Hamed\Countries\Model;

class NativeName {

    /** @var string */
    private $common;

    /** @var string */
    private $official;

    /**
     * @param string $common
     * @param string $official
     * @return void
     */
    public function __construct(string $common, string $official)
    {
        $this->common = $common;
        $this->official = $official;
    }
 
    /**
     * @return string
     */
    public function getCommon(): string
    {
        return $this->common;
    }

    /**
     * @return string
     */
    public function getOfficial(): string
    {
        return $this->official;
    }
}