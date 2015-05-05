$( document ).ready(function() {
	$("#log").mCustomScrollbar();
	$('#map').panzoom();
	$("#map").panzoom("option", "increment", 0.1);
    $("#map").parent().on('mousewheel.focal', function( e ) {
            e.preventDefault();
            var delta = e.delta || e.originalEvent.wheelDelta;
            var zoomOut = delta ? delta < 0 : e.originalEvent.deltaY > 0;
            $("#map").panzoom('zoom', zoomOut, {
              increment: 0.1,
              animate: false,
              focal: e
            });
          });    
		
		/*
        $(window).bind('mousewheel DOMMouseScroll', function(event){
            if (event.originalEvent.wheelDelta > 0 || event.originalEvent.detail < 0) {
                        $("#map").panzoom("zoom", false,{focal:event});
            }
            else {
                $("#map").panzoom("zoom", true,{focal:event});
            }
        }); 
*/		
        
        
        
	GetState(game.Initialize);	
});


/*
(function() {
          var $section = $('#focal');
          var $panzoom = $section.find('.panzoom').panzoom();
          $panzoom.parent().on('mousewheel.focal', function( e ) {
            e.preventDefault();
            var delta = e.delta || e.originalEvent.wheelDelta;
            var zoomOut = delta ? delta < 0 : e.originalEvent.deltaY > 0;
            $panzoom.panzoom('zoom', zoomOut, {
              increment: 0.1,
              animate: false,
              focal: e
            });
          });
        })();
		*/