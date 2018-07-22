#!/usr/bin/php5-cgi
<?php
  include_once("config.inc.php");
	include_once( $cfg["php"]["include"] . "functions.inc.php");

	function dump_array_to_html( $filename="", $data=array(), $parent="") {
		global $cfg;
		$filename=$cfg["atr"]["htmlout"].$filename;
		if ( @is_writable($filename) || @file_exists($filename) === false ) {
			print( "Attempting write to ". $filename ."\n");
			if (!$fd = @fopen($filename, 'w')) {
				return false;
			}
			$c=0;
			$noimage="img/noss.png";
			$htmlout="<!-- Add main styling -->\n<link rel=\"stylesheet\" href=\"css/slide.css\">";
			$htmlout.="\n<!-- Container for the image gallery -->\n<div class=\"slider-container\">\n";
			if( @fwrite($fd, $htmlout) === FALSE ) {
				@fclose($fd);
				return false;
			}

			$slideout="\n<!-- Next and previous buttons -->\n<a class=\"prev\" onclick=\"plusSlides(-1)\">&#10094;</a>\n<a class=\"next\" onclick=\"plusSlides(1)\">&#10095;</a>\n";
			$slideout.="\n<!-- Image text -->\n<div class=\"caption-container\"><p id=\"caption\"></p></div>\n";
			$slideout.="\n<!-- Thumbnail images -->\n<div class=\"galleryrow\">\n";
			foreach( $data as $id=>$imgname ) {
				if( is_array($imgname)) {
					print( "Opening dir ". $id ." in ". $parent ."\n");
					dump_array_to_html("dir.dsp.".$parent."-".$id.".html", $data[$id], $parent."-".$id);
				} else {
					if( stristr( $imgname, ".atr" ) ) {
						$c++;
						$shortname=str_replace( $cfg["atr"]["path"], $cfg["atr"]["link"], $imgname );
						$atrname=basename( $imgname, ".atr" );
						$download=str_replace( $cfg["php"]["basedir"], "", $imgname );
						$image=str_replace(".atr", ".png", $download );
						if( file_exists($image) !== FALSE ) {
							$htmlout="<div class=\"mainSlide\"><img src=\"$image\" style=\"width:100%\"></div>\n";
							$slideout.="<div class=\"column\"><img class=\"thumb cursor\" src=\"$image\" style=\"width:100%\" id=\"$shortname\" draggable=\"true\" ondragstart=\"drag(event)\" onclick=\"currentSlide($c)\" alt=\"$shortname\"></div>\n";
						} else {
							$htmlout="<div class=\"mainSlide\"><img src=\"$noimage\" style=\"width:100%\"></div>\n";
							$slideout.="<div class=\"column\"><img class=\"thumb cursor\" src=\"$noimage\" style=\"width:100%\" id=\"$shortname\" draggable=\"true\" ondragstart=\"drag(event)\" onclick=\"currentSlide($c)\" alt=\"$shortname\"></div>\n";
						}
						if( @fwrite($fd, $htmlout) === FALSE ) {
							@fclose($fd);
							return false;
						}
					}
				}
			}
			$slideout.="</div></div>\n";
			//$slideout.="<script src=\"js/slide.js\"></script>\n";
			if( @fwrite($fd, $slideout) === FALSE ) {
				@fclose($fd);
				return false;
			} else {
				fclose($fd);
			}
		}
	}

	if( @file_exists($cfg["atr"]["tree"]) ){
		$mytree=it_get_array_from_disk($cfg["atr"]["tree"]);
	} else {
		die("Unable to read the tree\n");
	}

	/** Is our output directory in place? */
	if( file_exists($cfg["atr"]["htmlout"]) === FALSE) {
		@mkdir( $cfg["atr"]["htmlout"], 0775);
	}

	$dir="root";
	//var_dump($mytree);
	dump_array_to_html("dir.dsp.".$dir.".html", $mytree);
?>