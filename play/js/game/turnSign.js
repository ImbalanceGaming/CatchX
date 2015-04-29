var turnSign = {};
turnSign.Update = function (gameState)
{
    
    if (game.side != gameState.turnSide)
    {
            $( announcementDiv ).html( "Wacht op andere spelers." );
            $( announcementDiv ).removeClass("announcementBlink");
    }
    else
    {
            $( announcementDiv ).html( "Het is jouw beurt." );
            $( announcementDiv ).addClass("announcementBlink");
            wait = false;
    }
    
}

var announcementDiv = "#bottomHudElementInner";