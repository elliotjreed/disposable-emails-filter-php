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
        'trailing_comma_in_multiline' => ['after_heredoc' => true, 'elements' => []],
        'nullable_type_declaration_for_default_null_value' => ['use_nullable_type_declaration' => true],
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'global_namespace_import' => ['import_classes' => true, 'import_functions' => false],
        'concat_space' => ['spacing' => 'one'],
        'types_spaces' => ['space' => 'single'],
        'native_function_invocation' => [
            'include' => ['@all'],
            'scope' => 'all'
        ]
    ])
    ->setFinder($finder);
