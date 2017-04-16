<?php
 
$finder = PhpCsFixer\Finder::create()
        ->in('src');

return PhpCsFixer\Config::create()
        ->setRules([
            '@PSR2' => true,
            'no_whitespace_in_blank_line' => true,
            'phpdoc_add_missing_param_annotation' => true,
        ])
        ->setUsingCache(false)
        ->setFinder($finder);