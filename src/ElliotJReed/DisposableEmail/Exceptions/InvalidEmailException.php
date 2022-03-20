<?php

declare(strict_types=1);

namespace ElliotJReed\DisposableEmail\Exceptions;

final class InvalidEmailException extends DisposableEmailException
{
    protected $message = 'The email address specified is invalid according to RFC 822.';
}
