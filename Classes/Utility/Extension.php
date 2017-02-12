<?php
namespace SchamsNet\ExtensionCompatibilityCheck\Utility;

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

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Extension utilities
 */
class Extension implements \TYPO3\CMS\Core\SingletonInterface
{
    /**
     * Returns the version of a specific extension
     *
     * @access  private
     * @param   string      $extensionKey extension key
     * @return  string      Extension version, e.g. "1.2.999"
     */
    public static function getExtensionVersion($extensionKey)
    {
        return ExtensionManagementUtility::getExtensionVersion($extensionKey);
    }

    /**
     * Returns the extension configuration
     *
     * @access  private
     * @return  array       Extension configuration
     */
    public static function getExtensionConfiguration($extensionKey)
    {
        if (isset($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extensionKey])
         && is_string($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extensionKey])
         && !empty($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extensionKey])) {
            $configuration = @unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$extensionKey]);
            if (is_array($configuration)) {
                return $configuration;
            }
        }
        return array();
    }
}
