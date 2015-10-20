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
	$lay_out->head_pagetitle = "Contact | ";

$lay_out->rightImage = "images/kop_colofon.gif";
		$lay_out->rightMessages = "";

	$lay_out->rightMessages .="<div class=\"recentNieuwsBericht\">
				<span class=\"nieuwsTitel\">$obj->news_title</span><br />
				<span class=\"nieuwsAuteur\">$obj->news_date</span>
				<p><b>Bezoekadres:</b><br />Rietpolderweg 2<br />2266BM Leidschendam</p><p><b>Postadres:</b>
				Postbus 16<br />
				2266 BM Leidschendam</p>
				</div>
				<div class=\"recentNieuwsBericht\">
				<p><img src=\"images/marcKlein.png\" alt=\"Marc\" id=\"bstFto\" align=\"left\" margin=\"1\" border=\"1\"/>
					<i>Voorzitter Surfafdeling<br />Surflessen / Groot Water Weekend</i><br />
					<b>Marc van Santen</b><br />
					<a href=\"contact_user.php?ontv=7\">Stuur een bericht.</a>
				</p>
				<!--<p><img src=\"images/ilseKlein.jpg\" alt=\"Ilse\" id=\"bstFto\" align=\"left\" margin=\"1\" border=\"1\"/>
					<i>Surfleden administratie</i><br />
					<b>Ruud van Velzen</b><br />
					<a href=\"contact_user.php?ontv=11\">Stuur een bericht</a>
					<br /><br />
				</p>-->
					<i>Wedstrijden &amp; zo</i><br />
					<b>Pim de Bruin</b><br />
					<a href=\"contact_user.php?ontv=17\">Stuur een bericht</a>
				</p>
					<i>Webmaster</i><br />
					<b>Huug Peters</b><br />
					<a href=\"contact_user.php?ontv=10\">Stuur een bericht</a><br />&nbsp;
				</p>
				</div>
				<!--<div class=\"recentNieuwsBericht\"><span class=\"nieuwsTitel\">Overstag</span><br /><p>De kopijdatum voor de eerstvolgende \"Overstag\" is op 10 januari 2009.</p></div>-->";

/*

		$query = "select * from news order by news_id desc limit 1,5";
$sql = mysql_query($query) or die("error");
while($obj=mysql_fetch_object($sql)){
	$lay_out->rightMessages .="<div class=\"recentNieuwsBericht\">
				<span class=\"nieuwsTitel\">$obj->news_title</span><br />
				<span class=\"nieuwsAuteur\">$obj->news_date</span>
				<p>";
	$lay_out->rightMessages .= nl2br($obj->news_short);
	if ($obj->news_message)
		$lay_out->rightMessages .= "<div class=\"miniLeesverder\"><a href=\"news_leesverder.php?news_id=$obj->news_id\" ><img src=\"images/butt_sm_leesverder.gif\" border=\"0\"/></a></div><br />\n"; 
	$lay_out->rightMessages .="</p>
			</div>";
*/
//}

		if($_REQUEST['page'] == 'inschrijven')
		{
			$lay_out->titelImage = "images/kop_contact.gif";
			$includefile = "./contact_aanmeldformulier.inc.htm";		

			$handle = fopen($includefile, "r");
			$contents = fread($handle, filesize($includefile));
			fclose($handle);

			$lay_out->partTwoText .= "<div class=\"objTitel\">Lid worden</div>";		
			$lay_out->partTwoText .= $contents;

		}
		else
		{
			$lay_out->titelImage = "images/kop_contact.gif";
			$includefile = "./contact_info-formulier.inc.htm";				

			$handle = fopen($includefile, "r");
			$contents = fread($handle, filesize($includefile));
			fclose($handle);

			$lay_out->partTwoText .= "<div class=\"objTitel\">$obj->titel</div>";		
			$lay_out->partTwoText .= $contents;

		}
/*
		else
		{
			$lay_out->titelImage = "images/kop_contact.gif";
			$query = "SELECT titel, tekst FROM teksten WHERE id ='2'";
			$SQL = mysql_query($query);
			$obj = mysql_fetch_object($SQL);

			$lay_out->partTwoText .= "<div class=\"objTitel\">$obj->titel</div>";		
			$lay_out->partTwoText .= "<div style=\"padding: 2%; width: 90%;\">$obj->tekst</div>";

		}
*/


/* parse lay_out */
echo $lay_out->build("Contact | ");

/* send page to client */

ob_end_flush();
?>
