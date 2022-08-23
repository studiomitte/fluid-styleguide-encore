<?php

declare(strict_types=1);

$EM_CONF[$_EXTKEY] = [
    'title' => 'Theme',
    'description' => '',
    'category' => 'fe',
    'author' => 'Georg Ringer',
    'author_email' => 'gr@studiomitte.com',
    'author_company' => 'StudioMitte',
    'state' => 'stable',
    'version' => '1.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-11.9.99',
            'typo3_encore' => '',
            'fluid_styleguide' => '',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'StudioMitte\\Theme\\' => 'Classes',
        ],
    ],
];
