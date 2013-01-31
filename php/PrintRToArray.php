<?php

/*
 * returns html for an arra
**/

function print_r_html_array($var, $datatype) {
    $html = "<table cellspacing=\"0\" cellpadding=\"5\" border=\"1\">
    <tr>" ;
    if ( $datatype ) $html .= "<td align=\"left\" valign=\"middle\" style=\"background-color: #ccc;\"><b>TYPE</b></td>" ;
    $html .= "<td align=\"left\" valign=\"middle\" style=\"background-color: #ccc;\"><b>KEY</b></td>
        <td align=\"left\" valign=\"middle\" style=\"background-color: #ccc;\"><b>VALUE</b></td>
    </tr>" ;
    foreach ( $var AS $key => $value ) {
        $html .= "<tr>" ;
        if ( $datatype ) $html .= "<td align=\"left\" valign=\"middle\" style=\"background-color: #fff;\">" . gettype($value) . "</td>" ;
        $html .= "<td align=\"left\" valign=\"middle\" style=\"background-color: #fff;\">$key</td><td align=\"left\" valign=\"middle\" style=\"background-color: #fff;\">" ;
        if ( is_array($value) ) {
            // stop recursion
            if ( $key === "GLOBALS" ) {
                $html .= "*RECURSION*" ;
            } else if ( empty($value) ) {
                $html .= "<i>EMPTY</i>" ;
            } else {
                $html .= print_r_html_array($value, $datatype) ;
            }
        } else if ( is_object($value) ) {
            $html .= print_r_html_object($value, $datatype) ;
        } else {
            if ( is_null($value) ) {
                $html .= "<i>NULL</i>" ;
            } else if ( is_string($value) && $value == "" ) {
                $html .= "<i>EMPTY</i>" ;
            } else if ( is_bool($value) ) {
                if ( $value ) {
                    $html .= "<i>TRUE</i>" ;
                } else {
                    $html .= "<i>FALSE</i>" ;
                }
            } else {
                $html .= htmlentities($value) ;
            }
        }
        $html .= "</td></tr>" ;
    }
    $html .= "</table>" ;
    return $html ;
}
