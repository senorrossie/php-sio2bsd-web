#!/usr/bin/php5-cgi
<html>
 <head>
  <title>Pi2SIO WebGUI</title>
   <style type="text/css">
body {
	background-image:url('img/stripes.gif');
	background-color:#ffffff;

	margin: 0 0 0 0;
	overflow: hidden;

	/* height: 100%; */
	width: 100%;
}

#main {
	width: 99%;
	height: 99%;
}

#header {
}

#drives {
	background-color:#333333;
	color: #cccccc;

	/* top, right, bottom, and left */
	margin: 0 1px 2px 5px;
	padding: 0 0 1px 2px;
}
#drives-buttons {
	margin: 5px;
	float: left;
}

#disks {
	overflow: scroll;
	height: 60%;

	margin-left: 35px;
	margin-right: 35px;
	margin-bottom: 5px;

	left: 15px;
	right: 5px;
}

input {
	font: Verdana, Arial;
	font-size: small;
}
  </style>
 </head>
<?php
include( ".config.inc.php" );
 
/**
 * Reads dumped array from disk
 *
 */
function it_get_array_from_disk( $filename="" ) {
  if ( @file_exists($filename) ) {
    $data = @unserialize(file_get_contents($filename));
    return $data;
  } else {
    return false;
  }
}
 
$disk1=$_POST['disk1'];
$disk2=$_POST['disk2'];
$disk3=$_POST['disk3'];
$disk4=$_POST['disk4'];
$do_update=$_POST['update'];
 
isset($disk1) || $disk1=$cfg["atr"]["drive1"];
isset($disk2) || $disk2=$cfg["atr"]["drive2"];
isset($disk3) || $disk3=$cfg["atr"]["drive3"];
isset($disk4) || $disk4=$cfg["atr"]["drive4"];
 
$cmdCLI=$cfg["sio2bsd"]["cmd"] . " " . $cfg["sio2bsd"]["param"];
$cmdCLI.= " -s /dev/" . $cfg["sio2bsd"]["serial"] . " ";
 
if( ($disk1!="-" || $disk2!="-" || $disk3!="-" || $disk4!="-") && (! empty($do_update) ) ) {
  $cmdCLI.="\"" . $disk1 . "\" \"" . $disk2 . "\" \"" . $disk3 . "\" \"" . $disk4 . "\"";
  exec( "pkill -9 sio2bsd" );
  exec( "rm -rf /tmp/sio2bsd*" );
  exec( "nohup " . $cmdCLI . " 1>/var/www/html/sio2bsd.log.txt 2>&1 &" );
}
?>
 <body>
  <div id="main">
   <div id="header">
    <img src="img/logo-color.gif" alt="A T A R I" align="left" border="0" height="60px"/>
    <h1 align="center">Simple WebGUI for /sio2bsd/</h1>
  </div>

  <div id="drives">
   <h2 align="center">Disk Drives [<a href="sio2bsd.log.txt" target="_log">SIO2BSD log</a>]</h2>
   <center>
    <form id="loaddrives" action="<?php echo $PHP_SELF;?>" method="POST">
	 <div id="drives-buttons">
      <button type="reset"><image src="img/reset.png" alt="Reset"></button>
	  <button type="submit" name="update" value="Update Drives"><image src="img/update.png" alt="Update Drives"></button>
	 </div>
     <br />
     <b>[</b>D1:<b>]</b> <input type="text" name="disk1" id="disk1" value="<?php echo $disk1;?>" /> &nbsp;
     <b>[</b>D2:<b>]</b> <input type="text" name="disk2" id="disk2" value="<?php echo $disk2;?>" /> &nbsp;
     <b>[</b>D3:<b>]</b> <input type="text" name="disk3" id="disk3" value="<?php echo $disk3;?>" /> &nbsp;
     <b>[</b>D4:<b>]</b> <input type="text" name="disk4" id="disk4" value="<?php echo $disk4;?>" /> &nbsp;
    </form>
   </center>
  </div>

  <div id="disks">
   <h2 align="center">Available Images [<a href="gen_atrlist.php">Regenerate</a>]</h2>
   <?php
/*
    $atrlist=it_get_array_from_disk( $cfg["atr"]["dump"] );
    foreach( $atrlist as $id=>$filename ) {
     if( stristr( $filename, ".atr" ) ) {
      $leachurl=str_replace( $cfg["atr"]["path"], $cfg["atr"]["link"], $filename );
      print( "<input type=\"button\" value=\"D1\" onClick=\"document.getElementById('disk1').value='$filename';\" /> " );
      print( "<input type=\"button\" value=\"D2\" onClick=\"document.getElementById('disk2').value='$filename';\" /> " );
      print( "<input type=\"button\" value=\"D3\" onClick=\"document.getElementById('disk3').value='$filename';\" /> " );
      print( "<input type=\"button\" value=\"D4\" onClick=\"document.getElementById('disk4').value='$filename';\" /> " );
      print( "<input type=\"button\" name=\"update\" value=\"Upd.\" onclick=\"document.getElementById('loaddrives').submit();\" /> " );
      print( " <a href=\"$leachurl\">$filename</a><br />" );
     }
    }
*/
     include_once( $cfg["atr"]["htmlout"] );
	print( "&nbsp;" );
   ?>
  </div>
 </div> <!--// Main //-->
 </body>
</html>
