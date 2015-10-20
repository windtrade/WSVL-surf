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
<form name='addnews' action='' enctype='multipart/form-data' method='post' >
	<input type='hidden' name='addnews' value='true' />
	Titel van het nieuwsbericht: <input type='text' name='news_title' maxlength='255' width='100' class='form' /><br />
	<input type='checkbox' name='news_image' checked class='form' /> Ik wil een plaatje toevoegen aan dit nieuwsbericht <br />
	Samenvatting:<br /><textarea name='news_short' rows='10' cols='80' class='form' ></textarea><br />
	Volledige bericht:<br /><textarea name='news_message' rows='30' cols='80' class='form' ></textarea><br />
	<input type='submit' value='Toevoegen' class='form'/>
</form>";
		return $text;
	}
	
	function verifyStep1($news_title, $news_image, $news_short, $news_message )
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
				
		if( $news_message == "" )
		{
			$error++;
			$text .= "
	<span class='form'><b>Volledige bericht:</b></span>
			";
		$text .= "
	<br /><textarea name='news_message' rows='30' cols='80' class='form' >$news_message</textarea><br />
		";
		}		
		$text .= "
		<input type='submit' value='Toevoegen' class='form'/>
</form>
		";
		
		if($error == true)
			return $text;
		
		$text = "";
		echo $news_short;
		/* check for photo */
		if ($news_image == "on")
		{
			/* need form for photo */
			echo $this->news_short;
			$text = $this->step2Form();
			return $text;
		}
		else
		{
			/* do final make up text en put into db */
			$this->news_short = nl2br($news_short);
			$this->news_message = nl2br($news_short);
			$this->news_image = $news_image;
			$this->news_title = $news_title;
			
			$this->createMessage();
		}
	}
	
	function step2Form()
	{
		$text = "
<form name='addnews' action='' enctype='multipart/form-data' method='post' >
	<input type='hidden' name='addnews' value='true' />
	<inpyt type='hidden' name='step2' value='true' />
	<input type='hidden' name='news_title' value=";
//	echo $this->news_title;
	$text .= $this->news_title;
	$text .= "/>
	<input type='hidden' name='news_image' value='$this->news_image' />
	<input type='hidden' name='news_short' value='$this->news_short' />
	<input type='hidden' name='news_message' value='$this->news_message' />
	<input type='file' name='image' class='form' /><br />	
	<input type='submit' value='Toevoegen' class='form'/>
</form>
		";
		return $text;
	}
	
	function createMessage()
	{
		/* parse message and put in DB */
	}
	// or die(mysql_errno($link) . ": " . mysql_error($link). "<br />\n");
}
?>

