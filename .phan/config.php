<?php

declare(strict_types=1);

use Phan\Issue;

return [
    'target_php_version' => '7.4',
    'allow_missing_properties' => false,
    'null_casts_as_any_type' => false,
    'null_casts_as_array' => false,
    'array_casts_as_null' => false,
    'scalar_implicit_cast' => false,
    'scalar_array_key_cast' => false,
    'scalar_implicit_partial' => [],
    'strict_method_checking' => true,
    'strict_object_checking' => true,
    'strict_param_checking' => true,
    'strict_property_checking' => true,
    'strict_return_checking' => true,
    'ignore_undeclared_variables_in_global_scope' => false,
    'ignore_undeclared_functions_with_known_signatures' => false,
    'backward_compatibility_checks' => false,
    'check_docblock_signature_return_type_match' => true,
    'prefer_narrowed_phpdoc_param_type' => true,
    'prefer_narrowed_phpdoc_return_type' => true,
    'analyze_signature_compatibility' => true,
    'phpdoc_type_mapping' => [],
    'dead_code_detection' => false,
    'unused_variable_detection' => true,
    'redundant_condition_detection' => true,
    'assume_real_types_for_internal_functions' => true,
    'quick_mode' => false,
    'generic_types_enabled' => true,
    'globals_type_map' => [],
    'minimum_severity' => Issue::SEVERITY_LOW,
    'suppress_issue_types' => [],
    'exclude_file_regex' => '@^vendor/.*/(tests?|Tests?)/@',
    'exclude_file_list' => [],
    'exclude_analysis_directory_list' => [
        'vendor/'
    ],
    'enable_include_path_checks' => true,
    'processes' => 1,
    'analyzed_file_extensions' => [
        'php'
    ],
    'autoload_internal_extension_signatures' => [],
    'plugins' => [
        'AlwaysReturnPlugin',
        'DollarDollarPlugin',
        'DuplicateArrayKeyPlugin',
        'DuplicateExpressionPlugin',
        'PregRegexCheckerPlugin',
        'PrintfCheckerPlugin',
        'SleepCheckerPlugin',
        'UnreachableCodePlugin',
        'UseReturnValuePlugin',
        'EmptyStatementListPlugin',
        'StrictComparisonPlugin',
        'LoopVariableReusePlugin'
    ],
    'directory_list' => [
        'src/ElliotJReed',
        'vendor/phan/phan/src/Phan',
        'vendor/phpunit/phpunit/src',
        'vendor/vimeo/psalm/src/Psalm'
    ],
    'file_list' => []
];
