<div class="container" id="gamesHost">
<h2>Host</h2>
    <?php 
    echo validation_errors();
    echo form_open(); 

    $data = array(
              'name'        => 'gameName',
              'id'          => 'name',
              'value'       => set_value('gameName'),
              'maxlength'   => '50',
              'size'        => '50',
              'style'       => 'width:50%',
            );
    echo form_label("Game name:","name");
    echo ("<br>");
    echo form_input($data);
    echo ("<br>");

    $data = array(
              'name'    => 'password',
              'id'          => 'password',
              'value'       => set_value('password'),
              'maxlength'   => '50',
              'size'        => '50',
              'style'       => 'width:50%',
            );
    echo form_label("Password:","password");
    echo ("<br>");
    echo form_password($data);
    echo ("<br><br>");
    echo form_submit('host', 'Host game');

  ?>
</div>

