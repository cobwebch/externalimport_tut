<?php

########################################################################
# Extension Manager/Repository config file for ext: "externalimport_tut"
#
# Auto generated 24-11-2008 22:26
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'External Import Tutorial',
	'description' => 'Tutorial for the External Import extension. Contains the manual and the necessary files.',
	'category' => 'doc',
	'author' => 'Francois Suter (Cobweb)',
	'author_email' => 'typo3@cobweb.ch',
	'shy' => '',
	'dependencies' => 'external_import,svnconnector_csv',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.0.0',
	'constraints' => array(
		'depends' => array(
			'external_import' => '',
			'svconnector_csv' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:11:{s:9:"ChangeLog";s:4:"b1c0";s:10:"README.txt";s:4:"ee2d";s:12:"ext_icon.gif";s:4:"1bdc";s:14:"ext_tables.php";s:4:"7525";s:14:"ext_tables.sql";s:4:"c3e6";s:41:"icon_tx_externalimporttut_departments.gif";s:4:"475a";s:39:"icon_tx_externalimporttut_employees.gif";s:4:"475a";s:16:"locallang_db.xml";s:4:"fe1a";s:7:"tca.php";s:4:"59b7";s:19:"doc/wizard_form.dat";s:4:"5b8a";s:20:"doc/wizard_form.html";s:4:"ddf7";}',
);

?>