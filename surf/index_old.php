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





//===================================================

//	Heter dan de Overstag bericht opzoeken

//===================================================

	$query = " SELECT * FROM news WHERE news_rubriek_id = '1' ORDER BY news_sticky DESC, news_timestamp DESC LIMIT 1";

	$sql = mysql_query($query) or die("error");



	while($obj=mysql_fetch_object($sql))

	{

		$lay_out->latestNewsTitle = $obj->news_title;

		$lay_out->latestNewsDate = $obj->news_date;

		$lay_out->latestNewsMessage = nl2br($obj->news_short);



		$onTop = $obj->news_id; 



		if ($obj->news_message)

		{

			$lay_out->latestNewsMessage .= "<a href=\"news_leesverder.php?news_id=$obj->news_id\" ><img src=\"images/heter_leesverder.gif\" width=\"112\" height=\"18\" border=\"0\" id=\"heterLeesverder\" /></a><br /><p>&nbsp;</p>\n"; 

		}



		$lay_out->latestNewsId = $obj->news_id;		

	}



//===================================================

//	Recent nieuws: met inleiding

//===================================================



	$lay_out->rightImage = "images/kop_recent-nieuws.gif";

	$lay_out->rightMessages = "";



	$query = "SELECT * FROM news WHERE news_id != '$onTop' AND news_rubriek_id = '1' ORDER BY news_sticky DESC, news_timestamp DESC LIMIT 0,2";

	$sql = mysql_query($query) or die("error");



	while($obj=mysql_fetch_object($sql))

	{



		$lay_out->rightMessages .="<div class=\"recentNieuwsBericht\">

				<span class=\"nieuwsTitel\">$obj->news_title</span><br />

				<span class=\"nieuwsAuteur\">$obj->news_date</span>

				<p>";

		$lay_out->rightMessages .= nl2br( str_replace("<br />", "", $obj->news_short) );



		if ($obj->news_message)

		{

			$lay_out->rightMessages .= "<div class=\"miniLeesverder\"><a href=\"news_leesverder.php?news_id=$obj->news_id\" ><img src=\"images/butt_sm_leesverder.gif\" border=\"0\"/></a></div><br />\n"; 

		}



		$lay_out->rightMessages .="</p></div>";

	}



//===================================================

//	Recent nieuws: alleen titels

//===================================================



	$query = "SELECT * FROM news WHERE news_id != '$onTop' AND news_rubriek_id = '1' ORDER BY news_sticky DESC, news_timestamp DESC LIMIT 2, 25";

	$sql = mysql_query($query) or die("error");



	$lay_out->rightMessages .= "<ul>";



	while($obj=mysql_fetch_object($sql))

	{

		$lay_out->rightMessages .="<li><a href=\"news_leesverder.php?news_id=$obj->news_id\" class=\"nieuwsTitel";

		if($_REQUEST['news_id'] == $obj->news_id) { $lay_out->rightMessages .=" newsCurrent "; }

		$lay_out->rightMessages .="\" >".trim($obj->news_title)."</a></li>\n";

	}



	$lay_out->rightMessages .= "</ul>";



//===================================================



		$lay_out->titelImage = "images/kop_over-ons.gif";

		$query = "SELECT tekst FROM teksten WHERE id ='1'";

		$SQL = mysql_query($query);

		$obj = mysql_fetch_object($SQL);

		

		$lay_out->partTwoText = $obj->tekst."<!-- teksten id=1 -->";

	/* parse lay_out */
	echo $lay_out->build("Informatie | ");
	
	/* send page to client */
	ob_end_flush();



			//netstat causes popup?

		/*$lay_out->partTwoText .= "

			<div id=\"statLayer\" style=\"display: none; visibility: invisible;position:absolute; left:10px; top:13px; width:10px; height:10px; z-index:1\">

				<!-- Begin Nedstat Basic code -->

				<!-- Title: Windsurfvereniging Leidschendam -->

				<!-- URL: http://213.10.107.26/images/wsvl/ -->

				<script language=\"JavaScript\" type=\"text/javascript\" src=\"http://m1.nedstatbasic.net/basic.js\">

				</script>

				<script language=\"JavaScript\" type=\"text/javascript\" >

				<!--

				  nedstatbasic(\"ACJA2Qd96dABZSy05Zap4SyHxjtA\", 0);

				// -->

				</script>

				<noscript>

				<a target=\"_blank\" href=\"http://v1.nedstatbasic.net/stats?ACJA2Qd96dABZSy05Zap4SyHxjtA\"><img

				src=\"http://m1.nedstatbasic.net/n?id=ACJA2Qd96dABZSy05Zap4SyHxjtA\"

				border=\"0\" nosave width=\"18\" height=\"18\"

				alt=\"Nedstat Basic - Free web site statistics\"></a>

				</noscript>

				<!-- End Nedstat Basic code -->

			</div>

		";*/

/*

			<SCRIPT LANGUAGE=\"JavaScript\">

				document.write(\"appName = \" + navigator.appName + \"<BR>\");

				document.write(\"appVersion = \" + navigator.appVersion + \"<BR>\");

			</SCRIPT>			

*/
?>
