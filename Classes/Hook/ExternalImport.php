<?php
namespace Cobweb\ExternalimportTut\Hook;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Cobweb\ExternalImport\Importer;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * Example hooks for the 'externalimport_tut' extension
 *
 * @author Francois Suter (Cobweb) <typo3@ideative.ch>
 * @package TYPO3
 * @subpackage tx_externalimporttut
 */
class ExternalImport implements SingletonInterface
{

    /**
     * This method responds to the "insertPreProcess" hook of the external importer class
     * It is used to create a default password for a new user
     *
     * @param array $record The record to transform
     * @param Importer $pObj A reference to the external importer object
     * @return array
     */
    public function processBeforeInsert($record, $pObj): array
    {
        // Perform operation only for the fe_users table and for external index 0
        if ($pObj->getExternalConfiguration()->getTable() === 'fe_users' && (int)$pObj->getExternalConfiguration()->getIndex() === 0) {
            // Simply reverse the username to create the password
            $record['password'] = strrev($record['username']);
        }
        return $record;
    }
}
