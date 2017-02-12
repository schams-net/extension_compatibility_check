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

use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Extensionmanager\Domain\Model\Dependency;
use TYPO3\CMS\Extensionmanager\Domain\Model\Extension;

/**
 * Shows the version numbers of the TYPO3 dependency, if any
 */
class Typo3DependencyViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * Finds and returns the suitable TYPO3 versions ("<min> - <max>") of a given extension
     *
     * @param Extension $extension
     * @return string
     */
    public function render(Extension $extension)
    {
        /** @var Dependency $dependency */
        foreach ($extension->getDependencies() as $dependency) {
            if ($dependency->getIdentifier() === 'typo3') {
                $lowestVersion = $dependency->getLowestVersion();
                $highestVersion = $dependency->getHighestVersion();
                $cssClass = $this->isVersionSuitable($lowestVersion, $highestVersion) ? 'success' : 'default';
                return
                    '<span class="label label-' . $cssClass . '">'
                        . htmlspecialchars($lowestVersion) . ' - ' . htmlspecialchars($highestVersion)
                    . '</span>';
            }
        }
        return '';
    }

    /**
     * Check if current TYPO3 version is suitable for the extension
     *
     * @param string $lowestVersion
     * @param string $highestVersion
     * @return bool
     */
    protected function isVersionSuitable($lowestVersion, $highestVersion)
    {
        $numericTypo3Version = VersionNumberUtility::convertVersionNumberToInteger(
            VersionNumberUtility::getNumericTypo3Version()
        );
        $numericLowestVersion = VersionNumberUtility::convertVersionNumberToInteger(
            $lowestVersion
        );
        $numericHighestVersion = VersionNumberUtility::convertVersionNumberToInteger(
            $highestVersion
        );
        return MathUtility::isIntegerInRange($numericTypo3Version, $numericLowestVersion, $numericHighestVersion);
    }
}
