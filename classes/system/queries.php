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
        $database = dbconnect::getInstance()->getConnector(); // \database::getInstance();
        
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
        $database = dbconnect::getInstance()->getConnector(); // \database::getInstance();
        
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
    
    /**
     *  ::Select
     *
     *  @param string   $sTableName A valid table-name (incl. TABLE_PREFIX).
     *  @param mixed    $aFields    Could be an string, an array, a full query ...
     *  @param string   $sCondition An optional condition (string) without (first) "WHERE".
     *  @param boolean  $bFetchAll  Flag to return all results in a nested list or a single one.
     *
     *  @returns array  The results as an (assoc.) array - or NULL if failed.
     * 
     */
    static public function select( $sTableName = "", $aFields=array(), $sCondition="", $bFetchAll=true )
    {
        $database = dbconnect::getInstance()->getConnector(); // \database::getInstance();
        
        // 1
        // 1.1
        $sSelectionTerm = "*";
        
        switch(true)
        {
            case (is_string($aFields)):
                $aFields = trim($aFields);
            
                if( ($aFields === "*") || ( $aFields === "" ) )
                {
                    $sSelectionTerm = "*";
                }
                else
                {
                    // hm ... could be "name id parameter street postalcode"
                    // comma separated e.g. "name, value, street, postalcode, county"
                    $aTemp = explode(",", $aFields);
                    $aTemp = array_map("trim", $aTemp); // trim each element
                    $sSelectionTerm = "`". implode("`,`", $aTemp)."`";
                }
                break;
            
            case (is_array($aFields)):
                if(0 === count($aFields))
                {
                    $sSelectionTerm = "*";
                } else {
                    $sSelectionTerm = "`". implode("`,`", $aFields)."`";
                }
                break;
                
            case (is_integer($aFields)):    // 0, -1
            case (is_null($aFields)):       // NULL
                $sSelectionTerm = "*";
                break;
        
        }
        
        $sQuery = "SELECT ".$sSelectionTerm." FROM `".$sTableName."`"; 
        
        if(strlen($sCondition) > 0)
        {
            $sQuery .= " WHERE ".$sCondition;
		
        }
        
        if( true === core::getInstance()->isLEPTON() )
        {
            // Huston - we've got another problem! ;-)
            $aResult = [];
            $database->execute_query(
                $sQuery,
                true,
                $aResult,
                $bFetchAll
            );
            return $aResult;
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
            if(method_exists($oResult, "fetchAll"))
            {
                return $oResult->fetchAll( MYSQLI_ASSOC );
            } else {
                // Huston: we've got a problem (with WBCE <= 1.3.3)
                $aAllResults = [];
                while( $aRow = $oResult->fetchRow( MYSQLI_ASSOC ) )
                {
                    $aAllResults[] = &$aRow;
                }
                return $aAllResults;
            }
        
        } else {
        
            return $oResult->fetchRow( MYSQLI_ASSOC );
        }
    }
}