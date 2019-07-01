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
 
class core extends \newsreader\abstracts\addon
{
    const WB_MIN        = "2.12.1";
    const WBCE_MIN      = "1.3.3";
    const LEPTON_MIN    = "4.3.0";

    const IS_UNKNOWN = NULL;

    const IS_WB     = 0x0001;
    const IS_WBCE   = 0x0002;
    const IS_LEPTON = 0x0004;

    public $system = self::IS_UNKNOWN;

    static $instance = NULL;

    public function initialize()
    {
        switch( true )
        {
            case( defined("LEPTON_GUID") ):
                $this->system = self::IS_LEPTON;
                break;
            
            case( defined("WBCE_VERSION") ):
                $this->system = self::IS_WBCE;
                break;
            
            case( defined("WB_PATH") ):
                $this->system = self::IS_WB;
                break;
        }
    }

    public static function getPlatformVersion()
    {
        if( NULL === static::$instance )
        {
            self::getInstance();
        }
    
        switch( true )
        {
            case(static::$instance->system === self::IS_LEPTON):
                return self::LEPTON_MIN;
                break;
            
            case(static::$instance->system === self::IS_WBCE):
                return self::WBCE_MIN;
                break;
            
            case(static::$instance->system === self::IS_WB):
                return self::WB_MIN;
                break;
            
            default:
                return self::IS_UNKNOWN;
        }
    }
    
    public static function isWB()
    {
        if(NULL === static::$instance)
        {
            self::getInstance();
        }    
        return (static::$instance->system === self::IS_WB);
    }
    
    public static function isWBCE()
    {
        if(NULL === static::$instance)
        {
            self::getInstance();
        }
        return (static::$instance->system === self::IS_WBCE);
    }
    
    public static function isLEPTON()
    {
        if(NULL === static::$instance)
        {
            self::getInstance();
        }
        return (static::$instance->system === self::IS_LEPTON);
    }
}