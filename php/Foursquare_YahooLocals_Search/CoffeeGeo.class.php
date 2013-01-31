<?php

class CoffeeGeo extends CoffeeURL{
    public function __construct() { parent::__construct(); } 
    
    public function MapAddress($address, $type = "coordinates"){
        $address = $this->UrlEncode($address);
        $address = "http://maps.google.com/maps/geo?q=" . $address . "&output=xml&key=" . $this->GoogleMapsKey;
        $xml = new SimpleXMLElement(file_get_contents($address));
        if($type == "coordinates"){
            return list($longitude, $latitude, $altitude) = explode(",", $xml->Response->Placemark->Point->coordinates);
        } else if($type == "physical"){
            # Check if there's a ZIP Code, if not, simply return approximate address
            if($xml->Response->Placemark->AddressDetails->Country->AdministrativeArea->Locality->PostalCode->PostalCodeNumber){
                return $xml->Response->Placemark->AddressDetails->Country->AdministrativeArea->Locality->PostalCode->PostalCodeNumber;
            } else {
                return $xml->Response->Placemark->address;
            }
        }
    }
    
    private function isZipCode($zipCode){
        if(is_numeric($zipCode) && strlen($zipCode) == 5){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    static function splitByCaps($string){
        return preg_replace('/([a-z0-9])?([A-Z])/','$1 $2',$string);
    }
    
    public function crossCheckZip($zipCode){
        if($this->isZipCode($zipCode)){
            $q = $this->DBRunSelect("areaName, areaState", "usa_zip_codes", "zipCode = " . $zipCode);
            $zipCode = $zipCode . " " . $this->splitByCaps($q[0]['areaName']) . " " . $q[0]['areaState'];
        }
        return $zipCode;
    }
    
    public function DetectLocationForURL($location = "", $type = ""){
        # Get user input location. If no input, default to 10010 in NYC
        $location = $this->location ? $this->location : "10010";
        
        # We only want coordinates
        if($type == "coordinates"){
            if($this->isZipCode($location))
                $location = $this->crossCheckZip($location);
            return $this->MapAddress($location, "coordinates");
        }
    
        # Detect a ZIP Code - if the location given is not numeric and the length
        # is not equal to 5, then its not a ZIP Code and we will search an address.
        if($this->isZipCode($location) == FALSE){    
            $location = $this->UrlEncode($this->MapAddress($location,"physical"));
        }
        
        return $location;
    }
    
    public function ConvertMilesToMeters($miles = ""){
        if($miles == 0 || !$miles) $miles = 1;
        return $miles * 1609.344;
    }
}

?>
