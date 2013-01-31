// A Simple Tab Switcher that looks for all li elements under the mainTabs ul id.
// an example of this in action is located at whatsmysongworth.com

// REQUIRES: jQuery

$(document).ready(function(){
    // Bind a click event to the ul#mainTabs.li 
    $('#mainTabs li').bind("click", function(e){
        e = e || window.event;
        var ul = $(this).parent();
        var index = ul.children().index(this);

        var i;
        // get number of li elements
        var numLi = $("#mainTabs li").size() - 1;

        // Match the tab that was clicked on to the correct div
        for(i = 0; i <= numLi; i++){
            if(i == index){
                document.getElementById("c" + i).style.display = "block";
            } else if(i != index){
                document.getElementById("c" + i).style.display = "none";
            } else {
                document.getElementById("c" + 0).style.display = "block";
            }
        }
    });
});
