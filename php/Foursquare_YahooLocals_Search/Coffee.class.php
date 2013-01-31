<?php
session_start();

# Primary CoffeeFixUp Class "Coffee". 
# All classes below MUST be loaded in the correct order.

# Load the static variables used in the classes below
require_once("CoffeeVars.class.php");

# Load the API keys used in the classes below and in the website
require_once("CoffeeKeys.class.php");

# Load the Database Connection and Action Class
require_once("CoffeeDb.class.php");

# Load the URL Builder and Modifier class
require_once("CoffeeURL.class.php");

# Load the Geographic Detection Class
require_once("CoffeeGeo.class.php");

# Load the Location Search Class
require_once("CoffeeSearchAPI.class.php");
    
# Load the jMathai Foursquare aSync libraries
require_once("jmathai-foursquare-async-f0801e0/EpiCurl.php");
require_once("jmathai-foursquare-async-f0801e0/EpiFoursquare.php");

class Coffee extends EpiFoursquare{
    public function __construct() {
        parent::__construct(); 
    } 
    
    public function InitFourSquareAuth($authToken=""){    
        return new EpiFoursquare($this->FourSquareClientID, $this->FourSquareClientSecret, $authToken="");
    }
    
    public function GrabFourSquareAuthorizationLink($fsObjUnAuthorized){
        $authorizeUrl = $fsObjUnAuthorized->getAuthorizeUrl($this->FSCallBackURL);
        return $authorizeUrl;
    }
    
    public function DoFourSquareLogin($fsObjUnAuthorized){
        if(!isset($_COOKIE['access_token'])) {
            $token = $fsObjUnAuthorized->getAccessToken($_GET['code'], $this->FSCallBackURL);
            setcookie('access_token', $token->access_token);
            $_COOKIE['access_token'] = $token->access_token;
        }
        
        if($_COOKIE['access_token']){
            $fsObjUnAuthorized->setAccessToken($_COOKIE['access_token']);
        }
    }
    
    public function Search($post){
        # Detect a good location based on user input
        $this->location = $post['location'];
        $this->radiusInMiles = $post['radius'];
    
        # Get JSON Feeds
        $this->yahooJson = $this->GetYahooJSON();
        $this->foursquareJson = $this->GetFourSquareJSON();
    
        # Parse the JSON Feeds and create arrays
        $this->ParseYahooJSON();
        $this->ParseFourSquareJSON();
        
        $this->UniteDataArrays();
    }
}

?>
