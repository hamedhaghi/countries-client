<?php

declare(strict_types=1);

namespace Hamed\Countries\Model;

use stdClass;

class Country
{
    /** @var Name */
    public $name;

    /** @var array<int,string> */
    public $tld;

    /** @var string */
    public $cca2;

    /** @var string */
    public $ccn3;

    /** @var string */
    public $cca3;

    /** @var bool */
    public $independent;

    /** @var string */
    public $status;

    /** @var bool */
    public $unMember;

    /** @var Currency[] */
    public $currencies;

    /** @var IDD[] */
    public $idd;

    /** @var array<int,string> */
    public $capital;

    /** @var array<int,string> */
    public $altSpellings;

    /** @var string */
    public $region;

    /** @var Language[] */
    public $languages;

    /** @var Translation[] */
    public $translations;

    /** @var array<int,int|float> */
    public $latlng;

    /** @var bool */
    public $landlocked;

    /** @var int */
    public $area;

    /** @var Demonym[] */
    public $demonyms;

    /** @var string */
    public $flag;

    /** @var Map */
    public $maps;

    /** @var int */
    public $population;

    /** @var Car */
    public $car;

    /** @var array<int,string> */
    public $timezones;

    /** @var array<int,string> */
    public $continents;

    /** @var Flag */
    public $flags;

    /** @var stdClass */
    public $coatOfArms;

    /** @var string */
    public $startOfWeek;

    /** @var CapitalInfo */
    public $capitalInfo;
}
