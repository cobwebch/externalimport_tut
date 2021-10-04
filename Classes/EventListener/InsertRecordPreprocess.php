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
            // Simply reverse the username to create the password
            $record['password'] = strrev($record['username']);
            $event->setRecord($record);
        }
    }

}