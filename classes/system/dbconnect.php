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
 
class dbconnect extends \newsreader\abstracts\addon
{
    
    public static $instance;
    
    public $db_instance = NULL;
    
    /**
     *  initialize the instance of this class.
     *
     */
    public function initialize()
    {
        if(true === class_exists("\\database", true))
        {
            if(true === method_exists("\\database", "getInstance"))
            {
                $this->db_instance = \database::getInstance();
            
            } else {
                global $database;
                $this->db_instance = &$database;
            }
        
        } else {
            $this->db_instance = LEPTON_database::getInstance();
        }
    }
    
    public function getConnector()
    {
        return $this->db_instance;
    }
    
}