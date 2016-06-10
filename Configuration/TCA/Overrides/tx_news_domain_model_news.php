<?php
// Add a new column for containing the external id
$tempColumns = array(
        'tx_externalimporttut_externalid' => array(
                'exclude' => 0,
                'label' => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_ttnews.externalid',
                'config' => array(
                        'type' => 'input',
                        'size' => '20'
                )
        ),
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
        'tx_news_domain_model_news',
        $tempColumns,
        1
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tx_news_domain_model_news',
        'tx_externalimporttut_externalid'
);

// Add the external information to the ctrl section
$GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['external'] = array(
        0 => array(
                'connector' => 'feed',
                'parameters' => array(
                        'uri' => 'http://typo3.org/xml-feeds/rss.xml'
                ),
                'data' => 'xml',
                'nodetype' => 'item',
                'reference_uid' => 'tx_externalimporttut_externalid',
                'enforcePid' => true,
                'priority' => 200,
                'disabledOperations' => 'delete',
                'description' => 'Import of typo3.org news'
        ),
);
// Add the external information for each column
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['title']['external'] = array(
        0 => array(
                'field' => 'title'
        )
);
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['tx_externalimporttut_externalid']['external'] = array(
        0 => array(
                'field' => 'link'
        )
);
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['datetime']['external'] = array(
        0 => array(
                'field' => 'pubDate',
                'userFunc' => array(
                        'class' => 'EXT:external_import/samples/class.tx_externalimport_transformations.php:tx_externalimport_transformations',
                        'method' => 'parseDate'
                )
        )
);
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['teaser']['external'] = array(
        0 => array(
                'field' => 'description',
                'trim' => true
        )
);
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['bodytext']['external'] = array(
        0 => array(
                'field' => 'encoded',
                'rteEnabled' => true
        )
);
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['type']['external'] = array(
        0 => array(
                'value' => 0
        )
);
$GLOBALS['TCA']['tx_news_domain_model_news']['columns']['hidden']['external'] = array(
        0 => array(
                'value' => 0
        )
);

// Add the external information to the ctrl section
$GLOBALS['TCA']['tx_news_domain_model_link']['ctrl']['external'] = array(
        0 => array(
                'connector' => 'feed',
                'parameters' => array(
                        'uri' => 'http://typo3.org/xml-feeds/rss.xml'
                ),
                'data' => 'xml',
                'nodetype' => 'item',
                'reference_uid' => 'uri',
                'enforcePid' => true,
                'priority' => 210,
                'disabledOperations' => 'delete',
                'description' => 'Import of typo3.org news related links'
        ),
);
// Add the external information for each column
$GLOBALS['TCA']['tx_news_domain_model_link']['columns']['title']['external'] = array(
        0 => array(
                'field' => 'title'
        )
);
$GLOBALS['TCA']['tx_news_domain_model_link']['columns']['uri']['external'] = array(
        0 => array(
                'field' => 'link'
        )
);
$GLOBALS['TCA']['tx_news_domain_model_link']['columns']['parent'] = array(
        'config' => array(
                'type' => 'passthrough',
        ),
        'external' => array(
                0 => array(
                        'field' => 'link',
                        'mapping' => array(
                                'table' => 'tx_news_domain_model_news',
                                'reference_field' => 'tx_externalimporttut_externalid'
                        )
                )
        )
);