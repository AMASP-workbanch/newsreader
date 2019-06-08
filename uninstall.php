<?php

/**
 *
 * @category        page
 * @package         newsreader
 * @author          Robert Hase, Matthias Gallas, Dietrich Roland Pehlke (last)
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.12.x
 * @requirements    PHP 7.1 and higher
 * @version         0.3.10
 * @lastmodified    Jun 2019 
 *
 */

if(!defined('WB_PATH')) { exit("Cannot access this file directly"); }

$database->query("DELETE FROM ".TABLE_PREFIX."search WHERE name = 'module' AND value = 'newsreader'");
$database->query("DELETE FROM ".TABLE_PREFIX."search WHERE extra = 'newsreader'");
$database->query("DROP TABLE ".TABLE_PREFIX."mod_newsreader");

?>