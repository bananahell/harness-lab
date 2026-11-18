<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()->in([
    __DIR__ . '/src',
    __DIR__ . '/tests',
    __DIR__ . '/public',
]);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        '@PHP83Migration' => true,
        'declare_strict_types' => true,
        // Same check as the editor's PHP6616 warning ("compiler optimization").
        'native_function_invocation' => [
            'include' => ['@compiler_optimized'],
            'scope' => 'namespaced',
            'strict' => true,
        ],
        // PHPUnit 12 ignores @covers docblocks, so this rule would only add noise.
        'php_unit_test_class_requires_covers' => false,
    ])
    ->setFinder($finder);
