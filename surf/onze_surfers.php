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

	//$query = " SELECT * FROM news ORDER BY news_sticky DESC, news_timestamp DESC LIMIT 1";
	$query = "SELECT DISTINCT(f.surfer_id), s.surfer_name, s.surfer_desc_short, s.surfer_id, f.surfer_foto_id FROM surfer_foto f, surfers s WHERE f.surfer_id = s.surfer_id ORDER BY RAND() LIMIT 1";
	
	if($_GET['surfer'])
	{
		$query = "SELECT s.surfer_id, s.surfer_name, s.surfer_desc_short, f.surfer_foto_id FROM surfer_foto f, surfers s WHERE s.surfer_id = f.surfer_id AND f.surfer_foto_id != 1 AND s.surfer_name = '$_GET[surfer]' LIMIT 0 , 1";
		$sql = mysql_query($query) or die("error");
		if(mysql_num_rows($sql) == 0)
		{
			$query = "SELECT s.surfer_id, s.surfer_name, s.surfer_desc_short, f.surfer_foto_id FROM surfer_foto f, surfers s WHERE s.surfer_id = f.surfer_id AND f.surfer_foto_id != 1 ORDER BY RAND() LIMIT 0 , 1";
			$sql = mysql_query($query) or die("error");
		}
	}
	else
	{
		$query = "SELECT s.surfer_id, s.surfer_name, s.surfer_desc_short, f.surfer_foto_id FROM surfer_foto f, surfers s WHERE s.surfer_id = f.surfer_id AND f.surfer_foto_id != 1 ORDER BY RAND() LIMIT 0 , 1";
		$sql = mysql_query($query) or die("error");
	}
	
	while($objWillekeur=mysql_fetch_object($sql))
	{
		$willekeurige_surfer = $objWillekeur->surfer_id;		
		$lay_out->willekeurigeSurferFoto = $objWillekeur->surfer_foto_id;
		$lay_out->willekeurigeSurferName = $objWillekeur->surfer_name;
	//	$lay_out->latestNewsDate = $obj->news_date;
		$lay_out->latestNewsMessage = nl2br($objWillekeur->surfer_desc_short);
		$onTop = $objWillekeur->surfer_id; 
	
		if ($objWillekeur->surfer_desc_long)
			$lay_out->latestNewsMessage .= "<a href=\"news_leesverder.php?news_id=$objWillekeur->news_id\" ><img src=\"images/heter_leesverder.gif\" width=\"112\" height=\"18\" border=\"0\" id=\"heterLeesverder\" /></a><br />\n"; 
		$lay_out->latestNewsId = $objWillekeur->surfer_id;

	}

$lay_out->rightImage = "images/kop_recent-nieuws.gif";
		$lay_out->rightMessages = "";
		$query = "SELECT * FROM news WHERE news_id != '$onTop' AND news_rubriek_id = '1' ORDER BY news_timestamp DESC LIMIT 0,5";
$sql = mysql_query($query) or die("error");
while($obj=mysql_fetch_object($sql)){
	$lay_out->rightMessages .="<div class=\"recentNieuwsBericht\">
				<span class=\"nieuwsTitel\">$obj->news_title</span><br />
				<span class=\"nieuwsAuteur\">$obj->news_date</span>
				<p>";
	$lay_out->rightMessages .= nl2br(str_replace("<br />", "", $obj->news_short));
	if ($obj->news_message)
		$lay_out->rightMessages .= "<div class=\"miniLeesverder\"><a href=\"news_leesverder.php?news_id=$obj->news_id\" ><img src=\"images/butt_sm_leesverder.gif\" border=\"0\"/></a></div><br />\n"; 
	$lay_out->rightMessages .="</p>
			</div>";

}

		$lay_out->titelImage = "images/kop_onze-surfers.gif";
	$lay_out->partTwoText = "Een overzicht van enkele van onze actieve surfleden. Sta je er niet tussen, maar ben je van mening dat je eigenlijk niet mag ontbreken in dit overzicht. Stuur dan e-mail met een leuke foto en wat meer informatie over jezelf";

$queryFoto = "SELECT DISTINCT(f.surfer_id), s.surfer_name, s.surfer_desc_short, s.surfer_id, f.surfer_foto_id FROM surfer_foto f, surfers s WHERE f.surfer_id = s.surfer_id AND s.surfer_id != '$willekeurige_surfer'  ORDER BY 'surfer_name' LIMIT 0 , 50";//ORDER BY RAND()
$queryFoto = "SELECT s.surfer_id, s.surfer_name, s.surfer_desc_short, f.surfer_foto_id FROM surfer_foto f, surfers s WHERE s.surfer_id = f.surfer_id AND s.surfer_id != '$willekeurige_surfer' AND f.surfer_foto_id != 1  ORDER BY 'surfer_name' LIMIT 0 , 50";
$sqlFoto = mysql_query($queryFoto) or die("Error");
$i = 0;
while($objFoto = mysql_fetch_object($sqlFoto))
{
	//$query = "SELECT *, UNIX_TIMESTAMP(event_timestamp) as datum from event WHERE event_id = '$objFoto->event_id'";
	//$sql = mysql_query($query) or die("error");

	
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
		//$query2 = "SELECT * FROM foto WHERE event_id = $objFoto->event_id ORDER BY RAND() LIMIT 1";
		//$sql2 = mysql_query($query2) or die("error");
		//$obj2 = mysql_fetch_object($sql2);
		$image = $objFoto->surfer_foto_id."-thumb.jpg";
		$lay_out->partTwoText .=  "<div class=\"surferFoto\"><!--<a href=\"viewsurfer.php?surfer_id=$objFoto->surfer_id&amp;tab=surfers\">--><img src=\"images/event/photo/$image\" height=\"98\" border=\"0\" /><!--</a>--></div>";
		$lay_out->partTwoText .=  "<div class=\"surferDesc\"><span class=\"nieuwsTitel\"><!--<a href=\"viewsurfer.php?surfer_id=$objFoto->surfer_id&amp;tab=surfers\">-->$objFoto->surfer_name<!--</a>--></span>";
		$lay_out->partTwoText .= "<br />$objFoto->surfer_desc_short</div></div>";
		/*if (time() > $obj->datum)
		$lay_out->partTwoText .= "<td class=\"kalenderGeweest\">$obj->event_title</td>";
		else
		$lay_out->partTwoText .= "<td>$obj->event_title</td>";
		$lay_out->partTwoText .= "</tr>";*/



	}
/*
			<SCRIPT LANGUAGE=\"JavaScript\">
				document.write(\"appName = \" + navigator.appName + \"<BR>\");
				document.write(\"appVersion = \" + navigator.appVersion + \"<BR>\");
			</SCRIPT>			

*/

/* parse lay_out */			
echo $lay_out->build("Onze surfers | ");





/* send page to client */

ob_end_flush();
?>