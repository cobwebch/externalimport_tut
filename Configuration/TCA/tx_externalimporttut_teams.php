<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_teams',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'default_sortby' => 'ORDER BY name',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => 'code,name',
        'typeicon_classes' => [
            'default' => 'tx_externalimport_tut-team'
        ]
    ],
    'external' => [
        'general' => [
            0 => [
                'connector' => 'csv',
                'parameters' => [
                    'filename' => 'EXT:externalimport_tut/Resources/Private/Data/teams.txt',
                    'delimiter' => "\t",
                    'text_qualifier' => '',
                    'skip_rows' => 1,
                    'encoding' => 'utf8',
                ],
                'data' => 'array',
                'referenceUid' => 'code',
                'priority' => 100,
                'description' => 'Import of all employee teams',
                'groups' => ['externalimport_tut'],
            ]
        ],
        'additionalFields' => [
            0 => [
                'rank' => [
                    'field' => 'rank',
                ],
            ],
        ],
    ],
    'columns' => [
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'default' => '0',
            ],
        ],
        'code' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_teams.code',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'max' => 5,
                'eval' => 'trim',
                'required' => true,
            ],
            'external' => [
                0 => [
                    'field' => 'code',
                ],
            ],
        ],
        'name' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_teams.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
            ],
            'external' => [
                0 => [
                    'field' => 'name',
                ],
            ],
        ],
        'members' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_teams.members',
            'config' => [
                'type' => 'group',
                'size' => 5,
                'allowed' => 'fe_users',
                'MM' => 'tx_externalimporttut_teams_feusers_mm',
                'maxitems' => 100,
            ],
            'external' => [
                0 => [
                    'field' => 'employee',
                    'multipleRows' => true,
                    'multipleSorting' => 'rank',
                    'transformations' => [
                        10 => [
                            'mapping' => [
                                'table' => 'fe_users',
                                'referenceField' => 'tx_externalimporttut_code',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => 'hidden, code, name, members',
        ],
    ],
];
