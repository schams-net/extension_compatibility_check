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

use SchamsNet\ExtensionCompatibilityCheck\Utility\Extension;
use TYPO3\CMS\Extensionmanager\Utility\ListUtility;

/**
 * Backend Controller
 */
class BackendController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * Extension key
     *
     * @access private
     */
    private $extensionKey = 'extension_compatibility_check';

    /**
     * TYPO3 CMS Reference Version
     *
     * @access private
     */
    private $typo3RefenceVersion = '7.6';

    /**
     * Session handler
     *
     * @access private
     * @var \SchamsNet\ExtensionCompatibilityCheck\Utility\BackendSessionHandler
     */
    private $session;

    /**
     * @access protected
     * @var \TYPO3\CMS\Extensionmanager\Domain\Repository\RepositoryRepository
     */
    protected $repositoryRepository;

    /**
     * Default constructor
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        /** @var $objectManager \TYPO3\CMS\Extbase\Object\ObjectManager */
        $this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Extbase\Object\ObjectManager::class
        );
    }

    /**
     * Inject Backend Session Handler
     *
     * @access public
     * @param \SchamsNet\ExtensionCompatibilityCheck\Utility\BackendSessionHandler $session
     * @return void
     */
    public function injectBackendSessionHandler(
        \SchamsNet\ExtensionCompatibilityCheck\Utility\BackendSessionHandler $session
    ) {
        $this->session = $session;
    }

    /**
     * Inject Backend Session Handler
     *
     * @access public
     * @param \TYPO3\CMS\Extensionmanager\Domain\Repository\RepositoryRepository $session
     * @return void
     */
    public function injectRepositoryRepository(
        \TYPO3\CMS\Extensionmanager\Domain\Repository\RepositoryRepository $RepositoryRepository
    ) {
        $this->repositoryRepository = $RepositoryRepository;
    }

    /**
     * Initialize action
     *
     * @access public
     * @return void
     */
    public function initializeAction()
    {
        // Set extension key
        $this->extensionKey = $this->request->getControllerExtensionKey();
        $this->identifier = 'TYPO3 CMS ' . TYPO3_version . ' - EXT:' .
            $this->extensionKey . ' ' . Extension::getExtensionVersion($this->extensionKey);

        $this->session->setStorageKey('tx_extensioncompatibilitycheck');

        // Global variables
        $this->globalViewVariables = array(
            'extKey' => $this->extensionKey,
            'identifier' => $this->identifier,
            'controller' => $this->request->getControllerName(),
            'action' => $this->request->getControllerActionName()
        );
    }

    /**
     * Splash screen action
     *
     * @access public
     * @return void
     */
    public function splashAction()
    {
        // Assign global variables to the view
        $this->view->assignMultiple($this->globalViewVariables);

        $showButtonContinue = true;

        /** @var $repository \TYPO3\CMS\Extensionmanager\Domain\Model\Repository */
        $repository = $this->repositoryRepository->findByUid((int)$this->settings['repositoryUid']);
        $this->view->assign('repository', $repository);

        // Generate Flash message and prevent continue to next screen, if
        // current TYPO3 instance is not version 6.2.x.
        if (version_compare(TYPO3_version, '6.2.0', '<') || version_compare(TYPO3_version, '6.2.999', '>')) {
            $showButtonContinue = false;
            $this->addFlashMessage(
                htmlspecialchars($this->translate('flashmessage.wrong_typo3_version.message')),
                htmlspecialchars($this->translate('flashmessage.wrong_typo3_version.headline')),
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR,
                true
            );
        }

        // Generate Flash message (warning only), if
        // current PHP version is not TYPO3 CMS 7.6 compatible.
        if (version_compare(PHP_VERSION, '5.5.0', '<') || version_compare(PHP_VERSION, '7.0.999', '>')) {
            $this->addFlashMessage(
                htmlspecialchars($this->translate('flashmessage.incompatible_php_version.message')),
                htmlspecialchars($this->translate('flashmessage.incompatible_php_version.headline')),
                \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING,
                true
            );
        }

        $this->view->assign('showButtonContinue', $showButtonContinue);
    }

    /**
     * Splash action
     *
     * @access public
     * @return void
     */
    public function listAction()
    {
        // Assign global variables to the view
        $this->view->assignMultiple($this->globalViewVariables);

        $extensionlist = array();

        // Read extension list (TYPO3 core function: Extension List Utility)
        // @see class \TYPO3\CMS\Extensionmanager\Utility\ListUtility
        $extensionListUtility = $this->objectManager->get(ListUtility::class);
        $availableExtensions = $extensionListUtility->getAvailableAndInstalledExtensionsWithAdditionalInformation();
        foreach ($availableExtensions as $extensionKey => $details) {
            if (array_key_exists('type', $details) && array_key_exists('version', $details)) {
                if (strtolower($details['type']) == 'local') {
                    $extensionlist[$details['title']] = $details;
                }
            }
        }

        // Sort extension list by key (extension title)
        ksort($extensionlist);

        // Assign variables to the view
        $this->view->assign('typo3RefenceVersion', $this->typo3RefenceVersion);
        $this->view->assign('extensionlist', $extensionlist);
    }
}