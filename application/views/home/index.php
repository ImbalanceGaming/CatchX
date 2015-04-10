<script>
    
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
            <button onclick="GetGames()" class="button-small">Refresh</button><br>
            <button onclick="ChangeFrame(4)">Host game</button>
        </div>
    </div>
    <!-- frame2 -->
    
    <!-- Frame 3:  join-->
    <div id="join" class="row">
        <p>Game name: <span id="joinGameNameView"></span></p>
        <p>
            <img style="margin-right:110px;"  src=" <?php echo base_url(); ?>avatars/pawnJoker.png" height=150 width=150  class="avatar pion"/>
            <img  src=" <?php echo base_url(); ?>avatars/pawnBatman.png" height=150 width=150  class="avatar pion"/>
            <img  src=" <?php echo base_url(); ?>avatars/pawnRobin.png" height=150 width=150  class="avatar pion"/>
            <img  src=" <?php echo base_url(); ?>avatars/pawnGordon.png" height=150 width=150  class="avatar pion"/>
            <img  src=" <?php echo base_url(); ?>avatars/pawnCatwoman.png" height=150 width=150  class="avatar pion"/>
        </p>
        
        <p>Map: Gotham</p>
        <div id="joinValidationErrors"></div>
        <p><input type="password" id="joinPassword" name="password" placeholder="password"></p>
        <input type="hidden" id="joinGameName" value="">
        <button>Join as Mr.X</button>
        <button onclick="Join()">Join as detectives</button><br>
        <button onclick="ChangeFrame(2)" class="button-small" >Go back</button>
    </div>
    <!-- /frame3 -->
    
    <!-- Frame 4: host -->
    <div id="host" class="row">    
        <p>
            <img style="margin-right:110px;"  src=" <?php echo base_url(); ?>avatars/pawnJoker.png" height=150 width=150  class="avatar pion"/>
            <img  src=" <?php echo base_url(); ?>avatars/pawnBatman.png" height=150 width=150  class="avatar pion"/>
            <img  src=" <?php echo base_url(); ?>avatars/pawnRobin.png" height=150 width=150  class="avatar pion"/>
            <img  src=" <?php echo base_url(); ?>avatars/pawnGordon.png" height=150 width=150  class="avatar pion"/>
            <img  src=" <?php echo base_url(); ?>avatars/pawnCatwoman.png" height=150 width=150  class="avatar pion"/>
        </p>
        
        <p>Map: Gotham</p>
        <div id="hostValidationErrors"></div>
        <p><input id="hostGameName" type="text" name="gameName" placeholder="Game name"> <input id="hostPassword" type="password" name="password" placeholder="password"></p>
        <button onclick="Host()">Host game</button><br>
        <button onclick="ChangeFrame(2)" class="button-small" >Go back</button>
    </div>
    <!-- /frame4 -->
    
    <div id="enter" class="row" style="text-align: center;">
        <button onclick="ChangeFrame(2)">Enter</button>
    </div>
    
    <div class="row" style="height:50px;"></div>
</div>