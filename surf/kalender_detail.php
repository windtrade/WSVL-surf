<?php

	/* start output buffering */
	ob_start();
	
	/* start the session */
	session_start();
	
	/* includes */
	include "library/config.inc.php";
	include "library/layout.lib.php";
	include "library/db.lib.php";
	
	/* start db */
	$db = new dataBase();
	$db->initialise($mysql_user, $mysql_password, $mysql_host, $mysql_dbName);
	
	/* start lay_out */
	$lay_out = new LayOut();

?>

<?php 

	$maanden = Array
	("nul","januari","februari","maart",
	"april","mei","juni","juli","augustus",
	"september","oktober","november",
	"december");
	$dagen = Array
	("Zo","Ma","Di",
	"Wo","Do","Vr",
	"Za");
	
	
	$query = " SELECT * FROM event WHERE event_onTop = '1' AND event_timestamp >= NOW() ORDER BY event_timestamp ASC LIMIT 1 ";
	$sql = mysql_query($query) or die("error");

	while($obj=mysql_fetch_object($sql))
	{
		$lay_out->topEventId = $obj->event_id;
		$lay_out->topEventTitle = $obj->event_title;
		$lay_out->topEventImage = "images/upcoming_event.gif";

		$maand = $maanden[date("n",strtotime($obj->event_timestamp))];
		$dag = date("d",strtotime($obj->event_timestamp));
		$jaar = date("Y",strtotime($obj->event_timestamp));

		$lay_out->latestNewsDate = "$dag $maand $jaar";
		$lay_out->latestNewsMessage = nl2br($obj->event_text);

		/*if ($obj->news_message)
		$lay_out->latestNewsMessage .= "<a href=\"news_leesverder.php?news_id=$obj->news_id\" ><img src=\"images/heter_leesverder.gif\" width=\"112\" height=\"18\" border=\"0\" id=\"heterLeesverder\" /></a><br />\n";
		$lay_out->latestNewsId = $obj->news_id;*/
	
	}

	$lay_out->rightImage = "images/kop_evenementen.gif";
	$lay_out->rightMessages = "";

	$query = " SELECT * FROM teksten WHERE id IN (4,6,7,8,9,10,11,13) AND tekst != '' ORDER BY id ASC ";
	$sql = mysql_query($query) or die("error");

	while($obj=mysql_fetch_object($sql))
	{
		$lay_out->rightMessages .="<div class=\"recentNieuwsBericht\">
					<span class=\"nieuwsTitel\">$obj->titel</span><br />
					<span class=\"nieuwsAuteur\">$obj->news_date</span>
					<p>";
		$lay_out->rightMessages .= nl2br(str_replace("<br />", "", $obj->tekst));
		if ($obj->news_message)
		{
			$lay_out->rightMessages .= "<div class=\"miniLeesverder\"><a href=\"news_leesverder.php?news_id=$obj->news_id\" ><img src=\"images/butt_sm_leesverder.gif\" border=\"0\"/></a></div><br />\n";
		}
		$lay_out->rightMessages .="</p>\n</div>";
	
	}

	//SELECT DATE_FORM//AT('1997-10-04 22:23:00', '%W %M %Y');
	$query = "SELECT *, UNIX_TIMESTAMP(event_timestamp) as datum from event WHERE event_onCalendar = '1' AND event_timestamp > now() order by event_timestamp ASC";
	$sql = mysql_query($query) or die("error");
	$i = 0;
	$lay_out->titelImage = "images/kop_kalender.gif";
	$lay_out->partTwoText = "<strong>De evenementen en (club)wedstrijden kalender voor ".date("Y").".</strong><p></p>
			<table width=\"100%\" style=\"border-top: 1px dashed #006699; border-bottom: 1px dashed #006699;\"  border=\"0\" cellpadding=\"5\" cellspacing=\"0\">";

	while($obj=mysql_fetch_object($sql))
	{
		$i++;
	
		if ( 0 == ($i %2))
		$lay_out->partTwoText .= "<tr class=\"backgroundGeel\">";
		else
		$lay_out->partTwoText .= "<tr class=\"backgroundBlauw\">";
	
	
		$lay_out->partTwoText .=  "<td align=\"center\">";
		$maand = $maanden[date("n",$obj->datum)];
		$dag = $dagen[date("w",$obj->datum)];
		$dag2 = date("d",$obj->datum);
		$dag3 = "$dag $dag2";
		if (2 <= $obj->event_length)
		{
			$end_date = mktime (0, 0, 0, date("m",$obj->datum),    date("d",$obj->datum) + ($obj->event_length - 1), date("Y",$obj->datum));
			$eind_datum = date("d",$end_date);

			// Vallen de twee data wel binnen dezelfde maand
			if(date("m",$obj->datum) != date("m",$end_date))
			{
				$maand1 = $maanden[date("n",$obj->datum)];
				$maand2 = $maanden[date("n",$end_date)];

				$lay_out->partTwoText .= "$dag2 $maand1 - $eind_datum $maand2";
			}
			else
			{
				$lay_out->partTwoText .= "$dag2 - $eind_datum $maand";
			}
		}
		else 
		{
			$lay_out->partTwoText .= "$dag3 $maand";
		}

		$lay_out->partTwoText .= "</td>";
	
		if (time() > $obj->datum)
		{
			//$lay_out->partTwoText .= "<td class=\"kalenderGeweest\">$obj->event_title</td>";
		}
		else
		{
			if( $obj->datum < (time()+604800) )
			{
				$lay_out->partTwoText .= "<td><strong>$obj->event_title</strong></td>";
			}
			else
			{
				$lay_out->partTwoText .= "<td>$obj->event_title</td>";
			}
		}
	
		$lay_out->partTwoText .= "</tr>";
	
	
	}
	
	$lay_out->partTwoText .= "</table>";
	$lay_out->rightMessages = 	$lay_out->partTwoText;
	$query = "SELECT *, UNIX_TIMESTAMP(event_timestamp) as datum from event WHERE event_id = '$_GET[event_detail]' LIMIT 1";
	$sql = mysql_query($query) or die("error");
	$i = 0;
	$lay_out->titelImage = "images/kop_kalender.gif";


	while($obj=mysql_fetch_object($sql))
	{
		$lay_out->partTwoText = "<strong>Uitgebreide informatie over $obj->event_title</strong><p>";
		$lay_out->partTwoText .= nl2br($obj->event_detail);
		$lay_out->partTwoText .= "</p>";
	}
	
	/* parse lay_out */
	echo $lay_out->build("Kalender | ");
	
	
	/* send page to client */	
	ob_end_flush();

?>
