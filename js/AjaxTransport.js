// Get data from front end and send to the back end script
function calculatorAjax(){
    var sPropertyType;
    var dataString = "";
    
    if($("#HouseSell").is(":checked")){ 
        sPropertyType = "HouseSell";
        setError("","sPropertyType");
    } else if($("#HouseRent").is(":checked")){ 
        sPropertyType = "HouseRent";
        setError("","sPropertyType");
    } else if($("#ApartmentSell").is(":checked")){ 
        sPropertyType = "ApartmentSell";
        setError("","sPropertyType");
    } else if($("#ApartmentRent").is(":checked")){ 
        sPropertyType = "ApartmentRent";
        setError("","sPropertyType");
    } else {
        setError("You must declare what type of property this is.", "sPropertyType");
    }
    
    var ems = new Array("iPropertyValue","iRealtorCommission","iNumRooms","iNumKitchens",
                        "iNumBathrooms","iNumDining","bFrontExterior","bRearExterior","bPostProcessing",
                        "bPostHiRes","bOriginalHiRes","bWebReadyImages","bPhotosOnDVD","bBasicWebsite");

    dataString += "sPropertyType=" + sPropertyType + "&";
    for(var i = 0; i <= ems.length - 1; i++)
        dataString += ems[i] + "=" + $("#" + ems[i]).val() + "&";
    
    $.ajax({
        type: "POST",
        url: "scripts/ajax/photographyCalculator.php",
        data: dataString,
        dataType: "text",
        success: function(data){
            var check = data.indexOf(",") != -1;
            if(check == false){
                $("#calculatorTotal").html('Your total: $' + data + '<a href="#" onclick="calculatorAjax()">Calculate</a>');
                $("#submitRequest").css("display", "block");
                $("#notificationArea").html("");
            } else if(check == true){
                var error = data.split(",");
                setError(error[0], error[1]);
            }
        }
    });
}