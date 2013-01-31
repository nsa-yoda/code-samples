<?php

/**
 * Function which highlights a section of a string
*/

function highlightStr($haystack, $needle, $highlightColorValue) {
    if (strlen($highlightColorValue) < 1 || strlen($haystack) < 1 || strlen($needle) < 1) {
        return $haystack;
    }

    preg_match_all("/$needle+/i", $haystack, $matches);

    if (is_array($matches[0]) && count($matches[0]) >= 1) {
        foreach ($matches[0] as $match) {
            $haystack = str_replace($match, 
                                    '<span style="background-color:'.$highlightColorValue.';">'.$match.'</span>', 
                                    $haystack);
        }
    }

    return $haystack;
}