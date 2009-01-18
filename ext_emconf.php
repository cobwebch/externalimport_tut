<?php

########################################################################
# Extension Manager/Repository config file for ext: "externalimport_tut"
#
# Auto generated 18-01-2009 17:49
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'External Import Tutorial',
	'description' => 'Tutorial for the External Import extension. Contains the manual and the necessary files.',
	'category' => 'example',
	'author' => 'Francois Suter (Cobweb)',
	'author_email' => 'typo3@cobweb.ch',
	'shy' => '',
	'dependencies' => 'external_import,svconnector_csv',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '1.0.0',
	'constraints' => array(
		'depends' => array(
			'external_import' => '',
			'svconnector_csv' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
			'devlog' => '',
		),
	),
	'_md5_values_when_last_written' => 'a:17:{s:9:"ChangeLog";s:4:"5853";s:10:"README.txt";s:4:"5a50";s:36:"class.tx_externalimporttut_hooks.php";s:4:"b705";s:46:"class.tx_externalimporttut_transformations.php";s:4:"6209";s:12:"ext_icon.gif";s:4:"da0a";s:17:"ext_localconf.php";s:4:"7dcd";s:14:"ext_tables.php";s:4:"42b0";s:14:"ext_tables.sql";s:4:"fc70";s:41:"icon_tx_externalimporttut_departments.gif";s:4:"0cdd";s:35:"icon_tx_externalimporttut_teams.gif";s:4:"0094";s:16:"locallang_db.xml";s:4:"9c96";s:7:"tca.php";s:4:"f740";s:14:"doc/manual.sxw";s:4:"bfa2";s:19:"res/departments.txt";s:4:"4626";s:17:"res/employees.txt";s:4:"4886";s:16:"res/holidays.txt";s:4:"7b08";s:13:"res/teams.txt";s:4:"ad82";}',
	'suggests' => array(
	),
);

?>