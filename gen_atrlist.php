#!/usr/bin/php5-cgi
<?php
  include(".config.inc.php");
 
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
          $dirlist[$num] = $filename;
          $num++;
        } elseif( $recurse ) {
          // FOUND: Directory
          if ( $file != "." && $file != ".." ) {
            $subdir = it_get_dir($filename . "/", $recurse );
            $subdirlist = array_merge( (array)$dirlist, (array)$subdir );
            $num = count( $subdirlist ) + 1;
            $dirlist = $subdirlist;
          }
        }
      }
    }
    @closedir( $Dir );
 
    if( ! empty($dirlist) ) {
      rsort($dirlist);
      reset($dirlist);
    }
    return $dirlist;
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
 
  $atrlist=it_get_dir($cfg["atr"]["path"], true );
  it_dump_array_to_disk( $cfg["atr"]["dump"], $atrlist);

  print (count($atrlist) . " images found!");
?>
