#!/usr/bin/php5-cgi
<?php
  include("config.inc.php");
  include_once( $cfg["php"]["include"] . "functions.inc.php");
 
  $mytree=it_get_dirtree($cfg["atr"]["path"], true );
  it_dump_array_to_disk( $cfg["atr"]["tree"], $mytree);
  
  print ( count($mytree) ." entries found!\n");
?>