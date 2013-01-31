<?php

class CoffeeURL extends CoffeeDb{
    public function __construct() { parent::__construct(); } 
    
    public function UrlEncode($url){
        return urlencode($url);
    }
    
    public function BuildYahooJSONUrl(){
        $location = $this->DetectLocationForURL();
        
        # No good data, so force 10079 while still in testing 
        # TODO: Replace with Error throw/catch
        if(!$location || $location == ",") $location = "40.7924950,-73.9519050";
        
        return "http://pipes.yahoo.com/pipes/pipe.run?Location=" . $location . 
               "&_id=694446aae61c435d80405010a0f0a5d3&_render=json";
    }
    
    public function getCurrentPageURL() {
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
            $pageURL .= "://";
            if ($_SERVER["SERVER_PORT"] != "80") {
                $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];    
            } else {
                $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
            }
        return $pageURL;
    }
    
    public function createFourSquareExternalLink($id){
        if($id) return "https://foursquare.com/venue/" . $id;
        else return "https://foursquare.com/venue/";
    }
    
    public function BuildFourSquareJSONUrl(){
        # Get Location Coordinates
        $location = $this->DetectLocationForURL("","coordinates");
        $location = $location[1] . "," . $location[0];
        
        # No good data, so force 10079 TODO: Replace with Error Catch
        if(!$location || $location == ",") $location = "40.7924950,-73.9519050";
        
        # Calculate radius from miles to meters
        $radiusInMeters = $this->ConvertMilesToMeters($this->radiusInMiles);
        
        # Build the parameters we want to send to FourSquare's API
        $params = array("ll" => $location, "query" => "coffee", "limit" => 50, "checkin" => "match", "radius" => $radiusInMeters);
        $num_params = count($params);
        
        # Build the FourSquare URL
        $url = "https://api.foursquare.com/v2/venues/search?";
        
        foreach($params AS $key => $value) $url .= $key . "=" . $value . "&";

        $url .= "&client_id=" . $this->FourSquareClientID;
        $url .= "&client_secret=" . $this->FourSquareClientSecret;
        $url .= "&v=" . date("Y") . date("m") . date("d");
        
        return $url;
    }
}

?>
