<?php
/* start the session */
session_start();

/* includes */
include "library/config.inc.php";
include "library/db.lib.php";

/* start db */
$db = new dataBase();
$db->initialise($mysql_user, $mysql_password, $mysql_host, $mysql_dbName);



?>

				Foto's toevoegen
			</div>
				<?php
				if($fototoe == "true"){
				$query = "SELECT * FROM foto WHERE foto_groep = '$_POST[groep_id]'";
				$sql = mysql_query($query);
				$row = mysql_num_rows($sql);
				echo $row;
				//for($i=0; $i<2; $i++;){
				$i=0;
				while($i!=10){
				$i++;
				$image1 = "image$i";
				echo "$image1<br />";
			//	if(move_uploaded_file($_FILES['image1']['tmp_name'], $uploaddir . $file)){
					    print_r($_FILES);
					$row++;
			if($i==1){		
					
$file = $_FILES[$image1]["name"] ;
$image = $_FILES[$image1]["tmp_name"];
$type = $_FILES[$image1]["type"];    
$size = getimagesize($image);
$path = "../images/fotos/";    
$maxfilesize = $_POST['MAX_FILE_SIZE']/1024;
$max_height = 130;    
$step = $size[1] / $max_height;
$width = $size[0] / $step;
$max_width = $width;  
$name = "$_POST[groep_id]-thumb.jpg";   
$quality = "90";  
set_time_limit("0"); 

if ($type == "image/pjpeg" OR $type == "image/jpeg")
{
  $src_img = ImageCreateFromJPEG($image);
  $img_w = imagesx($src_img);
  $img_h = imagesy($src_img);
  echo $img_w."x".$img_h."--> \n";
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
  echo $dst_w."x".$dst_h."<br>\n";
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
ImageCopyResampleBicubic($dst_img,$src_img,0,0,0,0,$dst_w,$dst_h,$img_w,$img_h);
  else
    imagecopy($dst_img,$src_img,0,0,0,0,$img_w,$img_h);
  if (!file_exists($path))
    mkdir($path, 0775);
  imagejpeg($dst_img, $path.$name, $quality);
  imagedestroy($dst_img);
  imagedestroy($src_img);
  echo "<img src=\"".$path.$name."\" border=\"0\"><p>";
/*   $query = "INSERT INTO foto (foto_id) values ( '$row')";
  mysql_query($query);*/ 
}  
else
{
  echo "Alleen JPG files!!!";
}}
$file = $_FILES[$image1]["name"] ;
if(($image = $_FILES[$image1]["tmp_name"])!= "none"){
$type = $_FILES[$image1]["type"];    
$size = getimagesize($image);
$path = "../images/fotos/";    
$maxfilesize = $_POST['MAX_FILE_SIZE']/1024;
$max_width = 700;    
$step = $size[0] / $max_width;
$height = $size[1] / $step;
$max_height = $height;  
$name = "$_POST[groep_id]-$row-large.jpg";   
$quality = "90";  
set_time_limit("0"); 

if ($type == "image/pjpeg" OR $type == "image/jpeg")
{
  $src_img = ImageCreateFromJPEG($image);
  $img_w = imagesx($src_img);
  $img_h = imagesy($src_img);
  echo $img_w."x".$img_h."--> \n";
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
  echo $dst_w."x".$dst_h."<br>\n";
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
	ImageCopyResampleBicubic($dst_img,$src_img,0,0,0,0,$dst_w,$dst_h,$img_w,$img_h);
  else
    imagecopy($dst_img,$src_img,0,0,0,0,$img_w,$img_h);
  if (!file_exists($path))
    mkdir($path, 0775);
  
    $query = "INSERT INTO foto (foto_groep) values ('$_POST[groep_id]')";
  mysql_query($query);
  $query2 = "SELECT * FROM foto WHERE foto_groep = '$_POST[groep_id]' ORDER BY foto_id DESC LIMIT 1";
  $sql2 = mysql_query($query2);
  $obj2 = mysql_fetch_object($sql2);
  $name = "$_POST[groep_id]-$obj2->foto_id-large.jpg"; 
  imagejpeg($dst_img, $path.$name, $quality);
  imagedestroy($dst_img);
  imagedestroy($src_img);
    echo "<img src=\"".$path.$name."\" border=\"0\"><p>";

}  
else
{
  echo "Alleen JPG files!!!";
}

  //baaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa

}}					
					
					
					echo "Groep is aangemaakt<br /><br /><br /><br />";
				}
				else
				{
				?>
				<form name="fototoe" action="" enctype="multipart/form-data" method="post">
					<input type="hidden" name="fototoe" value="true"/>
					Naam van de groep: 
					<select name="groep_id">
					<?php
					$query = "SELECT * FROM foto_groep ORDER BY groep_id DESC";
					$sql = mysql_query($query);
					while($obj = mysql_fetch_object($sql)){
					echo "<option value=\"$obj->groep_id\">$obj->groep_naam</option>";
					}
					?>
					</select><br />
					<input type="file" name="image1" /><br />
					<input type="file" name="image2" /><br />
					<input type="file" name="image3" /><br />
					<input type="file" name="image4" /><br />
					<input type="file" name="image5" /><br />
					<input type="file" name="image6" /><br />
					<input type="file" name="image7" /><br />
					<input type="file" name="image8" /><br />
					<input type="file" name="image9" /><br />
					<input type="file" name="image10" /><br />
					
					<input type="submit" value="Stuur foto's!" />
				</form>
				<?php } ?>
			<br /><br />
			<!--</div>-->
		</div>
	<div class="profile_bottom"></div>
</center>
<!-- end of object -->
</div>
<div style="padding:10px; ">
<a href="http://forum.ilsje.nl.eu.org/" ><img src="images/logo_forum.gif" align="right" border="0"/></a></div>
</div>


</body>
</html>
