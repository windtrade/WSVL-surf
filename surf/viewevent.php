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
if($_GET[event_id])
{

	$query = "select * from event where event_id = '$_GET[event_id]'";
	$sql = mysql_query($query) or die("error");

	while($obj=mysql_fetch_object($sql))
	{
		$page_event_title = $obj->event_title;

		$lay_out->topEventId = $obj->event_id;
		$lay_out->partTwoText = "<span class=\"heterTitel\"> $obj->event_title</span> <br />";
		$lay_out->partTwoText .= date("d-m-Y", strtotime($obj->event_timestamp))." <br />";
		$lay_out->partTwoText .= nl2br($obj->event_text);
		/*if ($obj->news_message)
		$lay_out->latestNewsMessage .= "<a href=\"news_leesverder.php?news_id=$obj->news_id\" ><img src=\"images/heter_leesverder.gif\" width=\"112\" height=\"18\" border=\"0\" id=\"heterLeesverder\" /></a><br />\n";
		$lay_out->latestNewsId = $obj->news_id;*/

	}
	$lay_out->rightImage = "images/kop_recent-nieuws.gif";
	$lay_out->rightMessages = "";
	$query = "SELECT * FROM news WHERE news_rubriek_id = '1' ORDER BY news_id DESC LIMIT 0,5";
	$sql = mysql_query($query) or die("error");
	while($obj=mysql_fetch_object($sql)){
		$lay_out->rightMessages .="<div class=\"recentNieuwsBericht\">
				<span class=\"nieuwsTitel\">$obj->news_title</span><br />
				<span class=\"nieuwsAuteur\">$obj->news_date</span>
				<p>";
		$lay_out->rightMessages .= nl2br($obj->news_short);
		if ($obj->news_message)
		$lay_out->rightMessages .= "<div class=\"miniLeesverder\"><a href=\"news_leesverder.php?news_id=$obj->news_id&tab=home\" ><img src=\"images/butt_sm_leesverder.gif\" border=\"0\"/></a></div><br />\n";
		$lay_out->rightMessages .="</p>
			</div>";

	}
	//ELECT DATE_FORM//AT('1997-10-04 22:23:00', '%W %M %Y');
	$lay_out->partTwoText .= "\n<br />";
	$queryVerslag = "SELECT * FROM verslag WHERE event_id = '$_GET[event_id]' ORDER BY verslag_id DESC";
	$sqlVerslag = mysql_query($queryVerslag);
	while ($verslagObj = mysql_fetch_object($sqlVerslag)) {
		$queryUser = "SELECT user_realName FROM cms_users WHERE user_id = '$verslagObj->verslag_userId'";
		$sqlUser = mysql_query($queryUser);
		$user = mysql_fetch_object($sqlUser);
		$lay_out->partTwoText .= "<ul><li><a href=\"verslag_leesverder.php?event_id=$_GET[event_id]&amp;verslag_id=$verslagObj->verslag_id&amp;tab=verslagen\"> Verslag geschreven op ".date("d-m-Y", strtotime($verslagObj->verslag_datum))." door: $user->user_realName</a></li></ul>\n";
	}

	$queryFoto = "SELECT * FROM foto WHERE event_id = '$_GET[event_id]' ORDER BY foto_id ASC";
	$sqlFoto = mysql_query($queryFoto) or die("Error");
	if(mysql_num_rows($sqlFoto)){
		/* Er zijn foto's */
		$i = 0;
		$lay_out->titelImage = "images/kop_fotogalerij.gif";
		$lay_out->partTwoText .= "<table><tr>\n";
		while($objFoto = mysql_fetch_object($sqlFoto))
		{
			/*$query = "SELECT *, UNIX_TIMESTAMP(event_timestamp) as datum from event WHERE event_id = '$objFoto->event_id'";
			$sql = mysql_query($query) or die("error");*/


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
			$image = "$objFoto->foto_id-thumb.jpg";
			if(0 == ($i %3))
			$lay_out->partTwoText .= "</tr><tr>";
			if ( 0 == ($i %2))
			$lay_out->partTwoText .= "<td class=\"backgroundDGeel\"><a href=\"viewphoto.php?photo_id=$objFoto->foto_id&tab=foto\"><img src=\"images/event/photo/$image\" class=\"galleryThumb\" height=\"98\" border=\"0\" /></a> </td>";
			else
			$lay_out->partTwoText .= "<td class=\"backgroundDBlauw\"><a href=\"viewphoto.php?photo_id=$objFoto->foto_id&tab=foto\"><img src=\"images/event/photo/$image\" class=\"galleryThumb\" height=\"98\" border=\"0\" /></a> </td>";

			$i++;
			/*//$image = "$objFoto->foto_id-thumb.jpg";
			$query2 = "SELECT * FROM foto WHERE event_id = $objFoto->event_id ORDER BY RAND() LIMIT 1";
			$sql2 = mysql_query($query2) or die("error");
			$obj2 = mysql_fetch_object($sql2);
			$image = "$obj2->foto_id-thumb.jpg";
			$lay_out->partTwoText .=  "<div class=\"surferFoto\"><img src=\"images/event/photo/$image\" height=\"98\" border=\"0\" /></div>";
			$lay_out->partTwoText .=  "<div class=\"surferDesc\"><span class=\"nieuwsTitel\">$obj->event_title ";
			$lay_out->partTwoText .= date("j F", $obj->datum);
			$lay_out->partTwoText .= "</span><br />$obj->event_text</div></div>";
			/*if (time() > $obj->datum)
			$lay_out->partTwoText .= "<td class=\"kalenderGeweest\">$obj->event_title</td>";
			else
			$lay_out->partTwoText .= "<td>$obj->event_title</td>";
			$lay_out->partTwoText .= "</tr>";*/



		}//}
	}
}
$lay_out->partTwoText .= "</tr></table>";


/* parse lay_out */
echo $lay_out->build("Foto album - ".$page_event_title." | ");





/* send page to client */

ob_end_flush();
?>
