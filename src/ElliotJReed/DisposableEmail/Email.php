<?php

declare(strict_types=1);

namespace ElliotJReed\DisposableEmail;

use ElliotJReed\DisposableEmail\Exceptions\InvalidDomainListException;
use ElliotJReed\DisposableEmail\Exceptions\InvalidEmailException;
use SplFileObject;

class Email
{
    private string $emailListPath;

    /**
     * @param string $emailListPath The path to a custom list of email domains.
     *                              The default is the list maintained by
     *                              https://github.com/martenson/disposable-email-domains.
     */
    public function __construct(string $emailListPath = __DIR__ . '/../../../list.txt')
    {
        $this->emailListPath = $emailListPath;
    }

    /**
     * @param string $email The email address to check whether it is a disposable or temporary email address
     *
     * @throws InvalidEmailException
     * @throws InvalidDomainListException
     */
    public function isDisposable(string $email): bool
    {
        if (!\filter_var($email, \FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException();
        }

        return $this->inDisposableEmailList($email);
    }

    /**
     * @param string $email The email address to check whether it is a disposable or temporary email address
     *
     * @throws InvalidDomainListException
     */
    private function inDisposableEmailList(string $email): bool
    {
        $emailDomain = $this->getEmailDomainFromFullEmailAddress($email);

        return \in_array(\strtolower($emailDomain), $this->getDomainsFromFile(), true);
    }

    /**
     * @param string $email the full email address
     */
    private function getEmailDomainFromFullEmailAddress(string $email): string
    {
        return (string) \substr($email, (int) \strpos($email, '@') + 1);
    }

    /**
     * @throws InvalidDomainListException
     */
    private function getDomainsFromFile(): array
    {
        $file = new SplFileObject($this->emailListPath);
        $fileContents = $file->fread($file->getSize());
        if (false === $fileContents || \strlen($fileContents) < 3) {
            throw new InvalidDomainListException('Invalid domain list file: ' . $this->emailListPath);
        }

        $fileContents = \preg_replace('~\R~u', "\n", $fileContents);

        return \explode("\n", $fileContents);
    }
}
