<?php

/**
 *
 * @category        page
 * @package         newsreader
 * @author          Robert Hase, Matthias Gallas, Dietrich Roland Pehlke (last)
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.12.x
 * @requirements    PHP 7.1 and higher
 * @version         0.4.0
 * @lastmodified    Jun 2019 
 *
 */

if(class_exists("addon\\newsreader\\classes\\newsreaderInit", true))
{
    addon\newsreader\classes\newsreaderInit::getInstance();
} else {
    require_once __DIR__."/classes/system/preload.php"; // [1]?
    newsreader\system\preload::initialize();            // [2]?
}

$module_directory   = "newsreader";
$module_name        = "Newsreader";
$module_function    = "page".( newsreader\system\core::isWBCE() ? " , preinit" : "");
$module_version     = "0.4.0";
$module_platform    = newsreader\system\core::getPlatformVersion();
$module_author      = "Robert Hase, adm_prg[AT]muc-net.de, Matthias Gallas, Dietrich Roland Pehlke (last)";
$module_license     = "GNU General Public License";
$module_description = "This module handels XML and RDF/RSS (0.9x, 1.0, 2.0) newsfeeds.";
$module_guid        = "913D804E-E254-4E09-A8F4-9C78519EF13D";
