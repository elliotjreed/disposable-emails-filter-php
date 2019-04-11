<?php
declare(strict_types=1);

namespace ElliotJReed\DisposableEmail\Static;

use ElliotJReed\DisposableEmail\Exceptions\InvalidEmailException;

final class Email
{
    /**
     * @param string $email The email address to check whether it is a disposable or temporary email address
     * @param string $emailListPath [optional] The path to a custom list of email domains
     * @return bool
     * @throws InvalidEmailException
     */
    public static function isDisposable(string $email, string $emailListPath = __DIR__ . '/../../../list.txt'): bool
    {
        if (!\filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException();
        }

        return self::inDisposableEmailList($email, $emailListPath);
    }

    /**
     * @param string $email The email address to check whether it is a disposable or temporary email address
     * @param string $emailListPath The path to a custom list of email domains
     * @return bool
     */
    private static function inDisposableEmailList(string $email, string $emailListPath): bool
    {
        $emailDomain = \substr($email, \strpos($email, '@') + 1);
        $file = new \SplFileObject($emailListPath);
        $emailList = \explode("\n", $file->fread($file->getSize()));

        return \in_array(\strtolower(\trim($emailDomain)), $emailList, true);
    }
}
