<?php
//-----------------------------------------------------
//	Lijstje met e-mail adressen die bij de forum
//	user ID's horen. Dit zou eigenlijk gewoon uit
//	de DB opgehaald moeten worden, zodat profiel 
//	wijzigingen ook hier op effect hebben :z
//-----------------------------------------------------
// 28-02-2011 - Huug : Laura vervangen door huug (tijdelijk)
$email_adressen[1] = "surf.wvleidschendam@gmail.com";
$email_adressen[2] = "surfles.wvleidschendam@gmail.com";
$email_adressen[4] = "robbert-jan@technotalents.nl";	// RJ
$email_adressen[6] = "huug@windtrade.nl";		// Huug
$email_adressen[7] = "surfvoorzitter@wvleidschendam.nl";// voorzitter
$email_adressen[9] = "femkeluijten@hotmail.com";	// Femke Luijten
$email_adressen[10] = "huug@windtrade.nl";		// Huug
$email_adressen[11] = "ledenadministratie@wvleidschendam.nl";
$email_adressen[12] = "rendier@randy347.demon.nl";		// Randy
$email_adressen[16] = "arjanus24@hotmail.com";			// Arjan
$email_adressen[17] = "pedebruin@hotmail.com";// Wedstrijden, Pim
//-----------------------------------------------------

//	submit = de name en id van de submit knop
//	ontvanger[0] = een hidden field in het formulier met daarin de forum user id van de ontvanger.
//		Als het formulier meerdere ontvangers moet hebben, dan gewoon doorgaan met  ontvanger[1] etc.
//	Er moet ook altijd een veld zijn met afzender, wat dus eigenlijk ook ingevuld moet worden door de bezoeker.
//	Het onderwerp veld is optioneel, maar het is wel handig als dat is ingevuld.


/*------------------------------------------------------//
//	We hadden last van spammers die ons formulier probeerden te misbruiken om spam te versturen !
//	Dit zou het moeten oplossen.
	//------------------------------------------------------*/
foreach ($_POST as $j =>$value)
{
	if (stristr($value,"Content-Type"))
	{
		header("HTTP/1.0 403 Forbidden");
		echo "YOU HAVE BEEN BANNED FROM ACCESSING THIS SERVER FOR TRIGGERING OUR SPAMMER TRAP";
		exit;

		/* Voor als de exit niet werkt */
		header("Location: http://www.wvleidschendam.nl");
	}
}
// Test ingevoegd door Bert Peters om als nog de spammers tegen te gaan. De vorige werkte niet...
if($_POST['berttest'] != "ja") {
	header("HTTP/1.0 403 Forbidden");
	die("As you were tested inhuman, we decided not to let you in. Goodbye.");
}
// Einde test.
//------------------------------------------------------------------
// ff snel een mailcher uit een andere site van me erin gepaste:
//------------------------------------------------------------------
function checkEmail($email)
{
   if(eregi("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$]", $email))
   {
      return FALSE;
   }

   list($Username, $Domain) = split("@",$email);

   if(getmxrr($Domain, $MXHost))
   {
      return TRUE;
   }
   else
   {
      if(fsockopen($Domain, 25, $errno, $errstr, 30))
      {
         return TRUE;
      }
      else
      {
         return FALSE;
      }
   }
}

//------------------------------------------------------------------
//	ONTVANGERS SELECTEREN EN OPZOEKEN
//------------------------------------------------------------------
	if($_POST['Submit'] && $_POST['ontvanger'])
	{
		// Wie zijn de ontvangers?
		if(is_array($_POST['ontvanger']))
		{
			foreach($_POST['ontvanger'] as $key => $value)
			{
			// Checken of we een geldige ontvanger hebben gekregen
				if(array_key_exists($value, $email_adressen))
				{
					$email_ontvanger[] = $email_adressen[$value];
				}
				else
				{
					$foutcode = "Ongeldige ontvanger gespecificeerd.";
				}
			}
		}
		else
		{
			//	??
			$foutcode =  "Er is helemaal geen ontvanger gespecificeerd!";
		}

//----------------------------------------------------------------------
//	We hebben een of meer ontvangers, dus nu kunnen we verder gaan.
//----------------------------------------------------------------------
		if(is_array($email_ontvanger))
		{
			$onderwerp = $_POST['onderwerp'];
			if($onderwerp == '') { $onderwerp = "Reactie via de website van de club."; }
			if($_POST['afzender'] == "")
				$afzender = $_POST['emailadres'];// Ik heb dit even veranderd van 'email adres' in emailadres, misschien werkt de afzender nu wel beter.
			else
				$afzender = $_POST[afzender];
			
			if(checkEmail($afzender) == FALSE)
				$afzender = "website@wvleidschendam.nl"; //geen mailadres opgegeven, of 1tje die niet klopt...
				
			$extra = "From:".$afzender."\nReturn-Path: website@wvleidschendam.nl\n";		// Hier moet nog een check op een geldig e-mail adres komen.
		
			$bericht = "\nVia de website van de club is de volgende informatie naar jou toegezonden.\n\n";
			foreach($_POST as $key => $value)
			{
				if($key != 'Submit')
				{
					if($key != 'ontvanger')	
					{	// Je vraagt je misschien af waarom deze if statement niet is samengevoegd met de vorige if statement
						// mijn ervaring is dat er niet meerdere  !=  vergelijkingen in 1 if statement kunnen staan.
						//	vandaar.

						$bericht .= $key.": ".$value."\n";
					}
				}
			}

			$bericht .= "\n\n-----------------------------------------------------\nDebugging info:\n";
			$bericht .= "User Agent: ".$_SERVER['HTTP_USER_AGENT']."\n";
			$bericht .= "IP adres: ".$_SERVER['REMOTE_ADDR']."\n";
			$bericht .= "Accept Type(s): ".$_SERVER['HTTP_ACCEPT']."\n";
			$bericht .= "-----------------------------------------------------\n\n";

			$foutcode = "De door jou ingevulde gegevens zijn zojuist verzonden. <br />Je hoort zo snel mogelijk nog van ons.";	//	In dit geval dus eigenlijk een 'goed' code ;)

			foreach($email_ontvanger as $key => $value)
			{
				//echo "mail($value, $onderwerp, $bericht, $extra)";
				mail($value, $onderwerp, $bericht, $extra);
			}
		}

//------------------------------------------------------------------
	
	}
	else
	{
		$foutcode = "Er is geen formulier gesubmit";
	}

?>
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


//===============================================================================
//	INSCHRIJVINGEN OPSLAAN IN DE DATABASE
//===============================================================================
	if($_POST['geboortedatum'] && $_POST['roepnaam'])
	{
		// Dan heeft iemand hoogstwaarschijnlijk het aanmeld formulier ingevuld ;)
		$naam = addslashes($_POST['naam']);
		$voorletters = addslashes($_POST['voorletters']);
		$roepnaam = addslashes($_POST['roepnaam']);
		$geboortedatum = addslashes($_POST['geboortedatum']);
		$adres = addslashes($_POST['adres']);
		$postcode = addslashes($_POST['postcode']);
		$woonplaats = addslashes($_POST['woonplaats']);
		$thuistelnr = addslashes($_POST['thuis_telnr']);
		$mobieltelnr = addslashes($_POST['mobiel_telnr']);
		$emailadres = addslashes($_POST['emailadres']);
		$emailadres_ouders = addslashes($_POST['emailadres_ouders']);
		$beroep_studie = addslashes($_POST['beroep']);
		$surfpool = addslashes($_POST['surfpool']);
		$opmerkingen = addslashes($_POST['opmerkingen']);

		mysql_query(" INSERT INTO surfles_inschrijvingen 
		(inschrijving_id, naam, voorletters, roepnaam, geboortedatum, adres, postcode, woonplaats, telnr_thuis, telnr_mobiel, email_adres, emailadres_ouders, beroep_studie, surfpool, aanmeld_datum, opmerkingen) VALUES 
		('', '$naam', '$voorletters', '$roepnaam', '$geboortedatum', '$adres', '$postcode', '$woonplaats', '$thuistelnr', '$mobieltelnr', '$emailadres', '$emailadres_ouders', '$beroep_studie', '$surfpool', NOW(), '$opmerkingen') ");

	}
//--------------------------------------------------------------------------------	

	/* start lay_out */
	$lay_out = new LayOut();


	if(!$_GET[tekst])
	$tekst = 3;
	$lay_out->rightImage = "none";
	$lay_out->rightMessages = "";
	$lay_out->rightMessages .="<div class=\"recentNieuwsBericht\">
					<span class=\"nieuwsTitel\">Nog meer informatie:</span><br />";
				
	$query = " select * from teksten where id NOT IN (1,2,6,7,8,9,10,11,13	) order by id desc ";
	$sql = mysql_query($query) or die("error");
	while($obj=mysql_fetch_object($sql)){
		if($obj->id != $tekst){
			$lay_out->rightMessages .="<p class=\"infoItems\">";
			$lay_out->rightMessages .= "<a href=\"informatie.php?tekst=$obj->id&amp;tab=informatie\">$obj->titel</a>";
				$lay_out->rightMessages .="</p>";
					
		}
	
	}
	$lay_out->rightMessages .="</div>";
	$lay_out->titelImage = "images/kop_informatie.gif";
	//$query = "SELECT * FROM teksten WHERE id ='$tekst'";
	//$SQL = mysql_query($query);
	//$obj = mysql_fetch_object($SQL);
	$lay_out->partTwoText = "<div class=\"objTitel\">Responsformulier</div>";
	$lay_out->partTwoText .= "<div style=\"padding: 2%; width: 90%;\">$foutcode</div>";
	
	/* parse lay_out */
	echo $lay_out->build("");
	
	/* send page to client */
	
	ob_end_flush();

?>
