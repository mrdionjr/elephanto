# Elephanto

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

## Description

A tiny promise-based HTTP Client for PHP, because why not ?


## Features

- Make Ajax request from PHP
- Based on the [GuzzlePromise](https://github.com/guzzle/promises)
- Intercept request and response
- Transform request and response data
- Cancel requests

## Install

Via Composer

``` bash
$ composer require mrdionjr/elephanto
```

## Usage

Performing a `GET` request

``` php
use Elephanto\Elephanto;
use Elephanto\Http\Response;

require '../vendor/autoload.php';

// Retrieve posts with a given user's ID
Elephanto::get('https://jsonplaceholder.typicode.com/posts?userId=1')
    ->then(function (Response $response) {
        return $response->array();
    })->then(function ($data) {
        var_dump($data); // [['id' => 1, 'userId' => 1]...]
    });


// Optionally the request above could also be done as
Elephanto::get('/user', [
    'params' => [
      'userId' => 1
    ]
  })
  ->then(function (Response $response) {
    var_dump($response->array());
  });

// Want to make a synchronous request ? Use the `wait` method
$response = Elephanto::get('https://jsonplaceholder.typicode.com/posts')->wait();
var_dump($response->array());

```

Performing a `POST` request

```php
Elephanto::post('https://jsonplaceholder.typicode.com/posts', [
    'title' => 'Elephanto is awesome !!',
    'author' => 'Salomon Dion'
  ])
  ->then(function ($response) {
      var_dump($response->array());
  });
```

## Elephanto API

Requests can be made by passing the relevant config to `Elephanto`.

### Request methods

##### Elephanto::get(url[, config])
##### Elephanto::post(url[, data[, config]])


###### NOTE
When using the requests methods `url`, `method`, and `body` properties don't need to be specified in config.

## Request Config

These are the available config options for making requests. Only the `url` is required. Requests will default to `GET` if `method` is not specified.

```php
[
  // `url` is the server URL that will be used for the request
  'url' => '/posts',

  // `method` is the request method to be used when making the request
  'method': 'GET', // default

  // `baseURL` will be prepended to `url` unless `url` is absolute.
  'baseURL' => 'https://some-domain.com/api/',

  // Request headers to be set
  'headers' => ['Content-Type' => 'application/json']
]
```

## Response Object

When using `then`, the response for a request contains the following information.

```php
Elephanto::get('/posts/1')
  ->then(function (Response $response) {
    // An array representation of the response, if JSON is returned
    $response->array();
    // `status` is the HTTP status code from the server response
    $response->status();
    // `statusText` is the HTTP status message from the server response
    $response->statusText();
    // `headers` the headers that the server responded with
    $response->headers();
    // `request` The request that generated this response
    $response->request();
  });
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email dev.mrdion@gmail.com instead of using the issue tracker.

## Credits

- [Salomon Dion][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/mrdionjr/elephanto.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/mrdionjr/elephanto/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/mrdionjr/elephanto.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/mrdionjr/elephanto.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/mrdionjr/elephanto.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/mrdionjr/elephanto
[link-travis]: https://travis-ci.org/mrdionjr/elephanto
[link-scrutinizer]: https://scrutinizer-ci.com/g/mrdionjr/elephanto/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/mrdionjr/elephanto
[link-downloads]: https://packagist.org/packages/mrdionjr/elephanto
[link-author]: https://github.com/mrdionjr
[link-contributors]: ../../contributors
