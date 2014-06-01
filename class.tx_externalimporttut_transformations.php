<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2007-2014 Francois Suter (Cobweb) <typo3@cobweb.ch>
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
***************************************************************/

/**
 * Example transformation functions for the 'externalimport_tut' extension
 *
 * @author		Francois Suter (Cobweb) <typo3@cobweb.ch>
 * @package		TYPO3
 * @subpackage	tx_externalimporttut
 */
class tx_externalimporttut_transformations implements t3lib_Singleton {

	/**
	 * This method assembles the user's full name
	 * At the point where it is called, the name field already contains the last name,
	 * so it's just a question of concatenating the first name
	 *
	 * @param	array	$record: the full record that is being transformed
	 * @param	string	$index: the index of the field to transform
	 * @param	array	$params: additional parameters from the TCA
	 * @return	mixed	Full name, i.e. last name and first name concatenated
	 */
	public function assembleName($record, $index, $params) {
		$fullName = $record['last_name'] . ' ' . $record['first_name'];
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
	 * @return	mixed	Calculated user name
	 */
	public function assembleUserName($record, $index, $params) {
			// Make sure the encoding uses the proper code
		$encoding = $GLOBALS['LANG']->csConvObj->parse_charset($params['encoding']);
			// The base for the user name will be the first name, a dot and the last name (lowercase)
		$baseName = $record['first_name'] . '.' . $record['last_name'];
		$userNameBase = $GLOBALS['LANG']->csConvObj->conv_case($encoding, $baseName, 'toLower');
			// We must make sure this doesn't contain non-ASCII characters
		$userName = $GLOBALS['LANG']->csConvObj->specCharsToASCII($encoding, $userNameBase);
			// Lastly replace single quotes, double quotes or spaces by underscores
			// Other special characters are acceptable
		$userNameClean = preg_replace('/[\'"\s]/', '_', trim($userName));
		return $userNameClean;
	}
}
?>