#!/usr/bin/env php
<?php

declare(strict_types=1);

$sourcePath = __DIR__ . '/../list.txt';
$compiledPath = __DIR__ . '/../list.php';

$fileContents = \file_get_contents($sourcePath);
if (false === $fileContents) {
    \fwrite(\STDERR, 'Unable to read ' . $sourcePath . \PHP_EOL);
    exit(1);
}

$fileContents = \preg_replace('~\R~u', "\n", $fileContents);
$domains = \explode("\n", $fileContents);

$exportedDomains = \implode(',' . \PHP_EOL . '    ', \array_map(
    static fn (string $domain): string => \var_export($domain, true),
    $domains
));

$compiledContents = '<?php' . \PHP_EOL . \PHP_EOL
    . 'declare(strict_types=1);' . \PHP_EOL . \PHP_EOL
    . 'return [' . \PHP_EOL . '    ' . $exportedDomains . ',' . \PHP_EOL . '];' . \PHP_EOL;

if (false === \file_put_contents($compiledPath, $compiledContents)) {
    \fwrite(\STDERR, 'Unable to write ' . $compiledPath . \PHP_EOL);
    exit(1);
}

echo 'Compiled ' . \count($domains) . ' domains to ' . $compiledPath . \PHP_EOL;
