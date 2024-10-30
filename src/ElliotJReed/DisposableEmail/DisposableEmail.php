<?php

declare(strict_types=1);

namespace ElliotJReed\DisposableEmail;

use ElliotJReed\DisposableEmail\Exceptions\InvalidDomainListException;

final class DisposableEmail
{
    /**
     * @param string $email The email address to check whether it is a disposable or temporary email address
     *
     * @return bool Returns true when the provided email address is likely to be a disposable or temporary email address
     *
     * @throws Exceptions\InvalidEmailException
     * @throws InvalidDomainListException
     */
    public static function isDisposable(string $email): bool
    {
        return (new Email())->isDisposable($email);
    }

    /**
     * @return string[] Returns an array of disposable and temporary email address domains
     *
     * @throws InvalidDomainListException
     */
    public static function getDomainList(): array
    {
        return (new Email())->getDomainList();
    }
}
