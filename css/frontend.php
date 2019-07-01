<?php

// 1
require dirname(dirname(dirname(__DIR__)))."/config.php";

// 1.1
$sTemplate = DEFAULT_TEMPLATE;
$sPath = WB_PATH."/templates/".$sTemplate."/frontend/newsreader/frontend.css";

$sCSSSource = file_get_contents( 
    (file_exists($sPath))
    ? $sPath
    : __DIR__."/frontend.css"
);

// 2
header('Content-Type: text/css');
echo  $sCSSSource;
