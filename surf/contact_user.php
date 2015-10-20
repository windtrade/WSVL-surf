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
	

	$lay_out->rightImage = "images/kop_colofon.gif";
			$lay_out->rightMessages = "";
	
		$lay_out->rightMessages .="<div class=\"recentNieuwsBericht\">
					<span class=\"nieuwsTitel\">$obj->news_title</span><br />
					<span class=\"nieuwsAuteur\">$obj->news_date</span>
					<p>
						<i>Voorzitter Surfafdeling</i><br />
						<b>Marc van Santen</b><br />
						<a href=\"contact_user.php?ontv=7\">Stuur een bericht.</a>
					</p>
					<p>
						<i>Groot Water Weekend</i><br />
						<bFemke</b><br />
						<br />
						<a href=\"contact_user.php?ontv=9\">Stuur een bericht.</a>
					</p>
					<p>
						<i>Surfleden administratie</i><br />
						<b>Ruud van Velzen</b><br />
						<a href=\"contact_user.php?ontv=11\">Stuur een bericht</a>
					</p>
					<p>
						<i>Training- / Instructie Administratie</i><br />
						<b>Huug Peters</b><br />
						tel. 06-14170776<br />
						<a href=\"contact_user.php?ontv=2\">Stuur een bericht</a>
					</p>
					<p>
						<i>Wedstrijdzaken</i><br />
						<b>Pim de Bruin</b><br />
						<a href=\"contact_user.php?ontv=\">Stuur een bericht</a>
					</p>
					<p>
						<i>Webmaster</i><br />
						<b>Erwin Marges</b><br />
						<a href=\"contact_user.php?ontv=2\">Stuur een bericht</a>
					</p>
					</div>
					<div class=\"recentNieuwsBericht\"><span class=\"nieuwsTitel\">Overstag</span><br /><p>De kopijdatum voor de eerstvolgende \"Overstag\" is op 14 mei 2006.</p></div>";
	
	
			$lay_out->titelImage = "images/kop_contact.gif";		
			if($_GET['ontv'] == "DVD" || $_GET['ontv'] == "dvd")
			{
			$lay_out->partTwoText = "

<form name=\"contact\" method=\"post\" action=\"formhandler.php\">
	<strong>&nbsp;Ik wil graag de FotoDVD van 2005 bestellen voor &euro; 6,- </strong>
	<table width=\"95%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"4\"><tr>
	  <td width=\"20%\"><strong>Je naam : </strong></td>
	  <td width=\"80%\"><input name=\"naam\" type=\"text\" id=\"naam\" size=\"32\"></td></tr><tr><td><strong>E-mail
	        adres : </strong></td><td>	          <input name=\"afzender\" type=\"text\" id=\"afzender\" size=\"32\"></td></tr><tr>
	              <td nowrap><strong>Telefoonnummer
	              : </strong></td><td><input name=\"mobiel telnr\" type=\"text\" id=\"mobiel telnr\" size=\"16\"></td></tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td valign=\"top\"><br /><strong>Opmerkingen : </strong></td><td><textarea name=\"opmerkingen\" id=\"opmerkingen\" cols=\"28\" rows=\"6\"></textarea></td></tr><tr><td> </td><td> </td></tr><tr><td> </td><td><input type=\"submit\" name=\"Submit\" value=\"  REACTIE VERSTUREN  \">
	                  <input name=\"ontvanger[0]\" type=\"hidden\" id=\"ontvanger[0]\" value=\"2\">
					  <input name=\"DVD2005\" type=\"hidden\" id=\"DVD2005\" value =\"true\" />
	                  <input name=\"onderwerp\" type=\"hidden\" id=\"onderwerp\" value=\"Reactie via de website WV Leidschendam.nl\"></td></tr></table>
</form>


			";
			}
			else
			{
						$lay_out->partTwoText = "

<form name=\"contact\" method=\"post\" action=\"formhandler.php\">
	<table width=\"95%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"4\"><tr>
	  <td width=\"20%\"><strong>Je naam : </strong></td>
	  <td width=\"80%\"><input name=\"naam\" type=\"text\" id=\"naam\" size=\"32\"></td></tr><tr><td><strong>E-mail
	        adres : </strong></td><td>	          <input name=\"afzender\" type=\"text\" id=\"afzender\" size=\"32\"></td></tr><tr>
	              <td nowrap><strong>Telefoonnummer
	              : </strong></td><td><input name=\"mobiel telnr\" type=\"text\" id=\"mobiel telnr\" size=\"16\"></td></tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td valign=\"top\"><br /><strong>Opmerkingen : </strong></td><td><textarea name=\"opmerkingen\" id=\"opmerkingen\" cols=\"28\" rows=\"6\"></textarea></td></tr><tr>
      <td valign=\"top\">Ik zweer plechtig dat ik een mens ben</td>
      <td><input type=\"radio\" name=\"berttest\" value=\"nee\" checked> nee
	      <input type=\"radio\" name=\"berttest\" value=\"ja\"> ja
      </td>
    </tr><tr><td> </td><td> </td></tr><tr><td> </td><td><input type=\"submit\" name=\"Submit\" value=\"  REACTIE VERSTUREN  \">
	                  <input name=\"ontvanger[0]\" type=\"hidden\" id=\"ontvanger[0]\" value=\"".$_GET['ontv']."\">
	                  <input name=\"onderwerp\" type=\"hidden\" id=\"onderwerp\" value=\"Reactie via de website WV Leidschendam.nl\"></td></tr></table>
</form>


			";}
	/* parse lay_out */
	echo $lay_out->build("");
	
	/* send page to client */
	
	ob_end_flush();

?>
