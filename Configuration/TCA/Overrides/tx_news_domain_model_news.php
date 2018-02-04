<?php
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
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
        'tx_news_domain_model_news',
        $tempColumns
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tx_news_domain_model_news',
        'tx_externalimporttut_externalid'
);

// Add the external information to the ctrl section
$GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['external'] = [
        0 => [
                'connector' => 'feed',
                'parameters' => [
                        'uri' => 'http://typo3.org/xml-feeds/rss.xml'
                ],
                'data' => 'xml',
                'nodetype' => 'item',
                'referenceUid' => 'tx_externalimporttut_externalid',
                'enforcePid' => true,
                'priority' => 200,
                'disabledOperations' => 'delete',
                'description' => 'Import of typo3.org news'
        ],
];
// Add the external information for each column
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['title']['external'] = [
        0 => [
                'field' => 'title'
        ]
];
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['tx_externalimporttut_externalid']['external'] = [
        0 => [
                'field' => 'link'
        ]
];
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['datetime']['external'] = [
        0 => [
                'field' => 'pubDate',
                'transformations' => [
                        10 => [
                                'userFunc' => [
                                        'class' => \Cobweb\ExternalImport\Transformation\DateTimeTransformation::class,
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
