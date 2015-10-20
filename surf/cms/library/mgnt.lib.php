<?php
/* **********************************************************************
   **	dataBase library of Content Management System				   **
   **********************************************************************
   ** Created 27-7-04 Erwin Marges									   **
   ********************************************************************** */

class Mgnt{

	
	
	function getUsers()
	{
		
		$sql = "SELECT * FROM cms_users WHERE mgnt = 'true'";
		$exec = mysql_query($sql) or die("Error bij het ophalen van users");
		
		$i=0;
		while($result = mysql_fetch_object($exec)){
			$text .= "<input type='checkbox' name='user$result->user_id'>$result->user_realName";
			$i++;
			if($i==3)
			{
				$text.="<br />";
				$i=0;
			}
			
		}

		
		
		
		return $text;
		}
	function addTask($users, $date, $task)
	{
		/* parse message and put in DB */
		$datum=date("d-m-Y");
		$query  = "INSERT INTO tasks (description, enddate) VALUES ('$task','$date')";
		mysql_query($query)  or die("foutje");

		/* get message_id */

		$query = "SELECT taskid FROM tasks WHERE description = '$task' ORDER BY taskid DESC LIMIT 1";
		$sql = mysql_query($query);
		while($obj = mysql_fetch_object($sql))
		{
			$taskId = $obj->taskid;

			foreach($users as $userId)
			{
			echo "$userId  ";
//			echo "INSERT INTO tasksusers (userId,taskId) VALUES('$userId', '$taskId')";
			mysql_query("INSERT INTO tasksUsers (userId,taskId) VALUES('$userId', '$taskId')");
			}
		}
	}
	
	function getAllTasks()
	{
		$sql = "SELECT *, UNIX_TIMESTAMP(t.enddate) as datum FROM tasks t order by t.enddate";
		$exec = mysql_query($sql) or die("Error bij het ophalen van tasks");
		$text = "Alle taken:<br /><table>
	<tr width='100%'><td class='td2'>Einddatum:</td><td class='td2'>Status:</td><td class='td2'>Taak:</td><td class='td2'>Personen:</td></tr>";
		
		while($result = mysql_fetch_object($exec)){
		$datee = date("d-m-Y", $result->datum);
			$text .= "<tr width='100%'><td class='td2'>$datee</td><td class='td2'>$result->status</td><td class='td2'>$result->description</td><td class='td2'>";
			$sql2 = "SELECT u.user_realName as name
FROM cms_users u, tasksUsers g
WHERE u.user_id = g.userId AND g.taskId = '$result->taskId'";
			$exec2 = mysql_query($sql2) or die("Error bij het ophalen van tasks");
			while($result2 = mysql_fetch_object($exec2)){
				$text .="$result2->name ";
			}
			$text.= "</td></tr>\n";
			
		}

		$text .= "</table>&nbsp;";
		


		return $text;
	}
	function getMyTasks()
	{
		$sql = "SELECT *, UNIX_TIMESTAMP(t.enddate) as datum
FROM tasks t, tasksUsers u
WHERE u.taskId = t.taskId AND u.userId = '$_SESSION[user_id]' order by t.enddate";
		$exec = mysql_query($sql) or die("Error bij het ophalen van tasks");
		$text = "Mijn taken:<br /><table>
	<tr width='100%'><td class='td2'>Einddatum:</td><td class='td2'>Status:</td><td class='td2'>Taak:</td></tr>";
		
		while($result = mysql_fetch_object($exec)){
		$datee = date("d-m-Y", $result->datum);
			$text .= "<tr width='100%'><td class='td2'> $datee </td><td class='td2'>$result->status</td><td class='td2'>$result->description</td></tr>\n";
			
			
			
		}

		$text .= "</table>&nbsp;";
		


		return $text;
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
		
		while($result = mysql_fetch_object($exec)){
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
				<span class='form'>Titel van het nieuwsbericht:</span>
			";
		//}

		$text .= "
			<input type='text' name='news_title' maxlength='255' width='100' class='form' value='$obj->news_title'/><br />
		";
		
		//if( $news_short == "" )
		//{
			//$error++;
			$text .= "
				<span class='form'>Samenvatting:</span>
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
	function verifyStep1Change($news_id, $news_title, $news_image, $news_short, $news_message )
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
		$this->changeMessage($news_id);

		//if ($news_image == "on")
			//$text = $this->step2Form();
		$text = "Nieuws bericht gewijzigd.";
		return $text;
	}
	
	function changeMessage($news_id)
	{
		$sql = "UPDATE news SET news_short = '$this->news_short', news_message = '$this->news_message', news_title = '$this->news_title' WHERE news_id = '$news_id' LIMIT 1";
		mysql_query($sql) or die("Fout bij nieuws wijzigen :/");
	}
	
}
?>

