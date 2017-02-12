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

class BackendSessionHandler implements \TYPO3\CMS\Core\SingletonInterface
{
    /**
     * @var string
     */
    protected $storageKey;

    /**
     * Set storage key
     *
     * @param string $storageKey
     */
    public function setStorageKey($storageKey)
    {
        $this->storageKey = $storageKey;
    }

    /**
     * Store $value in the session under $key
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function store($key, $value)
    {
        $data = $GLOBALS['BE_USER']->getSessionData($this->storageKey);
        $data[$key] = $value;
        return $GLOBALS['BE_USER']->setAndSaveSessionData($this->storageKey, $data);
    }

    /**
     * Delete $value of $key from session
     *
     * @param string $key
     * @return bool
     */
    public function delete($key)
    {
        $data = $GLOBALS['BE_USER']->getSessionData($this->storageKey);
        unset($data[$key]);
        return $GLOBALS['BE_USER']->setAndSaveSessionData($this->storageKey, $data);
    }


    /**
     * Get value of $key from session
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        $data = $GLOBALS['BE_USER']->getSessionData($this->storageKey);
        return isset($data[$key]) ? $data[ $key ] : null;
    }
}
