<?php

/**
 * Function that does a very simple check for a 404 page at specified URL
*/

function check404($url){
    $get = @file_get_contents($url);
    if(preg_match('#404#', $get) || !$get) return false;
    else return true;
}