<?php

declare(strict_types=1);

namespace Hamed\Countries\Model;

class CapitalInfo
{
    /** @var array<int,float> */
    private $latlng;

    /**
     * @param array<int,float> $latlng
     */
    public function __construct(array $latlng)
    {
        $this->latlng = $latlng;
    }

    /**
     * @return array<int,float>
     */
    public function getLatlng(): array
    {
        return $this->latlng;
    }
}
