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
