<?php

declare(strict_types=1);

namespace Hamed\Countries\Repository;

interface RepositoryInterface
{
    public function getAll();

    public function getByCapital(string $capital);

    public function getByCode(string $code);

    public function getByCurrency(string $currency);

    public function getByDemonym(string $demonym);

    public function getByFullName(string $name);

    public function getByLanguage(string $language);

    public function getByName(string $name);

    public function getByRegion(string $region);

    public function getBySubregion(string $subregion);

    public function getByTranslation(string $translation);
}
