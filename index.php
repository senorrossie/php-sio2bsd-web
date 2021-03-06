<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Web Experiments</title>

		<!-- /// Favicon /// -->
		<!-- sio2raspi -->
		<link rel="icon" href="favicon-rpi.ico">
		<!-- sio2bananapi
		<link rel="icon" href="favicon-bpi.ico">
		-->

		<!-- /// Styling /// -->
		<!-- Add icon library -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Add main styling -->
		<link rel="stylesheet" href="css/tpl-plain.css">

		<script src="js/ajax.js"></script>
		<script src="js/fdd.js"></script>
		<script src="js/dragndrop.js"></script>
		<script src="js/slide.js"></script>
	</head>
	<body>
		<div class="icon-bar">
			<?php
				@include_once( "config.inc.php");
				@include_once( $cfg["php"]["include"] . "functions.inc.php");
				$_CLEAN["SELF"] = clean($_SERVER["PHP_SELF"]);
			?>
			<a class="active" href="<?php echo $_CLEAN["SELF"];?>"><span class="glyphicon glyphicon-home"></span></a>
			<a href="<?php echo $cfg["sio2bsd"]["printer"]="P1.txt";?>" id="printer"><span class="glyphicon glyphicon-print"></span></a>
			<br />
			<a href="#" id="refresh" onclick="loadDoc('gen_pathtree.php', 'msg-bar');"><span class="glyphicon glyphicon-refresh"></span></a>
			<a href="#"><div id="eject" ondrop="eject(event)" ondragover="allowDrop(event)"><span class="glyphicon glyphicon-eject"></span></div></a>
			<br />
			<a href="#"><div id="drive1" ondrop="drop(event)" ondragover="allowDrop(event)"><span class="glyphicon glyphicon-floppy-disk"></span></div></a>
			<a href="#"><div id="drive2" ondrop="drop(event)" ondragover="allowDrop(event)"><span class="glyphicon glyphicon-floppy-disk"></span></div></a>
			<a href="#"><div id="drive3" ondrop="drop(event)" ondragover="allowDrop(event)"><span class="glyphicon glyphicon-floppy-disk"></span></div></a>
			<a href="#"><div id="drive4" ondrop="drop(event)" ondragover="allowDrop(event)"><span class="glyphicon glyphicon-floppy-disk"></span></div></a>
			<br />
		</div>
		<div id="msg-bar" class="hdr-msg-bar">
		  No messages found
		</div>
		<div id="folder-nav" class="hdr-folder-nav">
			<div id="folder-hdr">Folders:</div>
			<div class="folder-tree">
				<?php
				  if( FALSE === @include($cfg["atr"]["htmlout"]."folders.html")) {
						include( "folders.html");
					}
				?>
	        </div>
		</div>
		<div id="main" class="main">
			<?php
				if( FALSE === @include($cfg["atr"]["htmlout"]."main.html")) {
					include( "main.html");
				}
			?>
		</div>
	</body>
</html>
