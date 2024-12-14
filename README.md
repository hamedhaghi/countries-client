# Countries PHP Client

A PHP client for the [RestCountries API](https://restcountries.com/). This package simplifies interacting with the API by providing an object-oriented interface to retrieve country data.

## Features

- Fetch detailed information about countries.
- Caching support for improved performance.
- Easy integration with old and modern PHP projects.

## Requirements

- PHP 7.0 or higher

## Installation

Install the package via Composer:

```bash
composer require hamedhaghi/countries
```

### Usage Example

```php
require 'vendor/autoload.php';

use Hamed\Countries\Factory;

// Initialize the client
$repository = (new CountryRepositoryFactory())->init();

// Output country information
$countries = $repository->getAll();
$countries = $repository->getByCapital('berlin');
$countries = $repository->getByCode('DE');
$countries = $repository->getByCurrency('euro');
$countries = $repository->getByDemonym('german');
$countries = $repository->getByFullName('germany');
$countries = $repository->getByLanguage('german');
$countries = $repository->getByName('germany');
$countries = $repository->getByRegion('europe');
$countries = $repository->getBySubregion('western europe');
$countries = $repository->getByTranslation('germany');
```
