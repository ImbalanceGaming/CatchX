<script>
    var currentFrame = 1;
    function ChangeFrame(frame)
    {
        $('#container').removeClass('frame' + currentFrame); 
        $('#container').addClass('frame' + frame);
        currentFrame = frame;
    }
    
    var paginationCounter = 0;
    var gamesPerPage = 5;
    var games = ["game1","game2","game23","game58","game2","game23","game58","game2","game23","game58","game2","game23","game58","game2","game23","game58","game2","game23","game58"];
    function Paginate(page)
    {
        var previous = page - 1;
        var next = page + 1;
        var first = 1;
        var last = Math.ceil(games.length / gamesPerPage);
        page = Math.max(1,Math.min(last,page));
        
        var gamesListHtml ="";
        for (var i = (page-1)*gamesPerPage; ((i < games.length) && (i < (page-1)*gamesPerPage + 5)); i++)
            gamesListHtml += '<div onclick="ChangeFrame(3)" class="row game"><p>' + games[i] + '</p></div>';
        
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
</script>

<div class="container-fluid frame1" id="container">
    <div class="row" id="header" >
        <?php echo img('images/homeBanner.png');?>
        <h1>Welcome to CatchX</h1>
    </div>
    
    <!-- Frame 2: games list -->
    <div class="row" id="games">
        <p style="color:purple;">Select a game to join</p>        
        <div id="gamesList"></div>
        <div id="paginateControl" class="row" style="font-size: 200%; color:purple; padding-top: 20px; margin-bottom: 20px;border-width: 0px; border-top-width: 5px; border-style: solid; border-color: yellow;"></div>
        <div id="hostGame" class="row" style="text-align: center;">
            <button onclick="ChangeFrame(4)">Host game</button>
        </div>
    </div>
    
    <!-- Frame 3:  join-->
    <div id="join" class="row">
        <p>Game name</p>
        <p>
            <img style="margin-right:110px;"  src=" <?php echo base_url(); ?>avatars/pawnJoker.png" height=150 width=150  class="avatar pion"/>
            <img  src=" <?php echo base_url(); ?>avatars/pawnBatman.png" height=150 width=150  class="avatar pion"/>
            <img  src=" <?php echo base_url(); ?>avatars/pawnRobin.png" height=150 width=150  class="avatar pion"/>
            <img  src=" <?php echo base_url(); ?>avatars/pawnGordon.png" height=150 width=150  class="avatar pion"/>
            <img  src=" <?php echo base_url(); ?>avatars/pawnCatwoman.png" height=150 width=150  class="avatar pion"/>
        </p>
        
        <p>Map: Gotham</p>
        <p><input type="text" name="password" placeholder="password"></p>
        <button>Join as Mr.X</button>
        <button>Join as detectives</button>  
    </div>
    
    <!-- Frame 4: host -->
    <div id="host" class="row">
        <p><input type="text" name="password" placeholder="Game name"></p>
        <p>
            <img style="margin-right:110px;"  src=" <?php echo base_url(); ?>avatars/pawnJoker.png" height=150 width=150  class="avatar pion"/>
            <img  src=" <?php echo base_url(); ?>avatars/pawnBatman.png" height=150 width=150  class="avatar pion"/>
            <img  src=" <?php echo base_url(); ?>avatars/pawnRobin.png" height=150 width=150  class="avatar pion"/>
            <img  src=" <?php echo base_url(); ?>avatars/pawnGordon.png" height=150 width=150  class="avatar pion"/>
            <img  src=" <?php echo base_url(); ?>avatars/pawnCatwoman.png" height=150 width=150  class="avatar pion"/>
        </p>
        
        <p>Map: Gotham</p>
        <p><input type="text" name="password" placeholder="password"></p>
        <button onclick="ChangeFrame(3)">Host game</button> 
    </div>
    
    <div id="enter" class="row" style="text-align: center;">
        <button onclick="ChangeFrame(2)">Enter</button>
    </div>
    
    <div class="row" style="height:50px;"></div>
</div>