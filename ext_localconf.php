<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

// Register hook for generating password before storing users
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['external_import']['insertPreProcess'][] = \Cobweb\ExternalimportTut\Hook\ExternalImport::class;
