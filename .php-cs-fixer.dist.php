<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer;

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('.github')
    ->exclude('node_modules')
    ->exclude('var')
    ->exclude('coverage')
    ->exclude('vendor');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR2' => true,
        '@PSR12:risky' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'trailing_comma_in_multiline' => [],
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'concat_space' => ['spacing' => 'one'],
        'types_spaces' => ['space' => 'single'],
        'native_function_invocation' => [
            'include' => [NativeFunctionInvocationFixer::SET_ALL],
            'scope' => 'all'
        ],
    ])
    ->setFinder($finder);
