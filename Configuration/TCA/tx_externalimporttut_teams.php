<?php

return array(
        'ctrl' => array(
                'title' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_teams',
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
                        'default' => 'tx_externalimport_tut-team'
                ),
                'external' => array(
                        0 => array(
                                'connector' => 'csv',
                                'parameters' => array(
                                        'filename' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath(
                                                'externalimport_tut',
                                                'Resources/Private/Data/teams.txt'
                                        ),
                                        'delimiter' => "\t",
                                        'text_qualifier' => '',
                                        'skip_rows' => 1,
                                        'encoding' => 'utf8'
                                ),
                                'data' => 'array',
                                'referenceUid' => 'code',
                                'additionalFields' => 'rank',
                                'priority' => 100,
                                'description' => 'Import of all employee teams'
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
                        'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_teams.code',
                        'config' => array(
                                'type' => 'input',
                                'size' => '10',
                                'max' => '5',
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
                        'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_teams.name',
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
                'members' => array(
                        'exclude' => 0,
                        'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_teams.members',
                        'config' => array(
                                'type' => 'group',
                                'size' => 5,
                                'internal_type' => 'db',
                                'allowed' => 'fe_users',
                                'MM' => 'tx_externalimporttut_teams_feusers_mm',
                                'maxitems' => 100
                        ),
                        'external' => array(
                                0 => array(
                                        'field' => 'employee',
                                        'MM' => array(
                                                'mapping' => array(
                                                        'table' => 'fe_users',
                                                        'reference_field' => 'tx_externalimporttut_code',
                                                ),
                                                'sorting' => 'rank'
                                        )
                                )
                        )
                ),
        ),
        'types' => array(
                '0' => array('showitem' => 'hidden, code, name, members')
        )
);
