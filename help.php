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

require_once('../../config.php');

if(class_exists("addon\\newsreader\\classes\\newsreaderInit", true))
{
    addon\newsreader\classes\newsreaderInit::getInstance();
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
				background-color: #968922bd;
				color: #FFFFFF;
				width: 200px;
				padding-left: 10px;
				height: 24px;
			}
			.coltwo {
				background-color: #EEEEEE;
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
			<td class="colone">' .newsreader\language::RSS_URI. '</td>
			<td class="coltwo">' .newsreader\language::MSG_RSS_URI. '</td>
		</tr>
		<tr>
			<td class="colone">' .newsreader\language::CYCLE. '</td>
			<td class="coltwo">' .newsreader\language::MSG_CYCLE. '</td>
		</tr>
		<tr>
			<td class="colone">' .newsreader\language::LAST_UPDATED. '</td>
			<td class="coltwo">' .newsreader\language::MSG_LAST_UPDATED. '</td>
		</tr>
		<tr>
			<td class="colone">' .newsreader\language::OWN_DATEFORMAT. '</td>
			<td class="coltwo">' .newsreader\language::MSG_OWN_DATEFORMAT. '</td>
		</tr>
		<tr>
			<td class="colone">' .newsreader\language::SHOW_IMAGE. '</td>
			<td class="coltwo">' .newsreader\language::MSG_SHOW_IMAGE. '</td>
		</tr>
		<tr>
			<td class="colone">' .newsreader\language::SHOW_DESCRIPTION. '</td>
			<td class="coltwo">' .newsreader\language::MSG_SHOW_DESCRIPTION. '</td>
		</tr>
		<tr>
			<td class="colone">' .newsreader\language::MAX_ITEMS. '</td>
			<td class="coltwo">' .newsreader\language::MSG_MAX_ITEMS. '</td>
		</tr>
		<tr>
			<td class="colone">' .newsreader\language::CODING. '</td>
			<td class="coltwo">' .newsreader\language::MSG_CODING. '</td>
		</tr>
		<tr>
			<td class="colone">' .newsreader\language::USE_UTF8_ENCODING. '</td>
			<td class="coltwo">' .newsreader\language::MSG_USE_UTF8_ENCODING. '</td>
		</tr>
	</table>
</body>
</html>
';

echo $out;

?>