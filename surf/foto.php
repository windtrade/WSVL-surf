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

	$query = " SELECT f.event_id FROM foto f, event e WHERE e.event_id = f.event_id AND f.event_id != 117 AND e.showOnImages = 'true' ORDER BY e.event_timestamp DESC LIMIT 1";
	$sql = mysql_query($query) or die("error");

	if($obj=mysql_fetch_object($sql))
	$event_id = $obj->event_id;
	$query = " SELECT * FROM event WHERE event_id = '$event_id' ";
	$sql = mysql_query($query) or die("error");
	while($obj=mysql_fetch_object($sql)){
		$lay_out->topEventId = $obj->event_id;
		$lay_out->topEventTitle = $obj->event_title;
		$lay_out->topEventImage = "images/direct_uit_de_camera.gif";
		$lay_out->latestNewsDate = date("d-m-Y", strtotime($obj->event_timestamp));
		$lay_out->latestNewsMessage = nl2br($obj->event_text);
	
		$lay_out->latestNewsMessage .= "<a href=\"viewevent.php?event_id=$obj->event_id&amp;tab=foto#fotos\" ><img src=\"images/heter_bekijkfotos.gif\" border=\"0\" id=\"heterLeesverder\" /></a><br />\n";
		$queryVerslag = "SELECT * FROM verslag WHERE event_id = '$event_id' ";
		$sqlVerslag = mysql_query($queryVerslag);
		if($verslag = mysql_fetch_object($sqlVerslag))
		$lay_out->latestNewsMessage .= "<a href=\"verslag_leesverder.php?event_id=$obj->event_id&amp;tab=verslagen&amp;verslag_id=$verslag->verslag_id\" ><img src=\"images/heter_leesverder.gif\" border=\"0\" id=\"heterLeesverder\" /></a><br />\n";
	
	}
	$lay_out->rightImage = "images/kop_recent-nieuws.gif";
	$lay_out->rightMessages = "";
	$query = " SELECT * FROM news WHERE news_rubriek_id = '1' ORDER BY news_id desc LIMIT 0,5 ";
	$sql = mysql_query($query) or die("error");
	while($obj=mysql_fetch_object($sql)){
		$lay_out->rightMessages .="<div class=\"recentNieuwsBericht\">
					<span class=\"nieuwsTitel\">$obj->news_title</span><br />
					<span class=\"nieuwsAuteur\">$obj->news_date</span>
					<p>";
		$lay_out->rightMessages .= nl2br(str_replace("<br />", "", $obj->news_short));
		if ($obj->news_message)
		$lay_out->rightMessages .= "<div class=\"miniLeesverder\"><a href=\"news_leesverder.php?news_id=$obj->news_id&tab=home\" ><img src=\"images/butt_sm_leesverder.gif\" border=\"0\"/></a></div><br />\n";
		$lay_out->rightMessages .="</p>
				</div>";
	
	}
	//ELECT DATE_FORM//AT('1997-10-04 22:23:00', '%W %M %Y');
	//$queryFoto = "SELECT distinct(f.event_id) FROM foto f, event e WHERE f.event_id = e.event_id AND f.event_id != '$event_id' ORDER BY e.event_timestamp DESC";

	$uitgesloten_events = "28,101,117,".$event_id;
	$queryFoto = "SELECT DISTINCT (f.event_id), UNIX_TIMESTAMP( e.event_timestamp ) AS datum, e.event_text, e.event_title FROM foto f, event e WHERE f.event_id = e.event_id AND f.event_id NOT IN ($uitgesloten_events) AND e.showOnImages = 'true' ORDER BY e.event_timestamp DESC LIMIT 0 , 50";
	$sqlFoto = mysql_query($queryFoto) or die("Error");
	$i = 0;
	while($objFoto = mysql_fetch_object($sqlFoto))
	{
		//$query = "SELECT *, UNIX_TIMESTAMP(event_timestamp) as datum from event WHERE event_id = '$objFoto->event_id'";
		//$sql = mysql_query($query) or die("error");
	
		$lay_out->titelImage = "images/kop_fotogalerij.gif";
		//$lay_out->partTwoText .= "<p><strong></strong></p>
		//<!--<table width=\"100%\" style=\"border-top: 1px dashed #006699; border-bottom: 1px dashed #006699;\"  border=\"0\" cellpadding=\"5\" cellspacing=\"0\">-->";
	
		/*<div class="surferKader backgroundGeel">
		<div class="surferFoto"><img src="images/foto_surfles.jpg" width="133" height="114" border="0" /></div>
		<div class="surferDesc"><span class="nieuwsTitel">Surfles 30 mei </span><br />
		De foto's van de surflessen van vadaag staan er weer op. Klik hierboven op "foto's" om ze te bekijken.
		Mocht je het origineel willen hebben, stuur dan een mailtje naar E.Marges@planet.nl</div>
		</div>
	
		<div class="surferKader backgroundBlauw">
		<div class="surferFoto"><img src="images/foto_clubwedstrijd.jpg" width="133" height="93" border="0" /></div>
	
		<div class="surferDesc"><span class="nieuwsTitel">Clubwedstrijd 21 maart 2004</span><br>
		Een fotoverslag van de eerste clubwedstrijd van het seizoen, die we meteen begonnen met heel veel wind en een mooie downwind slalom.</div>
		</div>*/
		//while($obj=mysql_fetch_object($sql)){
			$i++;
	
			if ( 0 == ($i %2))
			$lay_out->partTwoText .= "<div class=\"surferKader backgroundGeel\">";
			else
			$lay_out->partTwoText .= "<div class=\"surferKader backgroundBlauw\">";
	
			//$image = "$objFoto->foto_id-thumb.jpg";
			$query2 = "SELECT * FROM foto WHERE event_id = $objFoto->event_id ORDER BY RAND() LIMIT 1";
			$sql2 = mysql_query($query2) or die("error");
			$obj2 = mysql_fetch_object($sql2);
			$image = "$obj2->foto_id-thumb.jpg";
			$lay_out->partTwoText .=  "<div class=\"surferFoto\"><a href=\"viewevent.php?event_id=$objFoto->event_id&amp;tab=foto\"><img src=\"images/event/photo/$image\" height=\"98\" border=\"0\" /></a></div>";
			$lay_out->partTwoText .=  "<div class=\"surferDesc\"><i>[".date("j F", $objFoto->datum)."]</i> <span class=\"nieuwsTitel\"><a href=\"viewevent.php?event_id=$objFoto->event_id&amp;tab=foto\">$objFoto->event_title</a></span>";
			$lay_out->partTwoText .= "<br />$objFoto->event_text</div></div>";
			/*if (time() > $obj->datum)
			$lay_out->partTwoText .= "<td class=\"kalenderGeweest\">$obj->event_title</td>";
			else
			$lay_out->partTwoText .= "<td>$obj->event_title</td>";
			$lay_out->partTwoText .= "</tr>";*/
	
	
	
		}
	//}
	
	//$lay_out->partTwoText .= "</table>";
	
	
	/* parse lay_out */
	echo $lay_out->build("Foto album | ");
	
	
	
	
	
	/* send page to client */
	
	ob_end_flush();
?>
