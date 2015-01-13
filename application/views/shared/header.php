<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
	<title>CatchX</title>   
        
        <?php         
            echo link_tag('css/bootstrap.min.css');
            //echo link_tag('css/bootstrap-theme.min.css');
            echo link_tag('css/style.css');
        ?>
        
        <script type="text/javascript" src="<?php echo base_url();?>js/jquery-2.1.3.min.js" ></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/bootstrap.min.js" ></script>
</head>
<body>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">CatchX</a>
        </div>
        <div>
          <ul class="nav navbar-nav">
              <li><a href="#">Home</a></li>
            <li><a href="#">Games</a></li>
            <li><a href="#">Host game</a></li> 
            <li><a href="#">Tutorial</a></li> 
          </ul>
        </div>
      </div>
    </nav>
