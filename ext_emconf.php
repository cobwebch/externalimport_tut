<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'External Import Tutorial',
    'description' => 'Tutorial for the External Import extension. Contains the manual and the necessary files.',
    'category' => 'example',
    'author' => 'Francois Suter (Idéative)',
    'author_email' => 'typo3@ideative.ch',
    'state' => 'stable',
    'author_company' => '',
    'version' => '5.1.0',
    'constraints' =>
        [
            'depends' =>
                [
                    'external_import' => '8.0.0-0.0.0',
                    'svconnector_csv' => '5.0.0-0.0.0',
                    'svconnector_feed' => '5.0.0-0.0.0',
                    'news' => '12.0.0-0.0.0',
                    'typo3' => '12.4.0-13.4.99',
                ],
            'conflicts' =>
                [
                ],
            'suggests' =>
                [
                ],
        ],
];
