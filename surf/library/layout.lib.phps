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
	var $partTwoShit = 1;
	
	function build(){
		/* builds lay_out */
		$blaat = new LayOut();
		$page = $blaat->head();
		$page .= $blaat->bodyStart();
		$page .= $blaat->menu();
		
/*		$latestNewsTitle = "Donec sit amet nunc id nisl lobortis aliquet";
		$latestNewsDate = "Door: Lorem Ipsum op 4 Oktober 2004";
		$latestNewsMessage = "Nunc eu diam. Vivamus ullamcorper, lacus id mattis venenatis, orci pede semper risus, at varius felis eros ut est. Sed iaculis, lacus non faucibus vulputate, odio enim porta dolor, et fermentum nunc leo eu leo. Praesent adipiscing libero at urna. Maecenas nec wisi. Nunc quis neque sed leo tempor fermentum. Ut mauris mauris, aliquet sit amet, cursus pellentesque, tincidunt molestie, nisl. Suspendisse orci. Phasellus pulvinar accumsan ligula. Sed egestas justo sed pede. Vestibulum in leo. Maecenas at ipsum. Proin urna dolor, ultrices non, mattis sed, commodo at, quam. Donec gravida. Sed in orci. Nullam et nisl.";
		$latestNewsId = 0;*/
		if($this->topEventTitle)
			$page .= $blaat->topEvent($this->topEventId, $this->topEventTitle, $this->latestNewsDate, $this->latestNewsMessage);		
		if($this->latestNewsTitle)
			$page .= $blaat->latestNews($this->latestNewsId, $this->latestNewsTitle, $this->latestNewsDate, $this->latestNewsMessage);


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
	
	function head(){
		/* generates header */
		$top = "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">\n";
		$top .= "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">\n";
		$top .= "<html>\n";
		$top .= "<head>\n";
		$top .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n";
		$top .= "<title>Windsurfvereniging Leidschendam en omstreken</title>\n";
		$top .= "<link href=\"css/default.css\" rel=\"stylesheet\" type=\"text/css\">\n";
		$top .= "<script language=\"javascript\" type=\"text/javascript\" src=\"wvleidschendam.js\"></script>\n\n";
		$top .= "<!--[if IE]>\n";
		$top .= "<style type=\"text/css\">\n";
		$top .= "	.heterBottom {\n";
		$top .= "		float: right;\n";
		$top .= "		text-align: right;\n";
		$top .= "	/* --- alleen voor IE --- */\n";
		$top .= "		margin-top: -23px;\n";
		$top .= "	/* ---------------------- */\n";
		$top .= "		height: 47px;\n";
		$top .= "		width: 100%;\n";
		$top .= "		background-attachment: scroll;\n";
		$top .= "		background-image: url(images/heter_bottom_bck.gif);\n";
		$top .= "		background-repeat: repeat-x;\n";
		$top .= "		background-position: left top;\n";
		$top .= "	}\n";
		$top .= "</style>\n";
		$top .= "<![endif]-->\n\n";
		$top .= "</head>\n";

		return $top;
		
	}	
	function menu(){
		/* generates menu */
		$body .= "	<!-- NAVIGATIE MENU BALK MET LOGO -->\n";
		$body .= "		<div class=\"navHeader\">\n";
		$body .= "			<div id=\"logo\"><img src=\"images/logo.gif\" width=\"755\" height=\"56\"></div>\n";
		$body .= "			<ul>\n";

		if( home == $_GET['tab'])
			$body .= "			  <li><a href=\"index.php?tab=home\" class=\"current\">Home</a></li>\n";
		else
			$body .= "			  <li><a href=\"index.php?tab=home\">Home</a></li>\n";		

		if( informatie == $_GET['tab'])
			$body .= "			  <li><a href=\"informatie.php?tab=informatie\" class=\"current\">Informatie</a></li>\n";
		else
			$body .= "			  <li><a href=\"informatie.php?tab=informatie\">Informatie</a></li>\n";

		if( kalender == $_GET['tab'])
			$body .= "			  <li><a href=\"kalender.php?tab=kalender\" class=\"current\">Kalender</a></li>\n";
		else
			$body .= "			  <li><a href=\"kalender.php?tab=kalender\">Kalender</a></li>\n";
			
		if( foto == $_GET['tab'])
			$body .= "			  <li><a href=\"foto.php?tab=foto\" class=\"current\">Foto's</a></li>\n";
		else
			$body .= "			  <li><a href=\"foto.php?tab=foto\">Foto's</a></li>\n";
			
		if( verslagen == $_GET['tab'])
			$body .= "			  <li><a href=\"verslagen.html?tab=verslagen\" class=\"current\">Verslagen</a></li>\n";
		else
			$body .= "			  <li><a href=\"verslagen.html?tab=verslagen\">Verslagen</a></li>\n";
		
		if( onze_surfers == $_GET['tab'])
			$body .= "			  <li><a href=\"onze_surfers.html?tab=onze_surfers\" class=\"current\">Onze surfers</a></li>\n";
		else
			$body .= "			  <li><a href=\"onze_surfers.html?tab=onze_surfers\" >Onze surfers</a></li>\n";
			
		$body .= "			  <li><a href=\"forum.php\">Forum</a></li>\n";

		if( contact == $_GET['tab'])
			$body .= "			  <li><a href=\"contact.php?tab=contact\" class=\"current\">Contact</a></li>\n";
		else
			$body .= "			  <li><a href=\"contact.php?tab=contact\">Contact</a></li>\n";

		$body .= "			</ul>\n";
		$body .= "		</div>\n";
		$body .= "	<!-- EINDE VAN HET NAVIGATIE MENU BALK MET LOGO -->\n\n\n";
		
		return $body;
	}
	
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
	
function topEvent($latestNewsId, $latestNewsTitle, $latestNewsDate, $latestNewsMessage){
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
			$body .= "			<img src=\"images/event/photo/$image\" id=\"heterFoto\" align=\"left\" />\n";
		}
		$body .= "			<div id=\"heterContent\">\n";
		$body .= "				<div class=\"heterTitel\">$latestNewsTitle</div>\n";
		$body .= "				<div>$latestNewsDate</div>\n";
		$body .= "				<p>\n";
		$body .= "					$latestNewsMessage";
		$body .= "				</p>\n";
		if($obj)
			$body .= "			    <a href=\"viewevent.php?event_id=$latestNewsId&tab=foto\"><img src=\"images/heter_bekijkfotos.gif\" width=\"143\" height=\"20\" border=\"0\" id=\"heterLeesverder\" /></a>\n";
		$body .= "			</div>\n";
		$body .= "		</div>\n";
		$body .= "		<div class=\"heterBottom\">\n";
		$body .= "			<img src=\"images/direct_uit_de_camera.gif\" align=\"right\" />\n";
		$body .= "		</div>\n";
		$body .= "	<!-- EINDE VAN HET BLAUWE KADER MET FOTO EN HET NIEUWSTE NIEUWSBERICHT -->\n\n\n";
		return $body;
	}

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
	
	function bodyStart(){
		/*prints the body */
		$body = "<body>\n";
		$body .= "<div class=\"contentArea\">\n\n\n";
		return $body;
	}
	
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
		$body .= "			<p class=\"nieuwsTitel\">$partTwoTitle</p>";
		$body .= "			<p>";
		if($partTwoImage)
			$body .= "			<img src=\"images/news/$image\" id=\"heterFoto\" align=\"left\" width=\"200\"/>\n";
		$body .= "			$partTwoText</p>\n";
		if($partTwoShit == 1)
			$body .= "		</div>\n\n ";
		return $body;
	}

	function partRight($rightImage, $rightMessages){

		$body .= "		<div class=\"rechterDeel\">\n";
		$body .= "			<div class=\"titelBalk\"><img src=\"$rightImage\" width=\"228\" height=\"22\"></div>\n";
		$body .= "			<div class=\"recentNieuwsKader\">\n\n";

		$body .= "$rightMessages\n";

		$body .= "		</div>\n";
		$body .= "		</div>	\n";
		$body .= "		<!-- EINDE VAN HET RECHTERDEEL -->\n\n";

		$body .= "	</div>\n";
		$body .= "	<!-- AFSLUITEN VAN DE TWEE DELEN -->\n\n";

		$body .= "</div>\n";
		$body .= "</body>\n";
		$body .= "</html>\n";
		
		return $body;
	}
	
}
?>
