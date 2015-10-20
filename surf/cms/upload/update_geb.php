<?php
	include "../library/config.inc.php";
	include "../library/layout.lib.php";
	include "../library/db.lib.php";
	
	/* start db */
	$db = new dataBase();
	$db->initialise($mysql_user, $mysql_password, $mysql_host, $mysql_dbName);

	$result_jarig = mysql_query("
		SELECT 
			uli.relatie_nr, uli.initialen, uli.naam, uli.postcode, uli4.postcode, uli.geb_datum
		FROM 
			users_ledenadm_import uli, 
			users_ledenadm_import_04 uli4
		WHERE 
			uli.naam = uli4.naam 
			AND uli.initialen = uli4.initialen 
			");

	$aantal_jarig = mysql_num_rows($result_jarig);
	if($aantal_jarig > 0)
	{
		while($jarig_data = mysql_fetch_array($result_jarig))
		{
			mysql_query(" UPDATE users_ledenadm_import_04 SET geb_datum = '$jarig_data[geb_datum]' WHERE naam = '$jarig_data[naam]' AND initialen = '$jarig_data[initialen]' ");
		}
	}
	

?>