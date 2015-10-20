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
	include "library/news.lib.php";
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
		$news = new news;
		if ($_POST[changenews] == true)
		{
			if ($_POST[step2] == true)
			{
				/* image upload */
				if (move_uploaded_file($_FILES['image']['tmp_name'], $news_imgDir . "/$_POST[news_id].jpg")) {
					$gd = new gd();
					$gd->resize("$news_imgDir/$_POST[news_id].jpg","$news_imgDir/$_POST[news_id]small.jpg",80,300);
				}
				
				$text = "Uw nieuwsbericht is gewijzigd.
				En bevat de volgende foto: 
				<img src='$news_imgDir/$_POST[news_id]small.jpg' />\n";
				$nl2br = 1; 
			}
			else if ($_POST[step3] == true)
			{
				$text = $news->verifyStep1Change($_POST[news_id], $_POST[news_rubriek_id], $_POST[news_title], $_POST[news_image], $_POST[news_short], $_POST[news_message]);
			}
			else
			{
			/* step 1; check data */
			//$text = $news->verifyStep1($_POST[news_title], $_POST[news_image], $_POST[news_short], $_POST[news_message]);
			
			// get message:
			$text = $news->changeStep2Form($_POST[news_id]);
			}
		}
		else
		{
			$text = $news->changeStep1Form();
		}
	
		if(!$nl2br)
		{
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
	}
	
	$lay_out->main("Nieuwsberichten wijzigen aan $_SESSION[cms_name]", $text, $nl2br);

	/* parse lay_out */
	echo $lay_out->build();
	
	/* send page to client */
	ob_end_flush();

?>