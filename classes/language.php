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

namespace newsreader;

if(defined(LANGUAGE) && file_exists(__DIR__."/languages/".LANGUAGE.".php"))
{
    eval ("class language extends \\languages\\".LANGUAGE." { } ");
    
} else {
    
    class language extends languages\EN
    {
    
    }
}