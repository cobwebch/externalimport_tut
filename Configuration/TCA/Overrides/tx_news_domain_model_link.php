<?php

// Add the external information to the ctrl section
$GLOBALS['TCA']['tx_news_domain_model_link']['ctrl']['external'] = [
        0 => [
                'connector' => 'feed',
                'parameters' => [
                        'uri' => 'http://typo3.org/xml-feeds/rss.xml'
                ],
                'data' => 'xml',
                'nodetype' => 'item',
                'referenceUid' => 'uri',
                'enforcePid' => true,
                'priority' => 210,
                'group' => 'externalimport_tut',
                'disabledOperations' => 'delete',
                'description' => 'Import of typo3.org news related links'
        ],
];
// Add the external information for each column
$GLOBALS['TCA']['tx_news_domain_model_link']['columns']['title']['external'] = [
        0 => [
                'field' => 'title'
        ]
];
$GLOBALS['TCA']['tx_news_domain_model_link']['columns']['uri']['external'] = [
        0 => [
                'field' => 'link'
        ]
];
$GLOBALS['TCA']['tx_news_domain_model_link']['columns']['parent'] = [
        'config' => [
                'type' => 'passthrough',
        ],
        'external' => [
                0 => [
                        'field' => 'link',
                        'transformations' => [
                                10 => [
                                        'mapping' => [
                                                'table' => 'tx_news_domain_model_news',
                                                'referenceField' => 'tx_externalimporttut_externalid'
                                        ]
                                ]
                        ]
                ]
        ]
];
