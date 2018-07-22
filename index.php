#!/usr/bin/php5-cgi
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Web Experiments</title>

		<!-- /// Styling /// -->
		<!-- Add icon library -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Add main styling -->
		<link rel="stylesheet" href="css/tpl-plain.css">

		<script src="js/ajax.js"></script>
		<script src="js/slide.js"></script>
		<script src="js/dragndrop.js"></script>
	</head>
	<body>
		<div class="icon-bar">
			<a class="active" href="<?php echo($_SELF);?>"><span class="glyphicon glyphicon-home"></span></a>
			<br />
			<a href="#" id="refresh" onclick="loadDoc('gen_pathtree.php', 'msg-bar');"><span class="glyphicon glyphicon-refresh"></span></a>
			<br />
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
