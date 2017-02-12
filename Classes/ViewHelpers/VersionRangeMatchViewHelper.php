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
 * Version Range Match ViewHelper
 */
class VersionRangeMatchViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * Determines if a specific extension version matches a given version range (min/max).
     *
     * Returns one of the following glyphicons:
     * "glyphicon-ok-sign", if version matches the range.
     * "glyphicon-remove-sign", if version is outside the range.
     * "glyphicon-question-sign", if arguments ($versionsMinMax and/or $rerenceVersion) are invalid.
     *
     * @param string $versionsMinMax TYPO3 CMS min/max versions (e.g. "6.2.0-6.2.999")
     * @param string $referenceVersion TYPO3 CMS reference versions (e.g. "7.6.10")
     * @return string
     */
    public function render($versionsMinMax, $referenceVersion)
    {
        if (preg_match('/^[0-9\.]*-[0-9\.]*$/', $versionsMinMax) && preg_match('/^[0-9\.]*$/', $referenceVersion)) {
            $versions = VersionNumberUtility::convertVersionsStringToVersionNumbers($versionsMinMax);
            $lowestVersionNumeric = VersionNumberUtility::convertVersionNumberToInteger($versions[0]);
            $highestVersionNumeric = VersionNumberUtility::convertVersionNumberToInteger($versions[1]);

            $referenceVersionNumeric = VersionNumberUtility::convertVersionNumberToInteger($referenceVersion);

            if ($referenceVersionNumeric >= $lowestVersionNumeric
             && $referenceVersionNumeric <= $highestVersionNumeric) {
                return '<span class="glyphicon glyphicon-ok-sign is-compatible"></span>';
            }
            return '<span class="glyphicon glyphicon-remove-sign is-not-compatible"></span>';
        }
        return '<span class="glyphicon glyphicon-question-sign compatibility-unknown"></span>';
    }
}
