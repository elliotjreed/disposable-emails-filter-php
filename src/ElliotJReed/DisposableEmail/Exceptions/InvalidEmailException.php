<?php

declare(strict_types=1);

namespace ElliotJReed\DisposableEmail\Exceptions;

use Exception;

final class InvalidEmailException extends Exception
{
    protected $message = 'The email address specified is invalid according to RFC 822.';
}
