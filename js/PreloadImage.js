// Preload images
function preload(){
    var images = new Array();
    for(i = 0; i < preload.arguments.length; i++){
        images[i] = new Image();
        images[i].src = preload.arguments[i];
    }
}

preload("http://newyorkrealestatephotography.com/images/homePageRollover/1.jpg",
        "http://newyorkrealestatephotography.com/images/homePageRollover/2.jpg",
        "http://newyorkrealestatephotography.com/images/homePageRollover/3.jpg",
        "http://newyorkrealestatephotography.com/images/homePageRollover/4.jpg",
        "http://newyorkrealestatephotography.com/images/homePageRollover/5.jpg"
);