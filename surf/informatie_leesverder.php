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
//=====================================================================================
//	...
//=====================================================================================

	$rubr_query = " SELECT * FROM teksten_rubrieken WHERE rubriek_sticky = 1 ORDER BY positie DESC ";
	$rubr_sql = mysql_query($rubr_query) or die("error");

	if($rubr_sql)
	{
		//$lay_out->infoRubrieken = $rubr_sql;
//		$lay_out->latestNewsDate = $obj->news_date;
//		$lay_out->latestNewsMessage = nl2br($obj->news_short);

/*
		if ($obj->news_message)
		{
			$lay_out->latestNewsMessage .= "<a href=\"news_leesverder.php?news_id=$obj->news_id\" ><img src=\"images/heter_leesverder.gif\" width=\"112\" height=\"18\" border=\"0\" id=\"heterLeesverder\" /></a><br />\n";
		}
*/
//		$lay_out->latestNewsId = $obj->news_id;
	}

//=====================================================================================
	if(!$_GET['tekst'])
	{
		//$tekst = 3;
	}
//----------------------------------

	if($_GET['rubriek_id'])
	{
		$rubr_query = " SELECT * FROM teksten_rubrieken WHERE rubriek_id = '".$_GET['rubriek_id']."' ";
		$rubr_sql = mysql_query($rubr_query) or die("error");
		$rubr_obj = mysql_fetch_object($rubr_sql);
	}


	$lay_out->rightImage = "none";
	$lay_out->rightMessages = "";


	// Grote blauwe rubriek dingen tonen aan de rechterkant
		$rubr_query = " SELECT * FROM teksten_rubrieken WHERE rubriek_sticky = 1 ORDER BY positie DESC ";
		$rubr_sql = mysql_query($rubr_query) or die("error");

		while($rubr_obj = mysql_fetch_object($rubr_sql))
		{

				$lay_out->rightMessages .= "
				<a href=\"informatie_leesverder.php?rubriek_id=".$rubr_obj->rubriek_id."&amp;tab=informatie\"><div class=\"";
				
				if($_GET['rubriek_id'] == $rubr_obj->rubriek_id) { $lay_out->rightMessages .= " infoSelected "; }
				
				$lay_out->rightMessages .= "infoButton sPrubr".$rubr_obj->rubriek_id."\">
					<img src=\"images/img_rubr".$rubr_obj->rubriek_id.".jpg\" height=\"28\" alt=\"".$rubr_obj->rubriek_titel."\" />
					<span class=\"titel\">".$rubr_obj->rubriek_titel."</span><br />
					<span><!--//".$rubr_obj->rubriek_desc."//--></span>
				</div></a>
				";

				$curRubrID = $rubr_obj->rubriek_id;
				if($curRubrID == $_GET['rubriek_id'])
				{

					$lay_out->rightMessages .="<div class=\"recentNieuwsBericht\">
									<span class=\"nieuwsTitel\">Meer over ".strtolower($rubr_obj->rubriek_titel).":</span><br />";
								
					$query = " SELECT * FROM teksten WHERE rubriek_id = '".$curRubrID."' ORDER BY id DESC ";
					$sql = mysql_query($query) or die("error");
					while($obj=mysql_fetch_object($sql))
					{
						//if($obj->id != $tekst)
						//{
							$teksten[] = $obj->id;
				
							$lay_out->rightMessages .="<p class=\"infoItems\">";
							$lay_out->rightMessages .= "&diams; <a href=\"informatie_leesverder.php?tekst=".$obj->id."&amp;rubriek_id=".$rubr_obj->rubriek_id."&amp;tab=informatie\">$obj->titel</a>";
							$lay_out->rightMessages .="</p>";			
						//}
					
					}
					$lay_out->rightMessages .="</div>";				
				
				}
			
		}

	$lay_out->titelImage = "images/kop_informatie.gif";


	if(is_array($teksten))
	{
		arsort($teksten);
	}


	if(!$_GET['tekst'])
	{
		$query = "SELECT * FROM teksten WHERE id ='$teksten[0]' ";
	}
	else
	{
		$query = "SELECT * FROM teksten WHERE id ='$tekst' ";	
	}
	$SQL = mysql_query($query);
	$obj = mysql_fetch_object($SQL);

	$lay_out->partTwoText .= "<span><a href=\"/index.php\">Home</a> &raquo; <a href=\"/informatie_new.php?tab=informatie\">Informatie</a> &raquo; ".$rubr_obj->rubriek_titel."</span><br /><hr align=\"left\" size=\"1\" noshade=\"noshade\">";

	$lay_out->partTwoText .= "<div class=\"objTitel\">$obj->titel</div>";
	$lay_out->partTwoText .= "<div class=\"infoMeer\">$obj->tekst</div>";
	
	/* parse lay_out */
	echo $lay_out->build("Informatie | ");
	
	/* send page to client */
	ob_end_flush();

?>
