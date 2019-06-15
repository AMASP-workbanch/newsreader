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

if(!defined('WB_PATH')) { exit("Cannot access this file directly"); }

if(class_exists("addon\\newsreader\\classes\\newsreaderInit", true))
{
    addon\newsreader\classes\newsreaderInit::getInstance();
}

newsreader\system\queries::delete(
    TABLE_PREFIX."search",
    [   "name"    => "module", "value"   => "newsreader" ]
);

newsreader\system\queries::delete(
    TABLE_PREFIX."search",
    [   "extra"    => "newsreader" ]
);

newsreader\system\queries::drop( TABLE_PREFIX."mod_newsreader" );
