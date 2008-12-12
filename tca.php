<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

// Columns definition for the departments table

$TCA['tx_externalimporttut_departments'] = array(
	'ctrl' => $TCA['tx_externalimporttut_departments']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,code,name'
	),
	'feInterface' => $TCA['tx_externalimporttut_departments']['feInterface'],
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type'    => 'check',
				'default' => '0'
			)
		),
		'code' => array(
			'exclude' => 0,		
			'label' => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_departments.code',		
			'config' => array(
				'type' => 'input',	
				'size' => '10',	
				'max' => '4',	
				'eval' => 'required,trim',
			),
			'external' => array(
				0 => array(
					'field' => 'code'
				)
			)
		),
		'name' => array(
			'exclude' => 0,		
			'label' => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_departments.name',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required,trim',
			),
			'external' => array(
				0 => array(
					'field' => 'name'
				)
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'hidden;;1;;1-1-1, code, name')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

// Columns definition for the teams table

$TCA['tx_externalimporttut_teams'] = array(
	'ctrl' => $TCA['tx_externalimporttut_teams']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,code,name'
	),
	'feInterface' => $TCA['tx_externalimporttut_teams']['feInterface'],
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type'    => 'check',
				'default' => '0'
			)
		),
		'code' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_teams.code',
			'config' => array(
				'type' => 'input',
				'size' => '10',
				'max' => '5',
				'eval' => 'required,trim',
			),
			'external' => array(
				0 => array(
					'field' => 'code'
				)
			)
		),
		'name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_teams.name',
			'config' => array(
				'type' => 'input',
				'size' => '30',
				'eval' => 'required,trim',
			),
			'external' => array(
				0 => array(
					'field' => 'name'
				)
			)
		),
		'members' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_teams.members',
			'config' => array(
				'type' => 'group',
				'size' => 5,
				'internal_type' => 'db',
				'allowed' => 'fe_users',
				'MM' => 'tx_externalimporttut_teams_feusers_mm',
				'maxitems' => 100
			),
			'external' => array(
				0 => array(
					'field' => 'employee',
					'MM' => array(
						'mapping' => array(
							'table' => 'fe_users',
							'reference_field' => 'tx_externalimporttut_code',
						),
						'sorting' => 'rank'
					)
				)
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'hidden;;1;;1-1-1, code, name, members;;;;2-2-2')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);
?>