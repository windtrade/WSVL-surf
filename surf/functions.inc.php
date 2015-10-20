<?php
//==================================================================================================
//	FUNCTION (AMS_db_connectie)	(versie 1.0)(RJ)
//==================================================================================================

	function db_connectie()
	{
		global $HTTP_SERVER_VARS;
		global $dab;
		global $database;
	
		$dab[connect] = mysql_connect($dab[host], $dab[user], $dab[password]);   
		$dab[select] = mysql_select_db($dab[name]);
		$database[connect] = $dab[name];
	}

//==================================================================================================
//	FUNCTION (ams_check_tables)	(versie 1.0)(RJ)
//==================================================================================================
// deze functie controleert of de in 'mod_config' opgegeven tabellen bestaan,
// als ze nog niet bestaan dan worden ze automatisch aangemaakt op basis van $sql
// die ook in het bestand 'mod_config' staat. 
//==================================================================================================

	function ams_check_tables() {
		global $error;
		global $dbtable;
		global $db;
		global $database;
		global $sql;		

		if(gettype($dbtable)=="array")
		{ 
			while(list($index, $value) = each($dbtable) )
			{
				$test_result = mysql_query("SELECT * FROM $dbtable[$index]",$db[connect]);
				$error = mysql_errno();
				
				if($error == '1146')	//1146 = Table doesn't exist
				{
					//nu maakt ie de ontbrekende tabellen aan.
					mysql($database[connect],$sql[$index]);
					if(mysql_errno() != 0)
					{
						echo mysql_errno().": ".mysql_error()."<br />";
					}
				}
			}
		}		
		return $error;
	}

//==================================================================================================
//	FUNCTION (format_string_for_db)	(versie 1.0)(Marvin)
//==================================================================================================

	function format_string_for_db($value) {
		$value = trim($value);
		$value = nl2br($value);
		$value = addslashes($value);
		
		return $value;
	}

//==================================================================================================
//	FUNCTION (format_string_from_db)	(versie 2.0)(Marvin)(23-01-2002)
//==================================================================================================

	function format_string_from_db($value) {
		if(gettype($value)=="array")
		{ 
			while (list($index, $subarray) = each($value) ) {
				$value[$index] = format_string_from_db($subarray);
			}				
		}
		else
		{
			$value = str_replace("<br />","",$value);
			$value = stripslashes($value);
		}
	
		return $value;
	}

//==================================================================================================
//	FUNCTION (AMS_update_LIST_formfields)	(versie 1.0)(Marvin)(23-01-2002)
//==================================================================================================

	function NETFX_update_LIST_formfields($table,$field,$wherefield,$wherefieldvalue,$input) {
		global $db;
		global $database;

		if($wherefield != '0' && $wherefieldvalue != '0')
		{
			$result_records = mysql_query("SELECT * FROM $table WHERE $wherefield ='$wherefieldvalue'",$db[connect]);
		}
		else
		{
			$result_records = mysql_query("SELECT * FROM $table",$db[connect]);
		}

		$records_totaal = mysql_numrows($result_records);
		$id_field = mysql_field_name($result_records, 0);

		$teller = 0;
		while($teller < $records_totaal) :
	
			$record = mysql_result($result_records,$teller,$id_field);

			if(isset($input[$record]))
			{
				$input_value = $input[$record];
				AMS_query_LIST("UPDATE $table set $field ='$input_value' WHERE $id_field ='$record'");
			}	
			
			$teller++;
		endwhile;			
	}

//==================================================================================================
//	FUNCTION (AMS_update_LIST_posities)	(versie 2.0)(Marvin)
//==================================================================================================

	function AMS_update_LIST_posities($table,$field,$fieldvalue,$positie) {
		global $db;
		global $database;

		if($field != '0' && $fieldvalue != '0')
		{
			$result_records = mysql_query("SELECT * FROM $table WHERE $field ='$fieldvalue'",$db[connect]);
		}
		else
		{
			$result_records = mysql_query("SELECT * FROM $table",$db[connect]);
		}

		$records_totaal = mysql_numrows($result_records);
		$id_field = mysql_field_name($result_records, 0);

		$teller = 0;
		while($teller < $records_totaal) :
	
			$record = mysql_result($result_records,$teller,$id_field);
			$positie_value = $positie[$record];
			AMS_query_LIST("UPDATE $table set positie ='$positie_value' WHERE $id_field ='$record'");			
	
			$teller++;
		endwhile;			
	}

//==================================================================================================
//	FUNCTION (AMS_update_LIST_aktief)	(versie 2.0)(Marvin)
//==================================================================================================

	function AMS_update_LIST_aktief($table,$field,$fieldvalue,$aktief) {
		global $db;
		global $database;

		if($field != '0' && $fieldvalue != '0')
		{
			$result_records = mysql_query("SELECT * FROM $table WHERE $field ='$fieldvalue'",$db[connect]);
		}
		else
		{
			$result_records = mysql_query("SELECT * FROM $table",$db[connect]);
		}

		$records_totaal = mysql_numrows($result_records);
		$id_field = mysql_field_name($result_records, 0);

		$teller = 0;
		while($teller < $records_totaal) :
	
			$record = mysql_result($result_records,$teller,$id_field);
			$aktief_value = $aktief[$record];
			AMS_query_LIST("UPDATE $table set aktief ='$aktief_value' WHERE $id_field ='$record'");
	
			$teller++;
		endwhile;			
	}	

//==================================================================================================
//	FUNCTION (AMS_update_LIST_prullenbak)	(versie 2.0)(Marvin)
//==================================================================================================

	function AMS_update_LIST_prullenbak($table,$field,$fieldvalue,$action,$prullenbak) {
		global $db;
		global $database;

		if($field != '0' && $fieldvalue != '0')
		{
			$result_records = mysql_query("SELECT * FROM $table WHERE $field ='$fieldvalue'",$db[connect]);
		}
		else
		{
			$result_records = mysql_query("SELECT * FROM $table",$db[connect]);
		}

		$records_totaal = mysql_numrows($result_records);
		$id_field = mysql_field_name($result_records, 0);

		$teller = 0;
		while($teller < $records_totaal) :
	
			$record = mysql_result($result_records,$teller,$id_field);
			
			$prullenbak_value = $prullenbak[$record];
			
			if($prullenbak_value == 'y')	
			{
				if($action == '1')
				{
					AMS_query_LIST("UPDATE $table set prullenbak ='y' WHERE $id_field ='$record'");
				}
				elseif($action == '2')
				{
					AMS_query_LIST("UPDATE $table set prullenbak ='' WHERE $id_field ='$record'");
				}
			}
			
			$teller++;
		endwhile;			
	}
	
//==================================================================================================
//	FUNCTION (AMS_update_LIST_verwijderen)	(versie 2.0)(Marvin)
//==================================================================================================

	function AMS_update_LIST_verwijderen($table,$field,$fieldvalue,$verwijderen) {
		global $db;
		global $database;

		if($field != '0' && $fieldvalue != '0')
		{
			$result_records = mysql_query("SELECT * FROM $table WHERE $field ='$fieldvalue'",$db[connect]);
		}
		else
		{
			$result_records = mysql_query("SELECT * FROM $table",$db[connect]);
		}

		$records_totaal = mysql_numrows($result_records);
		$id_field = mysql_field_name($result_records, 0);

		$teller = 0;
		while($teller < $records_totaal) :
	
			$record = mysql_result($result_records,$teller,$id_field);
			
			if($verwijderen[$record] == 'y')
			{
				AMS_query_LIST("DELETE FROM $table WHERE $id_field ='$record'");
			}	
			
			$teller++;
		endwhile;			
	}	
//==================================================================================================
//	FUNCTION (AMS_foto_vars_conversie)	(versie 1.0)(Marvin)(18-03-2002)
//==================================================================================================

	function AMS_foto_vars_conversie() {
		global $config;
		
		//MODULENAAM ACHERHALEN IN DE FOTO VARIABELEN
		while(list($key, $value) = each ($config))
		{
			if(isset($config[$key][foto][uploaddir][mod]))
			{
				$tmp = $key;		
			}
		}
		
		//DIRECTORY
		$config[foto][uploaddir][mod] = $config[$tmp][foto][uploaddir][mod];

		//BRON FOTOS
		$bronnen[aantal] = count($config[$tmp][foto][naam]);
	
		$bron_teller = 1;
		while($bron_teller < $bronnen[aantal] + 1) :
	
			$config[foto][naam][$bron_teller] = $config[$tmp][foto][naam][$bron_teller];
			$config[foto][cmspreviewselect][$bron_teller] = $config[$tmp][foto][cmspreviewselect][$bron_teller];
	
			$resize[aantal] = count($config[$tmp][foto][$bron_teller][resize][naam]);
	
			$resize_teller = 1;
			while($resize_teller < $resize[aantal] + 1) :
	
				$config[foto][$bron_teller][resize][naam][$resize_teller] = $config[$tmp][foto][$bron_teller][resize][naam][$resize_teller];
				$config[foto][$bron_teller][resize][hoogte][$resize_teller] = $config[$tmp][foto][$bron_teller][resize][hoogte][$resize_teller];
				$config[foto][$bron_teller][resize][breedte][$resize_teller] = $config[$tmp][foto][$bron_teller][resize][breedte][$resize_teller];
	
				$resize_teller++;
			endwhile;
	
			$bron_teller++;
		endwhile;			
	}

//==================================================================================================
//	FUNCTION (foto_vars_conversie)	(versie 1.0)(Marvin)(18-03-2002)
//==================================================================================================

	function foto_vars_conversie() {
		global $config;
		
		//MODULENAAM ACHERHALEN IN DE FOTO VARIABELEN
		while(list($key, $value) = each ($config))
		{
			if(isset($config[$key][foto][uploaddir][mod]))
			{
				$tmp = $key;		
			}
		}
		
		//DIRECTORY
		$config[foto][uploaddir][mod] = $config[$tmp][foto][uploaddir][mod];

		//CONTROLEER OF DE TOEGANGSRECHTEN VOOR DE DIRECTORY GOED ZIJN INGESTELD
		//AMS_check_for_writable($config[foto][uploaddir][mod]);
	
		//BRON FOTOS
		$bronnen[aantal] = count($config[$tmp][foto][naam]);
	
		$bron_teller = 1;
		while($bron_teller < $bronnen[aantal] + 1) :
	
			$config[foto][naam][$bron_teller] = $config[$tmp][foto][naam][$bron_teller];
			$config[foto][cmspreviewselect][$bron_teller] = $config[$tmp][foto][cmspreviewselect][$bron_teller];
	
			$resize[aantal] = count($config[$tmp][foto][$bron_teller][resize][naam]);
	
			$resize_teller = 1;
			while($resize_teller < $resize[aantal] + 1) :
	
				$config[foto][$bron_teller][resize][naam][$resize_teller] = $config[$tmp][foto][$bron_teller][resize][naam][$resize_teller];
				$config[foto][$bron_teller][resize][hoogte][$resize_teller] = $config[$tmp][foto][$bron_teller][resize][hoogte][$resize_teller];
				$config[foto][$bron_teller][resize][breedte][$resize_teller] = $config[$tmp][foto][$bron_teller][resize][breedte][$resize_teller];
				$config[foto][$bron_teller][resize][percentage][$resize_teller] = $config[$tmp][foto][$bron_teller][resize][percentage][$resize_teller];
	
				$resize_teller++;
			endwhile;
	
			$bron_teller++;
		endwhile;			
	}

//==================================================================================================
//	FUNCTION (AMS_foto_component)	(versie 1.0)(Marvin)
//==================================================================================================

	function AMS_foto_component($id) {
		global $config;
		global $CMSstatus;		
		global $HTTP_POST_VARS;
		global $HTTP_POST_FILES;
	
		while(list($key, $value) = each ($config[foto][naam]))
		{
			if($HTTP_POST_VARS[verwijderfoto][$key] == "y")
			{
				while(list($delkey, $delvalue) = each ($config[foto][$key][resize][naam]))
				{
					$CMSstatus[fotos][] = AMS_remove_foto($id,$key,$delkey);
				}
			}
			
			if($HTTP_POST_FILES[foto][name][$key] != "")
			{
				while(list($resizekey, $resizevalue) = each ($config[foto][$key][resize][naam]))
				{
					$CMSstatus[fotos][] = AMS_upload_foto($id,$key,$resizekey);
				}			
			}
		}

		return $CMSstatus;
	}

//==================================================================================================
//	FUNCTION (AMS_upload_foto)	(versie 2.0)(Marvin)
//==================================================================================================

	function AMS_upload_foto($id,$key,$resizekey) {
		global $config;
		global $HTTP_POST_VARS;
		global $HTTP_POST_FILES;

		//GEPOSTE BESTAND
		$foto_local = $HTTP_POST_FILES[foto][name][$key];
		$foto_server = $HTTP_POST_FILES[foto][tmp_name][$key];		

		//RESIZE INFO	
		$naam = $config[foto][$key][resize][naam][$resizekey];
		$breedte = $config[foto][$key][resize][breedte][$resizekey];
		$hoogte = $config[foto][$key][resize][hoogte][$resizekey];
		
		//UPLOAD DIRECTORY
		$dir_upload = $config[foto][uploaddir][base].''.$config[foto][uploaddir][mod];

		//BESTANDNAAM			
		$filename[upload] = $dir_upload.''.$id."_foto".$key."_".$config[foto][$key][resize][naam][$resizekey].".jpg";
		$filename[name] = $config[foto][naam][$key]." <font size=\"1\">(".$config[foto][$key][resize][naam][$resizekey].")</font> ";

		//BESTAND EXTENSIE ACHTERHALEN
		$extensie = explode (".", $foto_local);
		$part = count($extensie);
		$extensie[$part - 1] = strtolower($extensie[$part - 1]);

		if(($extensie[$part - 1] == 'jpg') xor ($extensie[$part - 1] == 'jpeg'))
		{
			$size = GetImageSize($foto_server);

			if($size[2] == '2')
			{
				$foto[width] = $size[0];
				$foto[height] = $size[1];

				if($breedte != '' && $hoogte == '')			// VASTE BREEDTEMAAT
				{
					$action = "RESIZE";				
					$foto[verhouding] = $foto[width] / $breedte;

					if($foto[verhouding] > '0')
					{
						$foto[width] = $breedte;
						$foto[height] = $foto[height] / $foto[verhouding];
						$foto[height] = ceil($foto[height]);
					}
					else
					{
						$foto[width] = $breedte;
						$foto[height] = $foto[height] * $foto[verhouding];
						$foto[height] = ceil($foto[height]);
					}
				}
				elseif($hoogte != '' && $breedte == '')		// VASTE HOOGTEMAAT
				{
					$action = "RESIZE";				
					$foto[verhouding] = $foto[height] / $hoogte;

					if($foto[verhouding] > '0')
					{
						$foto[height] = $hoogte;
						$foto[width] = $foto[width] / $foto[verhouding];
						$foto[width] = ceil($foto[width]);
					}
					else
					{
						$foto[height] = $hoogte;
						$foto[width] = $foto[width] * $foto[verhouding];
						$foto[width] = ceil($foto[width]);
					}
				}
				elseif($hoogte != '' && $breedte != '')		// VASTE BREEDTEMAAT & HOOGTEMAAT
				{
					$action = "RESIZE";				
					$foto[width] = $breedte;
					$foto[height] = $hoogte;
				}
				elseif($hoogte == '' && $breedte == '')		// GEEN VASTE FORMATEN
				{
					$action = "UPLOAD";
					$foto[width] = $size[0];
					$foto[height] = $size[1];
				}					

				if($foto[width] > $size[0])					// ALS RESIZE BREEDTE > ORIGINAL BREEDTE
				{
					$action = "UPLOAD";				
					$foto[width] = $size[0];
					$foto[height] = $size[1];
				}
				elseif($foto[height] > $size[1])			// ALS RESIZE HOOGTE > ORIGINAL HOOGTE
				{
					$action = "UPLOAD";
					$foto[width] = $size[0];
					$foto[height] = $size[1];
				}

				// ALS BESTAND REEDS BESTAAT OP SERVER -> VERWIJDEREN OM EEN TOEGANGSRECHT ERROR TE VOORKOMEN
				if(file_exists($filename[upload]))
				{
					$delete = unlink($filename[upload]);
				}				

				if($action == "RESIZE")
				{
					// FOTO RESIZE
					$src_img = imagecreatefromjpeg($foto_server); 
					$new_w = $foto[width]; 
					$new_h = $foto[height]; 
					//$dst_img = imagecreate($new_w,$new_h);
					$dst_img = imagecreatetruecolor($new_w,$new_h);
					ImageCopyResampled($dst_img,$src_img,0,0,0,0,$new_w,$new_h,imagesx($src_img),imagesy($src_img));
					//ImageCopyResampleBicubic($dst_img,$src_img,0,0,0,0,$new_w,$new_h,imagesx($src_img),imagesy($src_img));
					$status = imagejpeg($dst_img, $filename[upload], 92);
				}
				elseif($action == "UPLOAD")
				{
					// FOTO UPLOAD
					$status = copy($foto_server, $filename[upload]);
				}
				
				if($status == 'true')
				{
					$status = "Het bestand <b>$filename[name]</b> is <font color=\"#006600\">toegevoegd</font> aan het systeem.";
				}
				elseif($status == 'false')
				{
					$status = "<font color=\"#FF0000\"><b>RESIZE ERROR :</b></font> Het bestand <b>$filename[name]</b> is <font color=\"#FF0000\"><b>NIET</b> toegevoegd</font> aan het systeem, probeert u het nog een keer. Als deze fout zich blijft voordoen neem dan contact op met NetFX Interactive.";			
				}
			}
			else
			{
				// FOTO IS GEEN JPG
				$status = "<font color=\"#FF0000\"><b>ERROR :</b></font> Dit bestand <b>$foto_local</b> is <font color=\"#FF0000\">geen JPG of JPEG</font> bestand.";
			}
		}
		else
		{
			// FOTO IS GEEN JPG
			$status = "<font color=\"#FF0000\"><b>ERROR :</b></font> Dit bestand <b>$foto_local</b> is <font color=\"#FF0000\">geen JPG of JPEG</font> bestand.";
		}

		return $status;
	}

//==================================================================================================
	
	function ImageCopyResampleBicubic ($dst_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) { 
		for ($i = 0; $i < 256; $i++)
		{
			// get pallete. Is this algoritm correct? 
			@$colors = ImageColorsForIndex ($src_img, $i); 
			ImageColorAllocate ($dst_img, $colors['red'], $colors['green'], $colors['blue']); 
		} 
		
		$scaleX = ($src_w - 1) / $dst_w; 
		$scaleY = ($src_h - 1) / $dst_h; 
		
		$scaleX2 = $scaleX / 2.0; 
		$scaleY2 = $scaleY / 2.0; 
		
		for ($j = $src_y; $j < $dst_h; $j++)
		{ 
			$sY = $j * $scaleY; 
			
			for ($i = $src_x; $i < $dst_w; $i++)
			{ 
				$sX = $i * $scaleX; 
				
				$c1 = ImageColorsForIndex ($src_img, ImageColorAt ($src_img, (int) $sX, (int) $sY + $scaleY2)); 
				$c2 = ImageColorsForIndex ($src_img, ImageColorAt ($src_img, (int) $sX, (int) $sY)); 
				$c3 = ImageColorsForIndex ($src_img, ImageColorAt ($src_img, (int) $sX + $scaleX2, (int) $sY + $scaleY2)); 
				$c4 = ImageColorsForIndex ($src_img, ImageColorAt ($src_img, (int) $sX + $scaleX2, (int) $sY)); 
				
				$red = (int) (($c1['red'] + $c2['red'] + $c3['red'] + $c4['red']) / 4); 
				$green = (int) (($c1['green'] + $c2['green'] + $c3['green'] + $c4['green']) / 4); 
				$blue = (int) (($c1['blue'] + $c2['blue'] + $c3['blue'] + $c4['blue']) / 4); 
				
				$color = ImageColorClosest ($dst_img, $red, $green, $blue); 
				ImageSetPixel ($dst_img, $i + $dst_x, $j + $dst_y, $color); 
			} 
		} 
	}	

//==================================================================================================
//	FUNCTION (AMS_remove_foto)	(versie 1.1)(Marvin)
//==================================================================================================

	function AMS_remove_foto($id,$key,$delkey) {
		global $config;

		//UPLOAD DIRECTORY
		$dir_upload = $config[foto][uploaddir][base].''.$config[foto][uploaddir][mod];

		//BESTANDNAAM			
		$filename[remove] = $dir_upload.''.$id."_foto".$key."_".$config[foto][$key][resize][naam][$delkey].".jpg";
		$filename[name] = $config[foto][naam][$key]." <font size=\"1\">(".$config[foto][$key][resize][naam][$delkey].")</font> ";

		if(file_exists($filename[remove]))
		{
			$status = unlink($filename[remove]);

			if($status == 'true')
			{
				$status = "Het bestand <b>$filename[name]</b> is <font color=\"#FF0000\">verwijderd</font> uit het systeem.";
			}
			elseif(($status == 'false') xor ($status == '0'))
			{
				$status = "Het bestand <b>$filename[name]</b> is <font color=\"#FF0000\"><b>NIET</b> verwijderd</font> uit het systeem.";		
			}
		}
		else
		{
			$status = "Het bestand <b>$filename[name]</b> is <font color=\"#FF0000\">niet gevonden</font> in het systeem.";
		}

		return $status;
	}

//==================================================================================================
//	FUNCTION (AMS_file_component)	(versie 1.0)(RJ)
//==================================================================================================
//	dit component handelt het volledige upload, overschrijf of update proces af voor bestanden
//	die worden beheerd met behulp van het 'Library Filecomponent'. 	
//--------------------------------------------------------------------------------------------------

	function AMS_file_component($id) {
		global $config;
		global $HTTP_POST_VARS;
		global $HTTP_POST_FILES;
		global $db;
		global $database;
		global $dbtable;

		$aktieve_module = $config[mod][naam];

		while(list($key, $value) = each ($config[file][naam]))
		{
		//----------------------------------
		// verwijderen van het bestand
		//----------------------------------

			if($HTTP_POST_VARS[verwijderfile][$key] == "y")
			{
				AMS_file_remove($id,$key,$aktieve_module);
			}

		//----------------------------------
		// uploaden van een nieuw bestand
		//----------------------------------

			if($HTTP_POST_FILES[file][name][$key] != "")
			{
				AMS_file_upload($id,$key,$aktieve_module);
			}

		//----------------------------------
		// overschrijven van bestand
		//----------------------------------

			if($HTTP_POST_FILES[fileoverwrite][name][$key] != "")
			{
				AMS_file_remove($id,$key,$aktieve_module);

				AMS_file_upload($id,$key,$aktieve_module);
			}

		//----------------------------------
		// updaten van de database velden
		//----------------------------------

			if($HTTP_POST_VARS["file_beschrijving"][$key])
			{
				//WAT IS DE NAAM VAN DE DB WAAR BESTANDS INFO WORDT OPGESLAGEN?
				$config[cms][klant_kort] = strtolower($config[cms][klant_kort]);
				$files_db = $config[cms][klant_kort] .''. "_" .''. $config[mod][naam] .''. "_files";

				$beschrijving = $HTTP_POST_VARS["file_beschrijving"][$key];
				$aktief = $HTTP_POST_VARS["file_aktief"][$key];
				$archief = $HTTP_POST_VARS["file_archief"][$key];

				//BESCHRIJVING E.D. TOEVOEGEN IN DE DB 
				mysql($database[connect],"UPDATE $files_db SET module = '$aktieve_module', beschrijving = '$beschrijving', aktief = '$aktief', archief = '$archief' WHERE artikel_id = '$id' AND sleutel = '$key' AND module = '$aktieve_module'");	
				echo "_".mysql_errno().": ".mysql_error()."_";
			}

		}
	}

//==================================================================================================
//	FUNCTION (AMS_file_upload)	(versie 1.0)(RJ)(25-03-2002)(declared stable)
//==================================================================================================
//
//--------------------------------------------------------------------------------------------------

	function AMS_file_upload($artikel_id,$config_key) {
		global $config;
		global $HTTP_POST_VARS;
		global $HTTP_POST_FILES;
		global $db;
		global $database;
		global $dbtable;

		$aktieve_module = $config[mod][naam];

			//GEPOSTE BESTAND
			$foto_local = $HTTP_POST_FILES[file][name][$config_key];
			$foto_server = $HTTP_POST_FILES[file][tmp_name][$config_key];
			
			if($foto_server == '')
			{
				$foto_server = $HTTP_POST_FILES[fileoverwrite][tmp_name][$config_key];
			}
			
			if($foto_local == '')
			{
				$foto_local = $HTTP_POST_FILES[fileoverwrite][name][$config_key];
			}
			
					//BESTAND EXTENSIE ACHTERHALEN
					$extensie = explode (".", $foto_local);
					$part = count($extensie);
					$extensie[$part - 1] = strtolower($extensie[$part - 1]);

					//ANDERE DELEN VAN DE NAAM BIJ ELKAAR ZOEKEN
					$tussenstuk = $config[file][naam][$config_key];
					//$originele_naam = $HTTP_POST_FILES[file][name][$config_key];

						//WAT IS DE NAAM VAN DE DB WAAR BESTANDS INFO WORDT OPGESLAGEN?
						$config[cms][klant_kort] = strtolower($config[cms][klant_kort]);
						$files_db = $config[cms][klant_kort] .''. "_" .''. $config[mod][naam] .''. "_files";

						//WELKE KOLOM HEEFT DE PRIMARY KEY IN DE RELATED TO DB?
						$tmp_result = mysql_query("SELECT * FROM $dbtable[files_related_to]",$db[connect]);
						$id_field = mysql_field_name($tmp_result, 0);

						//WAT IS DE LAATST TOEGEVOEGDE ID
						$result_ids = mysql_query("SELECT * FROM $files_db ORDER BY file_id DESC LIMIT 1",$db[connect]);
						@$laatste_id = mysql_result($result_ids,0,'file_id');

		
						//WAT WORDT DE NIEUW TOE TE VOEGEN ID
						$nieuwe_id = $laatste_id + 1;
						$nieuwe_filename = $nieuwe_id .''. "_" .''. $aktieve_module .''. "_" .''. $tussenstuk .''. "." .''. $extensie[$part - 1];

					$beschrijving = $HTTP_POST_VARS["beschrijving"][$config_key];
					$aktief = $HTTP_POST_VARS["aktief"][$config_key];
					$archief = $HTTP_POST_VARS["archief"][$config_key];

					//BESCHRIJVING E.D. TOEVOEGEN IN DE DB 
					mysql($database[connect],"INSERT INTO $files_db (file_id,artikel_id,module,filename,server_filename,beschrijving,sleutel,aktief,archief) VALUES ('$nieuwe_id','$artikel_id','$aktieve_module','$foto_local','$nieuwe_filename','$beschrijving','$config_key','$aktief','$archief')");	
					echo "<!--".mysql_errno().": ".mysql_error()."-->";


				//UPLOAD DIRECTORY
				$dir_upload = $config[file][uploaddir][base];

				//BESTANDSNAAM
				$filename[upload] = $dir_upload .''. $nieuwe_filename;

			$theo = copy($foto_server, $filename[upload]);

	}

//==================================================================================================
//	FUNCTION (AMS_file_remove)	(versie 1.0)(RJ)(24-03-2002)(declared stable)
//==================================================================================================

	function AMS_file_remove($artikel_id,$config_key) {
		global $config;
		global $db;
		global $dbtable;
		global $database;
		global $HTTP_POST_VARS;
		global $HTTP_POST_FILES;

		$aktieve_module = $config[mod][naam];

			//WAT IS DE NAAM VAN DE DB WAAR BESTANDS INFO WORDT OPGESLAGEN?
			$config[cms][klant_kort] = strtolower($config[cms][klant_kort]);
			$files_db = $config[cms][klant_kort] .''. "_" .''. $config[mod][naam] .''. "_files";

			//ANDERE DELEN VAN DE NAAM BIJ ELKAAR ZOEKEN
			$tussenstuk = $config[file][naam][$config_key];
			$originele_naam = $HTTP_POST_FILES[file][name][$config_key];

			//VIND DE NAAM VAN HET BESTAND
			$result_filename = mysql_query("SELECT * FROM $files_db WHERE artikel_id = '$artikel_id' AND sleutel = '$config_key' AND module = '$aktieve_module' LIMIT 1",$db[connect]);
			$bestand_data = NETFX_MYSQL_get_row_info($result_filename,0);

			$file_location = $config[file][uploaddir][base] .''. $bestand_data[server_filename];

				if(file_exists($file_location))
				{
					unlink($file_location);
				}
	
			mysql($database[connect],"DELETE FROM $files_db WHERE artikel_id = '$artikel_id' AND sleutel = '$config_key' AND module = '$aktieve_module' LIMIT 1");
	}

//==================================================================================================
//	FUNCTION (AMS_query)	(versie 1.0)(Marvin)(IN BEWERKING)
//==================================================================================================

	function AMS_query($query) {
		global $db;
		global $database;

		$check[select] = strpos($query, "SELECT");
		$check[insert] = strpos($query, "INSERT");
		$check[update] = strpos($query, "UPDATE");
		$check[delete] = strpos($query, "DELETE");

		if(gettype($check[select])=="integer")			//SELECT
		{
			$result = mysql($db[connect], $query);
		}
		elseif(gettype($check[insert])=="integer")		//INSERT
		{
			$info = mysql($database[connect], $query);
			$id = mysql_insert_id();
			AMS_get_DB_status("INSERT",$info,"DEFAULT");
		}
		elseif(gettype($check[update])=="integer")		//UPDATE
		{
			$info = mysql($database[connect], $query);
			AMS_get_DB_status("UPDATE",$info,"DEFAULT");
		}
		elseif(gettype($check[delete])=="integer")		//DELETE
		{
			$info = mysql($query);
			AMS_get_DB_status("DELETE",$info,"DEFAULT");
		}
		else
		{
			echo("<b>Dit is geen correcte query</b><br><font color=\"#FF0000\">$query</font>");
			exit;
		}

		return $result;
	}
	
//==================================================================================================
//	FUNCTION (AMS_query_LIST)	(versie 1.0)(Marvin)(IN BEWERKING)
//==================================================================================================

	function AMS_query_LIST($query) {
		global $db;
		global $database;
		
		$check[select] = strpos($query, "SELECT");
		$check[insert] = strpos($query, "INSERT");
		$check[update] = strpos($query, "UPDATE");
		$check[delete] = strpos($query, "DELETE");

		if(gettype($check[select])=="integer")			//SELECT
		{
			$result = mysql($db[connect], $query);
		}
		elseif(gettype($check[insert])=="integer")		//INSERT
		{
			$info = mysql($database[connect], $query);
			$id = mysql_insert_id();
			AMS_get_DB_status("INSERT",$info,"LIST");
		}
		elseif(gettype($check[update])=="integer")		//UPDATE
		{
			$info = mysql($database[connect], $query);
			AMS_get_DB_status("UPDATE",$info,"LIST");
		}
		elseif(gettype($check[delete])=="integer")		//DELETE
		{
			$info = mysql($query);
			AMS_get_DB_status("DELETE",$info,"LIST");
		}
		else
		{
			echo("<b>Dit is geen correcte query</b><br><font color=\"#FF0000\">$query</font>");
			exit;
		}

		return $result;
	}

//==================================================================================================
//	FUNCTION (NETFX_MYSQL_get_row_info)	(versie 1.0)(Marvin)(16-01-2002)(EXPIRIMENTEEL)
//==================================================================================================

	function NETFX_MYSQL_get_row_info($result,$row) {

		if(@mysql_data_seek($result,$row))
		{
			$output = mysql_fetch_array($result, MYSQL_ASSOC);
		}
	
		return $output;
	}

//==================================================================================================
//	FUNCTION (AMS_get_DB_status)	(versie 1.1)(Marvin)(IN BEWERKING)
//==================================================================================================

	function AMS_get_DB_status($action,$info,$type) {
		global $CMSstatus;
		
		if($type == "DEFAULT")
		{
			if($action == "INSERT")
			{
				if($info == "1")
				{
					$CMSstatus[insert][] = "De gegevens zijn <font color=\"#006600\">toegevoegd</font> aan het systeem.";
				}
				else
				{
					$CMSstatus[insert][] = "<font color=\"#FF0000\"><b>INSERT ERROR :</b></font> De gegevens zijn <font color=\"#FF0000\"><b>NIET</b> toegevoegd</font> aan het systeem, probeert u het nog een keer. Als deze fout zich blijft voordoen neem dan contact op met NetFX Interactive.";
					AMS_show_DB_error();
				}
			}
			elseif($action == "UPDATE")
			{
				if($info == "1")
				{
					$CMSstatus[update][] = "De gegevens zijn <font color=\"#006600\">gewijzigd</font> in het systeem.";
				}
				else
				{
					$CMSstatus[update][] = "<font color=\"#FF0000\"><b>UPDATE ERROR :</b></font> De gegevens zijn <font color=\"#FF0000\"><b>NIET</b> gewijzigd</font> in het systeem, probeert u het nog een keer. Als deze fout zich blijft voordoen neem dan contact op met NetFX Interactive.";
					AMS_show_DB_error();
				}
			}
			elseif($action == "DELETE")
			{
				if($info == "1")
				{
					$CMSstatus[delete][] = "De gegevens zijn <font color=\"#006600\">verwijderd</font> uit het systeem.";
				}
				else
				{
					$CMSstatus[delete][] = "<font color=\"#FF0000\"><b>DELETE ERROR :</b></font> De gegevens zijn <font color=\"#FF0000\"><b>NIET</b> verwijderd</font> uit het systeem, probeert u het nog een keer. Als deze fout zich blijft voordoen neem dan contact op met NetFX Interactive.";
					AMS_show_DB_error();
				}
			}
		}
		elseif($type == "LIST")
		{
			//*******************************
			//	NOG TOEVOEGEN
			//*******************************
			/*
				De list items tellen (per action) & tekst weergeven met het aantal er in.
				De weergave tekst in aparte funtie die aangeroepen wordt als de list geheel verwerkt is.

			*/
			//*******************************
		}
		else
		{
			echo("AMS_get_DB_status | Het type is niet gedefineerd.");
			exit;
		}
	}

//==================================================================================================
//	FUNCTION (AMS_show_DB_error)	(versie 1.0)(Marvin)
//==================================================================================================

	function AMS_show_DB_error() {
		echo("<b>DATABASE ERROR : </b><br>".mysql_errno()." - ".mysql_error()."<BR>");
		exit;
	}

//==================================================================================================
//	FUNCTION (AMS_show_CMS_status)	(versie 1.0)(Marvin)
//==================================================================================================

	function AMS_show_CMS_status($id) {
		global $CMSstatus;

		session_register("CMSstatus");

		header("Location: status.php?id=$id");
		exit; 
	}

//==================================================================================================
//	FUNCTION (AMS_get_CMS_status_message)	(versie 1.0)(Marvin)
//==================================================================================================

	function AMS_get_CMS_status_message($value) {
		if(gettype($value)=="array")
		{ 
			while (list($index, $subarray) = each($value) ) {
				AMS_get_CMS_status_message($subarray);
			}				
		}
		else
		{
			AMS_show_CMS_status_message($value);
		}
	}

//==================================================================================================
//	FUNCTION (AMS_show_CMS_status_message)	(versie 1.0)(Marvin)
//==================================================================================================
	
	function AMS_show_CMS_status_message($value) {
		echo("<tr bgcolor=\"#FFFDF2\">"); 
		echo("<td align=\"left\" valign=\"middle\" bgcolor=\"#FFFDF2\"><font face=\"Verdana, Arial, Helvetica, sans-serif\" size=\"2\" color=\"#333333\">$value</font></td>");
		echo("</tr>");
	}

//==================================================================================================
//	FUNCTION (include_menu_array)	(versie 1.0)(RJ)
//==================================================================================================

	function get_active_modules($array) { 
		global $modulenaam;
	
		if(gettype($array)=="array") { 
	
			$teller = 0;
			while(list($index, $value) = each($array) ){

				if($value == 'true')
				{
					$modulenaam[$teller] = $index;
					$teller++;
				}
			}
		}
	}

//=================================================================================================	
//	FUNCTION (print_array)		(versie 1.2)(Marvin)
//=================================================================================================
//	Deze functie is vooral bedoeld voor tijdens het debuggen van je scripts, je kunt deze functie
//	gebruiken voor het tonen van alle waardes in een opgegeven Array of gewoon om alle aanwezige
//	variabelen in een pagina te tonen.
//-------------------------------------------------------------------------------------------------

	function print_array($array) {
		
		if(gettype($array)=="array") { 
			echo "<ul>"; 
				while (list($index, $subarray) = each($array) ) { 
					echo "<li>$index <code>=&gt;</code> "; 
					print_array($subarray); 
					echo "</li>"; 
				} 
			echo "</ul>"; 
		} else echo $array; 
	}

//=================================================================================================
//	FUNCTION (convert_hyperlinks)	(versie 1.0.1)(RJ)
//=================================================================================================
//-------------------------------------------------------------------------------------------------

	function convert_hyperlinks($tekst)
	{
		$aantal_http = substr_count($tekst, "http:");
		if($aantal_http > 0)
		{
			$http_teller = 0;
			$start_pos = 0;
			while($http_teller < $aantal_http):
	
				//zoek alles tussen http:// en de 1e spatie en maak er een [HYPERLINK] van.	
				$zoek_http = strpos($tekst, "http://", $start_pos);
		
				$spatie = chr(32);
				$eind_url_pos = strpos($tekst, "<br />", $zoek_http);
				if($eind_url_pos == '') { $eind_url_pos = strpos($tekst, $spatie, $zoek_http); }
				if($eind_url_pos == '') { $eind_url_pos = strpos($tekst, " ", $zoek_http); }
				if($eind_url_pos == '') { $eind_url_pos = strlen($tekst); }
		
				$lengte_van_url = $eind_url_pos - $zoek_http;
				$url = substr($tekst, $zoek_http, $lengte_van_url);
				$a_tag = "<a href='".$url."' target='_blank'><b>[HYPERLINK]</b></a>";
	
				$tekst = str_replace($url, $a_tag, $tekst);
	
				$start_pos = $eind_url_pos;
		
			$http_teller++;
			endwhile;
		}
		return $tekst;
	}

//=================================================================================================
//	FUNCTION (validateEmail)	(versie 1.0.0)(RJ)
//=================================================================================================
//	Deze functie controleerd niet alleen of het e-mail adres correct is opgebouwd, het controleerd
//	ook of het bijbehorende internet domein bestaat.
//-------------------------------------------------------------------------------------------------
	
	function validateEmail($email_adres)
	{
		if (eregi("^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,4}$",$email_adres))
		{
			$email = explode("@", $email_adres);
			if(checkdnsrr($email[1]) == true) 
			{
				$valid = 1;
			}
			else 
			{
				$valid = 0;
			}
		}
		else
		{
			$valid = 0;
		}

		return $valid; 
	}

//=================================================================================================
// FUNCTION (parseCacheFile)		(versie 0.1)(RJ)
//=================================================================================================
//	Deze functie maakt een server side ge-cached html bestand, aan de hand van de gespecificeerde
//	template.
//	Argumenten lijst:
//	- template file
//	- output filename
//-------------------------------------------------------------------------------------------------

	function parseCacheFile($template, $output_file, $cache_uid)
	{ 
		global $config;
		global $dab;
		global $database;
		global $dbtable;
		global $_SERVER;
		global $_SESSION;	

		ob_start(); 

			if(file_exists($template))
			{
				include($template);
			}
	
		$output = ob_get_contents(); 
		ob_end_clean(); 

		if(file_exists($output_file))
		{	
			unlink($output_file);
		}

		$file = fopen($output_file, "w"); 
		fputs($file, $output); 
		fclose($file);
	}

//=================================================================================================
?>