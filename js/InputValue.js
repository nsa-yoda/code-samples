/* 
 * Shorthand interface functions because I'm lazy
*/
function svt(control){ setValueTrueFalse(control) }
function hiv(control){ hideInputValue(control) }

// Set value of an input to true or false
function setValueTrueFalse(control){
    if(control.value == "false" || !control.value || control.value == "") {
        control.value = "true"
    } else { control.value = "false" }
}

// Hide the input value on focus and set it again when focus is lost
function hideInputValue(control){
    var cookieName = control.id ? control.id : control.name ? control.name : false;
    if(control.value.length == 1 && $("*:focus").length == 1){
        setCookie(cookieName, control.value, 2);
        control.value = "";
    } else if(control.value.length == 0 && $("*:focus").length == 0){
        control.value = getCookie(cookieName) ? getCookie(cookieName) : console.log("Error fetching cookie");
    }
}



// Below are helper functions that I did not write

// I did not write this
function getCookie(c_name){
    var i,x,y,ARRcookies=document.cookie.split(";");
    for (i=0;i<ARRcookies.length;i++){
        x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
        y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
        x=x.replace(/^\s+|\s+$/g,"");
        if (x==c_name){
            return unescape(y);
        }
    }
}

// I did not write this
function setCookie(c_name,value,exdays){
    var exdate=new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
    document.cookie=c_name + "=" + c_value;
}