<?php

declare(strict_types=1);

namespace ElliotJReed\DisposableEmail;

final class DisposableEmail
{
    /**
     * @param string $email The email address to check whether it is a disposable or temporary email address
     *
     * @return bool Returns true when the provided email address is likely to be a disposable or temporary email address
     *
     * @throws \ElliotJReed\DisposableEmail\Exceptions\InvalidEmailException
     * @throws \ElliotJReed\DisposableEmail\Exceptions\InvalidDomainListException
     */
    public static function isDisposable(string $email): bool
    {
        return (new Email())->isDisposable($email);
    }
}
