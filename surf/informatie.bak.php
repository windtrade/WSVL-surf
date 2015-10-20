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
/*$query = "select * from news order by news_id desc limit 1";
$sql = mysql_query($query) or die("error");
while($obj=mysql_fetch_object($sql)){
$lay_out->latestNewsTitle = $obj->news_title;
$lay_out->latestNewsDate = $obj->news_date;
$lay_out->latestNewsMessage = nl2br($obj->news_short);
if ($obj->news_message)
$lay_out->latestNewsMessage .= "<a href=\"news_leesverder.php?news_id=$obj->news_id\" ><img src=\"images/heter_leesverder.gif\" width=\"112\" height=\"18\" border=\"0\" id=\"heterLeesverder\" /></a><br />\n";
$lay_out->latestNewsId = $obj->news_id;

}*/
if(!$_GET[tekst])
$tekst = 3;
$lay_out->rightImage = "none";
$lay_out->rightMessages = "";
$lay_out->rightMessages .="<div class=\"recentNieuwsBericht\">
				<span class=\"nieuwsTitel\">Nog meer informatie:</span><br />";
			
$query = " select * from teksten where id NOT IN (1,2,4,6,7,8,9,10,11,13	) order by id desc ";
$sql = mysql_query($query) or die("error");
while($obj=mysql_fetch_object($sql)){
	if($obj->id != $tekst){
		$lay_out->rightMessages .="<p class=\"infoItems\">";
		$lay_out->rightMessages .= "<a href=\"informatie.php?tekst=$obj->id&amp;tab=informatie\">$obj->titel</a>";
			$lay_out->rightMessages .="</p>";
				
	}

}
$lay_out->rightMessages .="</div>";

//============================================

$lay_out->rightMessages .="<div class=\"subscrNieuwsbrief\"><img src=\"images/kop_nieuwsbrief.gif\" alt=\"Aanmelden voor de nieuwsbrief\" /><p>Wil jij ook de onregelmatig verschijnende nieuwsbrief van Windsurf vereninging Leidschendam en omstreken in je mailbox ontvangen? Meld je dan nu meteen aan!</p><form action=\"nieuwsbrief/subscribe.php\" method=\"post\">  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
    <tr>
      <td width=\"9%\" align=\"right\" nowrap=\"nowrap\"><strong>Naam : </strong></td>
      <td width=\"91%\">&nbsp;
      <input name=\"naam\" type=\"text\" id=\"naam\" size=\"25\" /></td>
    </tr>
    <tr>
      <td align=\"right\" nowrap=\"nowrap\"><strong>E-mail adres : </strong></td>
      <td>&nbsp;
      <input name=\"emailadres\" type=\"text\" id=\"emailadres\" size=\"25\" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name=\"subscribe\" type=\"radio\" value=\"y\" checked=\"checked\" />
      aanmelden nieuwsbrief </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name=\"subscribe\" type=\"radio\" value=\"n\" />
      afmelden nieuwsbrief </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type=\"submit\" name=\"Submit\" value=\"  UITVOEREN  \" /></td>
    </tr>
  </table></form></div>";

//============================================



$lay_out->titelImage = "images/kop_informatie.gif";
$query = "SELECT * FROM teksten WHERE id ='$tekst'";
$SQL = mysql_query($query);
$obj = mysql_fetch_object($SQL);
$lay_out->partTwoText = "<div class=\"objTitel\">$obj->titel</div>";
$lay_out->partTwoText .= "<div id=\"infoTeksten\" style=\"padding: 2%; width: 90%;\">$obj->tekst</div>";

/* parse lay_out */
echo $lay_out->build();

/* send page to client */

ob_end_flush();
?>