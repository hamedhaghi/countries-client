# Countries PHP Client

A PHP client for the [RestCountries API](https://restcountries.com/). This package simplifies interacting with the API by providing an object-oriented interface to retrieve country data.

## Features

- Fetch detailed information about countries.
- Support for caching to improve performance.
- Compatible with both legacy and modern PHP projects.

## Requirements

- PHP 7.0 or higher

## Installation

Install the package via Composer:

```bash
composer require hamedhaghi/countries
```

## Usage Example

```php
require 'vendor/autoload.php';

use Hamed\Countries\Factory;

// Initialize the client
$factory = new CountryRepositoryFactory();

// Enable caching for faster responses (optional)
$factory = $factory->isCachable()
                   ->setCacheTTL(3600); // Cache expiration time in seconds

// Initialize the repository
$repository = $factory->init();

// Query country data
$countries = $repository->getAll();
$countries = $repository->getByCapital('Berlin');
$countries = $repository->getByCode('DE');
$countries = $repository->getByCurrency('Euro');
$countries = $repository->getByDemonym('German');
$countries = $repository->getByFullName('Germany');
$countries = $repository->getByLanguage('German');
$countries = $repository->getByName('Germany');
$countries = $repository->getByRegion('Europe');
$countries = $repository->getBySubregion('Western Europe');
$countries = $repository->getByTranslation('Germany');

// Clear the cache
$factory->clearCache();

```

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request with your changes.

## License

This project is licensed under the MIT License.
