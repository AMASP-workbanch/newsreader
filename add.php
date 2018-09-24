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
	$sqlquery = 'INSERT INTO `' . TABLE_PREFIX . 'mod_newsreader` (`';
	$sqlquery .= implode("`,`", array_keys($fields))."`) VALUES(";
	
	if (method_exists( $database, "escapeString") ) {
	
		foreach($fields as $key => $value) $sqlquery .= "'".$database->escapeString($value)."',";
	
	} else {
		foreach($fields as $key => $value) $sqlquery .= "'".@mysql_real_escape_string($value)."',";
	} 
	$sqlquery = substr($sqlquery, 0,-1).")";

	$database->query($sqlquery);
}

?>