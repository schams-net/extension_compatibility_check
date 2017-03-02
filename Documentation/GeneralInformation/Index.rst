.. =============================================================================
.. Extension Compatibility Check
.. (c)2017 Michael Schams <schams.net>
.. https://schams.net
.. =============================================================================

.. include:: ../Includes.txt

General Information
-------------------


Introduction
^^^^^^^^^^^^

The official maintenance period of TYPO3 CMS version 6.2 LTS ends in March 2017. Agencies, TYPO3 integrators, developers and website owners face the challenge of upgrading their existing 6.2 instances to the new TYPO3 CMS version 7.6 LTS. In many cases updating the TYPO3 core is not a problem. However, extensions are often not maintained the same way as the TYPO3 core is, and some extensions are not 7.6 compatible at all.

The "Extension Compatibility Check" extension supports integrators in the review process, prior executing the upgrade. Installed in a TYPO3 CMS 6.2 LTS instance, the extension allows backend administrators to run a check to determine which extensions are compatible, which extensions require an update and which extensions need to be replaced (e.g. because no 7.6 compatible version exists).

It is important to understand that this extension does not modify, update or replace any existing extensions or fix any PHP code. The purpose of this extension is to generate a report about installed extension compatibility with TYPO3 7.6 LTS.



.. _system-requirements:

Requirements
^^^^^^^^^^^^

* TYPO3 CMS version 6.2 LTS
* PHP version 5.4, 5.5 or 5.6

Installation and execution of the backend module requires administrator privileges.


License
^^^^^^^

Copyright 2017 Michael Schams (schams.net), all rights reserved

This software is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, either version 2 of the License, or any later version.

The GNU General Public License can be found at: `<http://www.gnu.org/copyleft/gpl.html>`_


Contribution
^^^^^^^^^^^^

If you would like to report a bug or suggest a change or new feature, please use the
`Issue Tracker at GitHub <https://github.com/schams-net/extension_compatibility_check>`_.
You are also welcome to submit *pull requests* at GitHub, if you want me to review your changes and consider them to be included in the next version of the extension.
