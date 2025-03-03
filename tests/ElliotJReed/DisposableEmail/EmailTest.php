<?php

declare(strict_types=1);

namespace Tests\ElliotJReed\DisposableEmail;

use ElliotJReed\DisposableEmail\Email;
use ElliotJReed\DisposableEmail\Exceptions\InvalidDomainListException;
use ElliotJReed\DisposableEmail\Exceptions\InvalidEmailException;
use PHPUnit\Framework\TestCase;
use SplFileObject;

final class EmailTest extends TestCase
{
    private SplFileObject $list;

    protected function setUp(): void
    {
        $this->list = new SplFileObject(\sys_get_temp_dir() . '/disposable_email_test.txt', 'wb');
    }

    protected function tearDown(): void
    {
        \unlink($this->list->getRealPath());
    }

    public function testItReturnsTrueWhenEmailIsInDisposableEmailListWhenCheckingIfEmailIsTemporaryDomain(): void
    {
        $this->list->fwrite('disposable.com');
        $email = (new Email($this->list->getRealPath()))->isDisposable('email@disposable.com');

        $this->assertTrue($email);
    }

    public function testItNormalisesLineEndingsInEmailListWhenCheckingIfEmailIsTemporaryDomain(): void
    {
        $this->list->fwrite("temporary.com\r\ndisposable.com\r\n");
        $email = (new Email($this->list->getRealPath()))->isDisposable('email@disposable.com');

        $this->assertTrue($email);
    }

    public function testItReturnsTrueWhenEmailIsInDisposableEmailListAndProvidedEmailIsUppercaseWhenCheckingIfEmailIsTemporaryDomain(): void
    {
        $this->list->fwrite('disposable.com');
        $email = (new Email($this->list->getRealPath()))->isDisposable('EMAIL@DISPOSABLE.COM');

        $this->assertTrue($email);
    }

    public function testItReturnsFalseWhenEmailIsNotInDisposableEmailListWhenCheckingIfEmailIsTemporaryDomain(): void
    {
        $this->list->fwrite('disposable.com');
        $email = (new Email($this->list->getRealPath()))->isDisposable('email@not-disposable.com');

        $this->assertFalse($email);
    }

    public function testItThrowsInvalidEmailExceptionWhenEmailIsInvalidWhenCheckingIfEmailIsTemporaryDomain(): void
    {
        $this->list->fwrite('disposable.com');

        $this->expectException(InvalidEmailException::class);

        (new Email($this->list->getRealPath()))->isDisposable('invalid email address');
    }

    public function testItThrowsInvalidDomainListExceptionWhenFileDoesNotAppearValidWhenCheckingIfEmailIsTemporaryDomain(): void
    {
        $this->list->fwrite('a');

        $this->expectException(InvalidDomainListException::class);

        (new Email($this->list->getRealPath()))->isDisposable('email@not-disposable.com');
    }

    public function testItGetsListOfTemporaryDomains(): void
    {
        $this->list->fwrite('disposable.com');

        $this->assertSame(['disposable.com'], (new Email($this->list->getRealPath()))->getDomainList());
    }

    public function testItThrowsInvalidDomainListExceptionWhenFileDoesNotAppearValidWhenGettingTemporaryDomainList(): void
    {
        $this->list->fwrite('a');

        $this->expectException(InvalidDomainListException::class);

        (new Email($this->list->getRealPath()))->getDomainList();
    }
}
