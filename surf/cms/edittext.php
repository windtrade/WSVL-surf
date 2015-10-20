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
	include "library/tekst.lib.php";
	include "library/gd.lib.php";
	
	/* start db */
	$db = new dataBase();
	$db->initialise($mysql_user, $mysql_password, $mysql_host, $mysql_dbName);
	
	/* start lay_out */
	$lay_out = new LayOut();
	
	/* check for login */
	if ($_SESSION[user_loggedIn] == true)
	{
		/* Login = ok */
		$tekst = new tekst;
		if($_POST[edittext] == true)
		{
			/* step 1; check data */
			$text = $tekst->step2Form($_POST[text_id]);
	
		}
		elseif ($_POST[step2] == true)
		{
			$text = $tekst->editText($_POST[id], $_POST[titel], $_POST[tekst], $_POST[rubriek_id], $_POST[bron]);
		}
		else 
		{
			$text = $tekst->editTextForm();
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
	
	$lay_out->main("Teksten toevoegen aan $_SESSION[cms_name]", $text, $nl2br);
	
	/* parse lay_out */
	echo $lay_out->build();
	
	/* send page to client */
	ob_end_flush();
?>

