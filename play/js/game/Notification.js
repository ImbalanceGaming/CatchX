Notification = function()
{
	this.blocked = false;
	this.que = [];
	
	this.Notify = function(text)
	{
		if (game.notificator.blocked)
		{
			game.notificator.que.push(text);
			return;
		}
		
		game.notificator.blocked = true;
		$("#notification").css("opacity",1);
		$("#notification").html(text);
		setTimeout(function(){
			$("#notification").css("opacity",0);
			game.notificator.blocked = false;
			if (game.notificator.que.length > 0)
			{
				game.notificator.Notify(game.notificator.que.pop());
			}
		},2000)
	}
}