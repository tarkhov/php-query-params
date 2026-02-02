# PHP Query Params

Set url querystring params using PHP.

### Contents

1. [Compatibility](#compatibility)
2. [Installation](#installation)
   1. [Composer](#composer)
3. [Usage](#usage)
   1. [Filter query params](#filter-query-params)
   2. [Remove query params from url](#remove-query-params-from-url)
   3. [Set query params](#set-query-params)
   4. [Build url from parts](#build-url-from-parts)
4. [Author](#author)
5. [License](#license)

## Compatibility

Library | Version
------- | -------
PHP | >= 7.4

## Installation

### Composer

```bash
composer require tarkhov/php-query-params
```

## Usage

### Filter query params

Return specified query params from querystring.

```php
<?php
use PHPQueryParams\QueryParams;

$params = QueryParams::filter(['param1', 'param2'], 'param1=a&param2=b&param3=c');
// Output will be: param1=a&param2=b
echo $params;
```

### Remove query params from url

```php
<?php
use PHPQueryParams\QueryParams;

$url = QueryParams::remove(['param1', 'param2'], 'https://example.com/?param1=a&param2=b&param3=c');
// Output will be: https://example.com/?param3=c
echo $url;

// Remove single param
$url = QueryParams::remove('param1', 'https://example.com/?param1=a&param2=b&param3=c');
// Output will be: https://example.com/?param2=b&param3=c
echo $url;
```

### Set query params

```php
<?php
use PHPQueryParams\QueryParams;

$url = QueryParams::set(['param1' => 'new_value', 'param2' => 'new_value', 'param4' => 'new_param'], 'https://example.com/?param1=a&param2=b&param3=c');
// Output will be: https://example.com/?param1=new_value&param2=new_value&param3=c&param4=new_param
echo $url;
```

### Build url from parts

```php
<?php
use PHPQueryParams\QueryParams;

$parts = parse_url('https://example.com/?param1=a&param2=b&param3=c');
$parts['host'] = 'new-domain.com';
$url = QueryParams::toUrl($parts);
// Output will be: https://new-domain.com/?param1=a&param2=b&param3=c
echo $url;
```

## Author

* [Twitter](https://x.com/tarkhovich)
* [Medium](https://medium.com/@tarkhov)

## License

This project is licensed under the **MIT License** - see the `LICENSE` file for details.