.. =============================================================================
.. Extension Compatibility Check
.. (c)2017 Michael Schams <schams.net>
.. https://schams.net
.. =============================================================================

.. include:: ../Includes.txt

.. |icon-red| image:: ../Images/ResultsAndActions/icon-red.png
.. |icon-orange| image:: ../Images/ResultsAndActions/icon-orange.png
.. |icon-green| image:: ../Images/ResultsAndActions/icon-green.png

.. _results-and-actions:


Results and Actions
-------------------


.. important::

   It is important to understand that extension developers can specify which TYPO3 versions their extension is compatible with.
   This does not mean that their claim is correct!
   Due to the fact that the "Extension Compatibility Check" uses the details provided by the extension authors, it is not guaranteed that the results are accurate.


=============== ============================== =======================================================================================
Icon            Result                         Suggested Action
=============== ============================== =======================================================================================
|icon-green|    **Update not required.**       The currently installed extension version is already compatible with TYPO3 CMS 7.6 LTS.
                                               No actions are required. In most cases you even do not need to uninstall this extension
                                               before you update the TYPO3 core.
|icon-orange|   **Extension is TYPO3 CMS 7.6   The *currently* installed extension is **not** compatible with TYPO3 CMS 7.6 LTS.
                compatible since x.y.z.**      However, the extension author released an updated version, which is available for
                                               download from the
                                               `TYPO3 Extension Repository (TER) <https://typo3.org/extensions/repository/>`_.
                                               In most cases a TYPO3 update works, if you *disable* the currently installed
                                               extension, then update the TYPO3 core. After that, update the extension to a version
                                               that is compatible with 7.6 (note the version *x.y.z* stated in the results) and
                                               re-enable the extension in the Extension Manager.
|icon-red|      **No TYPO3 CMS 7.6 compatible  Extensions with a *red* icon are problematic. In this case, the extension author has
                version available**            not published a newer version which is compatible with TYPO3 CMS 7.6 LTS.
                                               This usually occurs if the extension author does not maintain the extension anymore.
                                               In this case, you should consider alternatives. Check the TER for 7.6 compatible
                                               extensions, which provide the same or similar functionality.
                                               You can also get in touch with the developer of the extension and ask if there are any
                                               plans for an extension update.
                                               Offering to sponsor the development is also a good idea in general.
                                               If you continue with the TYPO3 upgrade regardless, you should disable the extension
                                               before you start the upgrade process.
|icon-red|      **Extension not found in       If the extension can not be found in the database at all, the extension was likely
                database - no compatible       custom developed and not published in the TER.
                version available**            This does not mean that the extension is incompatible with TYPO3 CMS 7.6 LTS for sure,
                                               but it is very likely that it will break.
                                               It could be a good idea to get in touch with the developer of the extension -- or with
                                               any developer who is able to review, test and possibly update the code.
                                               If you continue with the TYPO3 upgrade regardless, you should disable the extension
                                               before you start the upgrade process.
=============== ============================== =======================================================================================
