<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$extensionPath = t3lib_extMgm::extPath($_EXTKEY);
$extensionRelativePath = t3lib_extMgm::extRelPath($_EXTKEY);

	// Base TCA for departments tables
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
		'dynamicConfigFile' => $extensionPath . 'tca.php',
		'iconfile'          => $extensionRelativePath . 'icon_tx_externalimporttut_departments.gif',
		'external' => array(
				0 => array(
					'connector' => 'csv',
					'parameters' => array(
						'filename' => $extensionPath . 'res/departments.txt',
						'delimiter' => "\t",
						'text_qualifier' => '"',
						'skip_rows' => 1,
						'encoding' => 'latin1'
					),
					'data' => 'array',
					'reference_uid' => 'code',
					'priority' => 10,
					'description' => 'Import of all company departments'
				)
		)
	),
);

	// Base TCA for teams tables
t3lib_extMgm::allowTableOnStandardPages('tx_externalimporttut_teams');

$TCA['tx_externalimporttut_teams'] = array(
	'ctrl' => array(
		'title'     => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_teams',
		'label'     => 'name',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY name',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => $extensionPath . 'tca.php',
		'iconfile'          => $extensionRelativePath . 'icon_tx_externalimporttut_teams.gif',
		'external' => array(
				0 => array(
					'connector' => 'csv',
					'parameters' => array(
						'filename' => t3lib_extMgm::extPath($_EXTKEY, 'res/teams.txt'),
						'delimiter' => "\t",
						'text_qualifier' => '',
						'skip_rows' => 1,
						'encoding' => 'utf8'
					),
					'data' => 'array',
					'reference_uid' => 'code',
					'additional_fields' => 'rank',
					'priority' => 100,
					'description' => 'Import of all employee teams'
				)
		)
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
			'type'			=> 'group',
			'internal_type'	=> 'db',
			'allowed'		=> 'tx_externalimporttut_departments',
			'size'			=> 1,
			'minitems'		=> 0,
			'maxitems'		=> 1,
		)
	),
	'tx_externalimporttut_holidays' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_employees.holidays',
		'config' => array(
			'type'		=> 'input',
			'size'		=> '10',
			'eval'		=> 'int',
			'checkbox'	=> '0',
			'default'	=> 0
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
			'filename' => $extensionPath . 'res/employees.txt',
			'delimiter' => ';',
			'text_qualifier' => '',
			'skip_rows' => 1,
			'encoding' => 'utf8'
		),
		'data' => 'array',
		'reference_uid' => 'tx_externalimporttut_code',
		'additional_fields' => 'last_name,first_name',
		'priority' => 50,
		'disabledOperations' => '',
		'enforcePid' => TRUE,
		'description' => 'Import of full employee list'
	),
	1 => array(
		'connector' => 'csv',
		'parameters' => array(
			'filename' => $extensionPath . 'res/holidays.txt',
			'delimiter' => ',',
			'text_qualifier' => '',
			'skip_rows' => 0,
			'encoding' => 'utf8'
		),
		'data' => 'array',
		'reference_uid' => 'tx_externalimporttut_code',
		'priority' => 60,
		'disabledOperations' => 'insert,delete',
		'description' => 'Import of holidays balance'
	)
);

	// Add the external information for each column
$TCA['fe_users']['columns']['name']['external'] = array(
	0 => array(
		'field' => 'last_name',
		'userFunc' => array(
			'class' => 'EXT:externalimport_tut/class.tx_externalimporttut_transformations.php:&tx_externalimporttut_transformations',
			'method' => 'assembleName'
		)
	)
);
$TCA['fe_users']['columns']['username']['external'] = array(
	0 => array(
		'field' => 'last_name',
		'userFunc' => array(
			'class' => 'EXT:externalimport_tut/class.tx_externalimporttut_transformations.php:&tx_externalimporttut_transformations',
			'method' => 'assembleUserName',
			'params' => array(
				'encoding' => 'utf8'
			)
		)
	)
);
$TCA['fe_users']['columns']['starttime']['external'] = array(
	0 => array(
		'field' => 'start_date',
		'userFunc' => array(
			'class' => 'EXT:external_import/samples/class.tx_externalimport_transformations.php:&tx_externalimport_transformations',
			'method' => 'parseDate'
		)
	)
);
$TCA['fe_users']['columns']['tx_externalimporttut_code']['external'] = array(
	0 => array(
		'field' => 'employee_number'
	),
	1 => array(
		'field' => 0
	)
);
$TCA['fe_users']['columns']['email']['external'] = array(
	0 => array(
		'field' => 'mail'
	)
);
$TCA['fe_users']['columns']['telephone']['external'] = array(
	0 => array(
		'field' => 'phone'
	)
);
$TCA['fe_users']['columns']['company']['external'] = array(
	0 => array(
		'value' => 'The Empire'
	)
);
$TCA['fe_users']['columns']['title']['external'] = array(
	0 => array(
		'field' => 'rank',
		'mapping' => array(
			'valueMap' => array(
				'1' => 'Captain',
				'2' => 'Senior',
				'3' => 'Junior'
			)
		),
		'excludedOperations' => 'update'
	)
);
$TCA['fe_users']['columns']['tx_externalimporttut_department']['external'] = array(
	0 => array(
		'field' => 'department',
		'mapping' => array(
			'table' => 'tx_externalimporttut_departments',
			'reference_field' => 'code'
		)
	)
);
$TCA['fe_users']['columns']['tx_externalimporttut_holidays']['external'] = array(
	1 => array(
		'field' => 1
	)
);

	// Load description of table tt_news
t3lib_div::loadTCA('tt_news');

	// Add a new column for containing the external id
$tempColumns = array(
	'tx_externalimporttut_externalid' => array(
		'exclude' => 0,
		'label' => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_ttnews.externalid',
		'config' => array(
			'type' => 'input',
			'size' => '20'
		)
	),
);
t3lib_extMgm::addTCAcolumns('tt_news', $tempColumns, 1);
t3lib_extMgm::addToAllTCAtypes('tt_news', 'tx_externalimporttut_externalid');

	// Add the external information to the ctrl section
$TCA['tt_news']['ctrl']['external'] = array(
	0 => array(
		'connector' => 'feed',
		'parameters' => array(
			'uri' => 'http://typo3.org/xml-feeds/rss.xml'
		),
		'data' => 'xml',
		'nodetype' => 'item',
		'reference_uid' => 'tx_externalimporttut_externalid',
		'enforcePid' => TRUE,
		'disabledOperations' => 'delete',
		'description' => 'Import of typo3.org news'
	),
);

	// Add the external information for each column
$TCA['tt_news']['columns']['title']['external'] = array(
	0 => array(
		'field' => 'title'
	)
);
$TCA['tt_news']['columns']['tx_externalimporttut_externalid']['external'] = array(
	0 => array(
		'field' => 'link'
	)
);
$TCA['tt_news']['columns']['datetime']['external'] = array(
	0 => array(
		'field' => 'pubDate',
		'userFunc' => array(
			'class' => 'EXT:external_import/samples/class.tx_externalimport_transformations.php:&tx_externalimport_transformations',
			'method' => 'parseDate'
		)
	)
);
$TCA['tt_news']['columns']['short']['external'] = array(
	0 => array(
		'field' => 'description',
		'trim' => TRUE
	)
);
$TCA['tt_news']['columns']['bodytext']['external'] = array(
	0 => array(
		'field' => 'encoded',
		'rteEnabled' => TRUE
	)
);
$TCA['tt_news']['columns']['ext_url']['external'] = array(
	0 => array(
		'field' => 'link',
	)
);
$TCA['tt_news']['columns']['type']['external'] = array(
	0 => array(
		'value' => 0
	)
);
$TCA['tt_news']['columns']['hidden']['external'] = array(
	0 => array(
		'value' => 0
	)
);
?>