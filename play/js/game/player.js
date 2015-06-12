Player = function(id, position, turn, control, image, name)
{
    this.id = id;
    this.position = position;
    this.turn = turn;
    this.control = control;
    this.htmlElement = {};
    this.name = name;
	this.image = image;
    
    this.Update = function (gameState)
    {
        var newPosition = gameState.players[this.id].position;
        if (this.position != newPosition)
            this.Move(game.graph.nodes[newPosition].x,game.graph.nodes[newPosition].y, newPosition);
        this.turn = gameState.players[this.id].turn;
        this.UpdatePortret(gameState);
		this.UpdatePawn();
    }
	
	this.UpdatePawn = function()
	{
		if (this.turn)
		{
			this.htmlElement.attr('src', "avatars/pawnReady" + this.name + ".png")
		}
		else
		{
			this.htmlElement.attr('src', "avatars/" + this.image)
		}
	}
    
    this.Move = function (x,y, newPosition)
    {
        this.position = newPosition;
        this.htmlElement.animate({ 
        left: (x - $("#player" + this.id).width() / 2),
        top: (y - $("#player" + this.id).height() / 2)		
        }, 1000 );
    }
    
    this.UpdatePortret = function (gameState)
    {
        if (this.turn)
            $( "#p" + this.id + "portretImg" ).addClass("blinking");
        else
            $( "#p" + this.id + "portretImg" ).removeClass("blinking");
    }
    
    this.Click = function ()
    {
        if (game.wait)
            return;
	
        game.selection.SelectPlayer(this);
	
		var audio = new Audio("audio/" + this.name + "/" + this.name + "Select" + Math.floor((Math.random() * 4) + 1) + ".wav");
		audio.play();
    }
    
    this.Highlight = function ()
    {
        this.htmlElement.removeClass("pion");
        this.htmlElement.addClass("selected");
    }
    
    this.RemoveHighlight = function ()
    {
        this.htmlElement.addClass("pion");
        this.htmlElement.removeClass("selected");
    }
    
    this.Initialize = function(image)
    {
        $("#map").append('<img  id="player' + this.id + '" src="avatars/' + image + '" height=150 width=150  alt="avatar" class="avatar pion"/>');
        this.htmlElement = $("#player" + this.id);
        if (this.control)
		{
			this.htmlElement.on("click touchstart",{"player":this.id},function(event)
			{
				game.players[event.data.player].Click();
			});
		}
        else
            this.htmlElement.css('pointer-events','none');
        
        var node = game.graph.nodes[this.position];
        var x = node.x - this.htmlElement.width() / 2;
        var y = node.y - this.htmlElement.height() / 2;
        this.htmlElement.css({left:x,top:y});
        this.UpdatePortret();
		
		$("#p" + this.id + "portretImg").on("click touchstart",{"player":this},function(event)
		{
			var playerPosition = game.graph.nodes[event.data.player.position];
			helper.Pan(playerPosition.x,playerPosition.y);
		});
		
    }
    this.Initialize(image);
    
    this.PlayMoveSound = function()
    {
        var audio = new Audio("audio/" + this.name + "/" + this.name + "Move" + Math.floor((Math.random() * 1) + 1) + ".wav");
        audio.play();
    }
};