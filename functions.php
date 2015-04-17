<?php

/*

 Website Baker Project <http://www.websitebaker.org/>
 Copyright (C) 2004-2007, Ryan Djurovich

 Website Baker is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 Website Baker is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Website Baker; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

function output($nf) {
	// view.php
	/*
	DESCRIPTION:
	ch_title		= title of the newsfeed
	ch_link		= link to somewhere (normally the website of the newsfeed)
	ch_desc		= description of the newsfeed
	img_title	= title of the newsfeed image/logo
	img_uri 		= URI to image/logo
	img_link		= link to somewhere (normally the website of the newsfeed)
	last_update	= last db update of this newsfeed (UNIX time)
	show_image	= show newsfeed image/logo (0|1)
	show_desc	= show newsfeed item description (0|1)
	*/

	// i18n
	$TEXT['LAST_UPDATED'] = 'last updated';
	if(file_exists(WB_PATH . '/modules/newsreader/i18n/' . LANGUAGE . '.php')) {
		include(WB_PATH . '/modules/newsreader/i18n/' . LANGUAGE . '.php');
	} elseif(file_exists(WB_PATH . '/modules/newsreader/i18n/EN.php')) {
		include(WB_PATH . '/modules/newsreader/i18n/EN.php');
	}

	$out = '
	<div class="newsreader">
	<a href="' . $nf['img_link'] . '" alt="' . $nf['img_title'] . '" title="' . $nf['img_title'] . '" target="_blank"><img src="' . $nf['img_uri'] . '" alt="' . $nf['img_title'] . '" title="' . $nf['img_title'] . '" border="0" /></a>
	<h2>' . $nf['ch_title'] . '</h2>
	<div class="nr_description">' . $nf['ch_desc'] . '</div>
	<div class="discreet">' . $TEXT['LAST_UPDATED'] . ': ' . date(DATETIME, $nf['last_update']) . '</div>
	<div class="nr_content">' .	$nf['content'] .'</div>
	</div>';
	echo $out . "\n";
}

function update($uri, $section_id, $show_image, $show_desc, $show_limit, $coding_from, $coding_to) {
	// view.php
	include(WB_PATH . '/modules/newsreader/newsparser.php');
	$nf = array();

	// create and set object newsfeed
	$px = new RSS_feed();
	$px->Set_Limit($show_limit); 
	$px->Show_Image($show_image); 
	$px->Show_Description($show_desc);
	$px->Set_URL($uri);
	
	$nf['show_image'] = $show_image;
	$nf['show_desc'] = $show_desc;
	
	// get newsfeed contents
	$nf['content'] = $px->Get_Results();
	$nf['ch_title'] = $px->channel['title'];
	$nf['ch_link'] = $px->channel['link'];
	$nf['ch_desc'] = $px->channel['desc'];
	$nf['img_title'] = isset($px->image['title']) ? $px->image['title']: "";
	$nf['img_uri'] = isset($px->image['url']) ? $px->image['url']: ""; // URI to image/logo
	$nf['img_link'] = isset($px->image['link']) ? $px->image['link'] : "";
	
	// coding charsets
	if($coding_from != '--' && $coding_to != '--') {
		include_once(WB_PATH . '/modules/newsreader/ConvertCharset.class.php');
		$NewEncoding = new ConvertCharset;
		$nf['ch_title'] = $NewEncoding->Convert($nf['ch_title'],$coding_from , $coding_to, 0);
		$nf['ch_desc'] = $NewEncoding->Convert($nf['ch_desc'],$coding_from , $coding_to, 0);
		$nf['content'] = $NewEncoding->Convert($nf['content'],$coding_from , $coding_to, 0);
	}
	
	// update db
	$nf['last_update'] = time();
	$sqlquery = 'UPDATE ' . TABLE_PREFIX . 'mod_newsreader
					 SET last_update = "' . $nf['last_update'] . '", content = "' . mysql_real_escape_string($nf['content']) . '",
					 ch_title = "' . mysql_real_escape_string($nf['ch_title']) . '", ch_link = "' . mysql_real_escape_string($nf['ch_link']) . '",
					 ch_desc = "' . mysql_real_escape_string($nf['ch_desc']) . '",
					 img_title = "' . mysql_real_escape_string($nf['img_title']) . '", img_uri = "' . mysql_real_escape_string($nf['img_uri']) . '",
					 img_link = "' . mysql_real_escape_string($nf['img_link']) . '"
					 WHERE section_id = "' . $section_id . '"';
	mysql_query($sqlquery);
	return $nf;
}

function readCharsets() {
	// modify.php
	$dir = WB_PATH . '/modules/newsreader/ConvertTables';
	$arrOptions = array('--');
	if(! is_dir($dir)) {
		return $arrOptions;
	}
	$dir = opendir($dir);
	$arrOptions[1] = 'utf-8';
	$entry = readdir($dir);
	$i = 2;
	while($entry) {
		if(! preg_match("/^\.+/", $entry) || ! is_dir($entry)) {
			$arrOptions[$i++] = $entry;
		}
		$entry = readdir($dir);
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
    	define('PAGE_LANGUAGES', true);
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
    	if(strlen($l) == 2 && file_exists('./i18n/'. strtoupper($l) . '.php')) {
			if(!defined('LANGUAGE')) {
				define('LANGUAGE', strtoupper($l));
			}
			$language = strtoupper($l);
			define('GET_LANGUAGE', true);
			define('USER_LANGUAGE', true);
			define('PAGE_LANGUAGES', true);
			break;
       	}
	}
	$arr = '';
	$i = '';
	return $language;
}

?>