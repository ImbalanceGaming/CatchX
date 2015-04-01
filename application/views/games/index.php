<?php

?>

<div class="container" id="gamesIndex">
    <h1>Games</h1>
    <p>Click on a game name in order to join that game. You will need a password to complete the join.</p>            
    <table class="table">
      <thead>
        <tr>
          <th>Game name</th>
        </tr>
      </thead>
      <tbody>
        <?php
            foreach($games as $game)
            {
                ?>
                <tr>
                    <td>
                        <a href="<?php echo site_url('/games/join/' . $game->name); ?>">
                        <?php echo $game->name ?>
                        </a>
                    </td>
                </tr
                <?php 
            }
        ?>
      </tbody>
    </table>
    <a href="<?php echo site_url('/games/host'); ?>"><h2>Host a game</h2></a>
</div>