<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'External Import Tutorial',
    'description' => 'Tutorial for the External Import extension. Contains the manual and the necessary files.',
    'category' => 'example',
    'author' => 'Francois Suter (Idéative)',
    'author_email' => 'typo3@ideative.ch',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author_company' => '',
    'version' => '5.0.0',
    'constraints' =>
        [
            'depends' =>
                [
                    'external_import' => '7.0.0-0.0.0',
                    'svconnector_csv' => '4.0.0-0.0.0',
                    'svconnector_feed' => '4.0.0-0.0.0',
                    'news' => '11.0.0-0.0.0',
                    'typo3' => '11.5.0-12.4.99',
                ],
            'conflicts' =>
                [
                ],
            'suggests' =>
                [
                ],
        ],
];
