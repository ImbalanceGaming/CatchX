Powerups = function (gameState)
{
    this.hiddens = 0;
    this.doubles = 0;    
    
    this.Update = function (gameState)
    {
        this.hiddens = gameState.hiddens;
        this.doubles = gameState.doubles;
        
        $("#doubleTicketsValue").html(gameState.doubles);
	$("#hiddenTicketsValue").html(gameState.hiddens);
    };
    
    this.Initialize = function (gameState)
    {
        $("#doubleAndJokerTickets").css("display","inline");
        this.Update(gameState);
    };
    this.Initialize(gameState);
    
    this.UseHidden = function()
    {
        return $("#hiddenCheckbox").prop("checked");
    };
    
    this.UseDouble = function()
    {
        return $("#doubleCheckbox").prop("checked");
    };
    
    this.Reset = function()
    {
        $("#doubleCheckbox").prop("checked", false);
	$("#hiddenCheckbox").prop("checked", false);
    };
};


