<?php

declare(strict_types=1);

namespace Cobweb\ExternalimportTut\EventListener;

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

use Cobweb\ExternalImport\Event\InsertRecordPreprocessEvent;

class InsertRecordPreprocess
{
    public function __invoke(InsertRecordPreprocessEvent $event): void
    {
        $importer = $event->getImporter();
        // Perform operation only for the fe_users table and for external index 0
        if ($importer->getExternalConfiguration()->getTable() === 'fe_users' && (int)$importer->getExternalConfiguration()->getIndex() === 0) {
            $record = $event->getRecord();
            // Generate the password from the reversed username and add some numbers and special characters
            // to satisfy password policy (NOTE: this is really just an example, don't try this at home)
            $password = strrev($record['username']);
            $password .= random_int(33, 47) . random_int(48, 57) . random_int(33, 47) . random_int(48, 57);
            $record['password'] = $password;
            $event->setRecord($record);
        }
    }

}