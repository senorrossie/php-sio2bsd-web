#!/usr/bin/php5-cgi
<?php
  include_once("config.inc.php");
  include_once( $cfg["php"]["include"] . "functions.inc.php");

  //$_CLEAN["GET"] = clean($_GET);

  if(empty($_GET)) {
    die( "Not loaded any disks.\n");
  } else {
    $drives=json_decode($_GET["drives"], true);

    $cmdCLI=$cfg["sio2bsd"]["cmd"] . " " . $cfg["sio2bsd"]["param"];
    $cmdCLI.= " -s /dev/" . $cfg["sio2bsd"]["serial"] . " "; 

    foreach( $drives as $id=>$floppy) {
      isset($floppy) || $drives[$id]=$cfg["atr"]["drive".$id];
      print( "[D". $id ."]:". $drives[$id] ." ");
      $c=1;
      $cmdCLI.="\"". str_replace( "./", $cfg["php"]["basedir"], $drives[$id], $c) ."\" ";
    }
    exec( "pkill -9 sio2bsd" );
    exec( "rm -rf /tmp/sio2bsd*" );
    exec( "nohup ". $cmdCLI ." 1>".  $cfg["php"]["basedir"] ."sio2bsd.log.txt 2>&1 &" );
  }
?>