<?php

use Cobweb\ExternalimportTut\Transformation\NameTransformation;
use Cobweb\ExternalImport\Transformation\DateTimeTransformation;
use Cobweb\ExternalImport\Transformation\ImageTransformation;
use Cobweb\ExternalimportTut\Transformation\CastTransformation;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

// Add new columns to fe_users table
$newColumns = [
    'tx_externalimporttut_code' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_employees.code',
        'config' => [
            'type' => 'input',
            'size' => '10',
            'eval' => 'trim',
        ]
    ],
    'tx_externalimporttut_department' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_employees.department',
        'config' => [
            'type' => 'group',
            'allowed' => 'tx_externalimporttut_departments',
            'size' => 1,
            'minitems' => 0,
            'maxitems' => 1,
        ]
    ],
    'tx_externalimporttut_holidays' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_employees.holidays',
        'config' => [
            'type' => 'number',
            'size' => '10',
            'checkbox' => '0',
            'default' => 0
        ]
    ]
];
ExtensionManagementUtility::addTCAcolumns(
    'fe_users',
    $newColumns
);
ExtensionManagementUtility::addToAllTCAtypes(
    'fe_users',
    '--div--;LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_employees,tx_externalimporttut_code,tx_externalimporttut_department,tx_externalimporttut_holidays'
);

// Add the general external information
$GLOBALS['TCA']['fe_users']['external']['general'] = [
    0 => [
        'connector' => 'feed',
        'parameters' => [
            'uri' => 'EXT:externalimport_tut/Resources/Private/Data/employees.xml'
        ],
        'data' => 'xml',
        'nodetype' => 'employee',
        'referenceUid' => 'tx_externalimporttut_code',
        'priority' => 50,
        'disabledOperations' => '',
        'enforcePid' => true,
        'description' => 'Import of full employee list',
        'groups' => ['externalimport_tut']
    ],
    1 => [
        'connector' => 'csv',
        'parameters' => [
            'filename' => 'EXT:externalimport_tut/Resources/Private/Data/holidays.txt',
            'delimiter' => ',',
            'text_qualifier' => '',
            'skip_rows' => 0,
            'encoding' => 'utf8'
        ],
        'data' => 'array',
        'referenceUid' => 'tx_externalimporttut_code',
        'priority' => 60,
        'disabledOperations' => 'insert,delete',
        'description' => 'Import of holidays balance',
        'groups' => ['externalimport_tut']
    ]
];
// Add the additional fields configuration
$GLOBALS['TCA']['fe_users']['external']['additionalFields'] = [
    0 => [
        'last_name' => [
            'field' => 'last_name'
        ],
        'first_name' => [
            'field' => 'first_name'
        ]
    ]
];

// Add the external information for each column
$GLOBALS['TCA']['fe_users']['columns']['name']['external'] = [
    0 => [
        'field' => 'last_name',
        'transformations' => [
            10 => [
                'userFunction' => [
                    'class' => NameTransformation::class,
                    'method' => 'assembleName'
                ]
            ]
        ]
    ]
];
$GLOBALS['TCA']['fe_users']['columns']['username']['external'] = [
    0 => [
        'field' => 'last_name',
        'transformations' => [
            10 => [
                'userFunction' => [
                    'class' => NameTransformation::class,
                    'method' => 'assembleUserName',
                    'parameters' => [
                        'encoding' => 'utf-8'
                    ]
                ]
            ]
        ]
    ]
];
$GLOBALS['TCA']['fe_users']['columns']['starttime']['external'] = [
    0 => [
        'field' => 'start_date',
        'transformations' => [
            10 => [
                'userFunction' => [
                    'class' => DateTimeTransformation::class,
                    'method' => 'parseDate'
                ]
            ]
        ]
    ]
];
$GLOBALS['TCA']['fe_users']['columns']['tx_externalimporttut_code']['external'] = [
    0 => [
        'field' => 'employee_number'
    ],
    1 => [
        'field' => 0
    ]
];
$GLOBALS['TCA']['fe_users']['columns']['email']['external'] = [
    0 => [
        'field' => 'mail'
    ]
];
$GLOBALS['TCA']['fe_users']['columns']['telephone']['external'] = [
    0 => [
        'field' => 'phone'
    ]
];
$GLOBALS['TCA']['fe_users']['columns']['company']['external'] = [
    0 => [
        'transformations' => [
            10 => [
                'value' => 'The Empire'
            ]
        ]
    ]
];
$GLOBALS['TCA']['fe_users']['columns']['title']['external'] = [
    0 => [
        'field' => 'rank',
        'transformations' => [
            10 => [
                'userFunction' => [
                    'class' => CastTransformation::class,
                    'method' => 'castToInteger'
                ]
            ],
            20 => [
                'mapping' => [
                    'valueMap' => [
                        1 => 'Captain',
                        2 => 'Senior',
                        3 => 'Junior'
                    ]
                ]
            ]
        ],
        'excludedOperations' => 'update'
    ]
];
$GLOBALS['TCA']['fe_users']['columns']['image']['external'] = [
    0 => [
        'field' => 'picture',
        'transformations' => [
            10 => [
                'userFunction' => [
                    'class' => ImageTransformation::class,
                    'method' => 'saveImageFromBase64',
                    'parameters' => [
                        'storage' => '1:imported_images',
                        'nameField' => 'name',
                        'defaultExtension' => 'jpg'
                    ]
                ]
            ]
        ],
        'children' => [
            'table' => 'sys_file_reference',
            'columns' => [
                'uid_local' => [
                    'field' => 'image'
                ],
                'uid_foreign' => [
                    'field' => '__parent.id__'
                ],
                'title' => [
                    'field' => 'name'
                ],
                'tablenames' => [
                    'value' => 'fe_users'
                ],
                'fieldname' => [
                    'value' => 'image'
                ],
            ],
            'controlColumnsForUpdate' => 'uid_local, uid_foreign, tablenames, fieldname',
            'controlColumnsForDelete' => 'uid_foreign, tablenames, fieldname'
        ]
    ]
];
$GLOBALS['TCA']['fe_users']['columns']['tx_externalimporttut_department']['external'] = [
    0 => [
        'field' => 'department',
        'transformations' => [
            10 => [
                'mapping' => [
                    'table' => 'tx_externalimporttut_departments',
                    'referenceField' => 'code',
                    'whereClause' => 'tx_externalimporttut_departments.sys_language_uid = 0'
                ]
            ]
        ]
    ]
];
$GLOBALS['TCA']['fe_users']['columns']['tx_externalimporttut_holidays']['external'] = [
    1 => [
        'field' => 1
    ]
];
