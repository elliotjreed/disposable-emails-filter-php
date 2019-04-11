<?php
declare(strict_types=1);

namespace ElliotJReed\DisposableEmail;

use ElliotJReed\DisposableEmail\Exceptions\InvalidEmailException;
use SplFileObject;

final class Email
{
    private $disposableEmailAddressDomainsListPath;

    /**
     * @param string $emailListPath The path to a custom list of email domains. The default is the list maintained by [github.com/martenson/disposable-email-domains](https://github.com/martenson/disposable-email-domains).
     */
    public function __construct(string $emailListPath = __DIR__ . '/../../../list.txt')
    {
        $this->disposableEmailAddressDomainsListPath = $emailListPath;
    }

    /**
     * @param string $email The email address to check whether it is a disposable or temporary email address
     * @return bool
     * @throws InvalidEmailException
     */
    public function isDisposable(string $email): bool
    {
        if (!\filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException();
        }

        return $this->inDisposableEmailList($email);
    }

    /**
     * @param string $email The email address to check whether it is a disposable or temporary email address
     * @return bool
     */
    private function inDisposableEmailList(string $email): bool
    {
        $emailDomain = $this->getEmailDomainFromFullEmailAddress($email);
        $file = new SplFileObject($this->disposableEmailAddressDomainsListPath);
        $emailList = \explode("\n", $file->fread($file->getSize()));

        return \in_array($this->normaliseEmailDomain($emailDomain), $emailList, true);
    }

    /**
     * @param string $email The full email address.
     * @return string
     */
    private function getEmailDomainFromFullEmailAddress(string $email): string
    {
        return \substr($email, \strpos($email, '@') + 1);
    }

    /**
     * @param string $emailDomain The email domain following the "@" symbol.
     * @return string
     */
    private function normaliseEmailDomain(string $emailDomain): string
    {
        return \strtolower(\trim($emailDomain));
    }
}
