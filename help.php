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

if(file_exists('./languages/' . $_REQUEST['lang'] . '.php')) {
	include('./languages/' . $_REQUEST['lang'] . '.php');
} else {
	include('./languages/EN.php');
}

// output
$out = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>WB Newsreader help</title>
		<style type="text/css">
			table {
				font-family: Verdana, sans-serif;
				font-size: 12px;
				line-height: 1.3 em;
				width: 100%;
			}
			.colone {
				font-weight: bold;
				background-color: #009900;
				color: #FFFFFF;
				width: 200px;
				padding-left: 10px;
				height: 24px;
			}
			.coltwo {
				background-color: #DDDDDD;
				color: #000000;
				padding-left: 10px;
				height: 24px;
			}
		</style>
	</head>
';
echo $out;


$out = '
<body>
	<table>
		<tr>
			<td class="colone">' .$MOD_NEWSREADER_TEXT['RSS_URI']. '</td>
			<td class="coltwo">' .$MOD_NEWSREADER_MSG['RSS_URI']. '</td>
		</tr>
		<tr>
			<td class="colone">' .$MOD_NEWSREADER_TEXT['CYCLE']. '</td>
			<td class="coltwo">' .$MOD_NEWSREADER_MSG['CYCLE']. '</td>
		</tr>
		<tr>
			<td class="colone">' .$MOD_NEWSREADER_TEXT['LAST_UPDATED']. '</td>
			<td class="coltwo">' .$MOD_NEWSREADER_MSG['LAST_UPDATED']. '</td>
		</tr>
		<tr>
			<td class="colone">' .$MOD_NEWSREADER_TEXT['OWN_DATEFORMAT']. '</td>
			<td class="coltwo">' .$MOD_NEWSREADER_MSG['OWN_DATEFORMAT']. '</td>
		</tr>
		<tr>
			<td class="colone">' .$MOD_NEWSREADER_TEXT['SHOW_IMAGE']. '</td>
			<td class="coltwo">' .$MOD_NEWSREADER_MSG['SHOW_IMAGE']. '</td>
		</tr>
		<tr>
			<td class="colone">' .$MOD_NEWSREADER_TEXT['SHOW_DESCRIPTION']. '</td>
			<td class="coltwo">' .$MOD_NEWSREADER_MSG['SHOW_DESCRIPTION']. '</td>
		</tr>
		<tr>
			<td class="colone">' .$MOD_NEWSREADER_TEXT['MAX_ITEMS']. '</td>
			<td class="coltwo">' .$MOD_NEWSREADER_MSG['MAX_ITEMS']. '</td>
		</tr>
		<tr>
			<td class="colone">' .$MOD_NEWSREADER_TEXT['CODING']. '</td>
			<td class="coltwo">' .$MOD_NEWSREADER_MSG['CODING']. '</td>
		</tr>
		<tr>
			<td class="colone">' .$MOD_NEWSREADER_TEXT['USE_UTF8_ENCODING']. '</td>
			<td class="coltwo">' .$MOD_NEWSREADER_MSG['USE_UTF8_ENCODING']. '</td>
		</tr>
	</table>
</body>
</html>
';

echo $out;

?>