<?php
namespace Cobweb\ExternalimportTut\Transformation;

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

use TYPO3\CMS\Core\SingletonInterface;

/**
 * Example transformation functions for the 'externalimport_tut' extension
 *
 * @author Francois Suter (Idéative) <typo3@ideative.ch>
 * @package TYPO3
 * @subpackage tx_externalimporttut
 */
class CastTransformation implements SingletonInterface
{

    /**
     * Casts the current value to integer.
     *
     * @param array $record The full record that is being transformed
     * @param mixed $index The index of the field to transform
     * @param array $params Additional parameters from the TCA
     * @return int
     */
    public function castToInteger(array $record, $index, array $params): string
    {
        return (int)($record[$index] ?? '0');
    }
}
