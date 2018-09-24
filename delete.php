<?php

/**
 *
 * @category        page
 * @package         newsreader
 * @author          Robert Hase, Matthias Gallas, Dietrich Roland Pehlke (last)
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.12.x
 * @requirements    PHP 5.3 and higher
 * @version         0.3.9
 * @lastmodified    Sep 2018 
 *
 */

if ((__FILE__ != $_SERVER['SCRIPT_FILENAME']) === false) {
	die('<head><title>Access denied</title></head><body><h2 style="color:red;margin:3em auto;text-align:center;">Cannot access this file directly</h2></body></html>');
}

$database->query("DELETE FROM `".TABLE_PREFIX."mod_newsreader` WHERE `section_id` = '".$section_id."'");

?>