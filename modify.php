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

global $admin;

include_once(WB_PATH . '/modules/newsreader/functions.php');
// include core functions to edit the optional module CSS files (frontend.css, backend.css)
include_once(WB_PATH .'/framework/module.functions.php');

if(!defined('LANGUAGE')) getLanguage();

$lang_file = WB_PATH . '/modules/newsreader/languages/' . LANGUAGE . '.php';
require_once( file_exists($lang_file) ? $lang_file : WB_PATH . '/modules/newsreader/languages/EN.php' );

$sqlquery = "SELECT uri, cycle, last_update, show_image, show_desc, show_limit, coding_from, coding_to,use_utf8_encode, own_dateformat
			FROM ".TABLE_PREFIX."mod_newsreader
			WHERE section_id = '$section_id'";
$sqlresult = $database->query($sqlquery);

$sqlrow = $sqlresult->fetchRow( MYSQL_ASSOC );

$uri = $sqlrow['uri'];
$cycle = $sqlrow['cycle'];
$datetime = DATE_FORMAT . ' ' . TIME_FORMAT;
$last_update = $sqlrow['last_update'];
$show_image = $sqlrow['show_image'];
$show_imageCkd = ($show_image == 1) ? 'checked="checked"' : "";
$show_desc = $sqlrow['show_desc'];
$show_descCkd = ($show_desc == 1) ? 'checked="checked"' : "";
$show_limit = $sqlrow['show_limit'];	
$optionFrom = $sqlrow['coding_from'];
$optionTo = $sqlrow['coding_to'];
$use_utf8_encoding = $sqlrow['use_utf8_encode']==1 ? "checked='checked'" : "";
$own_dateformat = $sqlrow['own_dateformat'];

/**
 *	include the button to edit the optional module CSS files (function added with WB 2.7)
 *	Note: CSS styles for the button are defined in backend.css (div class="mod_moduledirectory_edit_css")
 *	Place this call outside of any <form></form> construct!
 */
if(function_exists('edit_module_css'))
{
	edit_module_css('newsreader');
}

/**	*************
 *	Date and time
 */

require_once(dirname(__FILE__)."/classes/class.newsreader_date.php");
$oCDate = new newsreader_date();
	
$oCDate->set_wb_lang( LANGUAGE );
	
if($own_dateformat != "") {
	$oCDate->format = $own_dateformat;
} else {
	$oCDate->format = $oCDate->wb_date_formats[ DATE_FORMAT ] ." - ".$oCDate->wb_time_formats[ TIME_FORMAT ];
}
	
$last_update = $oCDate->toHTML( $last_update + (defined('TIMEZONE') ? TIMEZONE : 0) );

$arrOptions = readCharsets();

$select_from_options = "";
foreach($arrOptions as &$option){
	$select_from_options .= '<option value="'.$option.'"'; 
	$select_from_options .= ($option == $optionFrom) ? ' selected="selected">' : ">" ;
	$select_from_options .= $option . '</option>';
}

$select_to_options = "";
foreach($arrOptions as &$option){
	$select_to_options .= '<option value="'.$option.'"'; 
	$select_to_options .= ($option == $optionTo) ? ' selected="selected">' : ">" ;
	$select_to_options .= $option . '</option>';
}

$form_values = array(
	'WB_URL'	=> WB_URL,
	'SECTION_ID'	=> $section_id,
	'PAGE_ID'		=> $page_id,
	'SQLTYPE'		=> 'UPDATE',
	'TEXT_RSS_URI'	=> $MOD_NEWSREADER_TEXT['RSS_URI'],
	'URI'			=> $uri,
	'FTAN'			=> method_exists($admin, "getFTAN") ? $admin->getFTAN() : "",
	'TEXT_CYCLE'	=> $MOD_NEWSREADER_TEXT['CYCLE'],
	'CYCLE'			=> $cycle,
	'TEXT_LAST_UPDATED'	=> $MOD_NEWSREADER_TEXT['LAST_UPDATED'],
	'LAST_UPDATE'		=>  $last_update,
	'TEXT_SHOW_IMAGE'	=> $MOD_NEWSREADER_TEXT['SHOW_IMAGE'],
	'SHOW_IMAGE'		=> $show_image,	
	'SHOW_IMAGECKD'	=> $show_imageCkd,
	'TEXT_SHOW_DESCRIPTION'	=> $MOD_NEWSREADER_TEXT['SHOW_DESCRIPTION'],
	'SHOW_DESC'	=> $show_desc,
	'SHOW_DESCCKD'	=> $show_descCkd,
	'TEXT_MAX_ITEMS'	=> $MOD_NEWSREADER_TEXT['MAX_ITEMS'],
	'SHOW_LIMIT'	=> $show_limit,
	'TEXT_CODING'	=> $MOD_NEWSREADER_TEXT['CODING'],
	'TEXT_FROM'		=> strtolower($TEXT['FROM']),
	'SELECT_FROM'	=> $select_from_options,				#1
	'TEXT_TO'		=> strtolower($TEXT['TO']),
	'SELECT_TO'		=> $select_to_options,					#2
	'TEXT_USE_UTF8_ENCODING'	=> $MOD_NEWSREADER_TEXT['USE_UTF8_ENCODING'],
	'TEXT_OWN_DATEFORMAT'	=> $MOD_NEWSREADER_TEXT['OWN_DATEFORMAT'],
	'OWN_DATEFORMAT'	=> $own_dateformat,
	'USE_UTF8_ENCODING'	=> $use_utf8_encoding,
	'TEXT_SAVE'	=> $TEXT['SAVE'],
	'TEXT_CANCEL' => $TEXT['CANCEL'],
	'TEXT_PREVIEW' => $MOD_NEWSREADER_TEXT['PREVIEW']
);

$template = new Template( dirname(__FILE__)."/templates/" );
$template->set_file('page', 'modify.htt');
$template->set_block('page', 'main_block', 'main');

$template->set_var(	$form_values );

$template->parse('main', 'main_block', false);
$template->pparse('output', 'page', false);

?>