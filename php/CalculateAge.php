<?php

/**
 * Calculate a users age, given his/her birth date
*/
function calculateAge($bday){
    return floor( (time() - strtotime($bday)) / (60 * 60 * 24 * 365) );
}

