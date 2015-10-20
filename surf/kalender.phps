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
$query = "select * from event where event_onTop = '1' order by event_id desc limit 1";
$sql = mysql_query($query) or die("error");
while($obj=mysql_fetch_object($sql)){
	$lay_out->topEventId = $obj->event_id;
	$lay_out->topEventTitle = $obj->event_title;
	$lay_out->latestNewsDate = $obj->event_timestamp;
	$lay_out->latestNewsMessage = nl2br($obj->event_text);
	/*if ($obj->news_message)
		$lay_out->latestNewsMessage .= "<a href=\"news_leesverder.php?news_id=$obj->news_id\" ><img src=\"images/heter_leesverder.gif\" width=\"112\" height=\"18\" border=\"0\" id=\"heterLeesverder\" /></a><br />\n"; 
	$lay_out->latestNewsId = $obj->news_id;*/
	
}
$lay_out->rightImage = "images/kop_recent-nieuws.gif";
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

}
//ELECT DATE_FORM//AT('1997-10-04 22:23:00', '%W %M %Y');
$query = "SELECT *, UNIX_TIMESTAMP(event_timestamp) as datum from event WHERE event_onCalendar = '1' order by event_timestamp DESC";
$sql = mysql_query($query) or die("error");
$i = 0;
		$lay_out->titelImage = "images/kop_kalender.gif";
		$lay_out->partTwoText = "<p><strong>De evenementen en (club)wedstrijden kalender voor 2005.</strong></p>
		<table width=\"100%\" style=\"border-top: 1px dashed #006699; border-bottom: 1px dashed #006699;\"  border=\"0\" cellpadding=\"5\" cellspacing=\"0\">";
while($obj=mysql_fetch_object($sql)){
		$i++;

		if ( 0 == ($i %2))
			$lay_out->partTwoText .= "<tr class=\"backgroundGeel\">";
		else
			$lay_out->partTwoText .= "<tr class=\"backgroundBlauw\">";

			
           $lay_out->partTwoText .=  "<td align=\"center\">";
			$lay_out->partTwoText .= date("j F", $obj->datum);
			 $lay_out->partTwoText .= "</td>";
			 if (time() > $obj->datum)
				$lay_out->partTwoText .= "<td class=\"kalenderGeweest\">$obj->event_title</td>";
			else
				$lay_out->partTwoText .= "<td>$obj->event_title</td>";
         		$lay_out->partTwoText .= "</tr>";
		


}
         
$lay_out->partTwoText .= "</table>";


/* parse lay_out */			
echo $lay_out->build();





/* send page to client */

ob_end_flush();
?>
