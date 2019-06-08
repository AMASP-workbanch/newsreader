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


if(defined('WB_URL')) {
	$database->query("DROP TABLE IF EXISTS `".TABLE_PREFIX."mod_newsreader`");
	$sql = 'CREATE TABLE `'.TABLE_PREFIX.'mod_newsreader` ( '
		. ' `section_id` int(11) NOT NULL DEFAULT \'0\','
		. ' `page_id` int(11) NOT NULL DEFAULT \'0\','
		. ' `uri` varchar(255) NOT NULL DEFAULT \'\','
		. ' `show_image` int(1) NOT NULL DEFAULT \'1\','
		. ' `show_desc` int(1) NOT NULL DEFAULT \'1\','
		. ' `show_limit` int(2) NOT NULL DEFAULT \'15\','
		. ' `cycle` int(5) NOT NULL DEFAULT \'0\','
		. ' `last_update` int(14) NOT NULL DEFAULT \'0\','
		. ' `content` text NOT NULL,'
		. ' `ch_title` varchar(255) NOT NULL DEFAULT \'\','
		. ' `ch_link` varchar(255) NOT NULL DEFAULT \'\','
		. ' `ch_desc` varchar(255) NOT NULL DEFAULT \'\','
		. ' `img_title` varchar(255) NOT NULL DEFAULT \'\','
		. ' `img_uri` varchar(255)  NOT NULL DEFAULT \'\','
		. ' `img_link` varchar(255) NOT NULL DEFAULT \'\','
		. ' `coding_from` varchar(100) NOT NULL DEFAULT \'\','
		. ' `coding_to` varchar(100) NOT NULL DEFAULT \'\','
		. ' `use_utf8_encode` int(11) NOT NULL DEFAULT \'0\','
		. ' `own_dateformat` varchar(100) NOT NULL DEFAULT \'\','
		. ' PRIMARY KEY ( `section_id` ) )'
		. ' ';
	$database->query($sql);

	// Insert info into the search table
   // Module query info
   $field_info = array();
   $field_info['page_id'] = 'page_id';
   $field_info['title'] = 'page_title';
   $field_info['link'] = 'link';
   $field_info['description'] = 'description';
   $field_info['modified_when'] = 'modified_when';
   $field_info['modified_by'] = 'modified_by';
   $field_info = serialize($field_info);
   $database->query("INSERT INTO ".TABLE_PREFIX."search (name,value,extra) VALUES ('module', 'newsreader', '$field_info')");
   // Query start
   $query_start_code = "SELECT [TP]pages.page_id, [TP]pages.page_title, [TP]pages.link, [TP]pages.description, [TP]pages.modified_when, [TP]pages.modified_by FROM [TP]mod_newsreader, [TP]pages WHERE ";
   $database->query("INSERT INTO ".TABLE_PREFIX."search (name,value,extra) VALUES ('query_start', '$query_start_code', 'newsreader')");
   // Query body
   $query_body_code = " [TP]pages.page_id = [TP]mod_newsreader.page_id AND [TP]mod_newsreader.content [O] \'[W][STRING][W]\' AND [TP]pages.searching = \'1\'";
   $database->query("INSERT INTO ".TABLE_PREFIX."search (name,value,extra) VALUES ('query_body', '$query_body_code', 'newsreader')");
   // Query end
   $query_end_code = "";
   $database->query("INSERT INTO ".TABLE_PREFIX."search (name,value,extra) VALUES ('query_end', '$query_end_code', 'newsreader')");
}

?>