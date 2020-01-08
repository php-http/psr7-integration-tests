# HTTP Message

[![Total Downloads](https://img.shields.io/packagist/dt/php-http/psr7-integration-tests.svg?style=flat-square)](https://packagist.org/packages/php-http/psr7-integration-tests)

**Test PSR7 implementations against the specification.**

## Status

| PSR7 Implementation | Status        |
| ------------------- |:-------------:|
| Guzzle              | [![Guzzle](https://travis-matrix-badges.herokuapp.com/repos/php-http/psr7-integration-tests/branches/master/1)](https://travis-ci.org/php-http/psr7-integration-tests)      |
| Laminas             | [![Laminas](https://travis-matrix-badges.herokuapp.com/repos/php-http/psr7-integration-tests/branches/master/2)](https://travis-ci.org/php-http/psr7-integration-tests)        |
| Slim                | [![Slim](https://travis-matrix-badges.herokuapp.com/repos/php-http/psr7-integration-tests/branches/master/3)](https://travis-ci.org/php-http/psr7-integration-tests)        |
| Nyholm              | [![Nyholm](https://travis-matrix-badges.herokuapp.com/repos/php-http/psr7-integration-tests/branches/master/4)](https://travis-ci.org/php-http/psr7-integration-tests)      |
| RingCentral         | [![RingCentral](https://travis-matrix-badges.herokuapp.com/repos/php-http/psr7-integration-tests/branches/master/5)](https://travis-ci.org/php-http/psr7-integration-tests)      |

## Install

Via Composer

``` bash
$ composer require --dev php-http/psr7-integration-tests
```


## Documentation

Please see the [official documentation](http://docs.php-http.org/en/latest).


## Testing

``` bash
$ composer test
```

It is also possible to exclude tests that require a live internet connection:

``` bash
$ composer test -- --exclude-group internet
```

## Contributing

Please see our [contributing guide](http://docs.php-http.org/en/latest/development/contributing.html).

## Security

If you discover any security related issues, please contact us at [security@php-http.org](mailto:security@php-http.org).

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
