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
 
class queries extends \newsreader\abstracts\addon
{
    
    public static $instance;
    
    /**
     *  initialize the instance of this class.
     *
     */
    public function initialize()
    {

    }
    
    static public function insert( $sTableName = NULL, $aFields = array() )
    {
        $database = \database::getInstance();
        
        $sqlquery = "INSERT INTO `" . $sTableName. "` (`";
        $sqlquery .= implode("`,`", array_keys($aFields))."`) VALUES(";
	
        if (method_exists( $database, "escapeString") )
        {
	        foreach($aFields as $key => $value)
	        {
	            $sqlquery .= "'".$database->escapeString($value)."',";
	        }
	    } else {
            foreach($aFields as $key => $value)
            {
                $sqlquery .= "'". \mysqli::real_escape_string($value)."',";
            }
	    } 
	    
	    $sqlquery = substr($sqlquery, 0,-1).")";

	    $database->query($sqlquery);
        
        return $database->is_error();
    }
    
    static public function update( $sTableName = NULL, $aFields = array(), $sCondition="" )
    {
        $database = \database::getInstance();
        
        $query = "UPDATE `" . $sTableName . "` SET ";

	    if (method_exists( $database, "escapeString") )
	    {
		    foreach($aFields as $key =>&$value)
		    {
		        $query .= "`" . $key . "`='".$database->escapeString($value)."', ";
		    }
        } else {
            foreach($aFields as $key => $value)
            {
                $sqlquery .= "`" . $key . "`='".\mysqli::real_escape_string($value)."', ";
            }
        }
	
	    $query = substr($query, 0, -2);
	    if(strlen($sCondition) > 0)
	    {
	        $query .= " WHERE ". $sCondition; // `section_id`=".$section_id;	# Keep in Mind that the $section_id comes from admin-wrapper script!	
        }

	    $database->query( $query );
        
        return $database->is_error();
    }
    
    static public function select( $sTableName = "", $aFields=array(), $sCondition="", $bFetchAll=false )
    {
        $database = \database::getInstance();
        
        $sQuery = "SELECT `". implode("`,`", $aFields)."` FROM `".$sTableName."`"; 
        if(strlen($sCondition) > 0)
        {
            $sQuery .= " WHERE ".$sCondition;
		
        }
        $oResult = $database->query( $sQuery );
        
        if($database->is_error())
        {
            return NULL;
        }
        
        if($oResult->numRows() === 0)
        {
            return [];
        }
        
        if(true === $bFetchAll)
        {
            return $oResult->fetchAll( MYSQLI_ASSOC );
        
        } else {
        
            return $oResult->fetchRow( MYSQLI_ASSOC );
        }
    }
}