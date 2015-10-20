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
if($_GET[surfer_id]){


	/*if ($obj->news_message)
		$lay_out->latestNewsMessage .= "<a href=\"news_leesverder.php?news_id=$obj->news_id\" ><img src=\"images/heter_leesverder.gif\" width=\"112\" height=\"18\" border=\"0\" id=\"heterLeesverder\" /></a><br />\n"; 
	$lay_out->latestNewsId = $obj->news_id;*/
	

/*$lay_out->rightImage = "images/kop_recent-nieuws.gif";
		$lay_out->rightMessages = "";
		$query = "select * from news order by news_id desc limit 0,5";
$sql = mysql_query($query) or die("error");
while($obj=mysql_fetch_object($sql)){
	$lay_out->rightMessages .="<div class=\"recentNieuwsBericht\">
				<span class=\"nieuwsTitel\">$obj->news_title</span><br />
				<span class=\"nieuwsAuteur\">$obj->news_date</span>
				<p>";
	$lay_out->rightMessages .= nl2br($obj->news_short);
	if ($obj->news_message)
		$lay_out->rightMessages .= "<a href=\"news_leesverder.php?news_id=$obj->news_id\" ><img src=\"images/heter_leesverder.gif\" width=\"112\" height=\"18\" border=\"0\"/></a><br />\n"; 
	$lay_out->rightMessages .="</p>
			</div>";

}*/

		$body = "		<div class=\"rechterDeel\">\n";
		//$body .= "			<div class=\"titelBalk\"><img src=\"$rightImage\" width=\"228\" height=\"22\"></div>\n";
		//$body .= "			<div class=\"recentNieuwsKader\">\n\n";

		//$body .= "$rightMessages\n";

		//$body .= "		</div>\n";
		$body .= "		</div>	\n";
		$body .= "		<!-- EINDE VAN HET RECHTERDEEL -->\n\n";

		$body .= "	</div>\n";
		$body .= "	<!-- AFSLUITEN VAN DE TWEE DELEN -->\n\n";

		//$body .= "</div>\n";
		//$body .= "</body>\n";
		//$body .= "</html>\n";

//ELECT DATE_FORM//AT('1997-10-04 22:23:00', '%W %M %Y');
//	$query = "SELECT s.surfer_id, s.surfer_name, s.surfer_desc_short, f.surfer_foto_id FROM surfer_foto f, surfers s WHERE s.surfer_id = f.surfer_id AND f.surfer_foto_id != 1 ORDER BY RAND() LIMIT 0 , 1";
$queryFoto = "SELECT s.surfer_id, s.surfer_name, s.surfer_desc_short, f.surfer_foto_id FROM surfer_foto f, surfers s WHERE s.surfer_id = f.surfer_id AND f.surfer_foto_id != 1 AND s.surfer_id = '$_GET[surfer_id]' LIMIT 0 , 1";
$sqlFoto = mysql_query($queryFoto) or die("Error");
$i = 0;
$lay_out->titelImage = "images/kop_onze-surfers.gif";




while($objFoto = mysql_fetch_object($sqlFoto))
{
$query = "select * from event where event_id = '$objFoto->event_id'";
$sql = mysql_query($query) or die("error");
while($obj=mysql_fetch_object($sql)){
	$lay_out->topEventId = $obj->event_id;
	$lay_out->partTwoText = "<div style=\"padding: 2%;\"><b>$obj->event_title</b> <br />";
	$lay_out->partTwoText .= date("d-m-Y", strtotime($obj->event_timestamp))." <br />";
	$lay_out->partTwoText .= nl2br($obj->event_text)."</div>";
	$lay_out->partTwoShit = 0;
	}
	//$lay_out->partTwoText .= "<table><tr>\n";
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
			$image = "$objFoto->foto_id.jpg";		
		//if(0 == ($i %3))
		$queryFoto1 = "SELECT * FROM foto WHERE foto_id > '$_GET[photo_id]' AND event_id = '$objFoto->event_id' ORDER BY foto_id ASC LIMIT 1";
		$sqlFoto1 = mysql_query($queryFoto1) or die("Error");
		if($objFoto1 = mysql_fetch_object($sqlFoto1))
			$next = " || <a href=\"viewphoto.php?photo_id=$objFoto1->foto_id\">Volgende Foto</a> &raquo; ";

		$queryFoto1 = "SELECT * FROM foto WHERE foto_id < '$_GET[photo_id]' AND event_id = '$objFoto->event_id' ORDER BY foto_id DESC LIMIT 1";
		$sqlFoto1 = mysql_query($queryFoto1) or die("Error");
		if($objFoto1 = mysql_fetch_object($sqlFoto1))
			$prev = "&laquo; <a href=\"viewphoto.php?photo_id=$objFoto1->foto_id\">Vorige Foto</a> || ";

		$over = "<a href=\"viewevent.php?event_id=$objFoto->event_id\">Overzicht</a>";
		
			$lay_out->partTwoText .= "          <center>$prev   $over  $next<br /> ";
		
			$lay_out->partTwoText .= "<img src=\"images/event/photo/$image\" border=\"1\" /><br /> ";
			$lay_out->partTwoText .= "          $prev $over   $next</center><p>&nbsp;</p> ";
		

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
$lay_out->partTwoText .= "</tr></table> ";


/* parse lay_out */			
echo $lay_out->build("");





/* send page to client */

ob_end_flush();
?>
