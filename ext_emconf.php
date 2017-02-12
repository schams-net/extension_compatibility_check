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

$EM_CONF[$_EXTKEY] = array(
    'title' => 'Extension Compatibility Check',
    'description' => 'Lists TYPO3 compatibility of installed extensions.',
    'category' => 'module',
    'version' => '0.0.1',
    'module' => '',
    'state' => 'beta',
    'createDirs' => '',
    'clearcacheonload' => 0,
    'author' => 'Michael Schams (schams.net)',
    'author_email' => 'schams.net',
    'author_company' => 'https://schams.net',
    'constraints' => array(
        'depends' => array(
            'typo3' => '6.2.0-6.2.99',
            'php' => '5.3.7-5.6.99',
        ),
        'conflicts' => array(
        ),
        'suggests' => array(
        ),
    )
);
