
// Start Roll if it hasn't started yet
function checkRollover(){
    if($("#homePageImage").length > 0){
        setTimeout(function(){doRollover(1)}, 4000);
    }
}

// Perform image roll
function doRollover(numImage){
    var image = "images/homePageRollover/" + numImage + ".jpg?=" + Math.floor(Math.random()*10);
    $("#homePageImage").fadeOut(800).attr("src", image).fadeIn(700);
    
    if(numImage < 5) numImage++; else numImage = 1;
    setTimeout(function(){doRollover(numImage)}, 4000);
}
