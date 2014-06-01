<?php
// Register hook for generating password before storing users

$TYPO3_CONF_VARS['EXTCONF']['external_import']['insertPreProcess'][] = 'EXT:externalimport_tut/class.tx_externalimporttut_hooks.php:tx_externalimporttut_hooks';
?>