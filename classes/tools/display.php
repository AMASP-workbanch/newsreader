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
 
namespace newsreader\tools;
 
class display
{
    static function dump( $aAny = NULL, $sTag = "pre", $sCSSClassname = NULL )
    {
        $sReturnValue = "<".$sTag.($sCSSClassname != NULL ? " class='".$sCSSClassname."'" : "").">\n";
        
        ob_start();
            print_r( $aAny );
            $sReturnValue .= ob_get_clean();
            
        $sReturnValue .= "</".$sTag.">\n";
        
        return $sReturnValue;
    }
}
