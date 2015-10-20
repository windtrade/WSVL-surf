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

/* check for login */
if ($_SESSION[user_loggedIn] == true)
{
	/* Login = ok */
	$event = new event;
	if ($_GET['event_id']) {
		 // Event ID is recieved.
		 
		 // Check for image_id
		 if ($_GET['photo_id']) {
		 	// image_id sent
		 	$image_id = $_GET['photo_id'];
		 }
		 else 
		 	$image_id = 0;
		 // Show images
		 
		 $text = $event->showPhoto($_GET['event_id'], $image_id, $event_photoDir);
	}
//	if ($_POST[changeevent] == true)
//	{
//		if ($_POST[step1] == true)
//		{
//			/*if ($_POST[step2] == true)
//			{
//			/* image upload */
//			/*if (move_uploaded_file($_FILES['image']['tmp_name'], $event_imgDir . "/$_POST[event_id].jpg")) {
//			$gd = new gd();
//			$gd->resize("$event_imgDir/$_POST[event_id].jpg","$event_imgDir/$_POST[event_id]small.jpg",80,300);
//			}
//
//			$text = "Het evenement is toegevoegd.
//			En bevat de volgende foto:
//			<img src='$event_imgDir/$_POST[event_id]small.jpg' />\n";
//			$nl2br = 1;
//			}
//			else
//			{*/
//			$stroke = "-";
//			$event_date = $_POST[event_year] . $stroke . $_POST[event_month] . $stroke . $_POST[event_day];
//
//			/* step 1; check data */
//			$text = $event->verifyStep1Change($_POST[event_title], $_POST[event_onTop], $_POST[event_onCalendar], $_POST[event_text], $_POST[event_id], $event_date);
//
//		}
//		else if ($_POST[addphoto] == true) {
//			if (move_uploaded_file($_FILES['image']['tmp_name'], $event_imgDir . "/$_POST[event_id].jpg")) {
//				$gd = new gd();
//				$gd->resize("$event_imgDir/$_POST[event_id].jpg","$event_imgDir/$_POST[event_id]small.jpg",80,300);
//			}
//
//			$text = "De volgende foto is toegevoegd.
//				<img src='$event_imgDir/$_POST[event_id]small.jpg' />\n";
//			$tekst= $event->addphoto($_POST[event_id]);
//		}
//		else
//		$text = $event->changeStep1Form($_POST[event_id]);
//	}
//	else if ($_GET[delete]){
//		$text = $event->deletePhoto($_GET[delete], $event_imgDir);
//	}
//	else
//	{
//		$text = $event->changeEvent();
//	}
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
$lay_out->main("Evenementen wijzigen", $text, $nl2br);

/* parse lay_out */
echo $lay_out->build();

/* send page to client */
ob_end_flush();
?>

