<?php

return [
        'ctrl' => [
                'title' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_departments',
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
                        'default' => 'tx_externalimport_tut-department'
                ],
                'external' => [
                        0 => [
                                'connector' => 'csv',
                                'parameters' => [
                                        'filename' => 'EXT:externalimport_tut/Resources/Private/Data/departments.txt',
                                        'delimiter' => "\t",
                                        'text_qualifier' => '"',
                                        'skip_rows' => 1,
                                        'encoding' => 'latin1'
                                ],
                                'data' => 'array',
                                'referenceUid' => 'code',
                                'priority' => 10,
                                'group' => 'externalimport_tut',
                                'description' => 'Import of all company departments'
                        ]
                ]
        ],
        'interface' => [
                'showRecordFieldList' => 'hidden,code,name'
        ],
        'columns' => [
                'hidden' => [
                        'exclude' => 1,
                        'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
                        'config' => [
                                'type' => 'check',
                                'default' => '0'
                        ]
                ],
                'code' => [
                        'exclude' => 0,
                        'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_departments.code',
                        'config' => [
                                'type' => 'input',
                                'size' => 10,
                                'max' => 4,
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
                        'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_departments.name',
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
        ],
        'types' => [
                '0' => ['showitem' => 'hidden, code, name']
        ]
];
