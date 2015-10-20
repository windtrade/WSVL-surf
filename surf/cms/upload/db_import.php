<?php
// 23-01-2011 Huug Virus verwijderd :-(

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


	// open in read-only mode
	$db = dbase_open('LEDENLIJST20050101.dbf', 0);
	
	if ($db)
	{
		$record_numbers = dbase_numrecords($db);
		for ($i = 1; $i <= $record_numbers; $i++)
		{
			$row = dbase_get_record_with_names($db, $i);
//			$henk = print_array($row);

				$row['MDATE'] = "2005-01-01 00:00:00";
	
				$sql = "INSERT INTO users_ledenadm_import_04 
				(relatie_nr, soort, initialen, naam, adres, huisnummer, postcode, plaats, telefoon, laatste_mutatie) VALUES 
				('$i','$row[SOORT]','".addslashes($row['VOORVOEGSE'])."','".addslashes($row['NAAM'])."','".addslashes($row['ADRES'])."','".addslashes($row['NR'])."','".addslashes($row['POSTCODE'])."','".addslashes(strtoupper($row['PLAATS']))."','".addslashes($row['TELEFOON'])."','$row[MDATE]');";
	
				echo $sql."<br />\n";

		}
	}


?>
