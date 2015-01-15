<div class="container" id="gamesHost">
    <h2>Join</h2>
    <?php
        $hiddenArray = array(
            'gameName'=>$gameName
        );
        echo validation_errors();
        echo form_open('games/checkPassword','',$hiddenArray);
        echo "<div style='margin-bottom: 10px;'>";
        echo "Enter Password: ";
        echo form_password('password');
        echo "</div>";
        echo "<div>";
        echo form_submit('sumbit', 'Submit');
        echo "</div>";
        echo form_close();
    ?>
</div>

