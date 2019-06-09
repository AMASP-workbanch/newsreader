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

namespace newsreader\abstracts;

abstract class addon
{
    static $instance = NULL;

    public static function getInstance()
    {
        if (NULL === static::$instance)
        {
            static::$instance = new static();
            static::$instance->initialize();
        }
        return static::$instance;
    }

    abstract public function initialize();
}