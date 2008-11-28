<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

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
			)
		),
		'name' => array(
			'exclude' => 0,		
			'label' => 'LLL:EXT:externalimport_tut/locallang_db.xml:tx_externalimporttut_departments.name',		
			'config' => array(
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required,trim',
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
?>