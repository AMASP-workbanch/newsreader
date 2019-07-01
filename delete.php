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

if ((__FILE__ != $_SERVER['SCRIPT_FILENAME']) === false) {
	die('<head><title>Access denied</title></head><body><h2 style="color:red;margin:3em auto;text-align:center;">Cannot access this file directly</h2></body></html>');
}

if(class_exists("addon\\newsreader\\classes\\newsreaderInit", true))
{
    addon\newsreader\classes\newsreaderInit::getInstance();
}

newsreader\system\queries::delete(
    TABLE_PREFIX."mod_newsreader",
    [   "section_id"    => $section_id ]
);
