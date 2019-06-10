# CHANGELOG
## Module: newsreader
Please note: This change log may not be accurate

------------------------------------------------------------------------------------------
### 0.4.0
- Add classes
- Use twig for backend/frontend
- Remove old template files

### 0.3.10
- Minor changes in the readme
- Tested on PHP 7.3.1 with WBCE 1.3.3

### 0.3.9
- Codechanges and modifications for WB 2.12.x
- Remove L* specific code

### 0.3.8
- Minor additions inside preview; add "use_utf8_encoding" and "own_dateformat" to configuration table.
- Correct time used in preview.
- Remove typos in language-files.
- rename class "c_date" to "newsreader_date" to avoid nameing-conflicts within x_CDate class.
- minor cosmetic (css-)changes in preview.
- Bugfix for missing own_dateformat.
- CSS fixes inside help.php

### 0.3.7
- Valid preview output.
- Codechanges inside the JavaScript for the preview inside modify.htt
- Add backend.js to module
- Bugfix within section_id in modify.htt

### 0.3.6
- Bugfixes inside the preview.
- Remove tab-index inside modify.htt.
- Bugfixes for double-utf8-encoding.

### 0.3.5
- Bugfix inside ConvertCharset.class.php for empty strings to convert.

### 0.3.4
- Remove unnecessary keys from the language files.
- Remove unnecessary "alt" attribut from preview.
- Bugfix for multible newsreader sections on one page for the language files.
- Add image-block to view.htt to supress empty image-links.

### 0.3.3
- Codechanges inside functions.php.
- Remove unnecessary "alt" attribut from output.
- Bugfix for broken link in view.htt

### 0.3.2
- Bugfix inside newsparser.php - commented out cURL option(-s)

### 0.3.1
- Add 'add.php' to the module.
- Codechanges and bugfixes inside modify.php, save.php.
- Additional css changes.
- Additional fields and changes inside languages and help.
- Add README.md to the module.
- FTAN bugfix for WB 2.8.3 SP3

### 0.3.0
- Add field for own date-time format. E.g. "%A - %e. %B %Y - %H:%M"
- Use cURL inside the newsparser.php

### 0.2.2
- Add class c_date for date-time formating to the project.

### 0.2.1
- Add templates for view.php and modify.php. (Using "old" php-lib template engine for backward compatibility)
- Add validator class to save.php

### 0.2.0
- Prepare for GitHub, add Changelog
- Bugfix inside newsparser.php for optional utf8-encoding.
- Codechanges and cleanings.

### 0.1.9
- Bugfixes for WebsiteBaker 2.8.3 SP2 within PHP >= 5.5.x

### 0.1.8
- Bugfix in preview function
    
### 0.1.7
- Bugfix for FTAN and WB 2.8.4
- Bugfix for version-compare of module_platform less than WB 2.8.x

### 0.1.6
- Add a new info_icon for backend-interface.
- Minor codechanges inside the modify.php.
- Multible section support.
     
### 0.1.5
- FTAN support for WB 2.8.x.
- Add module guid.
- Add Lepton-CMS register_class_security
- Add rename screen.css to frontend.css and add backend.css
- Add EditCSS button to the backend-interface.
### 0.1.4
- Fix for missing values inside preview.php and some codecleanings.

### 0.1.3
- Fix for non existing keys inside functions.php.

### 0.1.2  ()
- PHP Error Fix ConvertCharset.class.php: ereg_replace to preg_replace.

### 0.1.1  ()
- PHP Error Quick Fix

### 0.1  (Christian Sommer, doc)
- changed line 344 of file newsparser.php according to a fix proposed by the forum member thorn for details see: (http://forum.websitebaker.org/index.php/topic,6790.0/)

### 0.0.6  (Robert Hase)
- initial release of the module
