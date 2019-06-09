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

function output($nf)
{
	/*
	DESCRIPTION:
	ch_title	= title of the newsfeed
	ch_link		= link to somewhere (normally the website of the newsfeed)
	ch_desc		= description of the newsfeed
	img_title	= title of the newsfeed image/logo
	img_uri		= URI to image/logo
	img_link	= link to somewhere (normally the website of the newsfeed)
	last_update	= last db update of this newsfeed (UNIX time)
	show_image	= show newsfeed image/logo (0|1)
	show_desc	= show newsfeed item description (0|1)
	*/

	global $wb;
	global $MOD_NEWSREADER_TEXT;
	
	$sModulPath = str_replace('\\', '/', __DIR__).'/';  
	$sModulname = basename(__DIR__);

	$lang_file = WB_PATH . "/modules/".$sModulname."/languages/" . LANGUAGE . ".php";
	require( file_exists($lang_file) ? $lang_file : WB_PATH . "/modules/".$sModulname ."/languages/EN.php");
	
	$lookup_paths = array();

	$lookup_paths[] = ($wb->page['template'] != "")
		? "/templates/".$wb->page['template']."/templates/".$sModulname."/"
		: "/templates/".DEFAULT_TEMPLATE."/templates/".$sModulname."/"
		;

	$lookup_paths[] = "/modules/".$sModulname."/templates/";
	
	$template_dir = "";
	foreach($lookup_paths as &$path)
	{
		if (file_exists( WB_PATH.$path."view.htt" )) {
			$template_dir = WB_PATH.$path;
			break;
		}
	}

	if ($template_dir == "")
	{
		echo "Error: can't find any valid template-file for the view.php. Please check installation.";
		return NULL;
	}	

    if (!class_exists('Template', true))
    {
        require(WB_PATH.'/include/phplib/template.inc');
    }
	
	$template = new Template( $template_dir );
	$template->set_file('page', 'view.htt');
	$template->set_block('page', 'main_block', 'main');
	$template->set_block('main_block', 'image_block', 'image');
	
	/**	*************
 	 *	Date and time
 	 */
	$oCDate = newsreader\xdate::getInstance();
	
	$oCDate->set_wb_lang( LANGUAGE );
	if ($nf['own_dateformat'] != "")
	{
		$oCDate->format = $nf['own_dateformat'];
	} else {
		$oCDate->format = $oCDate->wb_date_formats[ DATE_FORMAT ] ." - ".$oCDate->wb_time_formats[ TIME_FORMAT ];
	}
	
	$last_update = $oCDate->toHTML( $nf['last_update'] + (defined('TIMEZONE') ? TIMEZONE : 0) );
	
	$template->set_var(
		array(
            'IMG_LINK'	=> $nf['img_link'],
            'IMG_TITLE'	=> $nf['img_title'],
            'IMG_URI'	=> $nf['img_uri'],
            'CH_TITLE'	=> $nf['ch_title'],
            'CH_DESC'	=> $nf['ch_desc'],
            'TEXT_LAST_UPDATED'	=> $MOD_NEWSREADER_TEXT['LAST_UPDATED'], # 1: language-file!
            'LAST_UPDATED_TIME'	=> $last_update,
            'CONTENT'	=> $nf['content']
        )
    );
	
	if ($nf['img_uri'] != "")
	{
		$template->parse('image', 'image_block', true); 
	}
	
	// Parse template object
	$template->parse('main', 'main_block', false);
	$template->pparse('output', 'page', false);
}

function update($uri, $section_id, $show_image, $show_desc, $show_limit, $coding_from, $coding_to, $use_utf8_encode=0, $own_dateformat="")
{
	// called by view.php
	global $database;
	
	include(WB_PATH . '/modules/newsreader/newsparser.php');

	$nf = array();

	if ($uri != "") {
		
		// create and set object newsfeed
		$px = new RSS_feed();
		$px->Set_Limit($show_limit); 
		$px->Show_Image($show_image); 
		$px->Show_Description($show_desc);
		$result = $px->Set_URL($uri);
	
		if (false === $result) {
			return $px->error;
		}
		
		$nf['show_image'] = $show_image;
		$nf['show_desc'] = $show_desc;
	
		// get newsfeed contents
		$nf['content'] = $px->Get_Results( $use_utf8_encode );
		$nf['ch_title'] = $px->channel['title'];
		$nf['ch_link'] = $px->channel['link'];
		$nf['ch_desc'] = $px->channel['desc'];
		$nf['img_title'] = isset($px->image['title']) ? $px->image['title']: "";
		$nf['img_uri'] = isset($px->image['url']) ? $px->image['url']: ""; // URI to image/logo
		$nf['img_link'] = isset($px->image['link']) ? $px->image['link'] : "";
	
		// coding charsets
		if (0 == $use_utf8_encode) {
			if($coding_from != '--' && $coding_to != '--') {
				include_once(WB_PATH . '/modules/newsreader/ConvertCharset.class.php');
				$NewEncoding = new ConvertCharset;
				$nf['ch_title'] = $NewEncoding->Convert($nf['ch_title'],$coding_from , $coding_to, 0);
				$nf['ch_desc'] = $NewEncoding->Convert($nf['ch_desc'],$coding_from , $coding_to, 0);
				$nf['content'] = $NewEncoding->Convert($nf['content'],$coding_from , $coding_to, 0);
			}
		}
		
		$nf['own_dateformat'] = $own_dateformat;
		
	} else {

		$nf['content'] = "";
		$nf['ch_title'] = "";
		$nf['ch_link'] = "";
		$nf['ch_desc'] = "";
		$nf['img_title'] = "";
		$nf['img_uri'] = "";
		$nf['img_link'] = "";
		$nf['own_dateformat'] = "";
	}
	// update db
	$nf['last_update'] = time();

	$fields = array(
		'last_update'	=> $nf['last_update'],
		'content'		=> $nf['content'],
		'ch_title'		=> $nf['ch_title'],
		'ch_link'		=> $nf['ch_link'],
		'ch_desc'		=> $nf['ch_desc'],
		'img_title'		=> $nf['img_title'],
		'img_uri'		=> $nf['img_uri'],
		'img_link'		=> $nf['img_link'],
		'use_utf8_encode' => $use_utf8_encode
	);
	
	if (method_exists( $database, "build_and_execute") ) {
		$database->build_and_execute(
			'update',
			TABLE_PREFIX . 'mod_newsreader',
			$fields,
			'section_id = '. $section_id
		);
		
	} else {
		$sqlquery = 'UPDATE `' . TABLE_PREFIX . 'mod_newsreader` SET ';
		if (method_exists( $database, "escapeString") ) {
			foreach($fields as $key => $value) $sqlquery .= "`".$key."`='".$database->escapeString($value)."',";
		} else {
			foreach($fields as $key => $value) $sqlquery .= "`".$key."`='".@mysql_real_escape_string($value)."',";
		} 
		$sqlquery = substr($sqlquery, 0,-1)." WHERE `section_id` = '". $section_id ."'";

		$database->query($sqlquery);
	}	
	return $nf;
}

function readCharsets() {
	
	$dir = WB_PATH . '/modules/newsreader/ConvertTables';
	$arrOptions = array('--');
	if(! is_dir($dir)) {
		return $arrOptions;
	}
	$dir = opendir($dir);
	$arrOptions[] = 'utf-8';
	while($entry = readdir($dir)) {
		#if(! preg_match("/^\.+/", $entry) || ! is_dir($entry)) {
		if (($entry[0] != ".") || !is_dir($entry)) {
			$arrOptions[] = $entry;
		}
	}
	closedir($dir);
	return $arrOptions;
}

function getLanguage() {
	if(isset($_SESSION['LANGUAGE']) AND $_SESSION['LANGUAGE'] != '') {
		if(!defined('LANGUAGE')) {
			define('LANGUAGE', $_SESSION['LANGUAGE']);
		}
		$language = $_SESSION['LANGUAGE'];
    	define('GET_LANGUAGE', true);
    	define('USER_LANGUAGE', true);
    	if (!defined('PAGE_LANGUAGES')) define('PAGE_LANGUAGES', true);
    	return $language;
	}
	$arr = explode(';',$_SERVER["HTTP_ACCEPT_LANGUAGE"]);
	$i = array();
	foreach($arr as $l)	{
       	$i = array_merge($i, explode(',',$l));
       	$i = array_merge($i, explode('-',$l));
       	$i = array_merge($i, explode('.',$l));
       	$i = array_merge($i, explode('=',$l));
       	$i = array_merge($i, explode('_',$l));
	}
	foreach(array_unique($i) as $l)	{
    	if(strlen($l) == 2 && file_exists('./languages/'. strtoupper($l) . '.php')) {
			if(!defined('LANGUAGE')) {
				define('LANGUAGE', strtoupper($l));
			}
			$language = strtoupper($l);
			define('GET_LANGUAGE', true);
			define('USER_LANGUAGE', true);
			if(!defined("PAGE_LANGUAGES"))
			{
			    define('PAGE_LANGUAGES', true);
			}
			break;
       	}
	}
	$arr = '';
	$i = '';
	return $language;
}

?>