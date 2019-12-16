<?php

declare(strict_types=1);

namespace ElliotJReed\DisposableEmail;

use ElliotJReed\DisposableEmail\Exceptions\InvalidDomainListException;
use ElliotJReed\DisposableEmail\Exceptions\InvalidEmailException;
use SplFileObject;

final class Email
{
    private string $emailListPath;

    /**
     * @param string $emailListPath The path to a custom list of email domains. The default is the list maintained by [github.com/martenson/disposable-email-domains](https://github.com/martenson/disposable-email-domains).
     */
    public function __construct(string $emailListPath = __DIR__ . '/../../../list.txt')
    {
        $this->emailListPath = $emailListPath;
    }

    /**
     * @param string $email The email address to check whether it is a disposable or temporary email address
     * @return bool
     * @throws InvalidEmailException
     * @throws InvalidDomainListException
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
     * @throws InvalidDomainListException
     * @throws InvalidEmailException
     */
    private function inDisposableEmailList(string $email): bool
    {
        $emailDomain = $this->getEmailDomainFromFullEmailAddress($email);

        return \in_array($this->normaliseEmailDomain($emailDomain), $this->getDomainsFromFile(), true);
    }

    /**
     * @param string $email The full email address.
     * @return string
     * @throws InvalidEmailException
     */
    private function getEmailDomainFromFullEmailAddress(string $email): string
    {
        $domain = \substr($email, (int) \strpos($email, '@') + 1);

        if ($domain === false) {
            throw new InvalidEmailException();
        }

        return $domain;
    }

    /**
     * @param string $emailDomain The email domain following the "@" symbol.
     * @return string
     */
    private function normaliseEmailDomain(string $emailDomain): string
    {
        return \strtolower(\trim($emailDomain));
    }

    /**
     * @return array
     * @throws InvalidDomainListException
     */
    private function getDomainsFromFile(): array
    {
        $file = new SplFileObject($this->emailListPath);
        $fileContents = $file->fread($file->getSize());
        if ($fileContents === false) {
            throw new InvalidDomainListException('Could not read file: ' . $this->emailListPath);
        }

        return \explode("\n", $fileContents);
    }
}
