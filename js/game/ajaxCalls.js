var id = "1";
var password = "123";
//var side = "good";
// TODO: Replace url
function GetState(functionThatDoesSomethingWithState)
{
    $.ajax({
      type:'POST',
      dataType: "json",
      url: "http://localhost/catchX/index.php/play/getState",
      data: { id: id, password: password, side:side},
      success: function(data) {functionThatDoesSomethingWithState(data);},
      error: function() {setTimeout(function(){GetState(functionThatDoesSomethingWithState);}, 1000);}
    });
}

// TODO: Replace url
function DoMove(player, position, destination, doubleTicket, hiddenTicket)
{
    $.ajax({
      type:'POST',
      dataType: "json",
      url: "http://localhost/catchX/index.php/play/doMove",
      data: { id: id, password: password, side: side, player: player, position:position , destination:destination, doubleTicket:doubleTicket,hiddenTicket:hiddenTicket},
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

//doubleTicket:$("#doubleCheckbox").prop("checked"), hiddenTicket:$("#hiddenCheckbox").prop("checked")