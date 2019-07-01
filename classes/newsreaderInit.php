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

namespace addon\newsreader\classes;
 
class newsreaderInit
{
    static $instance    = NULL;
    
    public $version     = NULL;
    public $platform    = NULL;
     
    public static function getInstance()
    {
        if (NULL === static::$instance)
        {
            static::$instance = new static();
            static::$instance->initialize();
        }
        return static::$instance;
    }
    
    private function initialize()
    {
        if(class_exists("\\bin\\CoreAutoloader", true))
        {
            \bin\CoreAutoloader::addNamespace([
                "newsreader"  => "modules/newsreader/classes/"
            ]);
        }
        
        require dirname(__dir__)."/info.php";
        $this->version = $module_version;
        $this->platform = $module_platform;
        
        return true;
    }
}