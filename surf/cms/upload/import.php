<?php

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
	$db = dbase_open('FDEXPORT.DBF', 0);
	
	if ($db)
	{
		$record_numbers = dbase_numrecords($db);
		for ($i = 1; $i <= $record_numbers; $i++)
		{
			$row = dbase_get_record_with_names($db, $i);
			echo $henk = print_array($row);
		}
	}


?>