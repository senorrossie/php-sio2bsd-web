#!/usr/bin/php5-cgi
<?php
  include(".config.inc.php");
 
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

  /**
   * Sucks given directory into a sorted array
   * Recurses into subdirs if asked
   *
   */
  function it_get_dir($directory, $recurse="true" ) {
    // Disable directory traversal
    if ( strstr ( $directory, ".." ) ) {
      return false;
    }
    $Dir = opendir( $directory );
    $num = 0;
 
    // false !== ... evades problems when encountering '0' or 'false' in names.
    while( false !== ($file = readdir( $Dir )) ) {
      $filename = $directory . $file;
      if( ! is_link($filename) ) {
        if( ! is_dir($filename) ) {
          // FOUND: Regular file
          $filelist[$num] = $filename;
          $num++;
        } elseif( $recurse ) {
          // FOUND: Directory
          if ( $file != "." && $file != ".." ) {
            $subdir = it_get_dir($filename . "/", $recurse );
            $subdirlist = array_merge( (array)$filelist, (array)$subdir );
            $num = count( $subdirlist ) + 1;
            $filelist = $subdirlist;
          }
        }
      }
    }
    @closedir( $Dir );
 
    if( ! empty($filelist) ) {
      rsort($filelist);
      reset($filelist);
    }
    return $filelist;
  }
 
  /**
   * Dumps array to disk, no more, no less
   *
   */
  function it_dump_array_to_disk( $filename="", $data=array() ) {
    if ( @is_writable($filename) || @file_exists($filename) === false ) {
      if (!$fd = @fopen($filename, 'w')) {
        return false;
      }
 
      if( @fwrite($fd, serialize($data)) === FALSE ) {
        @fclose($fd);
        return false;
      } else {
        fclose($fd);
      }
    }
  }
 
  function dump_array_to_html( $filename="", $data=array() ) {
    global $cfg;
    if ( @is_writable($filename) || @file_exists($filename) === false ) {
      if (!$fd = @fopen($filename, 'w')) {
        return false;
      }

      foreach( $data as $id=>$imgname ) {
        if( stristr( $imgname, ".atr" ) ) {
          $shortname=str_replace( $cfg["atr"]["path"], $cfg["atr"]["link"], $imgname );
          $atrname=basename( $imgname, ".atr" );
          $htmlout="<input type=\"button\" value=\"D1\" onClick=\"document.getElementById('disk1').value='$imgname';\" /> ";
          $htmlout.="<input type=\"button\" value=\"D2\" onClick=\"document.getElementById('disk2').value='$imgname';\" /> ";
          $htmlout.="<input type=\"button\" value=\"D3\" onClick=\"document.getElementById('disk3').value='$imgname';\" /> ";
          $htmlout.="<input type=\"button\" value=\"D4\" onClick=\"document.getElementById('disk4').value='$imgname';\" /> ";
          $htmlout.="<input type=\"button\" name=\"update\" value=\"Upd.\" onclick=\"document.getElementById('loaddrives').submit();\" /> ";
          $htmlout.=" <a href=\"$shortname\">$atrname</a><br />\n";
          if( @fwrite($fd, $htmlout) === FALSE ) {
            @fclose($fd);
            return false;
          }
        }
      }
      fclose($fd);
    }
  }

  //$atrlist=it_get_dir($cfg["atr"]["path"], true );
  $atrlist=it_get_array_from_disk( $cfg["atr"]["dump"] );
  //it_dump_array_to_disk( $cfg["atr"]["dump"], $atrlist);
  dump_array_to_html( $cfg["atr"]["htmlout"], $atrlist);
  print (count($atrlist) . " images found!");
?>
