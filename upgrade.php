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

/**
 *	prevent this file from being accessed directly
 */
if(!defined('WB_PATH')) die(header('Location: ../../index.php'));

$query = "show fields from `".TABLE_PREFIX."mod_newsreader`";

$result = $database->query ( $query );

if ($database->is_error() ) {

	$admin->print_error( $database->get_error() );

} else {
	
	$fields = array(
		'use_utf8_encode'	=> "INT NOT NULL DEFAULT 0",
		'own_dateformat'	=> "VARCHAR(100) NOT NULL DEFAULT ''"
	);
	
	while ( $data = $result->fetchRow() ) {
		foreach($fields as $look_up_field => &$options) {
			if ($data['Field'] == $look_up_field) $options = "";
		}
	}

	$errors = array();
	
	foreach($fields as $look_up_field => &$options) {
		if ($options != "") {
			$database->query( "ALTER TABLE `".TABLE_PREFIX."mod_newsreader` ADD `".$look_up_field."` ".$options );
			
			if ( $database->is_error() ) $errors[] =$database->get_error();	
		}
	}

	if ( true === count($errors) > 0 ) {

		$admin->print_error( implode("\n", $errors ) );

	} else {

		$admin->print_success( "Update Table for module 'newsreader' with success." );
	}
	
}

// Clear all content to force the reader to 'connect' direct after upgrade.
$database->query("UPDATE `".TABLE_PREFIX."mod_newsreader` SET `content`='' ");
?>