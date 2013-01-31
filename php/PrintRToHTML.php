<?php

/**
 * html table-formatted print_r
 * @param mixed $var        any variable
 * @param boolean $datatype whether or not to show datatypes in the output
 * returns nothing
**/

function print_r_html($var, $datatype = true) {
    if ( !is_array($var) && !is_object($var) ) {
        $html = "<table cellspacing=\"0\" cellpadding=\"5\" border=\"1\"><tr><td align=\"left\" valign=\"middle\" style=\"background-color: #ccc;\"><b>VALUE</b></td>" ;
        if ( $datatype ) $html .= "<td align=\"left\" valign=\"middle\" style=\"background-color: #ccc;\"><b>TYPE</b></td>" ;
        $html .= "</tr><tr><td align=\"left\" valign=\"middle\" style=\"background-color: #fff;\">$var</td>" ;
        if ( $datatype ) $html .= "<td align=\"left\" valign=\"middle\" style=\"background-color: #fff;\">" . gettype($var) . "</td>" ;
        $html .= "</tr></table>" ;
    } else {
        $html = "" ;
        if ( is_array($var) ) {
            $html .= print_r_html_array($var, $datatype) ;
        } else if ( is_object($var) ) {
            $html .= print_r_html_object($var, $datatype) ;
        }
    }
    echo $html ;
}