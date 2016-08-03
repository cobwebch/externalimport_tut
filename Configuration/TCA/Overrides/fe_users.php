<?php

// Add new columns to fe_users table
$newColumns = array(
        'tx_externalimporttut_code' => array(
                'exclude' => 0,
                'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_employees.code',
                'config' => array(
                        'type' => 'input',
                        'size' => '10',
                        'eval' => 'trim',
                )
        ),
        'tx_externalimporttut_department' => array(
                'exclude' => 0,
                'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_employees.department',
                'config' => array(
                        'type' => 'group',
                        'internal_type' => 'db',
                        'allowed' => 'tx_externalimporttut_departments',
                        'size' => 1,
                        'minitems' => 0,
                        'maxitems' => 1,
                )
        ),
        'tx_externalimporttut_holidays' => array(
                'exclude' => 0,
                'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_employees.holidays',
                'config' => array(
                        'type' => 'input',
                        'size' => '10',
                        'eval' => 'int',
                        'checkbox' => '0',
                        'default' => 0
                )
        )
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
        'fe_users',
        $newColumns,
        1
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'fe_users',
        '--div--;LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_employees,tx_externalimporttut_code,tx_externalimporttut_department,tx_externalimporttut_holidays'
);

// Add the external information to the ctrl section
$GLOBALS['TCA']['fe_users']['ctrl']['external'] = array(
        0 => array(
                'connector' => 'csv',
                'parameters' => array(
                        'filename' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('externalimport_tut', 'Resources/Private/Data/employees.txt'),
                        'delimiter' => ';',
                        'text_qualifier' => '',
                        'skip_rows' => 1,
                        'encoding' => 'utf8'
                ),
                'data' => 'array',
                'referenceUid' => 'tx_externalimporttut_code',
                'additionalFields' => 'last_name,first_name',
                'priority' => 50,
                'disabledOperations' => '',
                'enforcePid' => true,
                'description' => 'Import of full employee list'
        ),
        1 => array(
                'connector' => 'csv',
                'parameters' => array(
                        'filename' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('externalimport_tut', 'Resources/Private/Data/holidays.txt'),
                        'delimiter' => ',',
                        'text_qualifier' => '',
                        'skip_rows' => 0,
                        'encoding' => 'utf8'
                ),
                'data' => 'array',
                'referenceUid' => 'tx_externalimporttut_code',
                'priority' => 60,
                'disabledOperations' => 'insert,delete',
                'description' => 'Import of holidays balance'
        )
);

// Add the external information for each column
$GLOBALS['TCA']['fe_users']['columns']['name']['external'] = array(
        0 => array(
                'field' => 'last_name',
                'userFunc' => array(
                        'class' => \Cobweb\ExternalimportTut\Transformation\NameTransformation::class,
                        'method' => 'assembleName'
                )
        )
);
$GLOBALS['TCA']['fe_users']['columns']['username']['external'] = array(
        0 => array(
                'field' => 'last_name',
                'userFunc' => array(
                        'class' => \Cobweb\ExternalimportTut\Transformation\NameTransformation::class,
                        'method' => 'assembleUserName',
                        'params' => array(
                                'encoding' => 'utf8'
                        )
                )
        )
);
$GLOBALS['TCA']['fe_users']['columns']['starttime']['external'] = array(
        0 => array(
                'field' => 'start_date',
                'userFunc' => array(
                        'class' => \Cobweb\ExternalImport\Transformation\DateTimeTransformation::class,
                        'method' => 'parseDate'
                )
        )
);
$GLOBALS['TCA']['fe_users']['columns']['tx_externalimporttut_code']['external'] = array(
        0 => array(
                'field' => 'employee_number'
        ),
        1 => array(
                'field' => 0
        )
);
$GLOBALS['TCA']['fe_users']['columns']['email']['external'] = array(
        0 => array(
                'field' => 'mail'
        )
);
$GLOBALS['TCA']['fe_users']['columns']['telephone']['external'] = array(
        0 => array(
                'field' => 'phone'
        )
);
$GLOBALS['TCA']['fe_users']['columns']['company']['external'] = array(
        0 => array(
                'value' => 'The Empire'
        )
);
$GLOBALS['TCA']['fe_users']['columns']['title']['external'] = array(
        0 => array(
                'field' => 'rank',
                'mapping' => array(
                        'valueMap' => array(
                                '1' => 'Captain',
                                '2' => 'Senior',
                                '3' => 'Junior'
                        )
                ),
                'excludedOperations' => 'update'
        )
);
$GLOBALS['TCA']['fe_users']['columns']['tx_externalimporttut_department']['external'] = array(
        0 => array(
                'field' => 'department',
                'mapping' => array(
                        'table' => 'tx_externalimporttut_departments',
                        'reference_field' => 'code'
                )
        )
);
$GLOBALS['TCA']['fe_users']['columns']['tx_externalimporttut_holidays']['external'] = array(
        1 => array(
                'field' => 1
        )
);
