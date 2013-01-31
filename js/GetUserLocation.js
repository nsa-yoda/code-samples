/**
 * Get the User location
 * Author: Juan L Sanchez <juanleonardosanchez.com>
 */ 

function getUserLocation(onSuccessCallback, onErrorCallback){
    if(!onSuccessCallback){ log("onSuccessCallack not set"); return 0; }
    if(!onErrorCallback){ log("onErrorCallback not set"); return 0; }
    if(navigator.geolocation) navigator.geolocation.getCurrentPosition(onSuccessCallback, onErrorCallback);
    else{ log("navigator.geolocation not supported."); return 0; }
}