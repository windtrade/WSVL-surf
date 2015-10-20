<?php
	include "library/config.inc.php";
	include "library/layout.lib.php";
	include "library/db.lib.php";
	include "library/training.lib.php";

	/* start db */
	$db = new dataBase();
	$db->initialise($mysql_user, $mysql_password, $mysql_host, $mysql_dbName);
	// Berttest
	if(!strstr($_SERVER['HTTP_REFERER'],"training_afmelden.php") && strtolower($_REQUEST['berttest']) != 'wi') {
		die('Ik mag jou niet.');
		header('Location: training.php');
		header('Vriendelijke-groeten: Bert');
	}
	// Einde berttest
	// Wil de gebruiker zich afmelden of aanmelden?
	if($_REQUEST['aanmeldBevestig'] == '2' && $_REQUEST['email'])
	{
		if(checkEmail($_REQUEST['email']))
		{

			// Aanmelden voor alle trainingen vanaf nu ...
			$naam = addslashes($_REQUEST['naam']);
			$email = addslashes($_REQUEST['email']);
			$opmerking = addslashes($_REQUEST['opmerking']);
	
			for ($tijd=volgendeTraining() ; $tijd < eindeTraining() ; $tijd += 168*3600) {
				$value = date('Y-m-d', $tijd);
				$token = md5(uniqid(rand(), true));
	
				$sql = " INSERT INTO trainingsmaatjes 
				(trainingsmaatje_id, spot_id, datum, naam, emailadres, opmerking, token, aangemeld) VALUES 
				('','87','$value','$naam','$email','$opmerking','$token','1') ";
	
				//	1.	Gegevens opslaan in DB
				mysql_query($sql);
	
				//$afmeld_link[] = "http://surf.wvleidschendam.nl/training_afmelden.php?token=".$token."&email=".stripslashes($email)."&datum=".date("Ymd", strtotime($value));
	
			}


			//	2.	Bevestigings email opstellen
			$onderwerp = "Bevestiging aanmelding gevorderdentrainingen";
	
			$bericht = "Hoi ".stripslashes($naam).",
	
Leuk dat je op de dinsdagavonden naar de Gevorderdentraining toe komt. We beginnen om 19.00u met de training. 
Kom op tijd, je surfpak aantrekken en je zeil optuigen duurt altijd langer dan je denkt.

Mocht je onverhoopt toch een keer niet kunnen komen, meld je dan even af via onderstaande link
http://surf.wvleidschendam.nl/training_afmelden.php



Groeten en tot dinsdagavond,
De trainers van WV Leidschendam		
			";
	
				//	3.	E-mail versturen
				mail(stripslashes($email),$onderwerp,$bericht,"From: training@wvleidschendam.nl\n");
	
		}	
	}
	else
	{

		if($_REQUEST['afmeldBevestig'] == '1' && $_REQUEST['email'] && $_REQUEST['datum'])
		{
			// Het kan zijn dat de surfer zich niet eerder heeft aangemeld?
			// of zich niet via de e-mail link aan het afmelden is...
	
			if(!$_REQUEST['token'])
			{
				$email = addslashes($_REQUEST['email']);
				$datum = date("Y-m-d 00:00:00", strtotime($_REQUEST['datum']));
	
				$sql_check = " SELECT * FROM trainingsmaatjes WHERE emailadres = '$email' AND datum = '$datum' ";
				$result_aanmeldingen = mysql_query($sql_check);
				$aanmeldingen = mysql_fetch_array($result_aanmeldingen);
		
				if(is_array($aanmeldingen) && $aanmeldingen['token'] != '')
				{
					// Dan weten we nu wel wie het is
					$token = $aanmeldingen['token'];			
				}
				else
				{
					$token = md5(uniqid(rand(), true));			
				}
				
			}
			else
			{
				$token = $_REQUEST['token'];
			}


			if($_REQUEST['afmeldBevestig'] == '1' && $token)
			{
				$email = addslashes($_REQUEST['email']);
				$datum = date("Y-m-d 00:00:00", strtotime($_REQUEST['datum']));
	
				$opmerking = addslashes($_REQUEST['opmerking']);
	
				$sql = " UPDATE trainingsmaatjes SET aangemeld = 0, opmerking = '$opmerking' WHERE emailadres = '$email' AND datum = '$datum' AND token = '$token' ";
				mysql_query($sql);
			
			}	

		}
		elseif($_REQUEST['aanmeldBevestig'] == '1')
		{	// De gebruiker wil zich aanmelden...
		
			if($_REQUEST['datum'] && $_REQUEST['naam'] && $_REQUEST['email'])
			{
				$datum = date("Y-m-d 00:00:00", strtotime($_REQUEST['datum']));
				$naam = addslashes($_REQUEST['naam']);
				$email = addslashes($_REQUEST['email']);
				$opmerking = addslashes($_REQUEST['opmerking']);
				$token = md5(uniqid(rand(), true));

				// Controleren of er niet toevallig is aangemeld -> afgemeld en weer opnieuw aangemeld
				$sql_check = " SELECT * FROM trainingsmaatjes WHERE emailadres = '$email' AND datum = '$datum' ";
				$result_aanmeldingen = mysql_query($sql_check);
				$aanmeldingen = mysql_fetch_array($result_aanmeldingen);

				if(is_array($aanmeldingen) && $aanmeldingen['token'] != '')
				{
					$token = $aanmeldingen['token'];
			
					// update het bestaande record
					$sql = " UPDATE trainingsmaatjes SET aangemeld = 1, opmerking = '$opmerking' WHERE emailadres = '$email' AND token = '$aanmeldingen[token]' AND datum = '$datum' "; 

					//	1.	Gegevens opslaan in DB
					mysql_query($sql);

				}
				else
				{
					// nieuw record invoegen
					$sql = " INSERT INTO trainingsmaatjes 
					(trainingsmaatje_id, spot_id, datum, naam, emailadres, opmerking, token, aangemeld) VALUES 
					('','87','$datum','$naam','$email','$opmerking','$token','1') ";
			
					//	1.	Gegevens opslaan in DB
					mysql_query($sql);

				}
							
				//	2.	Bevestigings email opstellen
				$onderwerp = "Bevestiging aanmelding gevorderdentraining ".date("d-m", strtotime($_REQUEST['datum']));
				$afmeld_link = "http://surf.wvleidschendam.nl/training_afmelden.php?token=".$token."&email=".stripslashes($email)."&datum=".date("Ymd", strtotime($_REQUEST['datum']));
		
				$bericht = "Hoi ".stripslashes($naam).",
	
Leuk dat je dinsdagavond ook naar de Gevorderdentraining komt. We beginnen om 19.00u met de training. 
Kom op tijd, je surfpak aantrekken en je zeil optuigen duurt altijd langer dan je denkt.

Mocht je onverhoopt toch niet kunnen komen, meld je dan even af via onderstaande link
".$afmeld_link."


Groeten en tot dinsdagavond,
De trainers van WV Leidschendam		
		";
	
			//	3.	E-mail versturen
			mail(stripslashes($email),$onderwerp,$bericht,"From: training@wvleidschendam.nl\n");
	
			//		CC'tjes versturen naar de trainers?
	
			}
		}

	}

	Header("Location: training.php");

?>
