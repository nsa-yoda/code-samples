<?php

class CoffeeSearchAPI extends CoffeeGeo{
    public function __construct() {
        parent::__construct(); 
    } 
    
    public function UniteDataArrays(){
        if(is_array($this->yahooData) && is_array($this->foursquareData)){
            # We have both Yahoo and Foursquare Arrays
            $this->SearchResponse = array_merge($this->yahooData, $this->foursquareData);
        } else if(is_array($this->yahooData) && !is_array($this->foursquareData)){
            # We only have Yahoo Array
            $this->SearchResponse = $this->yahooData;
        } else if(!is_array($this->yahooData) && is_array($this->foursquareData)){
            # We only have Foursquare Array
            $this->SearchResponse = $this->foursquareData;
        } else {
            # We have no arrays
            $this->throwError("No Search Result");
        }
        
        
        echo "<pre>";
        print_r($this->SearchResponse);
        echo "</pre>";
    }
    
    public function GetYahooJSON(){   
        # Build the Yahoo Pipes URL
        $url = $this->BuildYahooJSONUrl();

        # Decode the Yahoo Pipes JSON and return nicely built array.
        if($json = file_get_contents($url)){
            return json_decode($json, true);
        } else {
            echo "Error: Could not fetch data.";
        }
    }
    
    public function ParseYahooJSON(){
        $json = $this->yahooJson;
        if($json){
            $i = 0;
            foreach($json['value']['items'] as $j){
                $this->yahooData[$i]['LocationName']            = $j['title'];
                $this->yahooData[$i]['LocationExternalLink']    = $j['link'];
                $this->yahooData[$i]['LocationPhone']           = $j['Phone'];
                $this->yahooData[$i]['LocationWebsite']         = $j['BusinessUrl'];
                $this->yahooData[$i]['LocationAddress']         = $j['y:location']['street'];
                $this->yahooData[$i]['LocationLatitude']        = $j['y:location']['lat'];
                $this->yahooData[$i]['LocationLongitude']       = $j['y:location']['lon'];
                $this->yahooData[$i]['LocationStreet']          = $j['y:location']['street'];
                $this->yahooData[$i]['LocationCity']            = $j['y:location']['city'];
                $this->yahooData[$i]['LocationState']           = $j['y:location']['state'];
                $this->yahooData[$i]['LocationZipCode']         = $j['y:location']['postal'];
                $i++;
            }
        } else{
            $this->yahooData = array("");
        }
    }
    
    public function GetFourSquareJSON(){
        # Build the FourSquare URL
        $url = $this->BuildFourSquareJSONUrl();
        
        # Decode the FourSquare JSON and return nicely built array.
        if($json = file_get_contents($url,0,null,null)){
            $json = substr($json, 0);
            return json_decode($json, true);
        } else {
            echo "Error: Could not fetch data.";
        }   
    }
    
    public function ParseFourSquareJSON(){
        $json = $this->foursquareJson;
        if($json){
            $i = 0;
            foreach($json['response']['venues'] as $j){
                $this->foursquareData[$i]['LocationName']            = $j['name'];
                $this->foursquareData[$i]['LocationExternalLink']    = $this->createFourSquareExternalLink($j['link']);
                $this->foursquareData[$i]['LocationPhone']           = $j['contact']['phone'] ? $j['contact']['phone'] : 
                                                                     $j['contact']['formattedPhone'] ? $j['contact']['formattedPhone'] : "";
                $this->foursquareData[$i]['LocationWebsite']         = $j['url'];
                $this->foursquareData[$i]['LocationAddress']         = $j['location']['address'];
                $this->foursquareData[$i]['LocationLatitude']        = $j['location']['lat'];
                $this->foursquareData[$i]['LocationLongitude']       = $j['location']['lng'];
                $this->foursquareData[$i]['LocationStreet']          = $j['location']['crossStreet'];
                $this->foursquareData[$i]['LocationCity']            = $j['location']['city'];
                $this->foursquareData[$i]['LocationState']           = $j['location']['state'];
                $this->foursquareData[$i]['LocationZipCode']         = $j['location']['postalCode'];
                $i++;
            }
        } else{
            $this->foursquareData = array("");
        }
    }
}

?>
