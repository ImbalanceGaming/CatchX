<?php

?>

<div class="container-fluid" id="gamesIndex" style="text-align:center; ">
    <h1> <?php echo img('images/homeBanner.png');?> Games</h1>
    
    
    <?php
            foreach($gameNames as $gameName)
            {
                ?>
                <a href="<?php echo site_url('/games/join/' . $gameName); ?>">
                        
                <div class="col-sm-12 game" style="">
                    <p><?php echo $gameName ?></p>
                </div>
                </a>
                <?php 
            }
        ?>
    <form action="<?php echo site_url('/games/host'); ?>">
        <input type="submit" value="Host game" style="">
    </form>
</div>