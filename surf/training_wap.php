<?php
	include "library/config.inc.php";
	include "library/layout.lib.php";
	include "library/db.lib.php";
	
	/* start db */
	$db = new dataBase();
	$db->initialise($mysql_user, $mysql_password, $mysql_host, $mysql_dbName);


	$trainers = array('arjanus24@hotmail.com','e.marges@gmail.com','robbert-jan@surfspullen.nl','iele@hotmail.com');

	$current_weekdag = date("w");
	if(date("w") <= 2)
	{
		$optelsom = 0;
	}
	else
	{
		$optelsom = 7;	
	}

	$volgende_dinsdag =  date("Y-m-d", mktime ( 0, 0, 0, date("m"), ( (date("d")+$optelsom) - ($current_weekdag-2) ), date("Y") ));

	$sql_aanmeldingen = " SELECT * FROM trainingsmaatjes WHERE datum = '".$volgende_dinsdag." 00:00:00' AND aangemeld = 1 ORDER BY naam ASC ";
	$result_aanmeldingen = mysql_query($sql_aanmeldingen);
	$aantal_aanmeldingen = mysql_num_rows($result_aanmeldingen);


	$sql_afmeldingen = " SELECT * FROM trainingsmaatjes WHERE datum = '".$volgende_dinsdag." 00:00:00' AND aangemeld = 0 ORDER BY naam ASC ";
	$result_afmeldingen = mysql_query($sql_afmeldingen);
	$aantal_afmeldingen = mysql_num_rows($result_afmeldingen);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Trainingsoverzicht <?php echo(date("d/m", strtotime($volgende_dinsdag))); ?></title>
</head>

<body>

	<h2>Wie komen er allemaal (<?php echo($aantal_aanmeldingen); ?>)</h2>
	<ul>
	<?php
		while($aanmeldingen = mysql_fetch_array($result_aanmeldingen))
		{

	?>
			<li>
				<strong><?php echo(ucfirst($aanmeldingen['naam'])); ?></strong>
				<?php if($aanmeldingen['opmerking'] != '') { ?><br /><em><?php echo(stripslashes($aanmeldingen['opmerking'])); ?></em><?php } ?>
			</li>
	<?php
		}
	?>
	</ul>


	<h2>Wie komen er niet (<?php echo($aantal_afmeldingen); ?>)</h2>
	<ul>
	<?php
		while($afmeldingen = mysql_fetch_array($result_afmeldingen))
		{

	?>
			<li>
				<strong><?php echo(ucfirst($afmeldingen['naam'])); ?></strong>
				<?php if($afmeldingen['opmerking'] != '') { ?><br /><em><?php echo(stripslashes($afmeldingen['opmerking'])); ?></em><?php } ?>
			</li>
	<?php
		}
	?>
	</ul>


</body>
</html>
