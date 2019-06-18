<?php

/**
 *  Tools for development
 *  @category   LEPTON cross development
 *  @package    newsreader
 *
 */

namespace newsreader\abstracts;

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

abstract class addon
{
    /**
     *  Instance of the class.
     */
    static $instance = NULL;

    /**
     *  Returns the instance of the class.
     *  Calls also the (abstract) class-method "initialize()"; without any argument.
     *
     *  @return object  The instance-object of the class.
     */
    public static function getInstance( $aOptions=array() )
    {
        if (NULL === static::$instance)
        {
            static::$instance = new static();
            static::$instance->initialize( $aOptions );
        }
        return static::$instance;
    }

    /**
     *  Abstract method - has to be overwrite by the child-instance!
     */
    abstract public function initialize();
}