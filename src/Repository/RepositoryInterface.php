<?php

declare(strict_types=1);

namespace Hamed\Countries\Repository;

interface RepositoryInterface
{
    public function getAll(): array;

    public function getByCapital(string $capital): array;

    public function getByCode(string $code): array;

    public function getByCurrency(string $currency): array;

    public function getByDemonym(string $demonym): array;

    public function getByFullName(string $name): array;

    public function getByLanguage(string $language): array;

    public function getByName(string $name): array;

    public function getByRegion(string $region): array;

    public function getBySubregion(string $subregion): array;

    public function getByTranslation(string $translation): array;
}