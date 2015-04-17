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

include_once(WB_PATH . '/modules/newsreader/functions.php');
if(!defined('LANGUAGE')) {
	getLanguage();
}

////////////////////////////////////////////////////////////////////////
// don't change anything below until you're knowing what you're doing //
////////////////////////////////////////////////////////////////////////

$sqlquery = "SELECT uri, cycle, show_image, show_desc, show_limit, last_update, content,
						  ch_title, ch_link, ch_desc, img_title, img_uri, img_link,
						  coding_from, coding_to
				 FROM ".TABLE_PREFIX."mod_newsreader WHERE section_id = '$section_id'";
$sqlresult = $database->query($sqlquery);
$sqlrow = $sqlresult->fetchRow( MYSQL_ASSOC );

$last_update = $sqlrow['last_update'] + $sqlrow['cycle'];
if (!defined('DATETIME')) define('DATETIME', DATE_FORMAT . ' ' . TIME_FORMAT);

if($sqlrow['last_update'] == 0 || strlen($sqlrow['content']) == 0) {
	output(update($sqlrow['uri'], $section_id, $sqlrow['show_image'], $sqlrow['show_desc'], $sqlrow['show_limit'], $sqlrow['coding_from'], $sqlrow['coding_to']));
} elseif($last_update < time()) {
	output(update($sqlrow['uri'], $section_id, $sqlrow['show_image'], $sqlrow['show_desc'], $sqlrow['show_limit'], $sqlrow['coding_from'], $sqlrow['coding_to']));
} else {
	output(array(
		'ch_title' 		=> $sqlrow['ch_title'],
		'ch_link' 		=> $sqlrow['ch_link'],
		'ch_desc' 		=> $sqlrow['ch_desc'],
		'img_title' 	=> $sqlrow['img_title'],
		'img_uri' 		=> $sqlrow['img_uri'],
		'img_link'	 	=> $sqlrow['img_link'],
		'content' 		=> $sqlrow['content'],
		'last_update' 	=> $sqlrow['last_update']
	));
}

?>