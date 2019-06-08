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

include_once(WB_PATH . '/modules/newsreader/functions.php');
if(!defined('LANGUAGE')) {
	getLanguage();
}

////////////////////////////////////////////////////////////////////////
// don't change anything below until you're knowing what you're doing //
////////////////////////////////////////////////////////////////////////

$sqlquery = "SELECT uri, cycle, show_image, show_desc, show_limit, last_update, content,
			ch_title, ch_link, ch_desc, img_title, img_uri, img_link,
			coding_from, coding_to, use_utf8_encode, own_dateformat
			FROM ".TABLE_PREFIX."mod_newsreader WHERE section_id = '$section_id'";

$sqlresult = $database->query($sqlquery);
$sqlrow = $sqlresult->fetchRow();

$last_update = $sqlrow['last_update'] + $sqlrow['cycle'];
if (!defined('DATETIME')) define('DATETIME', DATE_FORMAT . ' ' . TIME_FORMAT);

if( ( ( $sqlrow['last_update'] == 0 || strlen($sqlrow['content']) == 0) ) || $last_update < time() ) {
	output(
		update(
			$sqlrow['uri'],
			$section_id,
			$sqlrow['show_image'],
			$sqlrow['show_desc'],
			$sqlrow['show_limit'],
			$sqlrow['coding_from'],
			$sqlrow['coding_to'],
			$sqlrow['use_utf8_encode'],
			$sqlrow['own_dateformat']
	));
}
else {
	output( $sqlrow );
}

?>