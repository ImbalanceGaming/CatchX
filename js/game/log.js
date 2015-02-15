var currentLogLength = 0;

var log = {};
log.length = 0;

log.Create = function (gameState)
{
    for (var i = 1; i < gameState.numberOfTurns; i++)
    {
            $("#logInner").append('<div id="connectionTurn' + i + '" class="hudConnection"></div>');
            if (gameState.revealTurns.indexOf(i) != -1)
            {
                    $("#logInner").append('<div id="turn' + i + '" class="hudBlock"></div>');
            }
            else
            {
                    $("#logInner").append('<div id="turn' + i + '" class="hudCircle"></div>');
            }
    }
    this.Update(gameState);
}


log.Update = function (gameState)
{
    var newLog = gameState.log;
    if (this.length < newLog.length)
	{
		for (i = 0; i < newLog.length - this.length; i++)
		{
			$( "#connectionTurn" + (i+1) ).animate({ backgroundColor:newLog[i].color },1000);
			$( "#turn" + (i+1) ).animate( {backgroundColor: newLog[i].color, color:"rgba(0,0,0,1)"},1000 );
			if (newLog[i].position !== undefined)
				$( "#turn" + (i+1) ).html( newLog[i].position );
		}
	}
}