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
		/* tekst toevoegen */
		if ($_POST[addtext2] == true)
		{
			$text = $event->addText($_POST[event_id], $_POST[eventText], $_POST[titel]);
			if(!$text)
				$text = "Het verslag is toegevoegd";
		}
		else
		{
			$text = $event->selectEventText();
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
	$lay_out->main("Verslag toevoegen aan $_SESSION[cms_name]", $text, $nl2br);
	
	/* parse lay_out */
	echo $lay_out->build();
	
	/* send page to client */
	ob_end_flush();
?>

