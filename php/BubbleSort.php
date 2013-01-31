<?php

/**
 * Simple optimized bubble sort
*/

function bubbleSort($a){
    $n = count($a);
    while($n != 0){
        $l = 0;
        for($i = 1; $i <= $n - 1; $i++){
            if($a[$i -1] > $a[$i]){
                $a[$i] ^= $a[$i - 1] ^= $a[$i] ^= $a[$i - 1];
                $l = $i;
            }
        }
        $n = $l;
    }
    return $a;
}