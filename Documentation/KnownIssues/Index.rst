.. =============================================================================
.. Extension Compatibility Check
.. (c)2017 Michael Schams <schams.net>
.. https://schams.net
.. =============================================================================

.. include:: ../Includes.txt

Known Issues
============

TYPO3 CMS 7.6 LTS
^^^^^^^^^^^^^^^^^

The "Extension Compatibility Check" extension is **not compatible with TYPO3 CMS 7.6 LTS**.

After an upgrade of the TYPO3 CMS core from version 6.2 to 7.6, the extension is possibly still installed in the *new* system. If you access the extension in TYPO3 CMS 7.6 (or newer), a fatal error or a white page is shown.

Solution: uninstall and delete the extension before you upgrade from TYPO3 CMS 6.2 to 7.6.


PHP Version 5.3
^^^^^^^^^^^^^^^

TYPO3 CMS 6.2 LTS runs with PHP version 5.3, 5.4, 5.5 and 5.6. Therefore, it is possible that some users install and execute the "Extension Compatibility Check" extension in a system which runs PHP version 5.3. Unfortunately, the extension is incompatible with this version of PHP.

Solution: none (I know a possible soltuion - please contact me if you run TYPO3 CMS 6.2 LTS on PHP version 5.3).
