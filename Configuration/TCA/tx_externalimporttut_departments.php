<?php

return array(
        'ctrl' => array(
                'title' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_departments',
                'label' => 'name',
                'tstamp' => 'tstamp',
                'crdate' => 'crdate',
                'cruser_id' => 'cruser_id',
                'default_sortby' => 'ORDER BY name',
                'delete' => 'deleted',
                'enablecolumns' => array(
                        'disabled' => 'hidden',
                ),
                'searchFields' => 'code,name',
                'typeicon_classes' => array(
                        'default' => 'tx_externalimport_tut-department'
                ),
                'external' => array(
                        0 => array(
                                'connector' => 'csv',
                                'parameters' => array(
                                        'filename' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath(
                                                'externalimport_tut',
                                                'Resources/Private/Data/departments.txt'
                                        ),
                                        'delimiter' => "\t",
                                        'text_qualifier' => '"',
                                        'skip_rows' => 1,
                                        'encoding' => 'latin1'
                                ),
                                'data' => 'array',
                                'reference_uid' => 'code',
                                'priority' => 10,
                                'description' => 'Import of all company departments'
                        )
                )
        ),
        'interface' => array(
                'showRecordFieldList' => 'hidden,code,name'
        ),
        'columns' => array(
                'hidden' => array(
                        'exclude' => 1,
                        'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
                        'config' => array(
                                'type' => 'check',
                                'default' => '0'
                        )
                ),
                'code' => array(
                        'exclude' => 0,
                        'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_departments.code',
                        'config' => array(
                                'type' => 'input',
                                'size' => '10',
                                'max' => '4',
                                'eval' => 'required,trim',
                        ),
                        'external' => array(
                                0 => array(
                                        'field' => 'code'
                                )
                        )
                ),
                'name' => array(
                        'exclude' => 0,
                        'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_departments.name',
                        'config' => array(
                                'type' => 'input',
                                'size' => '30',
                                'eval' => 'required,trim',
                        ),
                        'external' => array(
                                0 => array(
                                        'field' => 'name'
                                )
                        )
                ),
        ),
        'types' => array(
                '0' => array('showitem' => 'hidden, code, name')
        )
);
