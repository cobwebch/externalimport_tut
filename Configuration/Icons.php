<?php

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
    'tx_externalimport_tut-department' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:externalimport_tut/Resources/Public/Icons/Department.svg'
    ],
    'tx_externalimport_tut-team' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:externalimport_tut/Resources/Public/Icons/Team.svg'
    ],
];
