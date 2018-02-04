<?php

return [
        'ctrl' => [
                'title' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_teams',
                'label' => 'name',
                'tstamp' => 'tstamp',
                'crdate' => 'crdate',
                'cruser_id' => 'cruser_id',
                'default_sortby' => 'ORDER BY name',
                'delete' => 'deleted',
                'enablecolumns' => [
                        'disabled' => 'hidden',
                ],
                'searchFields' => 'code,name',
                'typeicon_classes' => [
                        'default' => 'tx_externalimport_tut-team'
                ],
                'external' => [
                        0 => [
                                'connector' => 'csv',
                                'parameters' => [
                                        'filename' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath(
                                                'externalimport_tut',
                                                'Resources/Private/Data/teams.txt'
                                        ),
                                        'delimiter' => "\t",
                                        'text_qualifier' => '',
                                        'skip_rows' => 1,
                                        'encoding' => 'utf8'
                                ],
                                'data' => 'array',
                                'referenceUid' => 'code',
                                'additionalFields' => 'rank',
                                'priority' => 100,
                                'description' => 'Import of all employee teams'
                        ]
                ]
        ],
        'interface' => [
                'showRecordFieldList' => 'hidden,code,name'
        ],
        'columns' => [
                'hidden' => [
                        'exclude' => 1,
                        'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
                        'config' => [
                                'type' => 'check',
                                'default' => '0'
                        ]
                ],
                'code' => [
                        'exclude' => 0,
                        'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_teams.code',
                        'config' => [
                                'type' => 'input',
                                'size' => 10,
                                'max' => 5,
                                'eval' => 'required,trim',
                        ],
                        'external' => [
                                0 => [
                                        'field' => 'code'
                                ]
                        ]
                ],
                'name' => [
                        'exclude' => 0,
                        'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_teams.name',
                        'config' => [
                                'type' => 'input',
                                'size' => 30,
                                'eval' => 'required,trim',
                        ],
                        'external' => [
                                0 => [
                                        'field' => 'name'
                                ]
                        ]
                ],
                'members' => [
                        'exclude' => 0,
                        'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_teams.members',
                        'config' => [
                                'type' => 'group',
                                'size' => 5,
                                'internal_type' => 'db',
                                'allowed' => 'fe_users',
                                'MM' => 'tx_externalimporttut_teams_feusers_mm',
                                'maxitems' => 100
                        ],
                        'external' => [
                                0 => [
                                        'field' => 'employee',
                                        'MM' => [
                                                'mapping' => [
                                                        'table' => 'fe_users',
                                                        'referenceField' => 'tx_externalimporttut_code',
                                                ],
                                                'sorting' => 'rank'
                                        ]
                                ]
                        ]
                ],
        ],
        'types' => [
                '0' => ['showitem' => 'hidden, code, name, members']
        ]
];
