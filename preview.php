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

require_once('../../config.php');

if(class_exists("addon\\newsreader\\classes\\newsreaderInit", true))
{
    addon\newsreader\classes\newsreaderInit::getInstance();
}


if(!defined('NEWS_READER_LANGUAGE')) {
	define('NEWS_READER_LANGUAGE', newsreader\newsreader::getInstance()->getLanguage());
}

if(file_exists('./languages/' . NEWS_READER_LANGUAGE . '.php')) {
	include_once('./languages/' . NEWS_READER_LANGUAGE . '.php');
} else {
	include_once('./languages/EN.php');
}

// create and set object newsfeed
// include_once('./newsparser.php');

$px = new newsreader\RSS_feed();
$px->Set_Limit($_REQUEST['MAX_ITEMS']); 
$px->Show_Image($_REQUEST['SHOW_IMAGE']); 
$px->Show_Description($_REQUEST['SHOW_DESCRIPTION']);
$px->Set_URL($_REQUEST['RSS_URI']);

$nf = array();	
$nf['show_image'] = $_REQUEST['SHOW_IMAGE'];
$nf['show_desc'] = $_REQUEST['SHOW_DESCRIPTION'];
$nf['coding_from'] = $_REQUEST['CODE_FROM'];
$nf['coding_to'] = $_REQUEST['CODE_TO'];
$nf['use_utf8_encoding'] = $_REQUEST['USE_UTF8ENCODE'];
$nf['own_dateformat'] = ($_REQUEST['OWN_DATEFORMAT'] ?? "");

// get newsfeed contents
$nf['content'] = $px->Get_Results( $nf['use_utf8_encoding'] );
$nf['ch_title'] = $px->channel['title'];
$nf['ch_link'] = isset($px->channel['link']) ? $px->channel['link'] : "";
$nf['ch_desc'] = $px->channel['desc'];
$nf['img_title'] = $px->image['title'];
$nf['img_uri'] = isset($px->image['url']) ? $px->image['url'] : ""; // URI to image/logo
$nf['img_link'] = isset($px->image['link']) ? $px->image['link'] : "";

if(!isset($_REQUEST['OWN_DATEFORMAT']))
{
    $_REQUEST['OWN_DATEFORMAT'] = "";
}
/**	*************
 *	Date and time
 */
$oCDate = \newsreader\xdate::getInstance();
	
$oCDate->set_wb_lang( LANGUAGE );
	
if($nf['own_dateformat'] != "") {
	$oCDate->format = $nf['own_dateformat'];
} else {
	$oCDate->format = $oCDate->wb_date_formats[ DATE_FORMAT ] ." - ".$oCDate->wb_time_formats[ TIME_FORMAT ];
}
	
$last_update = $oCDate->toHTML( time() + (defined('TIMEZONE') ? TIMEZONE : 0) );

$out = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>WB Newsreader</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="content-language" content="en" />
		<style type="text/css">
			body{
				font-family: Verdana, sans-serif;
				font-size: 13px;
				line-height: 1.4em;
			}
			h1 {
				fontsize: 14px;
			}
			td {
				background-color: #336699;
				color: #FFFFFF;
				padding-left: 10px;
				height: 20px;
			}
			table#configuration tr th,
			table#ressourcen tr th {
				text-align: left;
				padding-left: 10px;
				background-color: #CCCCCC;
			}
			table#configuration tr th:first-child {
				width: 200px;
			}
			table#ressourcen tr th:first-child {
				width: 150px;
			}
			.newsreader {
			}
			.nr_description {
				font-weight: bold;
			}
			.nr_content {
			}
			.nr_content ul {
			}
			.nr_content li {
				margin-bottom: 1em;
				list-style: circle;
			}
			.nr_itemdesc {
			}

			.discreet {
				font-size:90%;
			}
 		</style>
	</head>
	<body>
		<h1>' . $MOD_NEWSREADER_HEAD['CONFIG_DISPL'] . '</h1>
		<br />
		<table width="100%" id="configuration">
			<tr>
				<th>' . $MOD_NEWSREADER_TEXT['Configuration'] . '</th>
				<th>' . $MOD_NEWSREADER_TEXT['Request'] . '</th>
			</tr>
			<tr>
				<td>' . $MOD_NEWSREADER_TEXT['RSS_URI'] . '</td>
				<td>' . $_REQUEST['RSS_URI'] . '</td>
			</tr>
			<tr>
				<td>' . $MOD_NEWSREADER_TEXT['SHOW_IMAGE'] . '</td>
				<td>' . $_REQUEST['SHOW_IMAGE'] . '</td>
			</tr>
			<tr>
				<td>' . $MOD_NEWSREADER_TEXT['SHOW_DESCRIPTION'] . '</td>
				<td>' . $_REQUEST['SHOW_DESCRIPTION'] . '</td>
			</tr>
			<tr>
				<td>' . $MOD_NEWSREADER_TEXT['MAX_ITEMS'] . '</td>
				<td>' . $_REQUEST['MAX_ITEMS'] . '</td>
			</tr>
			<tr>
				<td>' . $MOD_NEWSREADER_TEXT['CODING'] . '</td>
				<td>' . $TEXT['FROM'] . ': ' . $_REQUEST['CODE_FROM'] . ' ' . $TEXT['TO'] . ': ' . $_REQUEST['CODE_TO'] . '</td>
			</tr>
			<tr>
				<td>' . $MOD_NEWSREADER_TEXT['USE_UTF8_ENCODING'] . '</td>
				<td>' . ($nf['use_utf8_encoding'] == 1 ? $TEXT['YES'] : $TEXT['NO']) . '</td>
			</tr>
			<tr>
				<td>' . $MOD_NEWSREADER_TEXT['OWN_DATEFORMAT'] . '</td>
				<td>' . ($_REQUEST['OWN_DATEFORMAT'] != "" ? ($_REQUEST['OWN_DATEFORMAT'] . " (E.g.: " .$last_update. ")") : "" ) .'</td>
			</tr>
		</table>

		<br />

		<table width="100%" id="ressourcen">
			<tr>
				<th>' . $MOD_NEWSREADER_TEXT['Resource'] . '</th>
				<th>' . $MOD_NEWSREADER_TEXT['Value'] . '</th>
				<th>' . $MOD_NEWSREADER_TEXT['Description'] . '</th>
			</tr>
			<tr>
				<td>' . $MOD_NEWSREADER_TEXT['RSS_URI'] . '</td>
				<td>' . $px->URL . '</td>
				<td>' . $MOD_NEWSREADER_MSG['RSS_URI'] . '</td>
			</tr>
			<tr>
				<td>' . $MOD_NEWSREADER_TEXT['Image-URI'] . '</td>
				<td>' . $nf['img_uri'] . '<br />'. (($nf['img_uri'] != "") ? '<img src="' . $nf['img_uri'] . '" alt="logo" />' : '') .'</td>
				<td>' . $MOD_NEWSREADER_DESC['Image-URI'] . '</td>
			</tr>
			<tr>
				<td>' . $MOD_NEWSREADER_TEXT['Image-Title'] . '</td>
				<td>' . $nf['img_title'] . '</td>
				<td>' . $MOD_NEWSREADER_DESC['Image-Title'] . '</td>
			</tr>
			<tr>
				<td>' . $MOD_NEWSREADER_TEXT['Image-Link'] . '</td>
				<td>' . $nf['img_link'] . '</td>
				<td>' . $MOD_NEWSREADER_DESC['Image-Link'] . '</td>
			</tr>
			<tr>
				<td>' . $MOD_NEWSREADER_TEXT['Channel-Title'] . '</td>
				<td>' . $nf['ch_title'] . '</td>
				<td>' . $MOD_NEWSREADER_DESC['Channel-Title'] . '</td>
			</tr>
			<tr>
				<td>' . $MOD_NEWSREADER_TEXT['Channel-Desc'] . '</td>
				<td>' . $nf['ch_desc'] . '</td>
				<td>' . $MOD_NEWSREADER_DESC['Channel-Desc'] . '</td>
			</tr>
			<tr>
				<td>' . $MOD_NEWSREADER_TEXT['Channel-Link'] . '</td>
				<td>' . $nf['ch_link'] . '</td>
				<td>' . $MOD_NEWSREADER_DESC['Channel-Link'] . '</td>
			</tr>
		</table>

		<br />';
		/*
		if($nf['coding_from'] != '--' && $nf['coding_to'] != '--')
		{
			include_once('./ConvertCharset.class.php');
			$NewEncoding = new ConvertCharset;
			$nf['ch_title'] = $NewEncoding->Convert($nf['ch_title'],$nf['coding_from'] , $nf['coding_to'], 0);
			$nf['ch_desc'] = $NewEncoding->Convert($nf['ch_desc'],$nf['coding_from'] , $nf['coding_to'], 0);
			$nf['content'] = $NewEncoding->Convert($nf['content'],$nf['coding_from'] , $nf['coding_to'], 0);
		}
		*/
$out .=	'<b>Output:</b>
			<hr />
			<br />
<div class="newsreader">';
if ($nf['img_link'] != "") {
$out .= '	<a href="' . $nf['img_link'] . '" title="' . $nf['img_title'] . '">
		<img src="' . $nf['img_uri'] . '" alt="logo" title="' . $nf['img_title'] . '" border="0" />
	</a>';
}
$out .='	<h2>' . $nf['ch_title'] . '</h2>
	<div class="nr_description">' . $nf['ch_desc'] . '</div>
	<div class="discreet">' . $MOD_NEWSREADER_TEXT['LAST_UPDATED'] . ': ' . date("Y-m-d H:i:s", time() + (defined('TIMEZONE') ? TIMEZONE : 0)) . '</div>
	<div class="nr_content">' .
		$nf['content'] .
'	</div>
</div>

	</body>
</html>
';

echo $out;
