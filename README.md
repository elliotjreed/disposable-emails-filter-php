[![Contributor Covenant](https://img.shields.io/badge/Contributor%20Covenant-v2.0%20adopted-ff69b4.svg)](code_of_conduct.md)

# Disposable / Temporary Email Address Filter

This package provides a method for determining whether an email address is a disposable / temporary email address.

All credit to the maintaining of the list of disposable / temporary email addresses goes to [github.com/disposable-email-domains/disposable-email-domains](https://github.com/disposable-email-domains/disposable-email-domains).

This project and it's maintainer(s) do not discourage the use of such disposable / temporary email addresses, but simply allows for the detection of such.

## Usage

```php
<?php

require 'vendor/autoload.php';

use ElliotJReed\DisposableEmail\Email;

if ((new Email())->isDisposable('email@temporarymailaddress.com')) {
    echo 'This is a disposable / temporary email address';
}
```

If an invalid [email address](https://www.ietf.org/rfc/rfc0822.txt) is provided then an `InvalidEmailException` is thrown, so it is advisable to check that the email address is valid first. For example:

```php
<?php

require 'vendor/autoload.php';

use ElliotJReed\DisposableEmail\Email;

$email = 'not-a-real-email-address#example.net';

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    if ((new Email())->isDisposable($email)) {
        echo 'This is a disposable / temporary email address';
    }
} else {
    echo 'This is not a valid email address';
}
```

Would output:

```bash
This is not a valid email address
```

You can also provide your own custom domain list in a new line separated plain-text file, for example:

```text
example.com
example.net
```

Then passing the file location into the constructor:

```php
<?php

require 'vendor/autoload.php';

use ElliotJReed\DisposableEmail\Email;

new Email('/path/to/custom/list.txt');
```

If an invalid list is provided then an `InvalidDomainListException` is thrown.

## Getting Started with this Repository

PHP 7.4 or above and Composer is expected to be installed on our system.

### Installing Composer

For instructions on how to install Composer visit [getcomposer.org](https://getcomposer.org/download/).

### Installing the Package

```bash
composer require elliotjreed/disposable-emails-filter
```

### Installing for Development

After cloning this repository, change into the newly created directory and run

```bash
composer install
```

or if you have installed Composer locally

```bash
php composer.phar install
```

This will install all dependencies needed for the project.

## Running the Tests

All tests can be run by executing

```bash
composer run-script test
```

`phpunit` will automatically find all tests inside the `test` directory and run them based on the configuration in the `phpunit.xml` file.

## Built With

  - [github.com/disposable-email-domains/disposable-email-domains](https://github.com/disposable-email-domains/disposable-email-domains)
  - [PHP](https://secure.php.net/)
  - [Composer](https://getcomposer.org/)
  - [PHPUnit](https://phpunit.de/)

## License

This project is licensed under the MIT License - see the [LICENCE](LICENCE) file for details.
