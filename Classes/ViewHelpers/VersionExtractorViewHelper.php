<?php
namespace SchamsNet\ExtensionCompatibilityCheck\ViewHelpers;

/*
 * This file is part of the TYPO3 CMS Extension "Extension Compatibility Check"
 * Extension author: Michael Schams - https://schams.net
 *
 * For copyright and license information, please read the LICENSE.txt
 * file distributed with this source code.
 *
 * @package     TYPO3
 * @subpackage  extension_compatibility_check
 * @author      Michael Schams <schams.net>
 * @link        https://schams.net
 */

use TYPO3\CMS\Core\Utility\VersionNumberUtility;

/**
 * Version Extractor ViewHelper
 */
class VersionExtractorViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * Returns min or max version from a given version range
     *
     * @param string $versionsMinMax TYPO3 CMS min/max versions (e.g. "6.2.0-6.2.999")
     * @param string $minOrMax Retrieve either min or max version (e.g. "min")
     * @return string
     */
    public function render($versionsMinMax, $minOrMax = 'min')
    {
        if (preg_match('/^[0-9\.]*-[0-9\.]*$/', $versionsMinMax)) {
            $versions = VersionNumberUtility::convertVersionsStringToVersionNumbers($versionsMinMax);

            // Extract min and max versions from version range
            $min = VersionNumberUtility::convertVersionNumberToInteger($versions[0]);
            $max = VersionNumberUtility::convertVersionNumberToInteger($versions[1]);

            if ($minOrMax == 'min') {
                return $versions[0];
            } elseif ($minOrMax == 'max') {
                return $versions[1];
            } else {
                return implode(' to ', $versions);
            }
        }
        return '?';
    }
}
