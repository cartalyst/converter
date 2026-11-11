<?php

// Directories to not scan
$excludeDirs = [
    'vendor/',
];

// Files to not scan
$excludeFiles = [];

// Create a new Symfony Finder instance
$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude($excludeDirs)
    ->ignoreDotFiles(true)->ignoreVCS(true)
    ->filter(function (\SplFileInfo $file) use ($excludeFiles) {
        return ! in_array($file->getRelativePathName(), $excludeFiles);
    })
;

// The Cartalyst code style, ported from the abandoned
// cartalyst/php-cs-fixer-config package (v2.0.0), which is
// incompatible with current php-cs-fixer releases.
$rules = [
    /*
     * General Standards
     */
    '@Symfony' => true,
    '@PSR12'   => true,

    /*
     * Generic Rules
     */
    'array_indentation'          => false,
    'array_syntax'               => ['syntax' => 'short'],
    'combine_consecutive_issets' => true,
    'combine_consecutive_unsets' => true,
    'declare_equal_normalize'    => true,
    'dir_constant'               => true,
    'echo_tag_syntax'            => ['format' => 'long'],
    'explicit_indirect_variable' => true,
    'explicit_string_variable'   => true,
    'fully_qualified_strict_types' => ['phpdoc_tags' => []],
    'global_namespace_import'    => false,
    'increment_style'            => ['style' => 'post'],
    'linebreak_after_opening_tag' => true,
    'list_syntax'                => ['syntax' => 'long'],
    'lowercase_cast'             => true,
    'lowercase_static_reference' => true,
    'magic_method_casing'        => true,
    'mb_str_functions'           => false,
    'modernize_types_casting'    => true,
    'multiline_whitespace_before_semicolons' => [
        'strategy' => 'new_line_for_chained_calls',
    ],
    'native_function_invocation'     => false,
    'native_type_declaration_casing' => true,
    'no_alternative_syntax'          => true,
    'no_binary_string'               => true,
    'no_extra_blank_lines'           => [
        'tokens' => [
            'break',
            'continue',
            'curly_brace_block',
            'extra',
            'parenthesis_brace_block',
            'return',
            'square_brace_block',
            'switch',
            'throw',
            'use',
        ],
    ],
    'no_leading_import_slash'                     => true,
    'no_multiline_whitespace_around_double_arrow' => true,
    'no_null_property_initialization'             => true,
    'no_superfluous_elseif'                       => true,
    'no_trailing_comma_in_singleline'             => true,
    'no_unreachable_default_argument_value'       => true,
    'no_unused_imports'                           => true,
    'no_unset_cast'                               => true,
    'no_useless_else'                             => true,
    'no_useless_return'                           => true,
    'ordered_class_elements'                      => false,
    'ordered_imports'                             => ['sort_algorithm' => 'length'],
    'ordered_interfaces'                          => ['direction' => 'ascend', 'order' => 'alpha'],
    'protected_to_private'                        => false,
    'return_assignment'                           => true,
    'semicolon_after_instruction'                 => true,
    'simplified_null_return'                      => false,
    'single_trait_insert_per_statement'           => false,
    'short_scalar_cast'                           => true,
    'strict_comparison'                           => false,
    'ternary_to_null_coalescing'                  => true,
    'trailing_comma_in_multiline'                 => ['elements' => ['arrays']],
    'yoda_style'                                  => false,
    'void_return'                                 => false,

    /*
     * Docblocks & Comments
     */
    'general_phpdoc_annotation_remove' => [
        'annotations' => [
            'expectedException',
            'expectedExceptionMessage',
            'expectedExceptionMessageRegExp',
        ],
    ],
    'multiline_comment_opening_closing' => true,
    'phpdoc_add_missing_param_annotation' => true,
    'phpdoc_align' => [
        'tags'  => ['param'],
        'align' => 'vertical',
    ],
    'phpdoc_annotation_without_dot'   => true,
    'phpdoc_indent'                   => true,
    'phpdoc_inline_tag_normalizer'    => true,
    'phpdoc_no_empty_return'          => false,
    'phpdoc_no_package'               => false,
    'phpdoc_order'                    => true,
    'phpdoc_scalar'                   => true,
    'phpdoc_separation'               => true,
    'phpdoc_to_return_type'           => false,
    'phpdoc_trim'                     => true,
    'phpdoc_trim_consecutive_blank_line_separation' => true,
    'phpdoc_types'                    => true,
    'phpdoc_types_order'              => [
        'null_adjustment' => 'always_last',
        'sort_algorithm'  => 'alpha',
    ],
    'phpdoc_var_annotation_correct_order' => true,
    'phpdoc_var_without_name'             => true,

    'no_empty_comment'           => false,
    'no_empty_phpdoc'            => false,
    'no_empty_statement'         => false,
    'no_superfluous_phpdoc_tags' => false,

    'single_line_comment_style' => true,

    /*
     * Spacing, Alignment, Line Breaks, etc..
     */
    'align_multiline_comment'     => true,
    'blank_line_before_statement' => [
        'statements' => [
            'break',
            'continue',
            'declare',
            'do',
            'for',
            'foreach',
            'if',
            'include',
            'include_once',
            'require',
            'require_once',
            'return',
            'switch',
            'throw',
            'try',
            'while',
            'yield',
        ],
    ],
    'binary_operator_spaces' => [
        'default'   => 'align_single_space_minimal',
        'operators' => [
            '+=' => 'single_space',
        ],
    ],
    'cast_spaces'                => true,
    'class_attributes_separation' => [
        'elements' => [
            'const'    => 'one',
            'method'   => 'one',
            'property' => 'one',
        ],
    ],
    'concat_space'         => ['spacing' => 'none'],
    'method_argument_space' => [
        'on_multiline' => 'ignore',
    ],
    'method_chaining_indentation'       => true,
    'not_operator_with_successor_space' => true,
    'no_spaces_around_offset'           => [
        'positions' => ['outside'],
    ],
    'trim_array_spaces' => true,

    /*
     * PHPUnit
     */
    'php_unit_construct'       => true,
    'php_unit_dedicate_assert' => true,
    'php_unit_expectation'     => ['target' => 'newest'],
    'php_unit_method_casing'   => false,
    'php_unit_namespaced'      => ['target' => 'newest'],
    'php_unit_no_expectation_annotation' => [
        'target'          => 'newest',
        'use_class_const' => true,
    ],
    'php_unit_strict'                         => true,
    'php_unit_set_up_tear_down_visibility'    => true,
    'php_unit_test_case_static_method_calls'  => ['call_type' => 'this'],
    'php_unit_test_class_requires_covers'     => false,
];

return (new PhpCsFixer\Config('cartalyst'))
    ->setFinder($finder)
    ->setRules($rules)
    ->setUsingCache(false)
    ->setRiskyAllowed(true)
;
