<?php
/* **********************************************************************
   **	Lay-out library of Content Management System				   **
   **********************************************************************
   ** Created 26-7-04 Erwin Marges									   **
   ********************************************************************** */

class LayOut{
	var $main;
	var $test;
	var $latestNewsTitle;
	var $latestNewsDate;
	var $latestNewsMessage;
	var $latestNewsId;
	var $rightImage;
	var $rightMessages;
	var $partTwoTitle;
	var $partTwoImage;
	var $topEventTitle;
	var $topEventImage;
	var $willekeurigeSurfer;
	var $willekeurigeSurferName;
	var $willekeurigeSurferFoto;
	var $partTwoShit = 1;
	var $head_pagetitle;
	
	function build($title)
	{
		/* builds lay_out */
		$blaat = new LayOut();
		$page = $blaat->head($title);
		$page .= $blaat->bodyStart();
		$page .= $blaat->menu();
		
/*		$latestNewsTitle = "Donec sit amet nunc id nisl lobortis aliquet";
		$latestNewsDate = "Door: Lorem Ipsum op 4 Oktober 2004";
		$latestNewsMessage = "Nunc eu diam. Vivamus ullamcorper, lacus id mattis venenatis, orci pede semper risus, at varius felis eros ut est. Sed iaculis, lacus non faucibus vulputate, odio enim porta dolor, et fermentum nunc leo eu leo. Praesent adipiscing libero at urna. Maecenas nec wisi. Nunc quis neque sed leo tempor fermentum. Ut mauris mauris, aliquet sit amet, cursus pellentesque, tincidunt molestie, nisl. Suspendisse orci. Phasellus pulvinar accumsan ligula. Sed egestas justo sed pede. Vestibulum in leo. Maecenas at ipsum. Proin urna dolor, ultrices non, mattis sed, commodo at, quam. Donec gravida. Sed in orci. Nullam et nisl.";
		$latestNewsId = 0;*/

		if($this->willekeurigeSurferName)
		{
			$page .= $blaat->willekeurigeSurfer($this->latestNewsId, $this->willekeurigeSurferName, $this->willekeurigeSurferFoto, $this->latestNewsMessage);
		}
		
		if($this->topEventTitle)
		{
			$page .= $blaat->topEvent($this->topEventId, $this->topEventTitle, $this->latestNewsDate, $this->latestNewsMessage, $this->topEventImage);		
		}

		if($this->infoRubrieken)
		{
			$page .= $blaat->infoRubrieken($this->infoRubrieken);
		}
		
		if($this->latestNewsTitle)
		{
			$page .= $blaat->latestNews($this->latestNewsId, $this->latestNewsTitle, $this->latestNewsDate, $this->latestNewsMessage);
		}


		$page .= $blaat->partTwo($this->titelImage, $this->partTwoText, $this->partTwoTitle, $this->partTwoImage, $this->partTwoShit);
		
		
		if ($this->rightMessages){
			$page .= $blaat->partRight($this->rightImage, $this->rightMessages);
		}
		else
		{
			$body = "		<div class=\"rechterDeel\">\n";
			$body .= "			<div class=\"titelBalk\"><!--<img src=\"$rightImage\" width=\"228\" height=\"22\">--></div>\n";
			//$body .= "			<div class=\"recentNieuwsKader\">\n\n";
	
			//$body .= "$rightMessages\n";
	
			//$body .= "		</div>\n";
			$body .= "		</div>	\n";
			$body .= "		<!-- EINDE VAN HET RECHTERDEEL -->\n\n";
	
			$body .= "	</div>\n";
			$body = "	<!-- AFSLUITEN VAN DE TWEE DELEN -->\n\n";
	
			$body .= "</div>\n";
			$body .= "</div><p class=\"footerTxt\">
				Copyright &copy; 1978-".date("Y")." Watersportvereniging Leidschendam en omstreken, aangesloten bij<br />
				<a href=\"http://www.watersportverbond.nl\" target=\"_blank\"><img src=\"images/logo_watersportverbond.gif\" alt=\"Watersportverbond\" border=\"0\" /></a>&nbsp;<a href=\"http://www.cwo.nl\" target=\"_blank\"><img src=\"images/logo_cwo.gif\" alt=\"CWO\" border=\"0\" /></a>
				</p>\n";
				
			$body .= "</body>\n";
			$body .= "</html>\n";
			
			$page .= $body;
		}
		
		//$page .= $this->latestNewsTitle;
		
/*		$page .= "boebabah";
$page .= $this->latestNewsTitle;
$page .= $this->latestNewsDate;
$page .= $this->latestNewsMessage;
$page .= $this->latestNewsId;
$page .= $this->rightImage;
$page .= $this->rightMessages;*/
		return $page;
	}
	
	function head($title)
	{
		global $_SERVER;

		/* generates header */
		//$top = "<?phpxml version=\"1.0\" encoding=\"iso-8859-1\"?".">\n";
		$top .= "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">\n";
		$top .= "<html>\n";
		$top .= "<head>\n";
		$top .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
		$top .= "<title>".$title."Windsurfvereniging Leidschendam en omstreken</title>\n";
		$top .= "<meta name=\"description\" content=\"Windsurfvereniging Leidschendam e.o. is te vinden aan het surfstrand van recreatiegebied Vlietland, langs A4 tussen Leidschendam, Voorschoten en Leiden in. Waar we surflessen, clubwedstrijden en diverse andere activiteiten organiseren.\">\n";
		$top .= "<meta name=\"keywords\" content=\"surfen,windsurfen,surfing,surfclub,windsurfclub,vereniging,surfvereniging,windsurfing,surfles,vlietland,recreatiegebied,vlietlanden,vliet,leidschendam,leiden,voorschoten,voorburg,denhaag,den-haag, den haag,wassenaar,leiderdorp,zoeterwoude,nootdorp,leren,surfen,surfcursus,windsurfcursus,plankzeilen,wedstrijden,instructie,beginners,beginnersles,KNWV,Watersportverbond,formula,slalom,plankzeilen,courserace,training,thema,avonden,gijpen,overstag,planeren,waterstart,waterstarten,plane,zuid-holland,zuid holland, nederland,europa\">\n";

		$top .= "<link href=\"css/default.css\" rel=\"stylesheet\" type=\"text/css\">\n";

		if( strstr($_SERVER['HTTP_USER_AGENT'],"Gecko") && strstr($_SERVER['HTTP_USER_AGENT'],"rv:0.9.") )
		{
			$top .= "<link href=\"css/wsvl-ns62.css\" rel=\"stylesheet\" type=\"text/css\">\n";
		}
		elseif( strstr($_SERVER['HTTP_USER_AGENT'],"MSIE 6") )
		{
			$top .= "<link href=\"css/wsvl-ie6.css\" rel=\"stylesheet\" type=\"text/css\">\n";
		}
		elseif( strstr($_SERVER['HTTP_USER_AGENT'],"MSIE 5") )
		{
			$top .= "<link href=\"css/wsvl-ie5.css\" rel=\"stylesheet\" type=\"text/css\">\n";
		}

		$top .= " <!-- ".$_SERVER['HTTP_USER_AGENT']." -->\n";
		$top .= "<script language=\"javascript\" type=\"text/javascript\" src=\"wvleidschendam.js\"></script>\n\n";
		$top .= "<meta name=\"verify-v1\" content=\"F7RRNpNv41oNrhlCpMErAYdvgk2xUz6iUwj6vERG/5E=\" >\n";
		$top .= "</head>\n";

		return $top;
		
	}	

	function menu()
	{

		$nav_options[1]['title'] = "home";
		$nav_options[1]['link'] = "/?tab=home";

		$nav_options[2]['title'] = "informatie";
		$nav_options[3]['title'] = "kalender";
		$nav_options[4]['title'] = "training";

		$nav_options[5]['title'] = "foto's";
		$nav_options[5]['link'] = "foto.php?tab=foto";

		$nav_options[6]['title'] = "wedstrijden &amp; verslagen";
		$nav_options[6]['link'] = "verslagen.php?tab=verslagen";

		$nav_options[7]['title'] = "onze surfers";
		$nav_options[7]['link'] = "onze_surfers.php?tab=onze_surfers";

		$nav_options[8]['title'] = "forum";
		$nav_options[8]['link'] = "http://forum.wvleidschendam.nl";

		$nav_options[9]['title'] = "contact";	


		/* generates menu */
		$body .= "	<!-- NAVIGATIE MENU BALK MET LOGO -->\n";
		$body .= "		<div class=\"navHeader\">\n";

// DIV vervangen door een H1, voor zoekmachine vriendelijkheid.
		$body .= "		<h1>Windsurfvereniging Leidschendam en omstreken - surfclub in de regio Leidschendam, Voorschoten, Leiden, Leiderdorp, Zoeterwoude, Voorburg, Wassenaar, Den Haag, Oegstgeest. <img src=\"images/logo.gif\" width=\"755\" height=\"56\"><!--// Windsurfvereniging Leidschendam en omstreken (Leidschendam, Voorschoten, Leiden, Leiderdorp, Zoeterwoude, Voorburg, Wassenaar, Den Haag) //--></h1>\n";

//		$body .= "			<div id=\"logo\"><img src=\"images/logo.gif\" width=\"755\" height=\"56\"><!--// Windsurfvereniging Leidschendam en omstreken (Leidschendam, Voorschoten, Leiden, Leiderdorp, Zoeterwoude, Voorburg, Wassenaar, Den Haag) //--></div>\n";
		$body .= "			<ul>\n";

		if( home == $_GET['tab'])
		{
			$body .= "			  <li><a href=\"/?tab=home\" class=\"current\">Home</a></li>\n";
		}
		else
		{
			$body .= "			  <li><a href=\"/?tab=home\">Home</a></li>\n";		
		}

		if( informatie == $_GET['tab'])
		{
			$body .= "			  <li><a href=\"informatie.php?tab=informatie\" class=\"current\">Informatie</a></li>\n";
		}
		else
		{
			$body .= "			  <li><a href=\"informatie.php?tab=informatie\">Informatie</a></li>\n";
		}

		if( kalender == $_GET['tab'])
		{
			$body .= "			  <li><a href=\"kalender.php?tab=kalender\" class=\"current\">Kalender</a></li>\n";
		}
		else
		{
			$body .= "			  <li><a href=\"kalender.php?tab=kalender\">Kalender</a></li>\n";
		}

		if( training == $_GET['tab'])
		{
			$body .= "			  <li><a href=\"training.php?tab=training\" class=\"current\">Training</a></li>\n";
		}
		else
		{
			$body .= "			  <li><a href=\"training.php?tab=training\">Training</a></li>\n";
		}
		
		/*
		if( foto == $_GET['tab'])
		{
			$body .= "			  <li><a href=\"foto.php?tab=foto\" class=\"current\">Foto's</a></li>\n";
		}
		else
		{
			$body .= "			  <li><a href=\"foto.php?tab=foto\">Foto's</a></li>\n";
		}
			
		if( verslagen == $_GET['tab'])
		{
			$body .= "			  <li><a href=\"verslagen.php?tab=verslagen\" class=\"current\">Wedstrijden &amp; Verslagen</a></li>\n";
		}
		else
		{
			$body .= "			  <li><a href=\"verslagen.php?tab=verslagen\">Wedstrijden &amp; Verslagen</a></li>\n";
		} 
		
		if( onze_surfers == $_GET['tab'])
		{
			$body .= "			  <li><a href=\"onze_surfers.php?tab=onze_surfers\" class=\"current\">Onze surfers</a></li>\n";
		}
		else
		{
			$body .= "			  <li><a href=\"onze_surfers.php?tab=onze_surfers\" >Onze surfers</a></li>\n";
		} */
			
		$body .= "			  <li><a href=\"http://forum.wvleidschendam.nl/index.php\">Forum</a></li>\n";

		if( contact == $_GET['tab'])
		{
			$body .= "			  <li><a href=\"contact.php?tab=contact\" class=\"current\">Contact</a></li>\n";
		}
		else
		{
			$body .= "			  <li><a href=\"contact.php?tab=contact\">Contact</a></li>\n";
		}

		$body .= "			</ul>\n";
		$body .= "		</div>\n";
		$body .= "	<!-- EINDE VAN HET NAVIGATIE MENU BALK MET LOGO -->\n\n\n";
		
		return $body;
	}
	
//==============================================================================================
//	function LATEST NEWS
//==============================================================================================
//
//----------------------------------------------------------------------------------------------
	function latestNews($latestNewsId, $latestNewsTitle, $latestNewsDate, $latestNewsMessage){
		/* prints latest news message */
				$blaat = new LayOut();

		$small = "small.jpg";
		$latest = $latestNewsId;
		$image = "$latest$small";
		$body .= "	<!-- BLAUWE KADER MET FOTO EN HET NIEUWSTE NIEUWSBERICHT -->\n";
		$body .= "		<div id=\"heterKader\">\n";
		$body .= "			<img src=\"images/news/$image\" id=\"heterFoto\" align=\"left\" />\n";
		$body .= "			<div id=\"heterContent\">\n";
		$body .= "				<h3>$latestNewsTitle</h3>\n";

//		$body .= "				<div class=\"heterTitel\">$latestNewsTitle</div>\n";
//		$body .= "				<div>$latestNewsDate</div>\n";

		$body .= "				<p>\n";
		$body .= "					$latestNewsMessage";
		$body .= "				</p>\n";
		//$body .= "			    <img src=\"images/heter_leesverder.gif\" width=\"112\" height=\"18\" border=\"0\" id=\"heterLeesverder\" />\n";
		$body .= "			</div>\n";
		$body .= "		</div>\n";
		$body .= "		<div class=\"heterBottom\">\n";
		$body .= "			<img src=\"images/heter_dan_de_overstag.gif\" align=\"right\" />\n";
		$body .= "		</div>\n";
		$body .= "	<!-- EINDE VAN HET BLAUWE KADER MET FOTO EN HET NIEUWSTE NIEUWSBERICHT -->\n\n\n";
		return $body;
	}

//==============================================================================================
//	function WILLEKEURIGE SURFER
//==============================================================================================
//
//----------------------------------------------------------------------------------------------
	function willekeurigeSurfer($latestNewsId, $latestNewsTitle, $willekeurigeSurferFoto, $latestNewsMessage){
		/* prints latest news message */
				$blaat = new LayOut();

//		$small = "-thumb.jpg";
		$small = ".jpg";
	
		$latest = $latestNewsId;
		$image = "$willekeurigeSurferFoto$small";

		$body .= "	<!-- BLAUWE KADER MET FOTO EN HET NIEUWSTE NIEUWSBERICHT -->\n";
		$body .= "		<div id=\"heterKader\">\n";
		$body .= "			<img src=\"images/event/photo/$image\" width=\"300\" id=\"heterFoto\" align=\"left\" />\n";
		$body .= "			<div id=\"heterContent\">\n";
		$body .= "				<div class=\"heterTitel\">$latestNewsTitle</div>\n";
//		$body .= "				<div>$latestNewsDate</div>\n";
		$body .= "				<p>\n";
		$body .= "					$latestNewsMessage";
		$body .= "				</p>\n";
		//$body .= "			    <img src=\"images/heter_leesverder.gif\" width=\"112\" height=\"18\" border=\"0\" id=\"heterLeesverder\" />\n";
		$body .= "			</div>\n";
		$body .= "		</div>\n";
		$body .= "		<div class=\"heterBottom\">\n";
		$body .= "			<img src=\"images/zomaar_een_surfer.gif\" align=\"right\" />\n";
		$body .= "		</div>\n";
		$body .= "	<!-- EINDE VAN HET BLAUWE KADER MET FOTO EN HET NIEUWSTE NIEUWSBERICHT -->\n\n\n";
		return $body;
	}
//----------------------------------------------------------------------------------------------

//==============================================================================================
//	function TOP EVENT
//==============================================================================================
//
//----------------------------------------------------------------------------------------------
	function topEvent($latestNewsId, $latestNewsTitle, $latestNewsDate, $latestNewsMessage, $topEventImage)
	{
		/* prints latest news message */
				$blaat = new LayOut();

		$small = "small.jpg";
		$latest = $latestNewsId;
		$image = "$latest$small";
		
		$body .= "	<!-- BLAUWE KADER MET FOTO EN HET NIEUWSTE NIEUWSBERICHT -->\n";
		$body .= "		<div id=\"heterKader\">\n";
		if(file_exists("images/event/$image"))
			$body .= "			<img src=\"images/event/$image\" id=\"heterFoto\" align=\"left\" />\n";
		else
		{
			$query = "SELECT * FROM foto WHERE event_id = $latestNewsId ORDER BY RAND() LIMIT 1";
			$sql = mysql_query($query) or die("error");
			$obj = mysql_fetch_object($sql);
			$image = "$obj->foto_id-thumb.jpg";
			if($obj->foto_id != null)
				$body .= "			<img src=\"images/event/photo/$image\" id=\"heterFoto\" align=\"left\" />\n";
		}
		$body .= "			<div id=\"heterContent\">\n";
		$body .= "				<div class=\"heterTitel\">$latestNewsTitle</div>\n";
		$body .= "				<div>$latestNewsDate</div>\n";
		$body .= "				<p>\n";
		$body .= "					$latestNewsMessage";
		$body .= "				</p>\n";
		/*if($obj)
			$body .= "			    <a href=\"viewevent.php?event_id=$latestNewsId&tab=foto\"><img src=\"images/heter_bekijkfotos.gif\" width=\"143\" height=\"20\" border=\"0\" id=\"heterLeesverder\" /></a>\n";*/
		$body .= "			</div>\n";
		$body .= "		</div><br /><br />\n";
		$body .= "		<div class=\"heterBottom\">\n";
		$body .= "			<img src=\"$topEventImage\" align=\"right\" />\n";
		$body .= "		</div>\n";
		$body .= "	<!-- EINDE VAN HET BLAUWE KADER MET FOTO EN HET NIEUWSTE NIEUWSBERICHT -->\n\n\n";
		return $body;
	}

//==============================================================================================
//	function LATEST NEWS
//==============================================================================================
//
//----------------------------------------------------------------------------------------------
/*
	function latestNews($latestNewsId, $latestNewsTitle, $latestNewsDate, $latestNewsMessage){
		// prints latest news message
				$blaat = new LayOut();

		$small = "small.jpg";
		$latest = $latestNewsId;
		$image = "$latest$small";
		$body .= "	<!-- BLAUWE KADER MET FOTO EN HET NIEUWSTE NIEUWSBERICHT -->\n";
		$body .= "		<div id=\"heterKader\">\n";
		$body .= "			<img src=\"images/news/$image\" id=\"heterFoto\" align=\"left\" />\n";
		$body .= "			<div id=\"heterContent\">\n";
		$body .= "				<div class=\"heterTitel\">$latestNewsTitle</div>\n";
		$body .= "				<div>$latestNewsDate</div>\n";
		$body .= "				<p>\n";
		$body .= "					$latestNewsMessage";
		$body .= "				</p>\n";
		//$body .= "			    <img src=\"images/heter_leesverder.gif\" width=\"112\" height=\"18\" border=\"0\" id=\"heterLeesverder\" />\n";
		$body .= "			</div>\n";
		$body .= "		</div>\n";
		$body .= "		<div class=\"heterBottom\">\n";
		$body .= "			<img src=\"images/heter_dan_de_overstag.gif\" align=\"right\" />\n";
		$body .= "		</div>\n";
		$body .= "	<!-- EINDE VAN HET BLAUWE KADER MET FOTO EN HET NIEUWSTE NIEUWSBERICHT -->\n\n\n";
		return $body;
	}
*/

//==============================================================================================
//	function INFO RUBRIEKEN
//==============================================================================================
//
//----------------------------------------------------------------------------------------------
	function infoRubrieken($infoRubrieken)
	{
		/* prints sticky rubrieken en aanmeld formulier voor de nieuwsbrief */

				$blaat = new LayOut();

		$small = "small.jpg";
		$latest = $infoRubriekId;
		$image = "$latest$small";

		$body .= "	<!-- BLAUWE KADER MET FOTO EN HET NIEUWSTE NIEUWSBERICHT -->\n";
		$body .= "		<div id=\"heterInfoKader\">\n";
		$body .= "			<div class=\"infoKader\">\n";


		$rubr_query = " SELECT * FROM teksten_rubrieken WHERE rubriek_sticky = 1 ORDER BY positie DESC ";
		$rubr_sql = mysql_query($rubr_query) or die("error");

		while($rubr_obj = mysql_fetch_object($infoRubrieken))
		{

				$body .= "
				<a href=\"informatie_leesverder.php?rubriek_id=".$rubr_obj->rubriek_id."&amp;tab=informatie\"><div class=\"";
				
				if($_GET['rubriek_id'] == $rubr_obj->rubriek_id) { $body .= " infoSelected "; }
				
				$body .= "infoButton sPrubr".$rubr_obj->rubriek_id."\">
					<img src=\"images/img_rubr".$rubr_obj->rubriek_id.".jpg\" alt=\"".$rubr_obj->rubriek_titel."\" />
					<span class=\"titel\">".$rubr_obj->rubriek_titel."</span><br />
					<span>".$rubr_obj->rubriek_desc."</span>
				</div></a>
				";
		
		}

		$body .= "			</div>\n";

		$body .= "

			<div class=\"nieuwsbriefBox \">
			  <img src=\"images/kop_altijd-op-de-hoogte.gif\" alt=\"Altijd op de hoogte\" width=\"308\" height=\"31\"><br />
			  Wil jij ook de onregelmatig verschijnende nieuwsbrief van Windsurf
			  vereninging Leidschendam en omstreken in je mailbox ontvangen?
			    Meld je dan nu meteen aan!<br />
			  <form action=\"nieuwsbrief/subscribe.php\" method=\"post\" style=\"padding: 0px; margin: 0px;\">
                <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
                  <tr>
                    <td width=\"9%\" align=\"right\" nowrap=\"nowrap\"><strong>Naam
                        : </strong></td>
                    <td width=\"91%\">&nbsp;
                        <input name=\"naam\" type=\"text\" id=\"naam\" size=\"32\" /></td>
                  </tr>
                  <tr>
                    <td align=\"right\" nowrap=\"nowrap\"><strong>E-mail adres : </strong></td>
                    <td>&nbsp;
                        <input name=\"emailadres\" type=\"text\" id=\"emailadres\" size=\"32\" /></td>
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
                    <td><input type=\"submit\" name=\"Submit\" value=\"  BEVESTIGEN  \" /></td>
                  </tr>
                </table></form></div>
		</div>
		<div class=\"nieuwsbriefBoxBottom\" style=\"float: right; padding: 0px; margin: 0px; width: 49%; margin-top: -52px; height: 49px; \"></div>
		
		
		";

		$body .= "	<!-- EINDE VAN HET BLAUWE KADER MET FOTO EN HET NIEUWSTE NIEUWSBERICHT -->\n\n\n";

		return $body;
	}	


//==============================================================================================
//	function BODY START
//==============================================================================================
//
//----------------------------------------------------------------------------------------------
	function bodyStart(){
		/*prints the body */
		$body = "<body>\n";
		$body .= "<div class=\"contentArea\">\n\n\n";
		return $body;
	}

//==============================================================================================
//	function PART TWO
//==============================================================================================
//
//----------------------------------------------------------------------------------------------	
	function partTwo($titleImage, $partTwoText, $partTwoTitle, $partTwoImage, $partTwoShit){
		/* second par of body */
		$body = "	<!-- HET ONDERDERSTE GEDEELTE VAN DE PAGINA, DAT IN TWEE DELEN IS GESPLITST -->\n";	
		if($partTwoShit == 1)
			$body .= "	<div class=\"tweeDelen\">\n\n";

		/*image preperation */
		$small = "small.jpg";
		$latest = $partTwoImage;
		$image = "$latest$small";
		
		if($partTwoShit == 1)
			$body .= "		<div class=\"linkerDeel\">\n";
		else
			$body .= "		<div class=\"linkerDeel2\">\n";
		$body .= "			<div class=\"titelBalk\"><img src=\"$titleImage\" ></div>\n";
		if($partTwoTitle != '')
		{
			$body .= "			<p class=\"nieuwsTitel\">$partTwoTitle</p>";
		}
		$body .= "			<p>";
		if($partTwoImage)
			$body .= "			<img src=\"images/news/$image\" id=\"heterFoto\" align=\"left\" width=\"200\"/>\n";
		$body .= "			$partTwoText</p>\n";
		if($partTwoShit == 1)
			$body .= "		</div>\n\n ";
		return $body;
	}

//==============================================================================================
//	function PART RIGHT
//==============================================================================================
//
//----------------------------------------------------------------------------------------------
	function partRight($rightImage, $rightMessages){

		$body .= "		<div class=\"rechterDeel\">\n";
		$body .= "			<div class=\"titelBalk\">";
		if ("none" == $rightImage)
			$body .= "</div>\n";
		else 
			$body .= "<img src=\"$rightImage\" ></div>\n";
		$body .= "			<div class=\"recentNieuwsKader\">\n\n";

		$body .= "$rightMessages\n";

		$body .= "		</div>\n";
		$body .= "		</div>	\n";
		$body .= "		<!-- EINDE VAN HET RECHTERDEEL -->\n\n";

		$body .= "	</div>\n";
		$body .= "	<!-- AFSLUITEN VAN DE TWEE DELEN -->\n\n";

		$body .= "</div>\n";

		$body .= "<div class=\"footerTxt\">
			Copyright &copy; 1978-".date("Y")." Watersportvereniging Leidschendam en omstreken, aangesloten bij<br />
			<a href=\"http://www.watersportverbond.nl\" target=\"_blank\"><img src=\"images/logo_watersportverbond.gif\" alt=\"Watersportverbond\" border=\"0\" /></a>&nbsp;<a href=\"http://www.cwo.nl\" target=\"_blank\"><img src=\"images/logo_cwo.gif\" alt=\"CWO\" border=\"0\" /></a>
</div>\n";
		$body .= "<!-- Google analytics -->
<script src=\"http://www.google-analytics.com/urchin.js\" type=\"text/javascript\">
</script>
<script type=\"text/javascript\">
_uacct = \"UA-325606-2\";
urchinTracker();
</script>\n";
		$body .= "</body>\n";
		$body .= "</html>\n";
		
		return $body;
	}
	
//----------------------------------------------------------------------------------------------
	
}
?>
