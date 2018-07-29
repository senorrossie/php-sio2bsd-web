<?php
  include_once("config.inc.php");
  include_once( $cfg["php"]["include"] . "functions.inc.php");

  $_CLEAN["GET"] = clean($_GET);

  if(empty($_CLEAN["GET"])) {
    @include_once( $cfg["atr"]["htmlidx"] );
    die();
  } else {
    $dir=$_CLEAN["GET"]["dir"];
    if( @file_exists($cfg["atr"]["htmlout"] . "dir.dsp.$dir.html")) {
      // Display the cached slider
      @include_once( $cfg["atr"]["htmlout"] . "dir.dsp.$dir.html" );
    }else{
      print("Unable to load contents of folder ". $dir ."\n");
    }
  }
?>