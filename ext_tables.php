<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::allowTableOnStandardPages('tx_externalimporttut_departments');

$TCA['tx_externalimporttut_departments'] = array(
	'ctrl' => array(
		'title'     => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_departments',		
		'label'     => 'name',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY name',	
		'delete' => 'deleted',	
		'enablecolumns' => array(
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_externalimporttut_departments.gif',
	),
);

// Expand fe_users table

t3lib_div::loadTCA('fe_users');

// Add the new columns

$tempColumns = array(
	'tx_externalimporttut_code' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_employees.code',
		'config' => array(
			'type' => 'input',
			'size' => '10',
			'eval' => 'trim',
		)
	),
	'tx_externalimporttut_department' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_employees.department',
		'config' => array(
			'type' => 'group',
			'internal_type' => 'db',
			'allowed' => 'tx_externalimporttut_departments',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
		)
	),
	'tx_externalimporttut_holidays' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_employees.holidays',
		'config' => array(
			'type'     => 'input',
			'size'     => '10',
			'eval'     => 'double2',
			'checkbox' => '0',
			'default' => 0
		)
	)
);
t3lib_extMgm::addTCAcolumns('fe_users', $tempColumns, 1);
t3lib_extMgm::addToAllTCAtypes('fe_users', '--div--;LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_employees,tx_externalimporttut_code;;;;1-1-1,tx_externalimporttut_department,tx_externalimporttut_holidays');

// Add the external information to the ctrl section

$TCA['fe_users']['ctrl']['external'] = array(
	0 => array(
		'connector' => 'csv',
		'parameters' => array(
			'filename' => t3lib_extMgm::extPath($_EXTKEY, 'res/employees.txt'),
			'delimiter' => ';',
			'text_qualifier' => '',
			'skip_rows' => 1,
			'encoding' => 'utf8'
		),
		'data' => 'array',
		'reference_uid' => 'employee_number',
		'priority' => 10,
		'disabledOperations' => '',
		'description' => 'Import of full employee list'
	),
	1 => array(
		'connector' => 'csv',
		'parameters' => array(
			'filename' => t3lib_extMgm::extPath($_EXTKEY, 'res/holidays.txt'),
			'delimiter' => "\t",
			'text_qualifier' => '',
			'skip_rows' => 1,
			'encoding' => 'latin1'
		),
		'data' => 'array',
		'reference_uid' => 'code',
		'priority' => 20,
		'disabledOperations' => 'insert,delete',
		'description' => 'Import of holidays balance'
	)
);

// Add the external information for each column

$TCA['fe_users']['ctrl']['columns']['name']['external'] = array(
	0 => array(
		'field' => 'last_name',
		'userFunc' => ''
	)
);
$TCA['fe_users']['ctrl']['columns']['tx_externalimporttut_code']['external'] = array(
	0 => array(
		'field' => 'employee_number'
	)
);
?>