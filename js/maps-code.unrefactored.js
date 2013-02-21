// See maps-code.refactored.js for my changes to code below

var setupmabox = function () {
  var wide = $('body').width(),
    mapW = '900px';
    $('.open_sec').live('click', function(){
        $('.section_navigation > ul').slideToggle();
    });             
    if(wide <= 768 && $('.section_navigation').length >= 1) {
        $('.section_navigation h2').append('<a href="#open_sec" class="open_sec">View Section Navigation Â»</a>');
        
        $('.section_navigation > ul').hide();       
    }   
    if(wide <= 768) {
        mapW = '600px';
    }
    if(wide <= 400) {
        mapW = '320px';
    }   

    $(window).resize(function () {
        function showNav() {
            if($('body').width() >= 769 && $('.open_sec').length >= 1) {
                $('.open_sec').remove();
                $('.section_navigation > ul').show();
            }
            if($('body').attr('class') !== 'homepage' && $('body').width() >= 481) {
                $("#makeMeScrollable").css('width', '100%').unwrap();
                $("#makeMeScrollable").smoothDivScroll({ 
                    scrollToEasingFunction: "easeOutCubic",
                    hotSpotScrollingStep: 5,
                    hotSpotScrollingInterval: 2
                }); 
            } else if($('body').width() <= 768) { 
                if($('.scrollMe').length === 0){
                    var NewWidth = 0;
                    $("#makeMeScrollable div.col").each(function(i){
                        $(this).addClass('check');
                        NewWidth += $(this).outerWidth(true);   
                    });
                    $("#makeMeScrollable").css('width', NewWidth + 'px').wrap('<div class="scrollMe" />');                          
                }
                
                if($('.open_sec').length === 0) {
                    $('.section_navigation h2').append('<a href="#open_sec" class="open_sec">View Section Navigation Â»</a>');
                    $('.section_navigation > ul').hide();
                }                           
            }
        }
        window.setTimeout(showNav, 500, true);  // won't pass "true" to the showNav in IE
                                                
    }); 
        
                 
            


        // if there's a map-holder div and it's not the homepage - then go ahead and load the map
        if($('.map-holder').length >= 1 && $('body').attr('class') !== 'homepage' && wide >= 481) {
        
            mapbox.auto('map_ny', 'whitewhale.map-rqcwlcce');
            $('#ny_map').css('z-index','8').animate({left: '30px', width: mapW}, 500, function(){
                $('#map_ny').show().css('z-index', '9');
            });
            
            
        } else if($('.map-holder').length >= 1 && $('body').attr('class') !== 'homepage' && wide <= 480) {
        
            mapbox.auto('map_world', 'whitewhale.map-7srryw0v', function(map, tiledata) {
                map.zoom(3);
            });
            
            mapbox.auto('map_ny', 'whitewhale.map-rqcwlcce', function(map, tiledata) {
                map.zoom(8);
            });         
            
            mapbox.auto('map_us', 'whitewhale.map-s1s65k18', function(map, tiledata) {
                map.zoom(3);
            });         
            
            $('.loc_list a').addClass('loaded');
            
            $('#map_world').css('z-index', '9');            
            
        } else if($('.map-holder').length >= 1 && $('body').attr('class') === 'homepage') {
        
        // if there's a map-holder div and it IS the homepage - then load the map when 'locations' is clicked
        
            $('.locations').click(function(){
                mapbox.auto('map_world', 'whitewhale.map-7srryw0v');
            });
            
        }
        
        
        // map functionality
        if($('.map-holder').length >= 1) {  

            $('.map_click a, .loc_list a').click(function(e){
            
                e.preventDefault();
                            
                var newID = $(this).attr('href');
                
                if($(this).parents('div.loc_list, .map_click').hasClass('open') !== true) {
                    
                    $('.map_click, .loc_list').removeClass('open');
                    $(this).parents('div.loc_list, .map_click').addClass('open');
                    
                    $('.map_actual').css('z-index', '1');
                                
                    switch(newID){
                    
                        case '#world_map':
                            if($(this).hasClass('loaded') !== true) {
                                mapbox.auto('map_world', 'whitewhale.map-7srryw0v');
                                $(this).addClass('loaded');
                            }                       
                            
                            $('#ny_map').css({left: 'auto'}).animate({width: '30px', right: '30px'}, 500);
                            $('#us_map').css({left: 'auto'}).animate({width: '30px', right: '0'}, 500);
                            $('#world_map').animate({width: mapW, left: '0'}, 500, function(){
                                $('#map_world').css('z-index', '9');
                            });                         
                            
                            break;
                          
                        case '#ny_map':
                            if($(this).hasClass('loaded') !== true) {
                                mapbox.auto('map_ny', 'whitewhale.map-rqcwlcce');
                                $(this).addClass('loaded')
                            }
                            
                            $('#us_map').css({left: 'auto'}).animate({width: '30px', right: '0'}, 500);
                            $('#ny_map').css('z-index','8').animate({left: '30px', width: mapW}, 500, function(){
                                $('#map_ny').show().css('z-index', '9');
                            });                                                     
    
                          break;
                          
                        case '#us_map':
                            if($(this).hasClass('loaded') !== true) {
                                mapbox.auto('map_us', 'whitewhale.map-s1s65k18');
                                $(this).addClass('loaded');
                            }                       

                            $('#ny_map').animate({width: '30px', left: '30px'}, 500);   
                            $('#us_map').css('z-index','8').animate({left: '60px', width: mapW}, 500, function(){
                                $('#map_us').css('z-index', '9');
                            });                         
                            

                                          
                          break;                      
                          
                        default:
                          mapbox.auto('map_ny', 'whitewhale.map-rqcwlcce'); 
                    }               
                }       
                
            });         
            
        }

}
