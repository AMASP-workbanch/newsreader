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

$fields = array(
	'last_update'	=> Time(),
	'content'		=> "",
	'ch_title'		=> "",
	'ch_link'		=> "",
	'ch_desc'		=> "",
	'img_title'		=> "",
	'img_uri'		=> "",
	'img_link'		=> "",
	'use_utf8_encode' => 0,
	'show_limit'	=> 15,
	'cycle'			=> 86400,
	'coding_from'	=> '--',
	'coding_to'		=> '--',
	'show_image'	=> 1,
	'show_desc'		=> 1,
	'section_id'	=> $section_id,
	'page_id'		=> $page_id
);

if (method_exists( $database, "build_and_execute") ) {
	$database->build_and_execute(
		'insert',
		TABLE_PREFIX . 'mod_newsreader',
		$fields
	);
	
} else {
	
	newsreader\system\queries::insert(
	    TABLE_PREFIX."mod_newsreader",
	    $fields
	);
}
