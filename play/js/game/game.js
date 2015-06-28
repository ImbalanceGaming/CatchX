var game = {};
game.wait = true;
game.activePlayer = 0;
game.players = [];
game.graph = {};
game.turnSide = "";


game.Initialize = function (gameState)
{
    game.graph = new Graph(gameState.graph);
	
    game.notificator = new Notification();
	game.turnSide = gameState.turnSide;
	game.NotifyTurnChange(game.turnSide);
	
	
    for (i = 0; i < gameState.players.length; i++)
    {
        var player = gameState.players[i];
        game.players.push(new Player(
            i,
            player.position,
            player.turn,
            player.control,
            player.pawnImage,
            player.name
            ));
    }
    
    game.selection = new Selection();
    game.side = game.DetermineSide(gameState);
    log.Create(gameState);
    if (game.side == "evil")
	{
        game.powerups = new Powerups(gameState);
	}
    
    game.Update(gameState); 
}

game.NotifyTurnChange = function(turnSide)
{
	var audio = new Audio("audio/other/turn.mp3");
	audio.volume = 0.3;
	audio.play();
	
	if (turnSide == "evil")
	{
		game.notificator.Notify("Mr.X turn");
	}
	else
	{
		game.notificator.Notify("Detectives turn");
	}
}

game.Update = function (gameState) 
{    
    for (i = 0; i < game.players.length; i++) { 
        game.players[i].Update(gameState);
    }
    log.Update(gameState);
	if (game.side == "evil")
	{
		game.powerups.Update(gameState);
	}
    
    if (!game.Victory(gameState))
    {
		if (gameState.turnSide != game.turnSide)
		{
			game.turnSide = gameState.turnSide;
			game.NotifyTurnChange(game.turnSide);
		}
		
		
        if (game.side != gameState.turnSide)
		{
            setTimeout(function(){GetState(game.Update)}, 3000);
		}
        else
		{
            game.wait = false;
		}
    }
}

game.DetermineSide = function (gameState)
{
    if (gameState.players[0].control == '1')
        return "evil";
    else
        return "good";
}

game.Victory = function (gameState)
{
    if (gameState.victory != "0")
    {
        wait = true;
		
		for (var i = 0; i <= 4; i++)
		{
			$( "#p" + i + "portretImg" ).removeClass("blinking");
		}
		
        
        if (gameState.victory == "good")
            game.GoodEnding();
        else	
            game.BadEnding();
        return true;
    }
}

game.GoodEnding = function ()
{
	var audio = new Audio("audio/Joker/JokerLose.wav");
	audio.volume = 0.3;
	audio.play();
	
    $("#map").append('<img id="jokerLose" src="avatars/jokerAvatarLose.png" height=150 width=150  alt="joker" class="avatar" style="">');
    var node = game.graph.nodes[game.players[0].position];
    var x = node.x - $("#jokerLose").width() / 2 - 80;
    var y = node.y - $("#jokerLose").height() / 2;
    $("#jokerLose").css({left:x,top:y});
	game.notificator.Notify("Detectives win!");
}

game.BadEnding = function ()
{
	game.notificator.Notify("Mr.X wins!");
	var audio = new Audio("audio/Joker/JokerWin.wav");
	audio.volume = 0.3;
	audio.play();
}