<?php

declare(strict_types=1);

namespace ElliotJReed\DisposableEmail\Exceptions;

use Exception;

final class InvalidDomainListException extends Exception
{
    protected $message = 'Failed to read from file containing the list of temporary email address domains.';
}
