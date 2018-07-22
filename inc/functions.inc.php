<?php
  /**
   * Clean GLOBAL vars
   */
  function clean($elem) { 
    if(!is_array($elem)) {
      $elem = htmlentities($elem,ENT_QUOTES,"UTF-8"); 
    } else {
      foreach ($elem as $key => $value) {
        $key = clean($key);
        $elem[$key] = clean($value);
      }
    }
    return $elem; 
  }
 
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
      $filelist["count"]=count( $filelist ) + 1;
    }
    return $filelist;
  }

  /**
   * Sucks given directory into a sorted array tree
   * Recurses into subdirs if asked
   *   [file] => directory . filename
   *   [directory] => array();
   *
   */
  function it_get_dirtree($directory, $recurse="true" ) {
    // Disable directory traversal
    if ( strstr ( $directory, ".." ) ) {
      return false;
    }
    $Dir = opendir( $directory );
    $filelist=array();
 
    // false !== ... evades problems when encountering '0' or 'false' in names.
    while( false !== ($file = readdir( $Dir )) ) {
      $filename = $directory . $file;
      if( ! is_link($filename) ) {
        if( ! is_dir($filename) ) {
          // FOUND: Regular file
          //print("Filename: ". $file ."\n");
          $filelist[$file] = $filename;
        } elseif( $recurse ) {
          // FOUND: Directory
          //print("Directory: ". $file ."\n");
          if ( $file != "." && $file != ".." ) {
            $subdir = it_get_dirtree($filename . "/", $recurse );
            $filelist[$file] = (array)$subdir;
          }
        }
      }
    }
    @closedir( $Dir );
 
    if( ! empty($filelist) ) {
      krsort($filelist);
      reset($filelist);
    }
    return $filelist;
  }
?>