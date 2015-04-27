$( document ).ready(function() {
    GetGames();
});

var currentFrame = 1;
function ChangeFrame(frame)
{
    $('#container').removeClass('frame' + currentFrame); 
    $('#container').addClass('frame' + frame);
    currentFrame = frame;
}

var paginationCounter = 0;
var gamesPerPage = 5;
var games = [];
function Paginate(page)
{
    var previous = page - 1;
    var next = page + 1;
    var first = 1;
    var last = Math.ceil(games.length / gamesPerPage);
    page = Math.max(1,Math.min(last,page));

    var gamesListHtml ="";
    for (var i = (page-1)*gamesPerPage; ((i < games.length) && (i < (page-1)*gamesPerPage + 5)); i++)
        gamesListHtml += '<div onclick="LoadJoinFrame(\'' + games[i] + '\'); ChangeFrame(3);" class="row game"><p>' + games[i] + '</p></div>';

    var paginateControlHtml = "";
    if (page > 1)
        paginateControlHtml += "<span onclick='Paginate(" + (page - 1) + ")'>previous</span> ";
    if (page > 3)
        paginateControlHtml += "<span onclick='Paginate(1)'>1</span> ... ";
    if (page > 1)
        paginateControlHtml += "<span onclick='Paginate(" + (page-1) + ")'>" + (page-1) + "</span> ";
    paginateControlHtml += '<span style="font-size:120%;">' + page + '</span> ';
    if (page + 1 <= last)
        paginateControlHtml += "<span onclick='Paginate(" + (page+1) + ")'>" + (page+1) + "</span> ";
    if (!(page + 1 >= last))
        paginateControlHtml += "... " + "<span onclick='Paginate(" + last + ")'>" + last + "</span> ";
    if (page + 1 <= last)
        paginateControlHtml += "<span onclick='Paginate(" + (page+1) + ")'>next</span>";

    $("#gamesList").html(gamesListHtml);
    $("#paginateControl").html(paginateControlHtml);

}

$( document ).ready(function() {
    Paginate(2);
});

//TODO replace url
function GetGames()
{
    $.ajax({
      type:'POST',
      dataType: "json",
      url: baseUrl + "index.php/games/GameList",
      success: function(data) {games = data; Paginate(1)}
    });
}

function Host()
{
    var gameName = $("#hostGameName").val();
    var password = $("#hostPassword").val();
    
    $.ajax({
      type:'POST',
      dataType: "json",
      url: baseUrl + "index.php/games/Host",
      data: { gameName: gameName, password: password},
      success: function(data) 
      {
          if (data.errors.length > 0)
              $("#hostValidationErrors").html(data.errors[0]);
          else
          {
              $("#hostValidationErrors").html("");
              Paginate(1);
              $("#joinPassword").val(password);
              LoadJoinFrame(gameName);
              ChangeFrame(3);
          }
      }
    });
}

function Join()
{
    var gameName = $("#joinGameName").val();
    var password = $("#joinPassword").val();
    
    $.ajax({
      type:'POST',
      dataType: "json",
      url: baseUrl + "index.php/games/Join",
      data: { gameName: gameName, password: password},
      success: function(data) 
      {
          if (data.errors.length > 0)
              $("#joinValidationErrors").html(data.errors[0]);
          else
          {
              $.cookie('name', gameName);
              $.cookie('password', password);
              $.cookie('id', data.id);
              window.location.href = baseUrl + "index.php/play";
          }
      }
    });
}

function LoadJoinFrame(gameName)
{
    $("#joinGameName").val(gameName);
    $("#joinGameNameView").html(gameName);
}