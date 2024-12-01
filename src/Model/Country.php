<?php

declare(strict_types=1);

namespace Hamed\Countries\Model;

use stdClass;

class Country
{
	/** @var Name */
	private $name;

	/** @var array<int,string> */
	private $tld;

	/** @var string */
	private $cca2;

	/** @var string */
	private $ccn3;

	/** @var string */
	private $cca3;

	/** @var bool */
	private $independent;

	/** @var string */
	private $status;

	/** @var bool */
	private $unMember;

	/** @var array<string,Currency> */
	private $currencies;

	/** @var IDD */
	private $idd;

	/** @var array<int,string> */
	private $capital;

	/** @var array<int,string> */
	private $altSpellings;

	/** @var string */
	private $region;

	/** @var array<string,Language> */
	private $languages;

	/** @var array<string,Translation> */
	private $translations;

	/** @var array<int,float> */
	private $latlng;

	/** @var bool */
	private $landlocked;

	/** @var float */
	private $area;

	/** @var array<string,Demonym> */
	private $demonyms;

	/** @var string */
	private $flag;

	/** @var Map */
	private $maps;

	/** @var int */
	private $population;

	/** @var Car */
	private $car;

	/** @var array<int,string> */
	private $timezones;

	/** @var array<int,string> */
	private $continents;

	/** @var Flag */
	private $flags;

	/** @var array|stdClass */
	private $coatOfArms;

	/** @var string */
	private $startOfWeek;

	/** @var CapitalInfo */
	private $capitalInfo;

	public function __construct(
		Name $name,
		array $tld,
		string $cca2,
		string $ccn3,
		string $cca3,
		bool $independent,
		string $status,
		bool $unMember,
		array $currencies,
		IDD $idd,
		array $capital,
		array $altSpellings,
		string $region,
		array $languages,
		array $translations,
		array $latlng,
		bool $landlocked,
		float $area,
		array $demonyms,
		string $flag,
		Map $maps,
		int $population,
		Car $car,
		array $timezones,
		array $continents,
		Flag $flags,
		$coatOfArms,
		string $startOfWeek,
		CapitalInfo $capitalInfo
	) {
		$this->name = $name;
		$this->tld = $tld;
		$this->cca2 = $cca2;
		$this->ccn3 = $ccn3;
		$this->cca3 = $cca3;
		$this->independent = $independent;
		$this->status = $status;
		$this->unMember = $unMember;
		$this->currencies = $currencies;
		$this->idd = $idd;
		$this->capital = $capital;
		$this->altSpellings = $altSpellings;
		$this->region = $region;
		$this->languages = $languages;
		$this->translations = $translations;
		$this->latlng = $latlng;
		$this->landlocked = $landlocked;
		$this->area = $area;
		$this->demonyms = $demonyms;
		$this->flag = $flag;
		$this->maps = $maps;
		$this->population = $population;
		$this->car = $car;
		$this->timezones = $timezones;
		$this->continents = $continents;
		$this->flags = $flags;
		$this->coatOfArms = $coatOfArms;
		$this->startOfWeek = $startOfWeek;
		$this->capitalInfo = $capitalInfo;
	}

	/**
	 * @return Name
	 */
	public function getName(): Name
	{
		return $this->name;
	}

	/**
	 * @return array<int,string>
	 */
	public function getTld(): array
	{
		return $this->tld;
	}

	/**
	 * @return string
	 */
	public function getCca2(): string
	{
		return $this->cca2;
	}

	/**
	 * @return string
	 */
	public function getCcn3(): string
	{
		return $this->ccn3;
	}

	/**
	 * @return string
	 */
	public function getCca3(): string
	{
		return $this->cca3;
	}

	/**
	 * @return bool
	 */
	public function getIndependent(): bool
	{
		return $this->independent;
	}

	/**
	 * @return string
	 */
	public function getStatus(): string
	{
		return $this->status;
	}

	/**
	 * @return bool
	 */
	public function getUnMember(): bool
	{
		return $this->unMember;
	}

	/**
	 * @return array<string,Currency>
	 */
	public function getCurrencies(): array
	{
		return $this->currencies;
	}

	/**
	 * @return IDD
	 */
	public function getIdd(): IDD
	{
		return $this->idd;
	}

	/**
	 * @return array<int,string>
	 */
	public function getCapital(): array
	{
		return $this->capital;
	}

	/**
	 * @return array<int,string>
	 */
	public function getAltSpellings(): array
	{
		return $this->altSpellings;
	}

	/**
	 * @return string
	 */
	public function getRegion(): string
	{
		return $this->region;
	}

	/**
	 * @return array<string,Language>
	 */
	public function getLanguages(): array
	{
		return $this->languages;
	}

	/**
	 * @return array<string,Translation>
	 */
	public function getTranslations(): array
	{
		return $this->translations;
	}

	/**
	 * @return array<int,float>
	 */
	public function getLatlng(): array
	{
		return $this->latlng;
	}

	/**
	 * @return bool
	 */
	public function getLandlocked(): bool
	{
		return $this->landlocked;
	}

	/**
	 * @return float
	 */
	public function getArea(): float
	{
		return $this->area;
	}

	/**
	 * @return array<string,Demonym>
	 */
	public function getDemonyms(): array
	{
		return $this->demonyms;
	}

	/**
	 * @return string
	 */
	public function getFlag(): string
	{
		return $this->flag;
	}

	/**
	 * @return Map
	 */
	public function getMaps(): Map
	{
		return $this->maps;
	}

	/**
	 * @return int
	 */
	public function getPopulation(): int
	{
		return $this->population;
	}

	/**
	 * @return Car
	 */
	public function getCar(): Car
	{
		return $this->car;
	}

	/**
	 * @return array<int,string>
	 */
	public function getTimezones(): array
	{
		return $this->timezones;
	}

	/**
	 * @return array<int,string>
	 */
	public function getContinents(): array
	{
		return $this->continents;
	}

	/**
	 * @return Flag
	 */
	public function getFlags(): Flag
	{
		return $this->flags;
	}

	/**
	 * @return array|stdClass
	 */
	public function getCoatOfArms()
	{
		return $this->coatOfArms;
	}

	/**
	 * @return string
	 */
	public function getStartOfWeek(): string
	{
		return $this->startOfWeek;
	}

	/**
	 * @return CapitalInfo
	 */
	public function getCapitalInfo(): CapitalInfo
	{
		return $this->capitalInfo;
	}
}
