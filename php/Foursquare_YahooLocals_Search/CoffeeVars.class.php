<?php

class CoffeeVars{
    #################################
    # EDITABLE VARIABLES START HERE #    
    #################################
    /*
     * Stores the Database connection data
    */
    public $DBConnection = "";
    public $DBUsername = "REDACTED FROM CODE SAMPLE";
    public $DBPassword = "REDACTED FROM CODE SAMPLE";
    public $DBHostname = "REDACTED FROM CODE SAMPLE";
    public $DBDatabase = "REDACTED FROM CODE SAMPLE";
    #################################
    #  EDITABLE VARIABLES END HERE  #    
    #################################
    
    /*
     * Site URL
    */
    public $SiteURL = "REDACTED FROM CODE SAMPLE";
    
    /*
     * Foursquare Callback URLs
    */
    public $FSCallBackURL = "REDACTED FROM CODE SAMPLE";

    /*
     * Stores search location (zip, address, etc)
     */
    public $location = "";
    
    /*
     * Stores search radius in miles
     */
    public $radiusInMiles = "";
    
    /*
     * If we need to cURL into an API, make us seem like Google Chrome
     */
    protected $userAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.X.Y.Z Safari/525.13.";
    
    /*
     * Again, for cURL'ing into FourSquare
     */
    public $FourSquareRequestTimeout = 30;
    
    /*
     * Foursquare Auth redirect variable
    */
    public $FourSquareAuthRedirect = "";
    
    /*
     * Yahoo JSON response
     */
    public $yahooJson = "";
    
    /*
     * FourSquare JSON response
     */
    public $foursquareJson = "";
    
    /*
     * Yahoo Parsed JSON Data Array
     */
    public $yahooData = "";
    
    /*
     * FourSquare Parsed JSON Data Array
     */
    public $foursquareData = "";
    
    /*
     * Stores the merged arrays $foursquareData and $yahooData
     */
    public $SearchResponse = "";
}

?>
