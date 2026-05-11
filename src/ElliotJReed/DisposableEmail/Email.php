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
     * @return bool Returns true when the provided email address is likely to be a disposable or temporary email address
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
     * @return string[] Returns an array of disposable and temporary email address domains
     *
     * @throws InvalidDomainListException
     */
    public function getDomainList(): array
    {
        return $this->getDomainsFromFile();
    }

    /**
     * @param string $email The email address to check whether it is a disposable or temporary email address
     *
     * @return bool Returns true when the provided email address is in the disposable email list
     *
     * @throws InvalidDomainListException
     */
    private function inDisposableEmailList(string $email): bool
    {
        $emailDomain = \strtolower($this->getEmailDomainFromFullEmailAddress($email));
        $domainParts = \explode('.', $emailDomain);
        $domains = $this->getDomainsFromFile();

        // Check domain and all parent domains (skip checking TLD alone)
        for ($i = 0, $count = \count($domainParts); $i < $count - 1; $i++) {
            $checkDomain = \implode('.', \array_slice($domainParts, $i));
            if (\in_array($checkDomain, $domains, true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $email The full email address
     *
     * @return string Returns the email address domain
     */
    private function getEmailDomainFromFullEmailAddress(string $email): string
    {
        return (string) \substr($email, (int) \strpos($email, '@') + 1);
    }

    /**
     * @return string[] Returns an array of disposable and temporary email address domains
     *
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
