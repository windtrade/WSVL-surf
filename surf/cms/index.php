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



/* start db */

$db = new dataBase();

$db->initialise($mysql_user, $mysql_password, $mysql_host, $mysql_dbName);



/* start lay_out */

$lay_out = new LayOut();



/* check for login */

if ($_POST[checklogin] == true)

{

	/* check if login is correct */

	$check = new login();

	if ($check->login2($_POST[user_name], $_POST[user_password]) == 1)

	{

		/* login ok */

		$text = "U bent nu ingelogd.<br />\n Links in het menu kunt een kiezen aan welk gedeelte van de site u onderhoud wilt uitvoeren.\n";

	}

	else

	{

		/* login false, give error */

		$text = "U heeft geen goede gebruikersnaam/wachtwoord combinatie opgegeven tijdens het inloggen.\n Probeer het opnieuw.\n";

	}

	

}

else

{

	/* fill up lay_out */

	$text = "<img src='images/slot.jpg' height='133' width='132' align='left' />\n Op deze pagina's kunt u wijzigen aanbrengen in de site, maar voordat u verder kunt gaan moet u eerst even inloggen.\n";

	$text .= "Als u geen wachtwoord heeft voor deze site, dan dient u even contact op te nemen met de Administrator.\n\n\n\n\n\n";

	$text .= "Voor technische ondersteuning kunt u contact op nemen met Erwin Marges via E.Marges@planet.nl\n";

}

$lay_out->main("Welkom in het CMS van $_SESSION[cms_name]", $text, 1);



/* parse lay_out */

echo $lay_out->build();



/* send page to client */



ob_end_flush();








?>