$( document ).ready(function() {
    
	$(window).load(function(){
            $("#log").mCustomScrollbar();
        });
        $('#map').panzoom({});
	$("#map").panzoom("option", "increment", 0.1);
        
        $(window).bind('mousewheel DOMMouseScroll', function(event){
            if (event.originalEvent.wheelDelta > 0 || event.originalEvent.detail < 0) {
                        $("#map").panzoom("zoom", false,{focal:event});
            }
            else {
                $("#map").panzoom("zoom", true,{focal:event});
            }
        });   
        
        
        
	GetState(game.Initialize);	
});