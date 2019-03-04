[![Build Status](https://travis-ci.org/elliotjreed/disposable-emails-filter-php.svg?branch=master)](https://travis-ci.org/elliotjreed/disposable-emails-filter-php)[![Coverage Status](https://coveralls.io/repos/github/elliotjreed/disposable-emails-filter-php/badge.svg?branch=master)](https://coveralls.io/github/elliotjreed/disposable-emails-filter-php?branch=master)

# Disposable / Temporary Email Address Filter

This package provides a method for determining whether an email address is a disposable / temporary email address.

All credit to the maintaining of the list of disposable / temporary email addresses goes to [github.com/martenson/disposable-email-domains](https://github.com/martenson/disposable-email-domains).

This project and it's maintainer(s) do not discourage the use of such disposable / temporary email addresses, but simply allows for the detection of such.


## Usage

```php
<?php
require 'vendor/autoload.php';

use ElliotJReed\DisposableEmail\Email;

if (Email::isDisposable('email@not-disposable.com')) {
    echo 'This is a disposable / temporary email address';
}
```


## Getting Started

PHP 7 or above and Composer is expected to be installed on our system.


### Installing Composer

For instructions on how to install Composer visit [getcomposer.org](https://getcomposer.org/download/).


### Installing

After cloning this repository, change into the newly created directory and run

```
composer install
```

or if you have installed Composer locally

```
php composer.phar install
```

This will install all dependencies needed for the project.


## Running the Tests

All tests can be run by executing

```
vendor/bin/phpunit
```

`phpunit` will automatically find all tests inside the `test` directory and run them based on the configuration in the `phpunit.xml` file.


## Built With

- [github.com/martenson/disposable-email-domains](https://github.com/martenson/disposable-email-domains)
- [PHP](https://secure.php.net/)
- [Composer](https://getcomposer.org/)
- [PHPUnit](https://phpunit.de/)


## License

This project is licensed under the MIT License - see the [LICENCE](LICENCE) file for details.
