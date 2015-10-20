<?php
/* **********************************************************************
**	dataBase library of Content Management System				   **
**********************************************************************
** Created 27-7-04 Erwin Marges									   **
********************************************************************** */

class event{
	var $event_title;
	var $event_image;
	var $event_text;
	var $event_date;
	var $event_onCalendar;
	var $event_onTop;
	var $event_id;


	function step1Form(){
		$text = "
<form name='addevent' action='' enctype='multipart/form-data' method='post' >
	<input type='hidden' name='addevent' value='true' />
	Naam van het evenement: <input type='text' name='event_title' maxlength='255' width='100' class='form' /><br />
	Dag/maand/jaar:
					<input type='text' name='event_day' maxlength='2' size='2' class='form' />
					<input type='text' name='event_month' maxlength='2' size='2' class='form' />
					<input type='text' name='event_year' maxlength='4' size='4' class='form' /><br />

	<input type='checkbox' name='event_image' class='form' /> Ik wil een plaatje toevoegen aan dit evenement <br />
	<input type='checkbox' name='event_onCalendar' class='form' /> Dit evenement moet op de kalender geplaatst worden <br />
	<input type='checkbox' name='event_onTop' class='form' /> Dit evenement wordt groot aangekondigd op de kalender pagina <br />
	Informatie over het evenement:<br /><textarea name='event_text' rows='10' cols='80' class='form' ></textarea><br />
	<input type='submit' value='Toevoegen' class='form'/>
</form>";
		return $text;
	}

	function changeStep1Form($event_id){
		$query = "SELECT *, UNIX_TIMESTAMP(event_timestamp) AS datum FROM event where event_id = '$event_id'";
		$sql = mysql_query($query);
		if($result = mysql_fetch_object($sql)){
			$dag = date("d", $result->datum);
			$maand = date("m", $result->datum);
			$jaar = date("Y", $result->datum);

			$text = "
<form name='addevent' action='' enctype='multipart/form-data' method='post' >
	<input type='hidden' name='changeevent' value='true' />
	<input type='hidden' name='step1' value='true' />
	<input type='hidden' name='event_id' value='$event_id' />
	Naam van het evenement: <input type='text' name='event_title' maxlength='255' width='100' class='form' value='$result->event_title'/><br />

	Dag/maand/jaar:
					<input type='text' name='event_day' maxlength='2' size='2' class='form' value='$dag' />
					<input type='text' name='event_month' maxlength='2' size='2' class='form' value='$maand'/>
					<input type='text' name='event_year' maxlength='4' size='4' class='form' value='$jaar'/><br />";
			if($result->event_onCalendar == 1)
			$text .= "<input type='checkbox' name='event_onCalendar' class='form' checked/>\n";
			else
			$text .= "<input type='checkbox' name='event_onCalendar' class='form' />\n";
			$text .= "Dit evenement moet op de kalender geplaatst worden <br />";
			if($result->event_onTop == 1)
			$text .= "<input type='checkbox' name='event_onTop' class='form' checked/>\n";
			else
			$text .= "<input type='checkbox' name='event_onTop' class='form' />\n";
			$rtext = str_replace("<br />","",$result->event_text);

			$text .= "Dit evenement wordt groot aangekondigd op de kalender pagina <br />
	Informatie over het evenement:<br /><textarea name='event_text' rows='10' cols='80' class='form' >$rtext</textarea><br />
	<input type='submit' value='Wijzigen' class='form'/>
</form>";
			if($result->event_image == 1){
				$foto = $result->event_id;
				$small = "small.jpg";
				$foto = "$foto$small";
				$text .= "Onderstaande foto wordt momenteel weergegeven bij dit event<br /><img src=\"../images/event/$foto\"/>";
				$text .= "<br /><a class='link1' href='?delete=$event_id'>Deze foto verwijderen</a>";
			}
			else
			{
				$text .= "<form name='addfoto' action='' enctype='multipart/form-data' method='post' >\n <input type='hidden' name='addphoto' value='true' />\n<input type='hidden' name='changeevent' value='true' />\n<input type='hidden' name='event_id' value='$result->event_id' />\nOf plaats een foto bij dit evenement: <input type='file' name='image' class='form' /><br /><input type='submit' value='Plaats foto' class='form'/></form>";
			}
			$sqlFotos = "SELECT *
         FROM `foto` 
         WHERE `event_id` = '$event_id' LIMIT 0, 30";
			$execFotos = mysql_query($sqlFotos) or die("Error in query execFotos");
			if ($objFoto = mysql_fetch_object($execFotos)) {
				/* er zijn foto's */
				$text .= "<br /><br /><a class=\"link1\" href=\"viewphoto.php?event_id=$event_id\">Klik hier om de foto's die bij dit evenement horen te wijzigen / verwijderen</a><br />\n";
			}
			return $text;
		}
	}

	function changeEvent(){
		$text = "<form name='changeevent' action='' enctype='multipart/form-data' method='post' >
	<input type='hidden' name='changeevent' value='true' />
	Naam van het evenement: <select name='event_id'>";
		/* get events */
		$query = "SELECT *, UNIX_TIMESTAMP(event_timestamp) AS datum FROM event ORDER BY event_timestamp DESC ";
		$sql = mysql_query($query);
		while($result = mysql_fetch_object($sql)){
			$date = date("d-m-Y", $result->datum);
			$text .= "<option value='$result->event_id'>$result->event_title - $date </option>\n";
		}
		$text .= "</select><input type='submit' value='Wijzigen' class='form'/>
</form>";

		/*check for image */

		return $text;
	}

	function verifyStep1Change($event_title, $event_onTop, $event_onCalendar, $event_text, $event_id, $event_date )
	{
		$error = 0;
		$text = "
<form name='addevent' action='' enctype='multipart/form-data' method='post' >
	<input type='hidden' name='addevent' value='true' />
	<input type='hidden' name='step1' value='true' />

	<input type='hidden' name='event_onTop' value='$event_onTop' />
	<input type='hidden' name='event_onCalendar' value='$event_onCalendar' />
		";

		if( $event_title == "" )
		{
			$error++;
			$text .= "
	<span class='form'><b>Titel van het evenement:</b></span>
			";
		}
		$text .= "
	<input type='text' name='event_title' maxlength='255' width='100' class='form' value='$event_title'/><br />
		";

		if( $event_text == "" )
		{
			$error++;
			$text .= "
	<span class='form'><b>Informatie over evenement:</b></span>
			";
		}
		$text .= "
	<br /><textarea name='event_text' rows='10' cols='80' class='form' >$event_text</textarea><br />
		";

		/*if( $news_message == "" )
		{
		$error++;
		$text .= "
		<span class='form'><b>Volledige bericht:</b></span>
		";
		$text .= "
		<br /><textarea name='news_message' rows='30' cols='80' class='form' >$news_message</textarea><br />
		";
		}	*/
		$text .= "
		<input type='submit' value='Wijzigen' class='form'/>
</form>
		";

		if($error == true)
		return $text;

		/* no error reset $text string */
		$text = "blaat";
		/* final makeup and put in DB */
		$this->event_text = nl2br($event_text);
		//$this->event_date = $event_date;
		$this->event_title = $event_title;
		$this->event_image = $event_image;
		$this->event_onCalendar = $event_onCalendar;
		$this->event_onTop = $event_onTop;
		$this->event_id = $event_id;
		$this->event_date = $event_date;
		$this->changeMessage();

		if ($event_image == "on")
		$text = $this->step2Form();
		else
		$text = "Het event is aangepast\n";
		return $text;
	}


	function verifyStep1($event_title, $event_image, $event_onTop, $event_onCalendar, $event_text, $event_date )
	{
		$error = 0;
		$text = "
<form name='addevent' action='' enctype='multipart/form-data' method='post' >
	<input type='hidden' name='addevent' value='true' />
	<input type='hidden' name='event_image' value='$event_image' />
	<input type='hidden' name='event_onTop' value='$event_onTop' />
	<input type='hidden' name='event_onCalendar' value='$event_onCalendar' />
		";

		if( $event_title == "" )
		{
			$error++;
			$text .= "
	<span class='form'><b>Titel van het evenement:</b></span>
			";
		}
		$text .= "
	<input type='text' name='event_title' maxlength='255' width='100' class='form' value='$event_title'/><br />
		";

		if( $event_text == "" )
		{
			$error++;
			$text .= "
	<span class='form'><b>Informatie over evenement:</b></span>
			";
		}
		$text .= "
	<br /><textarea name='event_text' rows='10' cols='80' class='form' >$event_text</textarea><br />
		";

		/*if( $news_message == "" )
		{
		$error++;
		$text .= "
		<span class='form'><b>Volledige bericht:</b></span>
		";
		$text .= "
		<br /><textarea name='news_message' rows='30' cols='80' class='form' >$news_message</textarea><br />
		";
		}	*/
		$text .= "
		<input type='submit' value='Toevoegen' class='form'/>
</form>
		";

		if($error == true)
		return $text;

		/* no error reset $text string */
		$text = "blaat";
		/* final makeup and put in DB */
		$this->event_text = nl2br($event_text);
		$this->event_date = $event_date;
		$this->event_title = $event_title;
		$this->event_image = $event_image;
		$this->event_onCalendar = $event_onCalendar;
		$this->event_onTop = $event_onTop;
		$this->createMessage();

		if ($event_image == "on")
		$text = $this->step2Form();

		return $text;
	}

	function step2Form()
	{
		$text = "
<form name='addevent' action='' enctype='multipart/form-data' method='post' >
	<input type='hidden' name='addevent' value='true' />
	<input type='hidden' name='step2' value='true' />
	<!--<input type='hidden' name='event_image' value='$this->event_image' />-->
	
	<input type='hidden' name='event_id' value='$this->event_id' />
	<input type='file' name='image' class='form' /><br />	
	<input type='submit' value='Toevoegen' class='form'/>
</form>
		";
		return $text;
	}

	function createMessage()
	{
		/* parse message and put in DB */
		if ($this->event_image == "on")
		$image = 1;
		/*$datum=date("d-m-Y");*/
		if ($this->event_onTop == "on")
		$this->event_onTop = 1;
		if ($this->event_onCalendar == "on")
		$this->event_onCalendar = 1;
		/*echo $this->event_date;*/
		$query  = "INSERT INTO event (event_onTop, event_onCalendar, event_author_id, event_image, event_timestamp, event_title, event_text) VALUES ('$this->event_onTop', '$this->event_onCalendar', '$_SESSION[user_id]', '$image', '$this->event_date', '$this->event_title', '$this->event_text')";
		mysql_query($query);

		/* get message_id */

		$query = "SELECT event_id FROM event ORDER BY event_id DESC LIMIT 1";
		$sql = mysql_query($query);
		while($obj = mysql_fetch_object($sql))
		{
			$this->event_id = $obj->event_id;
		}
	}

	function changeMessage()
	{
		/* parse message and put in DB */
		if ($this->event_image == "on")
		$image = 1;
		/*$datum=date("d-m-Y");*/
		if ($this->event_onTop == "on")
		$this->event_onTop = 1;
		if ($this->event_onCalendar == "on")
		$this->event_onCalendar = 1;
		/*echo $this->event_date;*/
		$query  = "UPDATE event SET event_onTop = '$this->event_onTop', event_onCalendar = '$this->event_onCalendar', event_title = '$this->event_title', event_text = '$this->event_text', event_timestamp = '$this->event_date' where event_id = '$this->event_id'";
		mysql_query($query);

		/* get message_id */


	}
	// or die(mysql_errno($link) . ": " . mysql_error($link). "<br />\n");


	function selectEvent(){
		$text = "<form name='changeevent' action='' enctype='multipart/form-data' method='post' >
			<input type='hidden' name='addphoto' value='true' />
	Naam van het evenement: <select name='event_id' class='form'>";
		/* get events */
		$query = "SELECT *, UNIX_TIMESTAMP(event_timestamp) AS datum FROM event ORDER BY event_timestamp DESC ";
		$sql = mysql_query($query);
		while($result = mysql_fetch_object($sql)){
			$date = date("d-m-Y", $result->datum);
			$text .= "<option value='$result->event_id'>$result->event_title - $date</option>\n";
		}


		$text .= "</select><br / ><input type='file' name='image1' class='form'/><br />";
		$text .= "<input type='file' name='image2' class='form'/><br />";
		$text .= "<input type='file' name='image3' class='form'/><br />";
		$text .= "<input type='file' name='image4' class='form'/><br />";
		$text .= "<input type='file' name='image5' class='form'/><br />";
		$text .= "<input type='file' name='image6' class='form'/><br />";
		$text .= "<input type='file' name='image7' class='form'/><br />";
		$text .= "<input type='file' name='image8' class='form'/><br />";
		$text .= "<input type='file' name='image9' class='form'/><br />";
		$text .= "<input type='file' name='image10' class='form'/><br />";
		$text .= "<input type='file' name='image11' class='form'/><br />";
		$text .= "<input type='file' name='image12' class='form'/><br />";
		$text .= "<input type='file' name='image13' class='form'/><br />";
		$text .= "<input type='file' name='image14' class='form'/><br />";
		$text .= "<input type='file' name='image15' class='form'/><br />";
		$text .= "<input type='file' name='image16' class='form'/><br />";
		$text .= "<input type='file' name='image17' class='form'/><br />";
		$text .= "<input type='file' name='image18' class='form'/><br />";
		$text .= "<input type='file' name='image19' class='form'/><br />";
		$text .= "<input type='file' name='image20' class='form'/><br />";
		$text .= "<input type='submit' value='Stuur fotos!' class='form'/>
</form>";
		return $text;
	}

	function selectEventText(){
		$text = '<form name="changeText" method="post" action="" enctype="multipart/form-data" >';
		//$text = "<form name='changeText' action='' enctype='multipart/form-data' method='post' >
		$text .= "<input type='hidden' name='addtext2' value='true' />
	Naam van het evenement: <select name='event_id' class='form'>";
		/* get events */
		$query = " SELECT *, UNIX_TIMESTAMP(event_timestamp) AS datum FROM event ORDER BY event_timestamp DESC ";
		$sql = mysql_query($query);
		while($result = mysql_fetch_object($sql)){
			$date = date("d-m-Y", $result->datum);
			$text .= "<option value='$result->event_id'>$result->event_title - $date</option>\n";
		}

		$text .= "</select><br />";
		$text .= "Titel van verslag<input type=\"text\" name=\"titel\" class=\"form\" /><br />Verslag:<br />";
		//$text .= "<textarea name=\"eventText\" rows=\"30\" cols=\"100\" class=\"form\"></textarea>\n";
		/*$text .= "<br /><input type='submit' value='Stuur verslag!' class='form'/><input type=\"button\" value=\"Add New Text\" onClick=\"addtext('blaat');\">
		</form>";*/


		$text .= '
<textarea name="eventText" rows="30" cols="100" class="form"></textarea><br />
<input type="submit" value= Stuur verslag!" class="form"/>
<!--<input type="button" value="Add New Text" onClick="addtext(\'12\');">-->
<input type="button" value="Kies een foto voor in het verslag" onClick="openChild(\'win2\');" class="form">
</form>';
		return $text;
	}

	function addText($event_id, $eventText, $titel){
		/* Verslag toevoegen */
		if($eventText){
			/*Er is tekst ingevoerd */
			$eventText = nl2br($eventText);
			/*make date*/
			$date = date("y-m-d");
			$query = "INSERT INTO verslag (event_id, verslag_userId, verslag_datum, verslag, titel) VALUES
				('$event_id', '$_SESSION[user_id]', '$date', '$eventText', '$titel')";
			mysql_query($query) or die("Error bij teksttoevoegen, Datum: $date");
		}
	}

	function showEvents($start){
		/* Show 5 events, starting at $start */
		$text = "<table>";
		$eventQuery = mysql_query("SELECT * FROM event ORDER BY event_id ASC LIMIT $start, 5");
		while ($eventObj = mysql_fetch_object($eventQuery)) {
			/* Print events */
			$text .= "<tr><td><table><tr><td>Naam:</td><td>$eventObj->event_title</td></tr>
						<tr><td>Datum:</td><td>$eventObj->event_title</td></tr>
						<tr><td>Op kalender:</td><td>$eventObj->event_title</td></tr>
						
						<tr><td>Informatie en foto:</td><td>$eventObj->event_title</td></tr>
						<tr><td>Verslagen:</td><td>$eventObj->event_title</td></tr>
						<tr><td>Foto's:</td><td>$eventObj->event_title</td></tr>";

			$text .= "</tr></table></td></tr>";

		}
		$start = $start +5;
		$eventVolgendeQuery = mysql_query("SELECT * FROM event ORDER BY event_id ASC LIMIT $start, 5");
		if ($eventVolgendeObj = mysql_fetch_object($eventVolgendeQuery)) {
			$text1 = "<a class=\"link1\" href=\"?start=$start\">Volgende Evenementen</a><br />";
		}
		$start = $start -6;
		if($start >= 0){
			$eventVorigeQuery = mysql_query("SELECT * FROM event ORDER BY event_id ASC LIMIT $start, 5");
			if ($eventVorigeObj = mysql_fetch_object($eventVorigeQuery)) {
				if($start <= 0)
				$start =0;
				else
				$start = $start -4;
				$text2 = "<a class=\"link1\" href=\"?start=$start\">Vorige Evenementen</a>";
			}
			$text .= $text2;
			$text .= $text1;
		}
		return $text;
	}

	function addphoto($event_id){
		mysql_query("UPDATE event SET event_image = '1' WHERE event_id = '$event_id'");
	}

	function deletePhoto($event_id, $event_imgDir){
		mysql_query("UPDATE event SET event_image = '0' WHERE event_id = '$event_id'");
		//unlink("../www/
		$small =  "small";
		unlink("$event_imgDir/$event_id$small.jpg");
		unlink("$event_imgDir/$event_id.jpg");
		return "De foto is verwijderd";
	}
	
	function deleteAPhoto($phoyo_id, $event_imgDir, $event_id){
		mysql_query("DELETE FROM `foto` WHERE foto_id = '$phoyo_id'");
		
		// Delete comments
		
		$small =  "small";
		$file1 = "$event_imgDir". $phoyo_id . "-thumb.jpg";
		$file2 = "$event_imgDir" . $phoyo_id . ".jpg";
		unlink($file1);
		unlink($file2);
		//$text .= "$event_imgDir". $phoyo_id . "-thumb.jpg <br />$event_imgDir" . $phoyo_id . ".jpg";
		$text .= "De foto is verwijderd. Klik <a class=\"link1\" href=\"viewphoto.php?event_id=$event_id\">Hier om terug te gaan naar de foto's</a>";
		return $text;
	}

	function showPhoto($event_id, $image_id, $event_photoDir){
		// showPhoto with $event_id and $image_id

		if (0 == $image_id) {
			// First photo;
			$sql = "SELECT * FROM `foto` WHERE `event_id` = '$event_id' LIMIT 0 , 1";
		}
		else {
			// Other photo;
			$sql = "SELECT * FROM `foto` WHERE `event_id` = '$event_id' AND `foto_id` = '$image_id' LIMIT 0 , 1";
		}
		$exec = mysql_query($sql) or die("Error in showPhoto Query");
		if ($obj = mysql_fetch_object($exec)) {
			/* show photo */
			$queryFoto1 = "SELECT * FROM foto WHERE foto_id > '$obj->foto_id' AND event_id = '$obj->event_id' ORDER BY foto_id ASC LIMIT 1";
			$sqlFoto1 = mysql_query($queryFoto1) or die("Error");
			if($objFoto1 = mysql_fetch_object($sqlFoto1))
			$next = " || <a class=\"link1\" href=\"viewphoto.php?event_id=$obj->event_id&amp;photo_id=$objFoto1->foto_id\">Volgende Foto</a> ";

			$queryFoto1 = "SELECT * FROM foto WHERE foto_id < '$obj->foto_id' AND event_id = '$obj->event_id' ORDER BY foto_id DESC LIMIT 1";
			$sqlFoto1 = mysql_query($queryFoto1) or die("Error");
			if($objFoto1 = mysql_fetch_object($sqlFoto1))
			$prev = "<a class=\"link1\" href=\"viewphoto.php?event_id=$obj->event_id&amp;photo_id=$objFoto1->foto_id\">Vorige Foto</a> || ";
			
			$text = "$prev - $next<br />\n<img src=\"$event_photoDir/$obj->foto_id.jpg\" /> <br />";
			$text .= "<li><a class=\"link1\" href=\"deletephoto.php?photo_id=$obj->foto_id&amp;event_id=$event_id\" />Verwijder deze foto</a></li><br />";
		}
		else {
			$text = "Er zijn geen foto's (meer) bij dit evenement. Klik <a class=\"link1\" href=\"changeevent.php\" >hier</a> om terug te gaan.\n";
		}
		$text .= "<br />Reacties op deze foto:<br />";
		return $text;
	}

}
?>

