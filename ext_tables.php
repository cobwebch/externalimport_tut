<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}


// Register sprite icons for new tables
/** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
        'tx_externalimport_tut-department',
        \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
        [
                'source' => 'EXT:externalimport_tut/Resources/Public/Icons/Department.png'
        ]
);
$iconRegistry->registerIcon(
        'tx_externalimport_tut-team',
        \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
        [
                'source' => 'EXT:externalimport_tut/Resources/Public/Icons/Team.png'
        ]
);
