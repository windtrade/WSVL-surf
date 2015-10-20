<?php
/* **********************************************************************
**	dataBase library of Content Management System				   **
**********************************************************************
** Created 27-7-04 Erwin Marges									   **
********************************************************************** */

class tekst{
	var $title;
	var $event_image;
	var $event_text;
	var $event_date;
	var $event_onCalendar;
	var $event_onTop;
	var $event_id;


	function step1Form(){
		$text = "
<form name='addevent' action='' enctype='multipart/form-data' method='post' >
	<input type='hidden' name='addtext' value='true' />
	Naam van de tekst: <input type='text' name='title' maxlength='255' width='100' class='form' /><br />
	<input type='submit' value='Toevoegen' class='form'/>
</form>";
		return $text;
	}

	function changeStep1Form($event_id){
		$query = " SELECT * FROM event where event_id = '$event_id' ";
		$sql = mysql_query($query);
		if($result = mysql_fetch_object($sql)){


			$text = "
<form name='addevent' action='' enctype='multipart/form-data' method='post' >
	<input type='hidden' name='changeevent' value='true' />
	<input type='hidden' name='step1' value='true' />
	<input type='hidden' name='event_id' value='$event_id' />
	Naam van het evenement: <input type='text' name='event_title' maxlength='255' width='100' class='form' value='$result->event_title'/><br />

";
			if($result->event_onCalendar == 1)
			$text .= "<input type='checkbox' name='event_onCalendar' class='form' checked/>\n";
			else
			$text .= "<input type='checkbox' name='event_onCalendar' class='form' />\n";
			$text .= "Dit evenement moet op de kalender geplaatst worden <br />";
			if($result->event_onTop == 1)
			$text .= "<input type='checkbox' name='event_onTop' class='form' checked/>\n";
			else
			$text .= "<input type='checkbox' name='event_onTop' class='form' />\n";
			$text .= "Dit evenement wordt groot aangekondigd op de kalender pagina <br />
	Informatie over het evenement:<br /><textarea name='event_text' rows='10' cols='80' class='form' >$result->event_text</textarea><br />
	<input type='submit' value='Wijzigen' class='form'/>
</form>";
		}
		return $text;
	}

	function changeEvent(){
		$text = "<form name='changeevent' action='' enctype='multipart/form-data' method='post' >
	<input type='hidden' name='changeevent' value='true' />
	Naam van het evenement: <select name='event_id'>";
		/* get events */
		$query = "SELECT * FROM event";
		$sql = mysql_query($query);
		while($result = mysql_fetch_object($sql)){
			$text .= "<option value='$result->event_id'>$result->event_title</option>\n";
		}
		$text .= "</select><input type='submit' value='Wijzigen' class='form'/>
</form>";
		return $text;
	}

	function verifyStep1Change($event_title, $event_onTop, $event_onCalendar, $event_text, $event_id )
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
		$this->changeMessage();

		if ($event_image == "on")
		$text = $this->step2Form();
		else
		$text = "Het event is aangepast\n";
		return $text;
	}


	function verifyStep1($title)
	{
		$this->title = $title;
		$error = 0;
		$text = "
<form name='addevent' action='' enctype='multipart/form-data' method='post' >
	<input type='hidden' name='addtext' value='true' />
	
		";

		if( $title == "" )
		{
			$error++;
			$text .= "
	<span class='form'><b>Titel van de tekst:</b></span>
			";
		}elseif (1 == $this->createTitle()){
			$text .= "
	<span class='form'><b>Er bestaat al een tekst met deze titel.<br /></b><b>Titel van de tekst:</b></span>
			";
		}
		$text .= "
	<input type='text' name='title' maxlength='255' width='100' class='form' /><br />
		";

		
		$text .= "
		<input type='submit' value='Toevoegen' class='form'/>
</form>
		";

		if($error == true)
		return $text;

		/* no error reset $text string */
		$text = "Tekst is toegevoegd.";
		/* final makeup and put in DB */
		return $text;
	}

	function step2Form($tekst_id)
	{
		$query = " SELECT * FROM teksten WHERE id = '$tekst_id' ";
		$sql = mysql_query($query) or die("ërror");
		$obj = mysql_fetch_object($sql);
		$tekst = str_replace("<br />","",$obj->tekst);
		$text = "
<form name='edittext' action='' enctype='multipart/form-data' method='post' >
	
	<input type='hidden' name='step2' value='true' />
	
	
	<input type='hidden' name='id' value='$tekst_id' />
	Titel van de tekst:<input type='tekst' name='titel' value=\"$obj->titel\" class='form' style='padding: 6px;' /><br /><br />
	Rubriek voor de tekst: 

		<select name='rubriek_id' id='rubriek_id' class='form'>
			<option value='0'> geen rubriek </option>";

		$rubr_query = " SELECT * FROM teksten_rubrieken ORDER BY rubriek_titel ASC ";
		$rubr_sql = mysql_query($rubr_query) or die("error");

		while($rubr_result = mysql_fetch_object($rubr_sql))
		{	
			if($obj->rubriek_id == $rubr_result->rubriek_id) { $sel = "selected"; }else{ $sel = ""; } 
			$text .= "			<option value='$rubr_result->rubriek_id' $sel >- $rubr_result->rubriek_titel </option> ";
		}


		$text .= "
		</select> <i>(wanneer relevant)</i><br /><br />

	<textarea name='tekst' rows='30' cols='100' class='form' style='padding: 6px;'>$tekst</textarea><br />
	<input type='text' name='bron' id='bron' value='$obj->bron' class='form' style='padding: 6px;' /><br />
	<input type='submit' value='Plaatsen' class='form'/>
</form>
		";
		return $text;
	}

	function createTitle()
	{
		$query = "SELECT * FROM teksten WHERE titel = '$this->title'";
		$sql = mysql_query($query);
		if( 0 == ($rows = mysql_num_rows($sql))){
			/* Title does not exist. */
			$query = "INSERT INTO teksten (titel) VALUES ('$this->title')";
			mysql_query($query);
		}
		else
		{
			/* Title does exist */
			return 1;
		}
		return 0;
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
		$query  = "UPDATE event SET event_onTop = '$this->event_onTop', event_onCalendar = '$this->event_onCalendar', event_title = '$this->event_title', event_text = '$this->event_text' where event_id = '$this->event_id'";
		mysql_query($query);

		/* get message_id */


	}
	// or die(mysql_errno($link) . ": " . mysql_error($link). "<br />\n");


	function selectEvent(){
		$text = "<form name='changeevent' action='' enctype='multipart/form-data' method='post' >
			<input type='hidden' name='addphoto' value='true' />
	Naam van het evenement: <select name='event_id' class='form'>";
		/* get events */
		$query = "SELECT * FROM event";
		$sql = mysql_query($query);
		while($result = mysql_fetch_object($sql)){
			$text .= "<option value='$result->event_id'>$result->event_title</option>\n";
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
		$text .= "<input type='submit' value='Stuur fotos!' class='form'/>
</form>";
		return $text;
	}

	function editTextForm(){
		$text = "<form name='changetext' action='' enctype='multipart/form-data' method='post' >
			<input type='hidden' name='edittext' value='true' />
	Naam van de tekst: <select name='text_id' class='form'>";
		/* get events */
		$query = "SELECT * FROM teksten";
		$sql = mysql_query($query);
		while($result = mysql_fetch_object($sql)){
			$text .= "<option value='$result->id'>$result->titel</option>\n";
		}
		$text .= "</select><br />";
		$text .= "<br /><input type='submit' value='Kies tekst!' class='form'/>
</form>";
		return $text;
	}
	
	function addText($event_id, $eventText){
		/* Verslag toevoegen */
		if($eventText){
			/*Er is tekst ingevoerd */
			$eventText = nl2br($eventText);
			/*make date*/
			$date = date("y-m-d");
			$query = "INSERT INTO verslag (event_id, verslag_userId, verslag_datum, verslag) VALUES
				('$event_id', '$_SESSION[user_id]', '$date', '$eventText')";
			mysql_query($query) or die("Error bij teksttoevoegen, Datum: $date");
		}
	}
	
	function editText($text_id, $titel, $tekst, $rubriek_id, $bron){
		//$query = "UPDATE teksten SET titel = '$titel' AND tekst = '$tekst' WHERE id = '$text_id'";
		$tekst = nl2br($tekst);
		$query = "UPDATE teksten SET titel = '$titel', tekst = '$tekst', rubriek_id = '$rubriek_id', bron = '$bron' WHERE id = '$text_id' LIMIT 1 ";
		mysql_query($query);
		return "De tekst is aangepast";
	}


}
?>

