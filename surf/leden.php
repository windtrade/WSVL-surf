<?php
	/* start output buffering */
	ob_start();
		
	/* start the session */
	session_start();

	if ( (!isset($_SERVER['PHP_AUTH_USER'])) || (!isset($_SERVER['PHP_AUTH_PW'])) )
	{
		header("WWW-Authenticate: Basic realm=\"WV Leidschendam e.o.\"");
		header("HTTP/1.0 401 Unauthorized");
		error("Unauthorized access...");
	}
	
	if($_SERVER['PHP_AUTH_USER'] && $_SERVER['PHP_AUTH_PW'])
	{
		
		/* includes */
		include "library/config.inc.php";
		include "library/layout.lib.php";
		
		include "library/db.lib.php";
		
		/* start db */
		$db = new dataBase();
		$db->initialise($mysql_user, $mysql_password, $mysql_host, $mysql_dbName);

		//	Zit de gebruiker in de secretariaats commissie en is de gebruiker nog steeds lid?
		$sql_bevoegd = " SELECT uli.relatie_nr, uli.soort, uli.kenmerk FROM users_ledenadm_import uli, leden_auth la WHERE uli.relatie_nr = la.relatie_nr AND la.username = '".addslashes($_SERVER['PHP_AUTH_PW'])."' AND la.password = '".addslashes($_SERVER['PHP_AUTH_USER'])."' AND uli.soort != '' AND uli.kenmerk LIKE '%secretariaatscie%' ";
		$result_bevoegd = mysql_query($query) or die("error");
	
		while($usr_bevoegd = mysql_fetch_object($result_bevoegd))
		{
			if(strstr($usr_bevoegd['kenmerk'], "secretariaatscie"))
			{
			
				/* start lay_out */
				$lay_out = new LayOut();


				/*
					* Wat wil je gaan doen?
						1. Actuele ledenlijst uploaden?
						2. Online gewijzigde gegevens downloaden?
						3. Leden logboek bijwerken?
				
				
					1).	* Upload formulier weergeven
						* Ledenlijst uploaden en opslaan op de server
						* dBase database openen
						- controleer of het bestand wel alle benodigde kolommen bevat, anders is er misschien wel een verkeerde export-lijst ge-upload :z
					
						* records doorlopen
							- bestaat het relatienummer al in de online database?
							- vergelijk online synchronisatie datum met de laatste mutatie datum
							
							Als het lid nog niet bestaat of onlangs is gewijzigd
							Dan wijzigen we de gewijzigde gegevens.
						
						* De uploader krijgt een status overzicht van welke gegevens van welke leden er online zijn gesynchroniseerd.
						* Klaar!


					2).	- Leden hebben de mogelijkheid om op de website hun gegevens te wijzigen
						- de op de website gewijzigde gegevens moeten ook in de ledenadminstratie 



				*/


			}

		}
		else
		{
			echo "Whoeps!";
		}

	}
	else
	{
		echo "Je kunt natuurlijk ook gewoon niet inloggen.";
	}		




?>
<?php

	

?>