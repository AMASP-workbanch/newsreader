<?php

/**
 *
 * @category        page
 * @package         newsreader
 * @author          Robert Hase, Matthias Gallas, Dietrich Roland Pehlke (last)
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WBCE 1.4.x, WebsiteBaker 2.12.x
 * @requirements    PHP 7.1 and higher
 * @version         0.4.0
 * @lastmodified    Jul 2019 
 *
 */

$module_directory   = "newsreader";
$module_name        = "Newsreader";
$module_function    = "page";   // [1]
$module_version     = "0.4.0";
$module_platform    = "2.12.2"; // [2]
$module_author      = "Robert Hase, adm_prg[AT]muc-net.de, Matthias Gallas, Dietrich Roland Pehlke (last)";
$module_license     = "GNU General Public License";
$module_description = "This module handels XML and RDF/RSS (0.9x, 1.0, 2.0) newsfeeds.";
$module_guid        = "913D804E-E254-4E09-A8F4-9C78519EF13D";

//  Overwrite vars
if(class_exists("addon\\newsreader\\classes\\newsreaderInit", true))
{
    addon\newsreader\classes\newsreaderInit::getInstance();
} else {
    require_once __DIR__."/classes/system/preload.php"; // [1]?
    newsreader\system\preload::initialize();            // [2]?
}

// [1]
$module_function    = "page".( newsreader\system\core::isWBCE() ? " , preinit" : "");
// [2]
$module_platform    = newsreader\system\core::getPlatformVersion();
