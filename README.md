# HTTP Message

[![Total Downloads](https://img.shields.io/packagist/dt/php-http/psr7-integration-tests.svg?style=flat-square)](https://packagist.org/packages/php-http/psr7-integration-tests)

**Test PSR7 implementations against the specification.**

## Status

| PSR7 Implementation | Status        | Legacy |
| ------------------- |:-------------:|:------:|
| Guzzle              | [![Guzzle](https://github.com/php-http/psr7-integration-tests/actions/workflows/guzzle.yml/badge.svg)](https://github.com/php-http/psr7-integration-tests/actions/workflows/guzzle.yml)                |
| Laminas             | [![Laminas](https://github.com/php-http/psr7-integration-tests/actions/workflows/laminas.yml/badge.svg)](https://github.com/php-http/psr7-integration-tests/actions/workflows/laminas.yml)             |  [Legacy](https://github.com/php-http/psr7-integration-tests/actions/workflows/laminas-legacy.yml) (failures expected) |
| Slim                | [![Slim](https://github.com/php-http/psr7-integration-tests/actions/workflows/slim.yml/badge.svg)](https://github.com/php-http/psr7-integration-tests/actions/workflows/slim.yml)                      |
| Nyholm              | [![Nyholm](https://github.com/php-http/psr7-integration-tests/actions/workflows/nyholm.yml/badge.svg)](https://github.com/php-http/psr7-integration-tests/actions/workflows/nyholm.yml)                |
| RingCentral         | [![RingCentral](https://github.com/php-http/psr7-integration-tests/actions/workflows/ringcentral.yml/badge.svg)](https://github.com/php-http/psr7-integration-tests/actions/workflows/ringcentral.yml) |
| HttpSoft            |  [![HttpSoft](https://github.com/php-http/psr7-integration-tests/actions/workflows/httpsoft.yml/badge.svg)](https://github.com/php-http/psr7-integration-tests/actions/workflows/httpsoft.yml)         |

## Install

To use the integration tests with a PSR-7 implementation, add this package to the dev dependencies:

``` bash
$ composer require --dev php-http/psr7-integration-tests
```

Then set up phpunit to run the tests for your implementation.

## Documentation

Please see the [official documentation](http://docs.php-http.org/en/latest).


## Testing

This repository also is set up to test a couple of implementations directly. You need to install dependencies from source for the tests to work:

``` bash
$ composer update --prefer-source
```

**Note:** If you already have the sources installed, you need to delete the vendor folder before running the above command.

Run the test suite for one implementation with:

``` bash
$ composer test -- --testsuite <name>
```

The names are `Guzzle`, `Laminas`, `Slim`, `Nyholm`, `RingCentral`.

It is also possible to exclude tests that require a live internet connection:

``` bash
$ composer test -- --testsuite <name> --exclude-group internet
```

## Contributing

Please see our [contributing guide](http://docs.php-http.org/en/latest/development/contributing.html).

## Security

If you discover any security related issues, please contact us at [security@php-http.org](mailto:security@php-http.org).

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
