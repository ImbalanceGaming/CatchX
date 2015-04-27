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