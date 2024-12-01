<?php

declare(strict_types=1);

namespace Hamed\Countries\Model;

class Name
{
    /** @var string */
    private $common;

    /** @var string */
    private $official;

    /** @var array<string,NativeName> */
    private $nativeName;

    /**
     * @param string $common
     * @param string $official
     * @param array<string,NativeName> $nativeName
     * @return void
     * */
    public function __construct(string $common, string $official, array $nativeName = [])
    {
        $this->common = $common;
        $this->official = $official;
        $this->nativeName = $nativeName;
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

    /**
     * @return array<string,NativeName>
     */
    public function getNativeName(): array
    {
        return $this->nativeName;
    }
}
