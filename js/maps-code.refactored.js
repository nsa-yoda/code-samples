/**
 * Initialize via:
   var manager = new MapManager();
   manager.setUpMapBox();
 */

function MapManager(){
  this.width = $('body').width();
  this.mapW = '900px';
  this.mapHolderLength = $('.map-holder').length;
  this.isHomepage = $('body').attr('class') !== 'homepage' ? false : true;
}

MapManager.prototype.setUpMapBox = function(){
  $(document).on('click', '.open_sec', function(){
    $('.section_navigation > ul').slideToggle();
  })
  
  if(this.width <= 768 && $('.section_navigation').length >= 1){
    $('.section_navigation h2').append('<a href="#open_sec" class="open_sec">View Section Navigation &raquo;</a>');
    $('.section_navigation > ul').hide();  
  }
  
  if(this.width <= 768){ this.mapW = '600px'; }
  if(this.width <= 400){ this.mapW = '320px'; }
  
  $(window).resize(function(){ console.log("onWindowResize"); this.onWindowResize(); });
  
  this.SetUpMapHolder();
  this.MapFunctionality();
  
  return this;
} 

MapManager.prototype.onWindowResize = function(){  
  if(width >= 769 && $('.open_sec').length >= 1){
    $('.open_sec').remove();
    $('.section_navigation > ul').show();
  }
  if(this.isHomepage === false && width >= 481){
    $("#makeMeScrollable").css('width', '100%').unwrap();
    $("#makeMeScrollable").smoothDivScroll({ 
        scrollToEasingFunction: "easeOutCubic",
        hotSpotScrollingStep: 5,
        hotSpotScrollingInterval: 2
    }); 
  } else if(this.width <= 768) { 
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
  window.setTimeout(showNav, 500, true);  // won't pass "true" to the showNav in IE
  
  return this;
}

/** 
 * If there's a div with class .map-holder, and it is NOT the homepage, load map
 * else, if div with class .map-holder exists and it IS the homepage, load only when
 * 'locations' is clicked.
 */
MapManager.prototype.SetUpMapHolder = function(){
  if(this.mapHolderLength >= 1 && this.isHomepage === false){
    if(this.width >= 481){
      mapbox.auto('map_ny', 'whitewhale.map-rqcwlcce');
      $('#ny_map').css('z-index','8').animate({left: '30px', width: this.mapW}, 500, function(){
          $('#map_ny').show().css('z-index', '9');
      });
    } else if(this.width < 481){
      mapbox.auto('map_world', 'whitewhale.map-7srryw0v', function(map, tiledata){ map.zoom(3); });
      mapbox.auto('map_ny', 'whitewhale.map-rqcwlcce', function(map, tiledata){ map.zoom(8); });         
      mapbox.auto('map_us', 'whitewhale.map-s1s65k18', function(map, tiledata){ map.zoom(3); });         
      $('.loc_list a').addClass('loaded');
      $('#map_world').css('z-index', '9');    
    }
  } else {
    $(document).on('click', '.locations', function(){
      mapbox.auto('map_world', 'whitewhale.map-7srryw0v');
    });
  }
}

/**
 * Handles map functionality
 */ 
MapManager.prototype.MapFunctionality = function(){
  if(this.mapHolderLength >= 1) {  
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
            $('#world_map').animate({width: this.mapW, left: '0'}, 500, function(){
                $('#map_world').css('z-index', '9');
            });
          break;  
          case '#ny_map':
            if($(this).hasClass('loaded') !== true) {
                mapbox.auto('map_ny', 'whitewhale.map-rqcwlcce');
                $(this).addClass('loaded')
            }
            $('#us_map').css({left: 'auto'}).animate({width: '30px', right: '0'}, 500);
            $('#ny_map').css('z-index','8').animate({left: '30px', width: this.mapW}, 500, function(){
                $('#map_ny').show().css('z-index', '9');
            });
          break;
          case '#us_map':
            if($(this).hasClass('loaded') !== true) {
                mapbox.auto('map_us', 'whitewhale.map-s1s65k18');
                $(this).addClass('loaded');
            }          
            $('#ny_map').animate({width: '30px', left: '30px'}, 500);   
            $('#us_map').css('z-index','8').animate({left: '60px', width: this.mapW}, 500, function(){
                $('#map_us').css('z-index', '9');
            });               
          break;           
          default: mapbox.auto('map_ny', 'whitewhale.map-rqcwlcce'); 
        }               
      }       
    });    
  }
}
