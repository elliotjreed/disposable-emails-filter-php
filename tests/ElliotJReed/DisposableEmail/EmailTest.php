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

    public function testItReturnsTrueWhenEmailDomainIsASubdomainOfADisposableEmailDomainWhenCheckingIfEmailIsTemporaryDomain(): void
    {
        $this->list->fwrite('disposable.com');
        $email = (new Email($this->list->getRealPath()))->isDisposable('email@sub.disposable.com');

        $this->assertTrue($email);
    }

    public function testItReturnsTrueWhenEmailDomainIsANestedSubdomainOfADisposableEmailDomainWhenCheckingIfEmailIsTemporaryDomain(): void
    {
        $this->list->fwrite('disposable.com');
        $email = (new Email($this->list->getRealPath()))->isDisposable('email@another.sub.disposable.com');

        $this->assertTrue($email);
    }

    public function testItReturnsTrueWhenEmailDomainIsAnUppercaseSubdomainOfADisposableEmailDomainWhenCheckingIfEmailIsTemporaryDomain(): void
    {
        $this->list->fwrite('disposable.com');
        $email = (new Email($this->list->getRealPath()))->isDisposable('email@SUB.DISPOSABLE.COM');

        $this->assertTrue($email);
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

    public function testItReturnsTrueWhenEmailIsInDisposableEmailListWhenUsingACompiledPhpDomainListWhenCheckingIfEmailIsTemporaryDomain(): void
    {
        $path = \sys_get_temp_dir() . '/disposable_email_test_compiled.php';
        \file_put_contents($path, "<?php\n\ndeclare(strict_types=1);\n\nreturn ['disposable.com'];\n");

        try {
            $email = (new Email($path))->isDisposable('email@disposable.com');
        } finally {
            \unlink($path);
        }

        $this->assertTrue($email);
    }

    public function testItGetsListOfTemporaryDomainsWhenUsingACompiledPhpDomainList(): void
    {
        $path = \sys_get_temp_dir() . '/disposable_email_test_compiled.php';
        \file_put_contents($path, "<?php\n\ndeclare(strict_types=1);\n\nreturn ['disposable.com'];\n");

        try {
            $domainList = (new Email($path))->getDomainList();
        } finally {
            \unlink($path);
        }

        $this->assertSame(['disposable.com'], $domainList);
    }

    public function testItThrowsInvalidDomainListExceptionWhenCompiledPhpDomainListFileDoesNotExistWhenCheckingIfEmailIsTemporaryDomain(): void
    {
        $this->expectException(InvalidDomainListException::class);

        (new Email(\sys_get_temp_dir() . '/does-not-exist-disposable-email-list.php'))->isDisposable('email@disposable.com');
    }

    public function testItThrowsInvalidDomainListExceptionWhenCompiledPhpDomainListFileDoesNotReturnAnArrayWhenCheckingIfEmailIsTemporaryDomain(): void
    {
        $path = \sys_get_temp_dir() . '/disposable_email_test_invalid_compiled.php';
        \file_put_contents($path, "<?php\n\ndeclare(strict_types=1);\n\nreturn 'not-an-array';\n");

        $this->expectException(InvalidDomainListException::class);

        try {
            (new Email($path))->isDisposable('email@disposable.com');
        } finally {
            \unlink($path);
        }
    }

    public function testItThrowsInvalidDomainListExceptionWhenCompiledPhpDomainListFileReturnsAnEmptyArrayWhenCheckingIfEmailIsTemporaryDomain(): void
    {
        $path = \sys_get_temp_dir() . '/disposable_email_test_empty_compiled.php';
        \file_put_contents($path, "<?php\n\ndeclare(strict_types=1);\n\nreturn [];\n");

        $this->expectException(InvalidDomainListException::class);

        try {
            (new Email($path))->isDisposable('email@disposable.com');
        } finally {
            \unlink($path);
        }
    }
}
