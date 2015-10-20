<?php
/* ***********************************************************************
   **	gD  library of Content Management System	    		**
   ***********************************************************************
   ** Created 22-9-04 Erwin Marges					**
   *********************************************************************** */

class gd{
	var $news_title;
	var $news_image;
	var $news_short;
	var $news_message;
	
	function resize($file,$des,$q, $sz) {
		list($im_width,$im_height,$type,$rest) = getimagesize($file);
		switch($type) {
			case IMAGETYPE_JPEG:
				$im = imagecreatefromjpeg($file);
				break;
			case IMAGETYPE_PNG:
				$im = imagecreatefrompng($file);
				break;
			case IMAGETYPE_GIF:
				$im = imagecreatefromgif($file);
				break;
			default:
				unlink($file);
				die("Dit afbeeldingsformaat wordt niet ondersteund ($file)");
				break;
		}
		if($im_width >= $im_height) {
			$factor = $sz / $im_width;
			$new_width = $sz;
			$new_height = $im_height * $factor;
		}
		else
		{
			$factor = $sz / $im_height;
			$new_height = $sz;
			$new_width = $im_width * $factor;
		}
		$new_im=imagecreatetruecolor($new_width,$new_height);
		ImageCopyResized($new_im, $im, 0, 0, 0, 0, $new_width, $new_height, $im_width, $im_height);
		imagejpeg ($new_im,$des,$q);
		ImageDestroy($im);
		ImageDestroy($new_im);
	}
	
	function ImageCopyResampleBicubic (&$dst_img, &$src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h)
	{        
  		$palsize = ImageColorsTotal ($src_img);
  		for ($i = 0; $i < $palsize; $i++)
  		{  
    		$colors = ImageColorsForIndex ($src_img, $i);
    		ImageColorAllocate ($dst_img, $colors['red'], $colors['green'], $colors['blue']);
  		}
  		$scaleX = ($src_w - 1) / $dst_w;
  		$scaleY = ($src_h - 1) / $dst_h;
  		$scaleX2 = (int) ($scaleX / 2);
  		$scaleY2 = (int) ($scaleY / 2);
  		$dstSizeX = imagesx( $dst_img );
  		$dstSizeY = imagesy( $dst_img );
  		$srcSizeX = imagesx( $src_img );
  		$srcSizeY = imagesy( $src_img );
  		for ($j = 0; $j < ($dst_h - $dst_y); $j++)
  		{
    		$sY = (int) ($j * $scaleY) + $src_y;
    		$y13 = $sY + $scaleY2;
    		$dY = $j + $dst_y;
    		if (($sY > $srcSizeY) or ($dY > $dstSizeY))
      			break 1;
    		for ($i = 0; $i < ($dst_w - $dst_x); $i++)
    		{
      			$sX = (int) ($i * $scaleX) + $src_x;
      			$x34 = $sX + $scaleX2;
      			$dX = $i + $dst_x;
      			if (($sX > $srcSizeX) or ($dX > $dstSizeX))
        			break 1;
      			$color1 = ImageColorsForIndex ($src_img, ImageColorAt ($src_img, $sX, $y13));
      			$color2 = ImageColorsForIndex ($src_img, ImageColorAt ($src_img, $sX, $sY));
      			$color3 = ImageColorsForIndex ($src_img, ImageColorAt ($src_img, $x34, $y13));
      			$color4 = ImageColorsForIndex ($src_img, ImageColorAt ($src_img, $x34, $sY));
      			$red = ($color1['red'] + $color2['red'] + $color3['red'] + $color4['red']) / 4;
      			$green = ($color1['green'] + $color2['green'] + $color3['green'] + $color4['green']) / 4;
      			$blue = ($color1['blue'] + $color2['blue'] + $color3['blue'] + $color4['blue']) / 4;
      			ImageSetPixel ($dst_img, $dX, $dY,ImageColorClosest ($dst_img, $red, $green, $blue));
    		}
  		}
	}	
}
?>

