var id = "1";
var password = "123";
//var side = "good";
// TODO: Replace url
function GetState(functionThatDoesSomethingWithState)
{
    $.ajax({
      type:'POST',
      dataType: "json",
      url: backendUrl + "play/getState",
      data: { id: id, password: password, side:side},
      success: function(data) {functionThatDoesSomethingWithState(data, side);},
      error: function() {setTimeout(function(){GetState(functionThatDoesSomethingWithState);}, 1000);}
    });
}

// TODO: Replace url
function DoMove(playerId, positionNodeId, destinationNodeId, doubleTicket, hiddenTicket)
{
    $.ajax({
      type:'POST',
      dataType: "json",
      url: backendUrl + "play/doMove",
      data: { gameId: id, password: password, side: side, playerId: playerId, positionNodeId:positionNodeId , destinationNodeId:destinationNodeId, doubleTicket:doubleTicket,hiddenTicket:hiddenTicket},
      success: function(data) 
      {
          game.Update(data);
      },
      error: function() 
      {
          setTimeout(function(){GetState(game.Update);}, 1000);
      }
    });
}