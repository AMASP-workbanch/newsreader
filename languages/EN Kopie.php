<?php

/**
 *
 * @category        page
 * @package         newsreader
 * @author          Robert Hase, Matthias Gallas, Dietrich Roland Pehlke (last)
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WBCE 1.4.x, WebsiteBaker 2.12.x
 * @requirements    PHP 7.1 and higher
 * @version         0.4.0
 * @lastmodified    Jul 2019 
 *
 */

$MOD_NEWSREADER_TEXT = array(
	'RSS_URI'	=> 'RSS-URI',
	'CYCLE'	=> 'Update-Cycle',
	'LAST_UPDATED'	=> 'last updated',
	'SHOW_IMAGE'	=> 'show Logo',
	'SHOW_DESCRIPTION'	=> 'show Description',
	'MAX_ITEMS'	=> 'max, Items',
	'CODING'	=> 'Coding',
	'USE_UTF8_ENCODING'	=> "Use UTF-8 encoding",
	'Configuration'	=> 'Configuration',
	'Request'	=> 'Request',
	'Resource'	=> 'Resource',
	'Value'	=> 'Value',
	'Description'	=> 'Description',
	'Image-URI'	=> 'Image-URI',
	'Image-Title'	=> 'Image-Title',
	'Image-Link'	=> 'Image-Link',
	'Channel-Title'	=> 'Channel-Title',
	'Channel-Desc'	=> 'Channel-Description',
	'Channel-Link'	=> 'Channel-Link',
	'PREVIEW'	=> 'Preview',
	'OWN_DATEFORMAT'	=> 'Own Dateformat',
	'RECORDS UNTOUCHED' => 'RSS specific records untouched!'
);

$MOD_NEWSREADER_MSG	= array(
	'RSS_URI'	=> 'Weblink to the Newsfeed. Example: https://www.heise.de/newsticker/heise.rdf',
	'CYCLE'	=> 'Actualization interval in seconds. Should not be smaller than 14400 Sec. (4 hours).',
	'LAST_UPDATED'	=> 'Last actualization time of the Newsfeed.',
	'SHOW_IMAGE'	=> 'If enabled, the Newsfeed logo will be displayed (if defined in the newsfeed).',
	'SHOW_DESCRIPTION'	=> 'If enabled, the description of each news-item will be displayed (if included in the newsfeed)',
	'MAX_ITEMS'	=> 'maximum numbers of news items to display. Normaly, newsfeeds have no more than 15 items.',
	'CODING'	=> 'Coding of a Newsfeed. Sample: If the Newsfeed is UTF-8 coded and your Website is running with ISO-8859-1, please choose "from" utf-8 and "to" iso-8859-1.',
	'USE_UTF8_ENCODING'	=> 'Optional use of utf-8 encoding - if the feed gives an error like "missformed".',
	'OWN_DATEFORMAT'	=> 'Optonal use of own format for the date-time string. E.g. %A - %e. %B %Y - %H:%M <br />Details: <a href="http://php.net/manual/en/function.strftime.php" target="_new">http://php.net/manual/en/function.strftime.php</a>.'
);

$MOD_NEWSREADER_HEAD = array(
	'CONFIG_DISPL'	=> 'Output of the <u>saved</u> Configuration'
); 

$MOD_NEWSREADER_DESC = array(
	'Image-URI'	=> 'URI to the newsfeed image/logo',
	'Image-Title'	=> 'Title of the newsfeed image/logo',
	'Image-Link'	=> 'Link of the newsfeed image/logo. Mostly the URL of the newsfeed website',
	'Channel-Title'	=> 'Title of the newsfeed',
	'Channel-Desc'	=> 'Description of the newsfeed',
	'Channel-Link'	=> 'Link of the newsfeed title. Mostly the URL of the newsfeed website'
);

?>