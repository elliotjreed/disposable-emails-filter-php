<?php
declare(strict_types=1);

namespace Tests\ElliotJReed\DisposableEmail;

use ElliotJReed\DisposableEmail\Email;
use ElliotJReed\DisposableEmail\Exceptions\InvalidEmailException;
use PHPUnit\Framework\TestCase;
use SplFileObject;

final class EmailTest extends TestCase
{
    /** @var SplFileObject */
    private $list;

    public function setUp(): void
    {
        $this->list = new SplFileObject(\sys_get_temp_dir() . '/disposable_email_test.txt', 'wb');
    }

    public function tearDown(): void
    {
        \unlink($this->list->getRealPath());
    }

    public function testItReturnsTrueWhenEmailIsInDisposableEmailList(): void
    {
        $this->list->fwrite('disposable.com');
        $email = (new Email($this->list->getRealPath()))->isDisposable('email@disposable.com');

        $this->assertTrue($email);
    }

    public function testItReturnsFalseWhenEmailIsNotInDisposableEmailList(): void
    {
        $this->list->fwrite('disposable.com');
        $email = (new Email($this->list->getRealPath()))->isDisposable('email@not-disposable.com');

        $this->assertFalse($email);
    }

    public function testItThrowsInvalidEmailExceptionWhenEmailIsInvalid(): void
    {
        $this->list->fwrite('disposable.com');

        $this->expectException(InvalidEmailException::class);

        (new Email($this->list->getRealPath()))->isDisposable('invalid email address');
    }
}
