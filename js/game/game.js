var game = {};
game.wait = true;
game.activePlayer = 0;
game.players = [];
game.graph = {};


game.Initialize = function (gameState)
{
    game.graph = new Graph(gameState.graph);
    
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
        $("#doubleAndJokerTickets").css("display","inline"); 
    
    game.Update(gameState); 
}

game.Update = function (gameState) 
{    
    turnSign.Update(gameState);
    for (i = 0; i < game.players.length; i++) { 
        game.players[i].Update(gameState);
    }
    log.Update(gameState);
    
    if (!game.Victory(gameState))
    {
        if (game.side != gameState.turnSide)
            setTimeout(function(){GetState(game.Update)}, 3000);
        else
            game.wait = false;
    }
}

game.DetermineSide = function (gameState)
{
    if (gameState.players[0].control)
        return "evil";
    else
        return "good";
}

game.Victory = function (gameState)
{
    if (gameState.victory != "none")
    {
        wait = true;
        
        if (gameState.victory == "good")
            game.GoodEnding();
        else	
            game.BadEnding();
        return true;
    }
}

game.GoodEnding = function ()
{
    $("#map").append('<img id="jokerLose" src="' + baseUrl + 'avatars/jokerAvatarLose.png" height=150 width=150  alt="joker" class="avatar" style="">');
    var node = game.graph.nodes[game.players[0].position];
    var x = node.x - $("#jokerLose").width() / 2 - 80;
    var y = node.y - $("#jokerLose").height() / 2;
    $("#jokerLose").css({left:x,top:y});
}

game.BadEnding = function ()
{
}