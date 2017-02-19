<?php

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

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$pluginName = 'ExtensionCompatibilityCheck';
$pluginSignature = preg_replace('/[^a-z0-9]/', '', strtolower($_EXTKEY)) . '_' . strtolower($pluginName);

$extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY);
$extRelPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY);

// Make sure this block is not loaded in the frontend context or within upgrade wizards
if (TYPO3_MODE === 'BE' && !(TYPO3_REQUESTTYPE & TYPO3_REQUESTTYPE_INSTALL)) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'SchamsNet.' . $_EXTKEY,
        'tools',
        $pluginName,
        'bottom',
        array(
            'Backend' => 'splash, list'
        ),
        array(
            'access' => 'admin',
            'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Backend/Icons/ext_icon.png',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.be.xlf',
        )
    );
}

// Register AJAX handler
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler(
    'ExtensionCompatibilityCheck::AjaxDispatch',
    'SchamsNet\\ExtensionCompatibilityCheck\\Controller\\AjaxRequestHandler->dispatch'
);
