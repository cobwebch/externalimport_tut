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

$TCA['tx_externalimporttut_employees'] = array(
	'ctrl' => array(
		'title'     => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_employees',		
		'label'     => 'lastname',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY lastname',	
		'delete' => 'deleted',	
		'enablecolumns' => array(
			'disabled' => 'hidden',	
			'starttime' => 'starttime',	
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_externalimporttut_employees.gif',
		'external' => array(
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
				'description' => 'Import of full employee list'
			)
		)
	),
);
?>