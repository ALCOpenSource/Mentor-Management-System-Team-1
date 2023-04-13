<?php

$finder = Symfony\Component\Finder\Finder::create()
    ->notPath('bootstrap/*')
    ->notPath('storage/*')
    ->notPath('vendor')
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$config = new PhpCsFixer\Config();

return $config->setRules([
        '@PSR12' => true,
        '@PHP81Migration' => true,
        '@Symfony' => true,
        // '@PhpCsFixer' => true,
        'array_syntax' => ['syntax' => 'short'],
        'array_indentation' => true,
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'no_unused_imports' => true,
        'not_operator_with_successor_space' => true,
        'trailing_comma_in_multiline' => true,
        'phpdoc_scalar' => true,
        'unary_operator_spaces' => true,
        'binary_operator_spaces' => true,
        'blank_line_before_statement' => [
            'statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try'],
        ],
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_var_without_name' => true,
        'class_attributes_separation' => [
            'elements' => [
                'method' => 'one',
            ],
        ],
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
            'keep_multiple_spaces_after_comma' => true,
        ],
        'no_trailing_comma_in_singleline' => true,

        // PHP Doc related
        'phpdoc_add_missing_param_annotation' => [
            'only_untyped' => false,
        ],
        'phpdoc_order' => false,
        'phpdoc_align' => [
            'align' => 'left',
        ],
        'phpdoc_separation' => true,
        'phpdoc_trim' => true,
        'phpdoc_types_order' => [
            'null_adjustment' => 'always_last',
            'sort_algorithm' => 'none',
        ],
        'phpdoc_var_annotation_correct_order' => true,
        // 'phpdoc_to_return_type' => true,
        // 'phpdoc_to_param_type' => true,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_indent' => true,

        // Others
        'no_useless_return' => true,
        'simplified_null_return' => true,
        'array_indentation' => true,
        'method_chaining_indentation' => true,
        'no_useless_else' => true,
        'simplified_if_return' => true,
    ])
    ->setFinder($finder);
