function getQueryVariable(variable)
{
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
}

Helper = function()
{
	this.Pan = function(x,y)
	{
		var scale = $('#map').panzoom("getMatrix")[0];
		var mapDim = {'width':$('#map').width(),'height':$('#map').height()};
		var topLeft = {'x':((mapDim.width * (1-scale))/2),'y':((mapDim.height * (1-scale))/2)};
		$("#map").panzoom('pan',(-topLeft.x - x*scale + window.innerWidth/2 ),(-topLeft.y - y*scale + window.innerHeight/2),{ relative: false });
	}
}

var helper = new Helper();