<?php

use Cobweb\ExternalImport\Transformation\DateTimeTransformation;
use Cobweb\ExternalimportTut\Transformation\LinkTransformation;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

// Add a new column for containing the external id
$tempColumns = [
    'tx_externalimporttut_externalid' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:externalimport_tut/Resources/Private/Language/locallang_db.xlf:tx_externalimporttut_ttnews.externalid',
        'config' => [
            'type' => 'input',
            'size' => '20'
        ]
    ],
];
ExtensionManagementUtility::addTCAcolumns(
    'tx_news_domain_model_news',
    $tempColumns
);
ExtensionManagementUtility::addToAllTCAtypes(
    'tx_news_domain_model_news',
    'tx_externalimporttut_externalid'
);

// Add the external general information
$GLOBALS['TCA']['tx_news_domain_model_news']['external']['general'] = [
    0 => [
        'connector' => 'feed',
        'parameters' => [
            'uri' => 'https://typo3.org/?type=100'
        ],
        'data' => 'xml',
        'nodetype' => 'item',
        'referenceUid' => 'tx_externalimporttut_externalid',
        'enforcePid' => true,
        'priority' => 200,
        'disabledOperations' => 'delete',
        'description' => 'Import of typo3.org news',
        'groups' => ['externalimport_tut']
    ],
];
$GLOBALS['TCA']['tx_news_domain_model_news']['external']['additionalFields'] = [
    0 => [
        'category' => [
            'xpath' => './category[text()=\'TYPO3 CMS\']',
            'transformations' => [
                10 => [
                    'isEmpty' => [
                        'invalidate' => true
                    ]
                ]
            ]
        ]
    ]
];
// Add the external information for each column
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['title']['external'] = [
    0 => [
        'field' => 'title'
    ]
];
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['tx_externalimporttut_externalid']['external'] = [
    0 => [
        'field' => 'link',
        'transformations' => [
            10 => [
                'trim' => true
            ]
        ]
    ]
];
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['datetime']['external'] = [
    0 => [
        'field' => 'pubDate',
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
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['teaser']['external'] = [
    0 => [
        'field' => 'description',
        'transformations' => [
            10 => [
                'trim' => true
            ]
        ]
    ]
];
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['bodytext']['external'] = [
    0 => [
        'field' => 'encoded',
        'transformations' => [
            10 => [
                'userFunction' => [
                    'class' => LinkTransformation::class,
                    'method' => 'absolutizeUrls',
                    'parameters' => [
                        'host' => 'https://typo3.org'
                    ]
                ]
            ],
            20 => [
                'rteEnabled' => true
            ]
        ]
    ]
];
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['type']['external'] = [
    0 => [
        'transformations' => [
            10 => [
                'value' => 0
            ]
        ]
    ]
];
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['hidden']['external'] = [
    0 => [
        'transformations' => [
            10 => [
                'value' => 0
            ]
        ]
    ]
];
