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

