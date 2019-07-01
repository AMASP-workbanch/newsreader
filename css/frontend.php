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
 
// 1.0
require dirname(dirname(dirname(__DIR__)))."/config.php";

// 2.0
$sTemplate = DEFAULT_TEMPLATE;
if(isset($_SESSION['PAGE_ID']))
{
    // 2.1
    $aPageValues = newsreader\system\queries::select(
        TABLE_PREFIX."pages",
        ["template"],
        "page_id=".$_SESSION['PAGE_ID'],
        false
    );
    
    // 2.2
    if(isset($aPageValues['template']) && ($aPageValues['template'] != "") )
    {
        $sTemplate = $aPageValues['template'];
    }
}

// 3.0
$sPath = WB_PATH."/templates/".$sTemplate."/frontend/newsreader/frontend.css";

$sCSSSource = file_get_contents( 
    (file_exists($sPath))
    ? $sPath
    : __DIR__."/frontend.css"
);

// 4.0
header('Content-Type: text/css');
echo  $sCSSSource;
