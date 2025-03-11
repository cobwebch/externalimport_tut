<?php

declare(strict_types=1);

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
 */
class LinkTransformation implements SingletonInterface
{

    /**
     * Parses a rich-text content to make links absolute.
     *
     * Somehow the Core's link parser chokes on relative links, which should not happen.
     * This is a workaround rather than digging in the Core.
     *
     * @param array $record The full record that is being transformed
     * @param mixed $index The index of the field to transform
     * @param array $params Additional parameters from the TCA
     * @return string The text with modified links
     */
    public function absolutizeUrls(array $record, mixed $index, array $params): string
    {
        $host = $params['host'];
        $text = $record[$index] ?? '';
        return str_replace(
                'href="/',
                'href="' . $host . '/',
                $text
        );
    }
}
