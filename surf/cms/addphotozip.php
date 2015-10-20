<?php
/* start output buffering */
ob_start();

/* start the session */
session_start();

/* includes */
include "library/config.inc.php";
include "library/layout.lib.php";
include "library/login.lib.php";
include "library/db.lib.php";

/* includes for this file */
include "library/event.lib.php";
include "library/gd.lib.php";

/* start db */
$db = new dataBase();
$db->initialise($mysql_user, $mysql_password, $mysql_host, $mysql_dbName);

/* start lay_out */
$lay_out = new LayOut();

$gd = new gd();

/* check for login */
if ($_SESSION[user_loggedIn] == true)
{
	/* Login = ok */
	$event = new event;
	if ($_POST[addphoto] == true)
	{
		//for($i=0; $i<2; $i++;){
		$i=0;
		while($i!=10){
			$i++;
			$image1 = "image$i";
			//echo "$image1<br />";
			//	if(move_uploaded_file($_FILES['image1']['tmp_name'], $uploaddir . $file)){
			// print_r($_FILES);
			$row++;
			$zip = zip_open("/tmp/test2.zip");

			if(($image = $_FILES[$image1]["tmp_name"])!= "none"){

				while ($zip_entry = zip_read($zip)) {
					echo "Naam:                      " . zip_entry_name($zip_entry) . "\n";
					echo "Werkelijke grootte:        " . zip_entry_filesize($zip_entry) . "\n";
					echo "Gecomprimeerde grootte:    " . zip_entry_compressedsize($zip_entry) . "\n";
					echo "Compressie methode:        " . zip_entry_compressionmethod($zip_entry) . "\n";

					if (zip_entry_open($zip, $zip_entry, "r")) {
						echo "Inhoud bestand:\n";
						$buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
						echo "$buf\n";





						$file = zip_entry_name($zip_entry) ;
						$image = $buf;
						//$type = $_FILES[$image1]["type"];
						$size = getimagesize($image);
						$path = $event_photoDir;
						$maxfilesize = $_POST['MAX_FILE_SIZE']/1024;
						$max_height = $event_photoSizeSmall;
						$step = $size[1] / $max_height;
						$width = $size[0] / $step;
						$max_width = $width;
						$quality = "90";
						set_time_limit("0");

					//	if ($type == "image/pjpeg" OR $type == "image/jpeg")
						//{
							$query = "insert into foto (event_id, foto_userId) VALUES ('$_POST[event_id]', '$_SESSION[user_id]')";
							mysql_query($query) or die("error");
							$query = "SELECT foto_id FROM foto WHERE event_id = '$_POST[event_id]' AND foto_userId = '$_SESSION[user_id]' ORDER BY foto_id DESC LIMIT 1";
							$sql = mysql_query($query);
							if($obj = mysql_fetch_object($sql))
							$foto_id = $obj->foto_id;
							$name = "$foto_id-thumb.jpg";
							$src_img = ImageCreateFromJPEG($image);
							$img_w = imagesx($src_img);
							$img_h = imagesy($src_img);
							//echo $img_w."x".$img_h."--> \n";
							if ($img_w > $img_h)
							{
								if ($img_w > $max_width)
								{
									$dst_w = $max_width;
									$factor = $img_w / $dst_w;
									$dst_h = $img_h / $factor;
								}
								else
								{
									$dst_w = $img_w;
									$dst_h = $img_h;
								}
							}
							else
							{
								if ($img_h > $max_height)
								{
									$dst_h = $max_height;
									$factor = $img_h / $dst_h;
									$dst_w = $img_w / $factor;
								}
								else
								{
									$dst_w = $img_w;
									$dst_h = $img_h;
								}
							}
							//echo $dst_w."x".$dst_h."<br>\n";
							ob_start();
							phpinfo(8);
							$phpinfo=ob_get_contents();
							ob_end_clean();
							$phpinfo=strip_tags($phpinfo);
							$phpinfo=stristr($phpinfo,"gd version");
							$phpinfo=stristr($phpinfo,"version");
							$end=strpos($phpinfo," ");
							$phpinfo=substr($phpinfo,0,$end);
							$phpinfo=substr($phpinfo,7);
							if(version_compare("2.0", "$phpinfo")==1)
							$dst_img = imagecreate($dst_w,$dst_h);
							else
							$dst_img = imagecreatetruecolor($dst_w,$dst_h);
							if($img_w > $max_width || $img_h > $max_height)
							$gd->ImageCopyResampleBicubic($dst_img,$src_img,0,0,0,0,$dst_w,$dst_h,$img_w,$img_h);
							else
							imagecopy($dst_img,$src_img,0,0,0,0,$img_w,$img_h);
							if (!file_exists($path))
							mkdir($path, 0775);
							imagejpeg($dst_img, $path.$name, $quality);
							imagedestroy($dst_img);
							imagedestroy($src_img);
							//echo "<img src=\"".$path.$name."\" border=\"0\"><p>";
							/*   $query = "INSERT INTO foto (foto_id) values ( '$row')";
							mysql_query($query);*/
					//	}
					//	else
					//	{
							$text .=  "Alleen JPG files!!!";
					//	}
				}
						if(($file = zip_entry_name($zip_entry))!= "none"){
						$image = $buf;
						//$file = $_FILES[$image1]["name"] ;
						//if(($image = $_FILES[$image1]["tmp_name"])!= "none"){
							//$type = $_FILES[$image1]["type"];
							$size = getimagesize($image);
							$path = $event_photoDir;
							$maxfilesize = $_POST['MAX_FILE_SIZE']/1024;
							$max_width = $event_photoSizeMax;
							$step = $size[0] / $max_width;
							$height = $size[1] / $step;
							$max_height = $height;
							$name = "$foto_id.jpg";
							$quality = "90";
							set_time_limit("0");

						//	if ($type == "image/pjpeg" OR $type == "image/jpeg")
						//	{
								$src_img = ImageCreateFromJPEG($image);
								$img_w = imagesx($src_img);
								$img_h = imagesy($src_img);
								//echo $img_w."x".$img_h."--> \n";
								if ($img_w > $img_h)
								{
									if ($img_w > $max_width)
									{
										$dst_w = $max_width;
										$factor = $img_w / $dst_w;
										$dst_h = $img_h / $factor;
									}
									else
									{
										$dst_w = $img_w;
										$dst_h = $img_h;
									}
								}
								else
								{
									if ($img_h > $max_height)
									{
										$dst_h = $max_height;
										$factor = $img_h / $dst_h;
										$dst_w = $img_w / $factor;
									}
									else
									{
										$dst_w = $img_w;
										$dst_h = $img_h;
									}
								}
								//echo $dst_w."x".$dst_h."<br>\n";
								ob_start();
								phpinfo(8);
								$phpinfo=ob_get_contents();
								ob_end_clean();
								$phpinfo=strip_tags($phpinfo);
								$phpinfo=stristr($phpinfo,"gd version");
								$phpinfo=stristr($phpinfo,"version");
								$end=strpos($phpinfo," ");
								$phpinfo=substr($phpinfo,0,$end);
								$phpinfo=substr($phpinfo,7);
								if(version_compare("2.0", "$phpinfo")==1)
								$dst_img = imagecreate($dst_w,$dst_h);
								else
								$dst_img = imagecreatetruecolor($dst_w,$dst_h);
								if($img_w > $max_width || $img_h > $max_height)
								$gd->ImageCopyResampleBicubic($dst_img,$src_img,0,0,0,0,$dst_w,$dst_h,$img_w,$img_h);
								else
								imagecopy($dst_img,$src_img,0,0,0,0,$img_w,$img_h);
								if (!file_exists($path))
								mkdir($path, 0775);


								imagejpeg($dst_img, $path.$name, $quality);
								imagedestroy($dst_img);
								imagedestroy($src_img);
								//echo "<img src=\"".$path.$name."\" border=\"0\"><p>";

							//}
						//	else
						//	{
								$text .= "Alleen JPG files!!!";
						//	}
						}
				}
				//}







				if(!$text)
				$text = "De foto's zijn toegevoegd";


				zip_entry_close($zip_entry);
			}
			echo "\n";

		}

		zip_close($zip);

	}
	else
	{
		$text = $event->selectEvent();
	}
	if (!$nl2br)
	$nl2br = 0;
}
else
{
	/* Not Logged in. */
	$text = "<img src='images/slot.jpg' height='133' width='132' align='left' />\n Op deze pagina's kunt u wijzigen aanbrengen in de site, maar voordat u verder kunt gaan moet u eerst even inloggen.\n";
	$text .= "Als u geen wachtwoord heeft voor deze site, dan dient u even contact op te nemen met de Administrator.\n\n\n\n\n\n";
	$text .= "Voor technische ondersteuning kunt u contact op nemen met Erwin Marges via E.Marges@planet.nl\n";
	$nl2br = 1;
}
$lay_out->main("Foto's toevoegen aan $_SESSION[cms_name]", $text, $nl2br);

/* parse lay_out */
echo $lay_out->build();

/* send page to client */
ob_end_flush();
?>

