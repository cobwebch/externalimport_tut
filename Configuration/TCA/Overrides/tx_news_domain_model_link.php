<?php

// Add the external information to the ctrl section
$GLOBALS['TCA']['tx_news_domain_model_link']['ctrl']['external'] = array(
        0 => array(
                'connector' => 'feed',
                'parameters' => array(
                        'uri' => 'http://typo3.org/xml-feeds/rss.xml'
                ),
                'data' => 'xml',
                'nodetype' => 'item',
                'referenceUid' => 'uri',
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
