<?php
declare(strict_types=1);

namespace ElliotJReed\DisposableEmail;

final class Email
{
    public static function isDisposable(string $email, string $emailListPath = __DIR__ . '../../../list.txt'): bool
    {
        $emailDomain = \substr($email, \strpos($email, '@'));
        $file = new \SplFileObject($emailListPath);
        $emailList = \explode("\n", $file->fread($file->getSize()));

        return \in_array(\strtolower(\trim($emailDomain)), $emailList, true);
    }
}
