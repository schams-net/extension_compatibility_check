Extension Compatibility Check
=============================

Quick Summary
-------------

TYPO3 CMS extension to check the compatibility status of currently installed extensions in TYPO3 CMS 6.2 LTS.


Description
-----------

The official maintenance period of TYPO3 CMS version 6.2 LTS ends in March 2017. Agencies, TYPO3 integrators, developers and website owners face the challenge of upgrading their existing 6.2 instances to the new TYPO3 CMS version 7.6 LTS. In many cases updating the TYPO3 core is not a problem. However, extensions are often not maintained the same way as the TYPO3 core is, and some extensions are not 7.6 compatible at all.

The *Extension Compatibility Check* extension supports integrators in the review process, prior executing the upgrade. Installed in a TYPO3 CMS 6.2 LTS instance, the extension allows backend administrators to run a check to determine which extensions are compatible, which extensions require an update and which extensions need to be replaced (e.g. because no 7.6 compatible version exists).

It is important to understand that this extension does not modify, update or replace any existing extensions or fix any PHP code. The purpose of this extension is to generate a report about installed extension compatibility with TYPO3 7.6 LTS.


Documentation
-------------

<https://docs.typo3.org/typo3cms/extensions/extension_compatibility_check/>


Requirements
-------------------

* TYPO3 CMS version 6.2 LTS
* PHP version 5.4, 5.5 or 5.6

Installation and execution of the backend module requires administrator privileges.


Installation
------------

Stable and tested versions of the extension are published at the [TYPO3 Extension Repository (TER)](https://typo3.org/extensions/repository/view/extension_compatibility_check), so using the TYPO3 Extension Manager is the simplest option to install the extension.

If you want to test the latest bleeding edge version of the extension, download the ZIP file from the [GitHub repository](https://github.com/schams-net/extension_compatibility_check) and extract the archive. This creates a new directory `extension_compatibility_check-master`. Rename this directory to `extension_compatibility_check` (without `-master`) and transfer it to your TYPO3 server. Copy or move the directory into the `typo3conf/ext/` folder and make sure the permissions of all files and sub-directories are correct. At last, enable the extension in the Extension Manager.


License
-------

(c) 2017 Michael Schams (schams.net), all rights reserved

This software is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, either version 2 of the License, or any later version.

The GNU General Public License can be found at:  
http://www.gnu.org/copyleft/gpl.html


Contribution
------------

Feel free to report bugs or suggest changes or new feature at <https://github.com/schams-net/extension_compatibility_check>.
You are also welcome to submit *pull requests* at GitHub, if you want me to review your changes and consider them to be included in the next version of the extension.


Author
------

Michael Schams <[schams.net](https://schams.net)>
