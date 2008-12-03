<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2007 Francois Suter (Cobweb) <typo3@cobweb.ch>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
*
* $Id$
***************************************************************/

//require_once(t3lib_extMgm::extPath('external_import').'class.tx_externalimport_importer.php');

/**
 * Example transformation functions for the 'externalimport_tut' extension
 *
 * @author	Francois Suter (Cobweb) <typo3@cobweb.ch>
 * @package	TYPO3
 * @subpackage	tx_externalimporttut
 */
class tx_externalimporttut_transformations {

	/**
	 * This method assembles the user's full name
	 * At the point where it is called, the name field already contains the last name,
	 * so it's just a question of concatenating the first name
	 *
	 * @param	array	$record: the full record that is being transformed
	 * @param	string	$index: the index of the field to transform
	 * @param	array	$params: additional parameters from the TCA
	 * @return	mixed	Timestamp or formatted date string
	 */
	function assembleName($record, $index, $params) {
		$fullName .= $record[$index].' '.$record['first_name'];
		return $fullName;
	}

	/**
	 * This method assembles a valid user name
	 * At the point where it is called, this field contains the last name,
	 * which is not what we want
	 *
	 * @param	array	$record: the full record that is being transformed
	 * @param	string	$index: the index of the field to transform
	 * @param	array	$params: additional parameters from the TCA
	 * @return	mixed	Timestamp or formatted date string
	 */
	function assembleUserName($record, $index, $params) {
			// The base for the username will be the first name, a dot and the last name (lowercase)
		$userNameBase = strtolower($record['first_name'] . '.' . $record['last_name']);
			// We must make sure this doesn't contain non-ASCII characters
		$userName = $GLOBALS['LANG']->csConvObj->specCharsToASCII($params['encoding'], $userNameBase);
			// Lastly replace single quotes, double quotes or spaces by underscores
//		$userNameClean = preg_replace('/[\'"\s]/', '_', trim($userName));
		$userNameClean = preg_replace('/[^-a-zA-Z0-9_]/', '_', trim($userNameBase));
t3lib_div::devLog('Creating username for user: '.$record[$index], 'externalimport_tut', -1, array('base' => $userNameBase, 'no ascii' => $userName, 'clean' => $userNameClean));
		return $userNameClean;
	}

	/**
	 * This method responds to the "insertPreProcess" hook of the external importer class
	 * It is used to create a default password for a new user
	 * 
	 * @param	array	$record: the record to transform
	 * @param	object	$pObj: a reference to the external importer object
	 */
	function processBeforeInsert($record, $pObj) {
		if ($pObj->getTableName() == 'fe_users' && $pObj->getIndex() == 0) {
			$origRecord = $record;
				// Simply reverse the username to create the password
			$record['password'] = strrev($record['username']);
		}
		return $record;
	}
}
?>