<?php

/**
 * Function to get English ordinals for numbers
*/
function getEnglishOrdinals($num){
    switch(floor($num / 10) % 10){
        default:
            switch($num % 10){
                case 1: return 'st';
                case 2: return 'nd';
                case 3: return 'rd';  
            }
        case 1:
    }
        return 'th';
}