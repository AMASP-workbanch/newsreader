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
 
namespace newsreader\system;
 
class preload
{

    protected $basepath = "";
    
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
            static::$instance->basepath = dirname(dirname(dirname(__DIR__)));
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
        
        $sCMSBasePath = static::$instance->basepath;
        
        if($terms[0] === "addons")
        {
            array_shift($terms);
        }
        if($terms[0] === "newsreader")
        {
            $sCMSBasePath .= "/newsreader/classes/";
            
            array_shift($terms);
            
            $sSubPath = implode( DIRECTORY_SEPARATOR, $terms ).".php";
            
            //  1.1
            $sLookUpFileName = $sCMSBasePath.$sSubPath;
            
            // echo "<p>".$sLookUpFileName."<p>";
            if(file_exists( $sLookUpFileName ))
            {
                require $sLookUpFileName;
            } else {
                //  1.2
                $sLookUpFileName = dirname(dirname(__DIR__))."/classes/".$sSubPath;
                
                echo "<p>[1]".$sLookUpFileName."<p>";
                if(file_exists( $sLookUpFileName ))
                {
                    require $sLookUpFileName;
                }
            }
        }       
    }
}