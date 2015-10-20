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

if($_GET[verslag_id]){

	$query = "select * from event where event_id = '$_GET[event_id]'";
	$sql = mysql_query($query) or die("error");
	while($obj=mysql_fetch_object($sql)){
//		$lay_out->topEventId = $obj->event_id;
//		$lay_out->partTwoText = "<span class=\"heterTitel\"> $obj->event_title</span> <br />";
//		$lay_out->partTwoText .= date("d-m-Y", strtotime($obj->event_timestamp))." <br />";
//		$lay_out->partTwoText .= nl2br($obj->event_text);
/*		if ($obj->news_message)
		$lay_out->latestNewsMessage .= "<a href=\"news_leesverder.php?news_id=$obj->news_id\" ><img src=\"images/heter_leesverder.gif\" width=\"112\" height=\"18\" border=\"0\" id=\"heterLeesverder\" /></a><br />\n";
		$lay_out->latestNewsId = $obj->news_id; */


		$lay_out->topEventId = $obj->event_id;
		$lay_out->topEventTitle = $obj->event_title;
		$lay_out->topEventImage = "images/van_onze_razende_reporter.gif";
		$maand = $maanden[date("n",strtotime($obj->event_timestamp))];
		$dag = date("d",strtotime($obj->event_timestamp));
		$jaar = date("Y",strtotime($obj->event_timestamp));
		$lay_out->latestNewsDate = "$dag $maand $jaar";
		$lay_out->latestNewsMessage = nl2br($obj->event_text);


	}
//	$lay_out->rightImage = "images/kop_recent-nieuws.gif";
//	$lay_out->rightMessages = "";
//	$query = "select * from news order by news_id desc limit 0,5";
//	$sql = mysql_query($query) or die("error");
//	while($obj=mysql_fetch_object($sql)){
//		$lay_out->rightMessages .="<div class=\"recentNieuwsBericht\">
//				<span class=\"nieuwsTitel\">$obj->news_title</span><br />
//				<span class=\"nieuwsAuteur\">$obj->news_date</span>
//				<p>";
//		$lay_out->rightMessages .= nl2br($obj->news_short);
//		if ($obj->news_message)
//		$lay_out->rightMessages .= "<a href=\"news_leesverder.php?news_id=$obj->news_id&tab=home\" ><img src=\"images/heter_leesverder.gif\" width=\"112\" height=\"18\" border=\"0\"/></a><br />\n";
//		$lay_out->rightMessages .="</p>
//			</div>";
//
//	}

	//ELECT DATE_FORM//AT('1997-10-04 22:23:00', '%W %M %Y');
	$lay_out->partTwoText .= "\n<br />";
	$queryVerslag = "SELECT * FROM verslag WHERE verslag_id = '$_GET[verslag_id]' LIMIT 1";
	$sqlVerslag = mysql_query($queryVerslag);
	while ($verslagObj = mysql_fetch_object($sqlVerslag)) {
		$queryUser = "SELECT user_realName FROM cms_users WHERE user_id = '$verslagObj->verslag_userId'";
		$sqlUser = mysql_query($queryUser);
		$user = mysql_fetch_object($sqlUser);
		$lay_out->partTwoText .= "<a name=\"$verslagObj->verslag_id\"></a>\n<div class=\"verslagKader\"><div class=\"verslagAuteurInfo\">Verslag geschreven op ".date("d-m-Y", strtotime($verslagObj->verslag_datum))." door: $user->user_realName</div><div class=\"heterTitel\">$verslagObj->titel</div><br />$verslagObj->verslag</div>\n";
	}

	$lay_out->partTwoText .= "\n<br />";
	$queryVerslag = "SELECT * FROM verslag WHERE event_id = '$_GET[event_id]' AND verslag_id != $_GET[verslag_id] ORDER BY verslag_id DESC";
	$sqlVerslag = mysql_query($queryVerslag);
	while ($verslagObj = mysql_fetch_object($sqlVerslag)) {
		$queryUser = "SELECT user_realName FROM cms_users WHERE user_id = '$verslagObj->verslag_userId'";
		$sqlUser = mysql_query($queryUser);
		$user = mysql_fetch_object($sqlUser);
		$lay_out->partTwoText .= "<ul><li><a href=\"verslag_leesverder.php?event_id=$_GET[event_id]&amp;verslag_id=$verslagObj->verslag_id&amp;tab=verslagen\"> Lees ook het verslag geschreven door $user->user_realName</a></li></ul>\n";
	}


	$queryFoto = "SELECT * FROM foto WHERE event_id = '$_GET[event_id]' ORDER BY foto_id ASC";
	$sqlFoto = mysql_query($queryFoto) or die("Error");
	if(mysql_num_rows($sqlFoto)){
		/* Er zijn foto's */
		$i = 0;
		//$lay_out->titelImage = "images/kop_fotogalerij.gif";
		//$lay_out->partTwoText .= "<table><tr>\n";
			$lay_out->rightImage = "images/kop_fotogalerij_lg.gif";
	$lay_out->rightMessages = "";
	
		$lay_out->rightMessages .="<div class=\"recentNieuwsBericht\">
				<span class=\"nieuwsTitel\">$obj->news_title</span><br />
				<span class=\"nieuwsAuteur\">$obj->news_date</span>
				<p>";

			

	}
	else
	{
		$lay_out->rightImage = "images/overgangs-streep.gif";
	}

		while($objFoto = mysql_fetch_object($sqlFoto))
		{

			$image = "$objFoto->foto_id-thumb.jpg";
//			$lay_out->rightMessages .="<div class=\"recentNieuwsBericht\">
//					<a href=\"viewphoto.php?photo_id=$objFoto->foto_id&tab=foto\"><img src=\"images/event/photo/$image\" height=\"98\" border=\"0\" /></a>";
//			$lay_out->rightMessages .="</div>";
			if(0 == ($i %2)){
			$lay_out->rightMessages .= "</tr><tr>";

			$lay_out->rightMessages .= "<td class=\"backgroundGeel\"><a href=\"viewphoto.php?photo_id=$objFoto->foto_id&tab=foto\"><img src=\"images/event/photo/$image\" class=\"galleryThumb\" height=\"98\" border=\"0\" /></a> </td>";
			}else
			$lay_out->rightMessages .= "<td class=\"backgroundBlauw\"><a href=\"viewphoto.php?photo_id=$objFoto->foto_id&tab=foto\"><img src=\"images/event/photo/$image\" class=\"galleryThumb\" height=\"98\" border=\"0\" /></a> </td>";

			$i++;




		}//}
		$lay_out->rightMessages .="</div>";
	}

$lay_out->partTwoText .= "</tr></table>";

$lay_out->titelImage = "images/kop_verslag.gif";

/* parse lay_out */
echo $lay_out->build("Verslagen | ");





/* send page to client */

ob_end_flush();
?>
