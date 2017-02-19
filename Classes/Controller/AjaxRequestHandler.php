<?php
namespace SchamsNet\ExtensionCompatibilityCheck\Controller;

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

use SchamsNet\ExtensionCompatibilityCheck\Utility\BackendSessionHandler;
use SchamsNet\ExtensionCompatibilityCheck\Utility\Extension;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

/**
 * AJAX Request Handler
 */
class AjaxRequestHandler extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * Keywords of check results, also used in JavaScript file
     * See Resources/Public/JavaScript/ExtensionCompatibilityCheck.js
     */
    const AJAX_CHECK_RESULT_FAILED = 'failed';
    const AJAX_CHECK_RESULT_UPDATE = 'update';
    const AJAX_CHECK_RESULT_OK = 'ok';

    /**
     * Extension key
     *
     * @access private
     */
    private $extensionKey = 'extension_compatibility_check';

    /**
     * @var \TYPO3\CMS\Extensionmanager\Domain\Repository\ExtensionRepository
     * @inject
     */
    protected $extensionRepository;

    /**
     * Constructor
     *
     * @access private
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        /** @var $objectManager \TYPO3\CMS\Extbase\Object\ObjectManager */
        $this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Extbase\Object\ObjectManager::class
        );

        /** @var $extensionRepository \TYPO3\CMS\Extensionmanager\Domain\Repository\ExtensionRepository */
        $this->extensionRepository = $this->objectManager->get(
            '\TYPO3\CMS\Extensionmanager\Domain\Repository\ExtensionRepository'
        );

        /** @var $session \SchamsNet\ExtensionCompatibilityCheck\Utility\BackendSessionHandler */
        $this->session = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            'SchamsNet\ExtensionCompatibilityCheck\Utility\BackendSessionHandler'
        );
    }

    /**
     * Request dispatcher
     *
     * @access public
     * @param array $params Array of parameters from the AJAX interface, currently unused
     * @param \TYPO3\CMS\Core\Http\AjaxRequestHandler $ajaxObj Object of type AjaxRequestHandler
     * @return void
     */
    public function dispatch($params = array(), \TYPO3\CMS\Core\Http\AjaxRequestHandler &$ajaxObj = null)
    {
        if (array_key_exists('action', $_REQUEST)) {
            $action = $_REQUEST['action'];
            if ($action == 'checkCompatibility') {
                $this->checkCompatibility($ajaxObj);
            }
        }
    }

    /**
     * Return more details
     *
     * @access public
     * @param AjaxRequestHandler
     * @return void
     */
    private function checkCompatibility(&$ajaxObj)
    {
        // Set session key (identifier)
        $this->session->setStorageKey('tx_extensioncompatibilitycheck');

        $extensionKey = '';
        $typo3ReferenceVersionNumeric = 0;
        $extensionReferenceVersionNumeric = 0;
        $dependencies = array();
        $extensionFoundInDatabase = false;
        $extensionCurrentVersionDependency = array();

        // Extract extension key from request
        if (array_key_exists('extension', $_REQUEST)) {
            if (preg_match('/^[a-z0-9_]*$/', $_REQUEST['extension'])) {
                $extensionKey = $_REQUEST['extension'];
            }
        }

        // Extract TYPO3 reference version from request
        if (array_key_exists('typo3ReferenceVersion', $_REQUEST)) {
            if (preg_match('/^[0-9]{1,3}\.[0-9]{1,3}$/', $_REQUEST['typo3ReferenceVersion'])) {
                $typo3ReferenceVersion = $_REQUEST['typo3ReferenceVersion'];
                $typo3ReferenceVersionNumeric = VersionNumberUtility::convertVersionNumberToInteger(
                    $typo3ReferenceVersion . '.0'
                );
            }
        }

        // Extract extension reference version from request (currently installed version)
        if (array_key_exists('extensionReferenceVersion', $_REQUEST)) {
            if (preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $_REQUEST['extensionReferenceVersion'])) {
                $extensionReferenceVersion = $_REQUEST['extensionReferenceVersion'];
                $extensionReferenceVersionNumeric = VersionNumberUtility::convertVersionNumberToInteger(
                    $extensionReferenceVersion
                );
            }
        }

        // Extract extension dependency from request
        if (array_key_exists('extensionCurrentVersionDependency', $_REQUEST)) {
            if (preg_match('/^[0-9\.]{5,11}-[0-9\.]{5,11}$/', $_REQUEST['extensionCurrentVersionDependency'])) {
                $extensionCurrentVersionDependency = VersionNumberUtility::convertVersionsStringToVersionNumbers(
                    $_REQUEST['extensionCurrentVersionDependency']
                );
            }
        }

        // Get all versions of a specific extension from the current extension list
        $versions = $this->extensionRepository->findByExtensionKey($_REQUEST['extension'])->toArray();
        foreach ($versions as $extension) {
            $extensionFoundInDatabase = true;
            $version = $extension->getVersion();

            foreach ($extension->getDependencies() as $dependency) {
                if ($dependency->getIdentifier() === 'typo3') {
                    // Extract min TYPO3 CMS version (lowest)
                    $lowestVersionNumeric = VersionNumberUtility::convertVersionNumberToInteger(
                        $dependency->getLowestVersion()
                    );
                    // Extract max TYPO3 CMS version (higherst)
                    $highestVersionNumeric = VersionNumberUtility::convertVersionNumberToInteger(
                        $dependency->getHighestVersion()
                    );

                    if ($typo3ReferenceVersionNumeric >= $lowestVersionNumeric
                     && $typo3ReferenceVersionNumeric <= $highestVersionNumeric) {
                        $dependencies[VersionNumberUtility::convertVersionNumberToInteger($version)] = array(
                            'extension_version' => $version,
                            'typo3_version' => array(
                                'min' => $lowestVersionNumeric,
                                'max' => $highestVersionNumeric
                            )
                        );
                    }
                }
            }
        }

        // ...
        if ($extensionFoundInDatabase === true) {
            ksort($dependencies, SORT_NUMERIC);

            if (count($dependencies) == 0) {
                $dependencies = array(
                    'result' => self::AJAX_CHECK_RESULT_FAILED,
                    'message' => htmlentities(
                        LocalizationUtility::translate(
                            'ajax.message.no_compatible_version_available',
                            $this->extensionKey,
                            array($typo3ReferenceVersion)
                        )
                    )
                );
            } else {
                $compatible = current($dependencies);

                // String representation of version (e.g. "6.2.30")
                $compatibleExtensionVersion = $compatible['extension_version'];

                // Numeric representation of version string (e.g. 6002030)
                $compatibleExtensionVersionInteger = VersionNumberUtility::convertVersionNumberToInteger(
                    $compatibleExtensionVersion
                );

                $dependencies = array(
                    'result' => self::AJAX_CHECK_RESULT_OK,
                    'message' => htmlentities(
                        LocalizationUtility::translate(
                            'ajax.message.already_compatible_since_version',
                            $this->extensionKey,
                            array($typo3ReferenceVersion, $compatibleExtensionVersion)
                        )
                    )
                );

                if ($extensionReferenceVersionNumeric != 0
                 && $extensionReferenceVersionNumeric < $compatibleExtensionVersionInteger
                  ) {
                    $dependencies['result'] = self::AJAX_CHECK_RESULT_UPDATE;
                    $dependencies['message'].= ' ' . htmlentities(
                        LocalizationUtility::translate(
                            'ajax.message.update_available',
                            $this->extensionKey
                        )
                    );
                }
            }
        } else {
            // ...
            if (is_array($extensionCurrentVersionDependency) && count($extensionCurrentVersionDependency) == 2) {
                $min = VersionNumberUtility::convertVersionNumberToInteger($extensionCurrentVersionDependency[0]);
                $max = VersionNumberUtility::convertVersionNumberToInteger($extensionCurrentVersionDependency[1]);

                if ($max >= $typo3ReferenceVersionNumeric) {
                    $dependencies = array(
                        'result' => self::AJAX_CHECK_RESULT_OK,
                        'message' => htmlentities(
                            LocalizationUtility::translate(
                                'ajax.message.update_not_required',
                                $this->extensionKey
                            )
                        )
                    );
                }
            }

            if (count($dependencies) == 0) {
                $dependencies = array(
                    'result' => self::AJAX_CHECK_RESULT_FAILED,
                    'message' => htmlentities(
                        LocalizationUtility::translate(
                            'ajax.message.extension_not_found',
                            $this->extensionKey
                        )
                    )
                );
            }
        }

        // addContent(<key>, <content to add>)
        $ajaxObj->addContent('data', json_encode($dependencies));

        // Retrieve new content and generate output
        $ajaxObj->getContent('data');
    }
}
