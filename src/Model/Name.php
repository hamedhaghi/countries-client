<?php 

declare(strict_types=1);

namespace Hamed\Countries\Model;

class Name {

    /** @var string */
    public $common;

    /** @var string */
    public $official;

    /** @var NativeName[] */
    public $nativeName;
}