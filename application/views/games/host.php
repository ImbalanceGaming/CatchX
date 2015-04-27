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

