#!/usr/bin/php5-cgi
<html>
 <head>
  <title>Pi2SIO WebGUI</title>
   <style type="text/css">
body {
	background-image:url('img/stripes.gif');
	background-color:#ffffff;
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
  <center><img src="img/logo-color.gif" alt="A T A R I" align="middle" border="0" /></center>
  <h1 align="center">Simple WebGUI for /sio2bsd/</h1>
  <hr>
  <table with="90%" align="center" border="0">
   <tr>
    <th>Drives [<a href="sio2bsd.log.txt" target="_log">SIO2BSD log</a>]</td>
    <th>Available Images [<a href="gen_atrlist.php">Regenerate</a>]</td>
   <tr>
   <tr>
    <td valign="top">
     <form id="loaddrives" action="<?php echo $PHP_SELF;?>" method="POST">
      D1: <input type="text" name="disk1" id="disk1" value="<?php echo $disk1;?>" /><br />
      D2: <input type="text" name="disk2" id="disk2" value="<?php echo $disk2;?>" /><br />
      D3: <input type="text" name="disk3" id="disk3" value="<?php echo $disk3;?>" /><br />
      D4: <input type="text" name="disk4" id="disk4" value="<?php echo $disk4;?>" /><br />
      <br />
      <input type="reset">
      <input type="submit" name="update" value="Update Drives">
     </form>
    </td>
    <td>
     <?php
      $atrlist=it_get_array_from_disk( $cfg["atr"]["dump"] );
      foreach( $atrlist as $id=>$filename ) {
	if( stristr( $filename, ".atr" ) ) {
          $leachurl=str_replace( $cfg["atr"]["path"], $cfg["atr"]["link"], $filename );
	  print( "<input type=\"button\" value=\"D1\" onClick=\"document.getElementById('disk1').value='$filename';\" /> " );
	  print( "<input type=\"button\" value=\"D2\" onClick=\"document.getElementById('disk2').value='$filename';\" /> " );
	  print( "<input type=\"button\" value=\"D3\" onClick=\"document.getElementById('disk3').value='$filename';\" /> " );
	  print( "<input type=\"button\" value=\"D4\" onClick=\"document.getElementById('disk4').value='$filename';\" /> " );
	  print( "<input type=\"button\" name=\"update\" value=\"Upd.\" onclick=\"document.getElementById('loaddrives').submit();\" /> " );
	  print( " <a href=\"$leachurl\">$filename</a>" );
	  print( "<br />\n" );
        }
      }
     ?>
    </td>
   </tr>
  </table>
 </body>
</html>
