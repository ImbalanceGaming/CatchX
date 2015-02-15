<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/css/game/style.css">
	<link rel="stylesheet" href="<?php echo base_url();?>css/game/jquery.mCustomScrollbar.css" />
	
	<script src="<?php echo base_url();?>js/jquery-2.1.3.min.js"></script>
	<script src="<?php echo base_url();?>js/jquery.animate-colors-min.js"></script>
	<script src="<?php echo base_url();?>js/panzoom.js"></script>
	
        <script src="<?php echo base_url();?>js/game/selection.js"></script>
	<script src="<?php echo base_url();?>js/game/graph.js"></script>
	<script src="<?php echo base_url();?>js/game/player.js"></script>
	<script src="<?php echo base_url();?>js/game/log.js"></script>
	<script src="<?php echo base_url();?>js/game/game.js"></script>
        <script src="<?php echo base_url();?>js/game/ajaxCalls.js"></script>
        <script src="<?php echo base_url();?>js/game/helper.js"></script>
        <script src="<?php echo base_url();?>js/game/initialize.js"></script>
        <script src="<?php echo base_url();?>js/game/turnSign.js"></script>
        <script>
            var baseUrl = '<?php echo base_url();?>';
            var side = '<?php echo $side;?>';
        </script>
</head>
<body>
	<audio preload="auto" autobuffer id="audioPlayer"> 
	  <source src="<?php echo base_url();?>audio/Batman/BatmanMove1.wav" />
	</audio>
	<div id="outer">
		
		<div id="hud">
			<div id="topHudElement">
				<div id="innerHud">
					<div id="hudEvil">
						<div id="p0portret" class="hudPortret"><img src="<?php echo base_url();?>avatars/jokerPortret.png" height="80" width="60"></div>
						<div style="clear:both;"></div>
					</div>
					<div id="hudGood">
						<div id="p1portret" class="hudPortret"><img src="<?php echo base_url();?>avatars/batmanPortret.png" height="80" width="60"></div>
						<div id="p2portret" class="hudPortret"><img src="<?php echo base_url();?>avatars/robinPortret.png" height="80" width="60"></div>
						<div id="p3portret" class="hudPortret"><img src="<?php echo base_url();?>avatars/gordonPortret.png" height="80" width="60"></div>
						<div id="p4portret" class="hudPortret"><img src="<?php echo base_url();?>avatars/catwomanPortret.png" height="80" width="60"></div>
						
						<div style="clear:both;"></div>
					</div>
					
					<div style="clear:both;"></div>
					
					
				</div>
			</div>
		</div>
		
		<div id="map">
			<svg width="4357" height="6581">
			</svg>
		</div>
		<div id="logOuter">
			<div id="log">			
				<div id="logInner">				
					<div class="hudBlock" style="color:white; background-color:purple;">?</div>				
				</div>			
			</div>
		</div>
		<div id="bottomHudElement">
			<div id="bottomHudElementInner">
			</div>			
		</div>
		<div id="doubleAndJokerTickets">
			<input id="doubleCheckbox" type="checkbox" >
			<label for="doubleCheckbox" class="css-label">double x</label><span id="doubleTicketsValue"></span>
			<br>
			<input id="hiddenCheckbox" type="checkbox" >
			<label for="hiddenCheckbox" class="css-label">hidden x</label><span id="hiddenTicketsValue"></span>
		</div>
	</div>
	
	
	<script src="<?php echo base_url();?>js/jquery.mCustomScrollbar.concat.min.js"></script>
</body>
</html>