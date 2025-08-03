<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_departments',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'default_sortby' => 'ORDER BY name',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'languageField' => 'sys_language_uid',
        'searchFields' => 'code, name',
        'typeicon_classes' => [
            'default' => 'tx_externalimport_tut-department',
        ],
    ],
    'external' => [
        'general' => [
            'english' => [
                'connector' => 'csv',
                'parameters' => [
                    'filename' => 'EXT:externalimport_tut/Resources/Private/Data/departments.txt',
                    'delimiter' => "\t",
                    'text_qualifier' => '"',
                    'skip_rows' => 1,
                    'encoding' => 'latin1',
                ],
                'data' => 'array',
                'referenceUid' => 'code',
                'whereClause' => 'tx_externalimporttut_departments.sys_language_uid = 0',
                'priority' => 10,
                'description' => 'Import of all company departments (English, default language)',
                'groups' => ['externalimport_tut'],
            ],
            'french' => [
                'connector' => 'csv',
                'parameters' => [
                    'filename' => 'EXT:externalimport_tut/Resources/Private/Data/departments.txt',
                    'delimiter' => "\t",
                    'text_qualifier' => '"',
                    'skip_rows' => 1,
                    'encoding' => 'latin1',
                ],
                'data' => 'array',
                'referenceUid' => 'code',
                'whereClause' => 'tx_externalimporttut_departments.sys_language_uid = 1',
                'priority' => 15,
                'description' => 'Import of all company departments (French translation)',
                'groups' => ['externalimport_tut'],
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
        'sys_language_uid' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => ['type' => 'language'],
            'external' => [
                'french' => [
                    'field' => 'code',
                    'transformations' => [
                        10 => [
                            'value' => 1,
                        ],
                    ],
                ],
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'label' => '',
                        'value' => 0,
                    ],
                ],
                'foreign_table' => 'tx_externalimporttut_departments',
                'foreign_table_where' => 'AND tx_externalimporttut_departments.pid=###CURRENT_PID### AND tx_externalimporttut_departments.sys_language_uid IN (-1,0)',
                'default' => 0,
            ],
            'external' => [
                'french' => [
                    'field' => 'code',
                    'transformations' => [
                        10 => [
                            'mapping' => [
                                'table' => 'tx_externalimporttut_departments',
                                'referenceField' => 'code',
                                'whereClause' => 'tx_externalimporttut_departments.sys_language_uid = 0',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'code' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_departments.code',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'max' => 4,
                'eval' => 'trim',
                'required' => true,
            ],
            'external' => [
                'english' => [
                    'field' => 'code',
                ],
                'french' => [
                    'field' => 'code',
                ],
            ],
        ],
        'name' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_departments.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true,
            ],
            'external' => [
                'english' => [
                    'field' => 'name_en',
                ],
                'french' => [
                    'field' => 'name_fr',
                ],
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                hidden, code, name,
                --div--;LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language, sys_language_uid, l10n_parent
            ',
        ],
    ],
];
