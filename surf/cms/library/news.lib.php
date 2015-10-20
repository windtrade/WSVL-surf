<?php
/* **********************************************************************
   **	dataBase library of Content Management System				   **
   **********************************************************************
   ** Created 27-7-04 Erwin Marges									   **
   ********************************************************************** */

class news{
	var $news_title;
	var $news_image;
	var $news_short;
	var $news_message;
	
	function step1Form(){
		$text = "

			<form name='addnews' action='' enctype='multipart/form-data' method='post' style='padding-left: 10px;'>
				<table width='70%'  border='0' cellspacing='0' cellpadding='4'>
                  <tr>
                    <td width='12%' align='right'><strong>Titel :&nbsp; </strong></td>
                    <td width='88%'><input name='news_title' type='text' class='form' size='45' maxlength='255' width='100' />
                    <input type='hidden' name='addnews' value='true' /></td>
                  </tr>
                  <tr>
                    <td align='right'><strong>Rubriek :&nbsp; </strong></td>
                    <td><select name='news_rubriek_id' id='news_rubriek_id' class='form'>
                      <option value='1'>Nieuws</option>
                      <option value='2'>Wedstrijden</option>
                    </select></td>
                  </tr>
                  <tr>
                    <td align='right'>&nbsp;</td>
                    <td><input type='checkbox' name='news_image' checked class='form' />
                    Ik wil een plaatje toevoegen aan dit nieuwsbericht </td>
                  </tr>
                  <tr>
                    <td align='right'>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr align='left'>
                    <td colspan='2' valign='top'><strong>Samenvatting :&nbsp;</strong></td>
                  </tr>
                  <tr align='left'>
                    <td colspan='2' valign='top'><textarea name='news_short' rows='10' cols='80' class='form' ></textarea></td>
                  </tr>
                  <tr>
                    <td align='right'>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan='2'><strong>Volledige bericht:</strong></td>
                  </tr>
                  <tr>
                    <td colspan='2' valign='top'><textarea name='news_message' rows='30' cols='80' class='form' ></textarea></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><input type='submit' value='Toevoegen' class='form'/></td>
                  </tr>
                </table>
			</form>

			";
		return $text;
	}
	
	function verifyStep1($news_title, $news_rubriek_id, $news_image, $news_short, $news_message )
	{
		$error = 0;
		$text = "
			<form name='addnews' action='' enctype='multipart/form-data' method='post' >
				<input type='hidden' name='addnews' value='true' />
				<input type='hidden' name='news_image' value='$news_image' />
		";

		if( $news_title == "" )
		{
			$error++;
			$text .= "
				<span class='form'><b>Titel van het nieuwsbericht:</b></span>
			";
		}

		$text .= "
			<input type='text' name='news_title' maxlength='255' width='100' class='form' value='$news_title'/><br />
		";
		
		if( $news_short == "" )
		{
			$error++;
			$text .= "
				<span class='form'><b>Samenvatting:</b></span>
			";
		}

		$text .= "
			<br /><textarea name='news_short' rows='10' cols='80' class='form' >$news_short</textarea><br />
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
		$text = "";
		/* final makeup and put in DB */
		$this->news_short = nl2br($news_short);
		$this->news_message = nl2br($news_message);
		$this->news_title = $news_title;
		$this->news_rubriek_id = $news_rubriek_id;
		$this->news_image = $news_image;
		$this->createMessage();

		if ($news_image == "on")
			$text = $this->step2Form();

		return $text;
	}
	
	function step2Form()
	{
		$text = "
			<form name='addnews' action='' enctype='multipart/form-data' method='post' >
				<input type='hidden' name='addnews' value='true' />
				<input type='hidden' name='step2' value='true' />
				<input type='hidden' name='news_title' value='$this->news_title'/>
				<input type='hidden' name='news_image' value='$this->news_image' />
				<input type='hidden' name='news_short' value='$this->news_short' />
				<input type='hidden' name='news_message' value='$this->news_message' />
				<input type='hidden' name='news_id' value='$this->news_id' />
				<input type='hidden' name='news_rubriek_id' value='$this->news_rubriek_id' />
				<input type='file' name='image' class='form' /><br />	
				<input type='submit' value='Toevoegen' class='form'/>
			</form>
		";
		return $text;
	}
	
	function createMessage()
	{
		/* parse message and put in DB */
		if ($this->news_image == "on")
			$image = 1;
		$datum=date("d-m-Y");
		$query  = "INSERT INTO news (news_rubriek_id, news_author_id, news_image, news_timestamp, news_title, news_short, news_message, news_event_id) VALUES ('$this->news_rubriek_id','$_SESSION[user_id]', '$image', now(), '$this->news_title',  '$this->news_short', '$this->news_message', '$this->news_event_id')";
		mysql_query($query)  or die("foutje");

		/* get message_id */

		$query = "SELECT news_id FROM news ORDER BY news_id DESC LIMIT 1";
		$sql = mysql_query($query);
		while($obj = mysql_fetch_object($sql))
		{
			$this->news_id = $obj->news_id;
		}
	}
	
	
	function changeStep1Form()
	{
		// Get news from db
		$sql = "SELECT * FROM news ORDER BY news_id DESC";
		$exec = mysql_query($sql) or die("Error bij het ophalen van nieuws");
		$text = '<form name="changeNews" method="post" action="" enctype="multipart/form-data" >';
		//$text = "<form name='changeText' action='' enctype='multipart/form-data' method='post' >
		$text .= "<input type='hidden' name='changenews' value='true' />
		Naam van het nieuwsbericht: <select name='news_id' class='form'>";
		/* get events */
		
		while($result = mysql_fetch_object($exec))
		{
			$text .= "<option value='$result->news_id'>$result->news_title</option>\n";
		}

		$text .= "</select>&nbsp;";
		$text .= "<input type=\"submit\" value=\"selecteer\">";

		return $text;
	}
	
	function changeStep2Form($news_id)
	{
		$sql = "SELECT * FROM news WHERE news_id = '$news_id'";
		$exec = mysql_query($sql) or die("Error bij het ophalen van Nieuws");
		$obj = mysql_fetch_object($exec);
		$text = "
			<form name='addnews' action='' enctype='multipart/form-data' method='post' >
				<input type='hidden' name='changenews' value='true' />
				<input type='hidden' name='step3' value='true' />
				<input type='hidden' name='news_id' value='$obj->news_id' />
				
		";

		//if( $news_title == "" )
		//{
			//$error++;
			$text .= "
				<span class='form'>&nbsp;Titel van het nieuwsbericht:</span>
			";
		//}

		$text .= "
			<input type='text' name='news_title' size='45' maxlength='255' width='100' class='form' value='$obj->news_title'/><br />
		";
		
		if($obj->news_rubriek_id == '1') { $sel1 = "selected"; }else{ $sel2 = "selected"; }
		$text .= "<br />&nbsp;<span class='form'>Rubriek: </span><select name='news_rubriek_id' id='news_rubriek_id' class='form'>
                      <option value='1' ".$sel1." >Nieuws</option>
                      <option value='2' ".$sel2." >Wedstrijden</option>
                    </select><br />&nbsp;<br />";
		
		//if( $news_short == "" )
		//{
			//$error++;
			$text .= "
				<span class='form'>&nbsp;Samenvatting:</span>
			";
		//}
		$news_short = str_replace("<br />", "",$obj->news_short);
		$news_message = str_replace("<br />", "",$obj->news_message);
		
		$text .= "
			<br /><textarea name='news_short' rows='10' cols='80' class='form' >$news_short</textarea><br />
		";

		//if( $news_message == "" )
		//{
			//$error++;
			$text .= "
				<span class='form'>Volledige bericht:</span>
			";
			$text .= "
				<br /><textarea name='news_message' rows='30' cols='80' class='form' >$news_message</textarea><br />
			";
		//}	*/
		
		$text .= "
			<input type='submit' value='Wijzig!' class='form'/>
			</form>
		";
		
		return $text;
	}
	function verifyStep1Change($news_id, $news_rubriek_id, $news_title, $news_image, $news_short, $news_message )
	{
		$error = 0;
		$text = "
			<form name='addnews' action='' enctype='multipart/form-data' method='post' >
				<input type='hidden' name='addnews' value='true' />
				<input type='hidden' name='news_image' value='$news_image' />
		";

		if( $news_title == "" )
		{
			$error++;
			$text .= "
				<span class='form'><b>Titel van het nieuwsbericht:</b></span>
			";
		}

		$text .= "
			<input type='text' name='news_title' maxlength='255' width='100' class='form' value='$news_title'/><br />
		";
		
		if( $news_short == "" )
		{
			$error++;
			$text .= "
				<span class='form'><b>Samenvatting:</b></span>
			";
		}

		$text .= "
			<br /><textarea name='news_short' rows='10' cols='80' class='form' >$news_short</textarea><br />
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
		$text = "";
		/* final makeup and put in DB */
		$this->news_short = nl2br($news_short);
		$this->news_message = nl2br($news_message);
		$this->news_title = $news_title;
		$this->news_image = $news_image;
		$this->news_rubriek_id = $news_rubriek_id;
		$this->changeMessage($news_id);

		//if ($news_image == "on")
			//$text = $this->step2Form();
		$text = "Nieuws bericht gewijzigd.";
		return $text;
	}
	
	function changeMessage($news_id)
	{
		$sql = "UPDATE news SET news_rubriek_id = '$this->news_rubriek_id', news_short = '$this->news_short', news_message = '$this->news_message', news_title = '$this->news_title' WHERE news_id = '$news_id' LIMIT 1";
		mysql_query($sql) or die("Fout bij nieuws wijzigen :/");
	}
	
}
?>

