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
include "library/mgnt.lib.php";
//include "library/gd.lib.php";

/* start db */
$db = new dataBase();
$db->initialise($mysql_user, $mysql_password, $mysql_host, $mysql_dbName);

/* start lay_out */
$lay_out = new LayOut();
$mgnt = new Mgnt();
/* check for login */
if ($_SESSION[user_loggedIn] == true)
{
	/* Login = ok */
	if($_POST['addtask'] == true)
	{
	$users = array ();
	$counter = 0;
	
	if($_POST[user1]=="on")
	{
		$users[$counter] = 1;
		
		$counter++;
	}
	if($_POST[user2]=="on")
	{
		$users[$counter] = 2;
		
		$counter++;
	}
	if($_POST[user3]=="on")
	{
		$users[$counter] = 3;
		
		$counter++;
	}
	if($_POST[user4]=="on")
	{
		$users[$counter] = 4;

		$counter++;
	}
	if($_POST[user5]=="on")
	{
		$users[$counter] = 5;
		
		$counter++;
	}
	if($_POST[user6]=="on")
	{
		$users[$counter] = 6;
		
		$counter++;
	}
	if($_POST[user7]=="on")
	{
		$users[$counter] = 7;
		
		$counter++;
	}
	if($_POST[user8]=="on")
	{
		$users[$counter] = 8;

		$counter++;
	}
	if($_POST[user9]=="on")
	{
		$users[$counter] = 9;

		$counter++;
	}
	if($_POST[user10]=="on")
	{
		$users[$counter] = 10;

		$counter++;
	}
	$stroke = "-";
			$date = $_POST[event_year] . $stroke . $_POST[event_month] . $stroke . $_POST[event_day];
	$mgnt->addTask($users, $date, $_POST[task]);
	}
	// show your tasks
	$text = $mgnt->getMyTasks();
	
	// show all tasks
	$text .= $mgnt->getAllTasks(); /*"Alle taken:<br /><table>
	<tr width='100%'><td class='td2'>Einddatum:</td><td class='td2'>Status:</td><td class='td2'>Taak:</td></tr>
	<tr><td class='td2'>13-01-06</td><td class='td2'>Open</td><td class='td2'>Deadline overstag</td></tr>
	</table>";*/
	
	// add task
	$text .= "Voeg een taak toe:<br />
	<form name='addtask' method='post' action=''>
	Einddatum: (Dag/maand/jaar)
					<input type='text' name='event_day' maxlength='2' size='2' class='form' />
					<input type='text' name='event_month' maxlength='2' size='2' class='form' />
					<input type='text' name='event_year' maxlength='4' size='4' class='form' /><br />
	<input type='hidden' name='addtask' value='true'/>";
	$text .= $mgnt->getUsers();
	$text .= "<br />Taakomschrijving:<br /><textarea name='task' rows='3' cols='50' class='form'></textarea><br />
	<input type='submit' value='Voeg taak toe' class='form' />
	</form>";
	// show files ordered by date
	$text .= "Files:<br /><table>
	<tr width='100%'><td class='td2'>Datum laatste toevoeging:</td><td class='td2'>Onderwerp:</td><td class='td2'>Initial creator:</td></tr>
	<tr><td class='td2'>19-12-05</td><td class='td2'>Notulen vergadering</td><td class='td2'>Erwin</td></tr>
	</table>";
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
$lay_out->main("Surfbestuur overzichtspagina's", $text, $nl2br);

/* parse lay_out */
echo $lay_out->build();

/* send page to client */
ob_end_flush();
?>

