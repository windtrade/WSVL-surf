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

		$maanden = Array
		("nul","januari","februari","maart",
		"april","mei","juni","juli","augustus",
		"september","oktober","november",
		"december");
		$dagen = Array
		("Zo","Ma","Di",
		"Wo","Do","Vr",
		"Za");

?>
<?php 

	$query = "SELECT *, UNIX_TIMESTAMP(verslag_datum) AS datum FROM verslag ORDER BY datum DESC LIMIT 1";
	$sql = mysql_query($query) or die("error");
	//if($obj=mysql_fetch_object($sql))
	/*
	$query = "select * from event where event_id = '$event_id'";
	$sql = mysql_query($query) or die("error");*/
	while($obj=mysql_fetch_object($sql))
	{
		 
		$event_id = $obj->event_id;
		$lay_out->topEventId = $obj->event_id;
		$lay_out->topEventTitle = $obj->titel;
		$lay_out->topEventImage = "images/van_onze_razende_reporter.gif";
	
			$maand = $maanden[date("n",strtotime($obj->verslag_datum))];
			$dag = date("d",strtotime($obj->verslag_datum));
			$jaar = date("Y",strtotime($obj->verslag_datum));

			$lay_out->latestNewsDate = "$dag $maand $jaar";
	
	
		$verslag = substr($objVerslag->verslag, 0, 200);
		$verslag = explode("<br />", $obj->verslag);
		$verslag = $verslag[0];
		$lay_out->latestNewsMessage = nl2br($verslag)."<br />";
	
		$queryFoto = "SELECT * FROM foto WHERE event_id = '$event_id'";
		$sqlFoto = mysql_query($queryFoto);
		if($foto = mysql_fetch_object($sqlFoto))
		{
			$lay_out->latestNewsMessage .= "<a href=\"viewevent.php?event_id=$obj->event_id&amp;tab=foto#fotos\" ><img src=\"images/heter_bekijkfotos.gif\" border=\"0\" id=\"heterLeesverder\" /></a>\n";
		}

		$lay_out->latestNewsMessage .= "<a href=\"verslag_leesverder.php?event_id=$obj->event_id&amp;verslag_id=$obj->verslag_id&amp;tab=verslagen#text\" ><img src=\"images/heter_leesverder.gif\" border=\"0\" id=\"heterLeesverder\" /></a>\n";
	
	}

	$lay_out->rightImage = "images/kop_wedstrijden.gif";
	$lay_out->rightMessages = "";
	$query = " SELECT * FROM news WHERE news_rubriek_id = '2' ORDER BY news_sticky DESC, news_timestamp DESC LIMIT 0,10";
	$sql = mysql_query($query) or die("error");
	while($obj=mysql_fetch_object($sql))
	{
		$lay_out->rightMessages .="<div class=\"recentNieuwsBericht\">
					<span class=\"nieuwsTitel\">$obj->news_title</span><br />
					<span class=\"nieuwsAuteur\">$obj->news_date</span>
					<p>";
		$lay_out->rightMessages .= nl2br(str_replace("<br />", "", $obj->news_short));
		if ($obj->news_message)
		{
			$lay_out->rightMessages .= "<div class=\"miniLeesverder\"><a href=\"news_leesverder.php?news_id=$obj->news_id&tab=home\" ><img src=\"images/butt_sm_leesverder.gif\" border=\"0\"/></a></div><br />\n";
		}
		
		$lay_out->rightMessages .="</p></div>";
	
	}

	//SELECT DATE_FORM//AT('1997-10-04 22:23:00', '%W %M %Y');
	$queryVerslag = "SELECT *, UNIX_TIMESTAMP(verslag_datum) as datum FROM verslag ORDER BY datum DESC LIMIT 1, 9999999";
	$sqlVerslag = mysql_query($queryVerslag) or die("Error");
	$i = 0;
	$x = 0;

	while($objVerslag = mysql_fetch_object($sqlVerslag))
	{
		$queryUser = "SELECT * FROM cms_users WHERE user_id = '$objVerslag->verslag_userId'";
		$sqlUser = mysql_query($queryUser) or die("error");
		$queryEvent = "SELECT event_title FROM event WHERE event_id = '$objVerslag->event_id'";
		$sqlEvent = mysql_query($queryEvent);
		$objEvent = mysql_fetch_object($sqlEvent);
		$lay_out->titelImage = "images/kop_verslagen.gif";
		$verslag = substr($objVerslag->verslag, 0, 200);
		$verslag = explode("<br />", $objVerslag->verslag);
		$verslag = $verslag[0];
		$verslag = str_replace("<br />", "", $verslag);
		$datum = date("d-m-Y", $objVerslag->datum);
		$queryFoto = "SELECT * FROM foto WHERE event_id = '$objVerslag->event_id' ORDER BY foto_id ASC";
		$sqlFoto = mysql_query($queryFoto) or die("Error");
		$foto = "";

		if(mysql_num_rows($sqlFoto))
		{
			$foto = "<a href=\"viewevent.php?event_id=$objVerslag->event_id&tab=foto\">Bekijk de foto's</a> | ";
		}
	
		while($objUser=mysql_fetch_object($sqlUser)){
	
	
			if (5 >= $x)
			{
				if($objVerslag->verslag_id % 2)
				{
					$lay_out->partTwoText .=  "<div class=\"artikelKader\">";
				}
				else
				{
					$lay_out->partTwoText .=  "<div class=\"artikelKader kad1\">";
				}
	
				$lay_out->partTwoText .=  "<div class=\"verslagHomeAuteurInfo\">Event: <b>$objEvent->event_title</b></div>
					<div class=\"heterTitel\"><a href=\"verslag_leesverder.php?event_id=$objVerslag->event_id&amp;verslag_id=$objVerslag->verslag_id&amp;tab=verslagen#$objVerslag->verslag_id\">$objVerslag->titel</a></div>
					<p>$verslag</p>			
	
					
					<div class=\"verder\"><b>$objUser->user_realName</b> | $datum | $foto 0 reacties | <a href=\"verslag_leesverder.php?event_id=$objVerslag->event_id&amp;verslag_id=$objVerslag->verslag_id&amp;tab=verslagen#$objVerslag->verslag_id\">Lees verder &raquo;</a></div>";
				
				if(5 == $x)
				{
					$lay_out->partTwoText .=  "<div class=\"verslagHomeAuteurInfo\"><b>Nog meer verslagen:</b></div>";
				}
				$lay_out->partTwoText .=  "</div>";
	
			}
			else
			{
				$lay_out->partTwoText .=  "<div class=\"artikelKader\">";
	
				$lay_out->partTwoText .=  "<div class=\"verslagHomeAuteurInfo\">&middot; <b><a href=\"verslag_leesverder.php?event_id=$objVerslag->event_id&amp;tab=verslagen&amp;verslag_id=$objVerslag->verslag_id#$objVerslag->verslag_id\">$objVerslag->titel</a></b> door $objUser->user_realName</div>
					<!--<div class=\"heterTitel\">$objVerslag->titel</div>
					<p>$verslag...</p>			
	
					
					<div class=\"verder\">x = $x<b>$objUser->user_realName</b> | $datum | $foto 0 reacties | Lees verder &raquo;</a></div>-->
	
				</div>";
			}
	
		}
		$x++;
	}
	$lay_out->partTwoText .= "</table>";
	
	
	/* parse lay_out */
	echo $lay_out->build("Verslagen | ");
	
	/* send page to client */	
	ob_end_flush();

?>
