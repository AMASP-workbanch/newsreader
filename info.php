<?php

/*

 Website Baker Project <http://www.websitebaker.org/>
 Copyright (C) 2004-2007, Ryan Djurovich

 Website Baker is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 Website Baker is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Website Baker; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

 -------------------------------------------------------------------------
  DEVELOPMENT HISTORY
 -------------------------------------------------------------------------
   v0.0.6  (Robert Hase)
    + initial release of the module
	
   v0.1  (Christian Sommer, doc)
    + changed line 344 of file newsparser.php according to a fix proposed by the forum member thorn 
	   for details see: (http://forum.websitebaker.org/index.php/topic,6790.0/)
   v0.1.1  ()
   PHP Error Quick Fix
   v0.1.2  ()
   PHP Error Fix ConvertCharset.class.php: ereg_replace to preg_replace.
   v0.1.3
   Fix for non existing keys inside functions.php.
   v0.1.4
   Fix for missing values inside preview.php and some codecleanings.
   v0.1.5
   FTAN support for WB 2.8.x.
   Add module guid.
   Add Lepton-CMS register_class_security
   Add rename screen.css to frontend.css and add backend.css
   Add EditCSS button to the backend-interface.
   v0.1.6
   Add a new info_icon for backend-interface.
   Minor codechanges inside the modify.php.
   Multible section support.
*/

$module_directory	= 'newsreader';
$module_name		= 'Newsreader';
$module_function	= 'page';
$module_version		= '0.1.6';
$module_platform 	= defined("LEPTON_GUID") ? '1.1.2': '2.6.x';
$module_author		= 'Robert Hase, adm_prg[AT]muc-net.de, Matthias Gallas, Dietrich Roland Pehlke';
$module_license		= 'GNU General Public License';
$module_description	= 'This module handels XML and RDF/RSS (0.9x, 1.0, 2.0) newsfeeds.';
$module_guid		= '913D804E-E254-4E09-A8F4-9C78519EF13D';
?>