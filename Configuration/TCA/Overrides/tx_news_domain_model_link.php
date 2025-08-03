<?php

// Add the external general information
$GLOBALS['TCA']['tx_news_domain_model_link']['external']['general'] = [
    0 => [
        'connector' => 'feed',
        'parameters' => [
            'uri' => 'https://typo3.org/?type=100',
        ],
        'data' => 'xml',
        'nodetype' => 'item',
        'referenceUid' => 'uri',
        'enforcePid' => true,
        'priority' => 210,
        'disabledOperations' => 'delete',
        'description' => 'Import of typo3.org news related links',
        'groups' => ['externalimport_tut'],
    ],
];
// Add the external information for each column
$GLOBALS['TCA']['tx_news_domain_model_link']['columns']['title']['external'] = [
    0 => [
        'field' => 'title',
    ],
];
$GLOBALS['TCA']['tx_news_domain_model_link']['columns']['uri']['external'] = [
    0 => [
        'field' => 'link',
        'transformations' => [
            10 => [
                'trim' => true,
            ],
        ],
    ],
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
                    'trim' => true,
                ],
                20 => [
                    'mapping' => [
                        'table' => 'tx_news_domain_model_news',
                        'referenceField' => 'tx_externalimporttut_externalid',
                        'default' => 0,
                    ],
                ],
                30 => [
                    'isEmpty' => [
                        'invalidate' => true,
                    ],
                ],
            ],
        ],
    ],
];
