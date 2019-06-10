<?php

/**
 * This file is part of an ADDON for use with LEPTON Core.
 * This ADDON is released under the GNU GPL.
 * Additional license terms can be seen in the info.php of this module.
 *
 * @module          Twig Template Engine
 * @author          LEPTON Project
 * @copyright       2012-2019 LEPTON  
 * @link            https://www.LEPTON-cms.org
 * @license         http://www.gnu.org/licenses/gpl.html
 * @license_terms   please see info.php of this module
 *
 */

namespace newsreader\twig;

class operators extends \Twig_Extension
{
    // initialize
    public function __construct()
    {
    
    }
    
    /**
     *  See: page 40 ff. inside the twig documentation-pdf. 
     *      https://twig.symfony.com/doc/2.x/
     *      https://twig.symfony.com/doc/2.x/advanced.html#operators
     */
    public function getOperators()
    {
        return array(
            array(
                '!' => array(
                    'precedence' => 50,
                    'class' => 'wig_Node_Expression_Unary_Not'
                ),
                
                '¬' => array(
                    'precedence' => 50,
                    'class' => 'wig_Node_Expression_Unary_Not'
                )
             ),
            array(
                '||' => array(
                    'precedence' => 10,
                    'class' => 'Twig_Node_Expression_Binary_Or',
                    'associativity' => \Twig_ExpressionParser::OPERATOR_LEFT
                ),
                '&&' => array(
                    'precedence' => 15,
                    'class' => 'Twig_Node_Expression_Binary_And',
                    'associativity' => \Twig_ExpressionParser::OPERATOR_LEFT
                )
            )
        );
    }
}