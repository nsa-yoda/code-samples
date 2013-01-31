<?php

/**
 * Function which, given an address, returns the latitude, longitude
 * and altitude of said location - according to Google.
*/


function GeoMapCoors($search){
    $address = "http://maps.google.com/maps/geo?q=" . urlencode($search) . "&output=xml";
    $xml = new SimpleXMLElement(file_get_contents($address));
    return list($longitude, $latitude, $altitude) = explode(",", $xml->Response->Placemark->Point->coordinates);
}