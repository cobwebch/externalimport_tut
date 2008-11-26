<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_externalimporttut_departments'] = array (
	'ctrl' => $TCA['tx_externalimporttut_departments']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,code,name'
	),
	'feInterface' => $TCA['tx_externalimporttut_departments']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'code' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_departments.code',		
			'config' => array (
				'type' => 'input',	
				'size' => '10',	
				'max' => '4',	
				'eval' => 'required,trim',
			)
		),
		'name' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_departments.name',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required,trim',
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, code, name')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);



$TCA['tx_externalimporttut_employees'] = array (
	'ctrl' => $TCA['tx_externalimporttut_employees']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,starttime,endtime,number,lastname,firstname,phone,email,department,holidays'
	),
	'feInterface' => $TCA['tx_externalimporttut_employees']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'starttime' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'default'  => '0',
				'checkbox' => '0'
			)
		),
		'endtime' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'checkbox' => '0',
				'default'  => '0',
				'range'    => array (
					'upper' => mktime(3, 14, 7, 1, 19, 2038),
					'lower' => mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))
				)
			)
		),
		'number' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_employees.number',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required,trim',
			)
		),
		'lastname' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_employees.lastname',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required,trim',
			)
		),
		'firstname' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_employees.firstname',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required,trim',
			)
		),
		'phone' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_employees.phone',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'email' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_employees.email',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'trim',
			)
		),
		'department' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_employees.department',		
			'config' => array (
				'type' => 'group',	
				'internal_type' => 'db',	
				'allowed' => 'tx_externalimporttut_departments',	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'holidays' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_employees.holidays',		
			'config' => array (
				'type'     => 'input',
				'size'     => '4',
				'max'      => '4',
				'eval'     => 'int',
				'checkbox' => '0',
				'range'    => array (
					'upper' => '1000',
					'lower' => '10'
				),
				'default' => 0
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, number, lastname, firstname, phone, email, department, holidays')
	),
	'palettes' => array (
		'1' => array('showitem' => 'starttime, endtime')
	)
);
?>