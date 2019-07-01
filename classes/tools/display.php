<?php

/**
 *  Tools for development
 *  @category   LEPTON cross development
 *  @package    newsreader
 *
 */

namespace newsreader\tools;

/**
 *
 * @category        page
 * @package         newsreader
 * @author          Robert Hase, Matthias Gallas, Dietrich Roland Pehlke (last)
 * @license         http://www.gnu.org/licenses/gpl.html
 * @requirements    PHP 7.1 and higher
 * @version         0.4.0
 * @lastmodified    Jul 2019 
 *
 */
 
class display
{
    /**
     *  Generates a var-dump for a given variable/object.  
     *
     *  @param  object  $aAny           Any valid (listable) kind ov var to display(dump).  
     *  @param  string  $sTag           An optional tag type, e.g. pre, div, dd/dl. Default is 're'.  
     *  @param  string  $sCSSClassname  An optional css-class name/identifier. Default is '' (empty string === 'none').  
     *  @return string  The generated (html) source.  
     *
     *  @code{.php}
     *      // examples:
     *      echo newsreader\tools\display::dump( $oObject );
     *      echo newsreader\tools\display::dump( $oObject, "div" );
     *      echo newsreader\tools\display::dump( $oObject, "div", "ui message green" );
     *
     *  @endcode
     */
    static function dump( $aAny = NULL, $sTag = "pre", $sCSSClassname = NULL ) : string
    {
        $sReturnValue = "<".$sTag.($sCSSClassname != NULL ? " class='".$sCSSClassname."'" : "").">\n";
        
        ob_start();
            print_r( $aAny );
            $sReturnValue .= ob_get_clean();
            
        $sReturnValue .= "</".$sTag.">\n";
        
        return $sReturnValue;
    }
}
