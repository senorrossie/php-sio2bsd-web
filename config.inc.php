<?php
	/** Config file
	 * For those that prefer full path:
	 *   $cfg["php"]["base"]="/var/www/html/new/";                  // basedir
	 *   $cfg["php"]["include"]=$cfg["php"]["base"]."inc/";         // Include directory
	 *
	 * Otherwise, relative to the current dir also works:
	 *   $cfg["php"]["base"]="./";                                  // basedir
	 *   $cfg["php"]["include"]=$cfg["php"]["base"]."inc/";         // Include directory
	**/
	/*** Script ***/
	$cfg["php"]["basedir"]="./";                                    // base directory
	$cfg["php"]["baseurl"]="/new/";                                 // base url
	$cfg["php"]["include"]=$cfg["php"]["basedir"]."inc/";           // Include directory
	/*** Disks ***/
	$cfg["atr"]["path"]=$cfg["php"]["basedir"]."fandal/";           // location of atr/xex/... files
	$cfg["atr"]["cache"]=$cfg["php"]["basedir"].".cache/";          // location of cache directory
	$cfg["atr"]["dump"]=$cfg["php"]["basedir"]."atrlist.ser.php";   // location of serialized file(atr) list
	$cfg["atr"]["tree"]=$cfg["php"]["basedir"]."pathtree.ser.php";  // location of serialized pathlist file
	$cfg["atr"]["htmlout"]=$cfg["atr"]["cache"]."html/";            // location of generated html files
	$cfg["atr"]["htmlidx"]=$cfg["php"]["basedir"]."main.html";      // location of generated html files
	$cfg["atr"]["link"]="";                             					  // path to download symlink
	$cfg["atr"]["drive1"]="-";                 						          // default disk in D1: (- = empty drive)
	$cfg["atr"]["drive2"]="-";            					                // default disk in D2: (- = empty drive)
	$cfg["atr"]["drive3"]="-";            					                // default disk in D3: (- = empty drive)
	$cfg["atr"]["drive4"]="-";             						              // default disk in D4: (- = empty drive)
	/*** Webpage ***/
	$cfg["html"]["ajax"]="true";
	/*** SIO2BSD ***/
	$cfg["sio2bsd"]["cmd"]="/usr/bin/sio2bsd";      					      // location of the sio2bsd binary
	$cfg["sio2bsd"]["param"]="";
	$cfg["sio2bsd"]["serial"]="ttyUSB0";        					          // atari8warez dual usb: ttyUSB0 || sio2pi: ttyAMA0
?>
