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
 
namespace newsreader\system;

if(!class_exists("newsreader\\system\\preload"))
{
    class preload
    {        
        protected $aBasePaths = [];
        
        public static $instance;
    
        /**
         *  initialize the instance of this class.
         *
         */
        public static function initialize()
        {
            if (null === static::$instance)
            {
                static::$instance = new static();
                
                $sPath = dirname(dirname(__DIR__));
                static::$instance->aBasePaths = [
                    dirname($sPath)."/newsreader/classes/",
                    $sPath."/classes/",
                    dirname(dirname($sPath))."/modules/newsreader/classes/"
                ];
                
                static::$instance->register();
            }
        }
    
        /**
         * Registers autoloader as an SPL autoloader.
         *
         * @param bool $prepend Whether to prepend the autoloader or not.
         */
        protected function register($prepend = true)
        {
            spl_autoload_register(array(__CLASS__, 'NewsreaderAutoloader'), true, $prepend);
        }

        /**
         *	NewsreaderAutoloader autoloader for WBCE
         *
         *
         */
        protected function NewsreaderAutoloader( $aClassName ) {
            $terms = explode("\\", $aClassName);

            if($terms[0] === "addons")
            {
                array_shift($terms);
            }
            if($terms[0] === "newsreader")
            {
                array_shift($terms);
            
                $sSubPath = implode( DIRECTORY_SEPARATOR, $terms ).".php";
            
                foreach( static::$instance->aBasePaths as &$sTempPath )
                {
                    $sLookUpFileName = $sTempPath.$sSubPath;
                    if(file_exists( $sLookUpFileName ))
                    {
                        require $sLookUpFileName;
                        break;
                    }
                }
            }       
        }
    }
}