<?php

declare(strict_types=1);

namespace ElliotJReed\DisposableEmail\Exceptions;

final class InvalidDomainListException extends DisposableEmailException
{
    protected $message = 'Failed to read from file containing the list of temporary email address domains.';
}
