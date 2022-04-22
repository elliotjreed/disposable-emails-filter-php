<?php

declare(strict_types=1);

namespace Tests\ElliotJReed\DisposableEmail;

use ElliotJReed\DisposableEmail\DisposableEmail;
use PHPUnit\Framework\TestCase;

final class DisposableEmailTest extends TestCase
{
    public function testItReturnsTrueWhenEmailIsInDisposableEmailList(): void
    {
        $this->assertTrue(DisposableEmail::isDisposable('email@temporary-mail.net'));
    }
}
