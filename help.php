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

// i18n
$TEXT['RSS_URI'] = 'RSS-URI';
$TEXT['CYCLE'] = 'Update-Cycle';
$TEXT['LAST_UPDATED'] = 'last updated';
$TEXT['SHOW_IMAGE'] = 'show Logo';
$TEXT['SHOW_DESCRIPTION'] = 'show Description';
$TEXT['MAX_ITEMS'] = 'max. Items';
$TEXT['CODING'] = 'Coding';
$TEXT['FROM'] = 'from';
$TEXT['TO'] = 'to';

$MSG['RSS_URI'] = 'Weblink to the Newsfeed. Example: http://www.heise.de/newsticker/heise.rdf';
$MSG['CYCLE'] = 'Actualization interval in seconds. Should not be smaller than 14400 Sec. (4 hours).';
$MSG['LAST_UPDATED'] = 'Last actualization time of the Newsfeed.';
$MSG['SHOW_IMAGE'] = 'If enabled, the Newsfeed logo will be displayed (if defined in the newsfeed).';
$MSG['SHOW_DESCRIPTION'] = 'If enabled, the description of each news-item will be displayed (if included in the newsfeed)';
$MSG['MAX_ITEMS'] = 'maximum numbers of news items to display. Normaly, newsfeeds have no more than 15 items.';
$MSG['CODING'] = 'Coding of a Newsfeed. Sample: If the Newsfeed is UTF-8 coded and your Website is running with ISO-8859-1, please choose "from" utf-8 and "to" iso-8859-1.';

if(file_exists('./i18n/' . $_REQUEST['lang'] . '.php')) {
	include('./i18n/' . $_REQUEST['lang'] . '.php');
} elseif(file_exists('./i18n/EN.php')) {
	include('./i18n/EN.php');
}

// output
$out = '
<html>
	<head>
		<title>WB Newsreader Info</title>
		<style type="text/css">
			#colone {
				font-weight: bold;
				background-color: #336699;
				color: #FFFFFF;
			}
			#coltwo {
				background-color: #336699;
				color: #FFFFFF;
			}
		</style>
	</head>
';
echo $out;


$out = '
<body>
	<table width=100%>
		<tr>
			<td id="colone">' .$TEXT['RSS_URI']. '</td>
			<td id="coltwo">' .$MSG['RSS_URI']. '</td>
		</tr>
		<tr>
			<td id="colone">' .$TEXT['CYCLE']. '</td>
			<td id="coltwo">' .$MSG['CYCLE']. '</td>
		</tr>
		<tr>
			<td id="colone">' .$TEXT['LAST_UPDATED']. '</td>
			<td id="coltwo">' .$MSG['LAST_UPDATED']. '</td>
		</tr>
		<tr>
			<td id="colone">' .$TEXT['SHOW_IMAGE']. '</td>
			<td id="coltwo">' .$MSG['SHOW_IMAGE']. '</td>
		</tr>
		<tr>
			<td id="colone">' .$TEXT['SHOW_DESCRIPTION']. '</td>
			<td id="coltwo">' .$MSG['SHOW_DESCRIPTION']. '</td>
		</tr>
		<tr>
			<td id="colone">' .$TEXT['MAX_ITEMS']. '</td>
			<td id="coltwo">' .$MSG['MAX_ITEMS']. '</td>
		</tr>
		<tr>
			<td id="colone">' .$TEXT['CODING']. '</td>
			<td id="coltwo">' .$MSG['CODING']. '</td>
		</tr>
	</table>
</body>
</html>
';

echo $out;

?>