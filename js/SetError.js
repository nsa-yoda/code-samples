// Set error message and cookie
function setError(errorMessage, errorID){
    var n = "We've pre-filled some common selections for you.";
    var prev = "";
    if(errorMessage.length > 0){
        if(prev = getCookie("previousError")){
            setError("",prev);
        }
        
        if(errorMessage != "") errorID = errorID + "ID";
        
        setCookie("previousError", errorID, 1);
        $("#notificationArea").css("color", "red").html(errorMessage);
        $("#" + errorID).css("background-color", "#600");
        abort();
    } else {
        $("#notificationArea").fadeOut(50).css("color", "#ffffff").html(n).fadeIn(400);
        $("#" + errorID).css("background-color", "#000");
    }
}