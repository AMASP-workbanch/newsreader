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

if (!defined('SYSTEM_RUN'))
{
    require( dirname(dirname((__DIR__))).'/config.php');
}

//  For WB only - WBCE use another way
if(class_exists("addon\\newsreader\\classes\\newsreaderInit", true))
{
    addon\newsreader\classes\newsreaderInit::getInstance();
}

// Tells script to update when this page was last updated
$update_when_modified = true;
// Include WB admin wrapper script
$admin_header = false; // suppress to print the header, so no new FTAN will be set
require(WB_PATH."/modules/admin.php");

$tan_ok = false;
if (true === method_exists($admin, 'checkFTAN')) {
	if (!$admin->checkFTAN()) {
		$admin->print_header();
		$admin->print_error($MESSAGE['GENERIC_SECURITY_ACCESS'], WB_URL);
		$admin->print_footer();
		exit();
	} else {
		// After check print the header
		$admin->print_header();
		$tan_ok = true;
	}
} else {
	$admin->print_header();
}
   
$lang_file = __DIR__.'/languages/' . LANGUAGE . '.php';
require_once (file_exists($lang_file))
    ? $lang_file
    : __DIR__.'/languages/EN.php'
    ;

$oVal = newsreader\xvalidate::getInstance();
$oVal->strict_looking_inside = "post";

$all_names = array (
	'uri'			=> array ('type' => 'str',	'default' => NULL,	'range' =>""),
	'cycle'			=> array ('type' => 'int+', 'default' => 86400, 'range' => array('min'=> 14400, 'max'=> 999999)),
	'show_image'	=> array ('type' => 'int+', 'default' => 0, 'range' => array('min'=> 0, 'max'=> 1)),
	'show_desc'		=> array ('type' => 'int+', 'default' => 0, 'range' => array('min'=> 0, 'max'=> 1)),
	'show_limit'	=> array ('type' => 'int+',	'default' => "10",	'range' => array('min'=> 1, 'max'=> 50)),
	'coding_from'		=> array ('type' => 'str',  'default' => '--', 'range' => ""),
	'coding_to' 		=> array ('type' => 'str', 'default' => '--', 'range' => ""),
	'use_utf8_encode'	=> array ('type' => 'int+', 'default' => 0, 'range' => array('min'=> 0, 'max'=> 1)),
	'own_dateformat'	=> array ('type' => 'str',	'default' => NULL,	'range' =>"")
);

$all_values = array ();

foreach($all_names as $item=>&$options)
{ 
    $all_values[$item] = $oVal->get_request($item, $options['default'], $options['type'], $options['range']);
}

if (method_exists( $database, "build_and_execute") )
{
	$database->build_and_execute(
		'update',
		TABLE_PREFIX."mod_newsreader",
		$all_values,
		'section_id = '. $section_id
	);		

} else {
	
	newsreader\system\queries::update(
	   TABLE_PREFIX."mod_newsreader",
	   $all_values,
	   "`section_id`=".$section_id 
	);
}

// get the newsfeed and save it
$result = newsreader\newsreader::getInstance()->update(
	$all_values['uri'],
	$section_id,
	$all_values['show_image'],
	$all_values['show_desc'],
	$all_values['show_limit'],
	$all_values['coding_from'],
	$all_values['coding_to'],
	$all_values['use_utf8_encode']
);

if($database->is_error()) {
	$admin->print_error(mysql_error() . " ".$query, $js_back);
} else {
	if (!is_array( $result) ) {
			$admin->print_error( $result . "<br />".$MOD_NEWSREADER_TEXT['RECORDS UNTOUCHED'], $js_back);
	
	} else {
	    if(isset($_POST['job']))
	    {
	        if($_POST['job']== "save_back")
	        {
	            $admin->print_success($MESSAGE['PAGES_SAVED'], ADMIN_URL.'/pages/index.php');
	        } else {
	            $admin->print_success($MESSAGE['PAGES_SAVED'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
	        }
	    }
	}
}

$admin->print_footer();
