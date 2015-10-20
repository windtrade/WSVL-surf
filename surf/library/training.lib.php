<?php
/*
	Supporting functies voor de trainings pagina's
	feb 2011 Huug Peters
	01-04-2011 : huug : fixed volgendeTraining
	13-08-2011 : huug : functie aanmelden toegevoegd
*/
	function eersteTraining()
	{
		$today = localtime(time(), true);
		$startYear = 1900 + ($today[tm_mon] < 9 ? $today[tm_year] : $today[tm_year]+1);
		$firstTraining = mktime(0, 0, 0, 3, 31, $startYear); // march 31st this year or next
		$firstTraining += (2-date('w', $firstTraining))*24*3600; // tuesday following last sunday in March
		return $firstTraining;
	}

	function eersteDonderdagTraining()
	{
		$today = localtime(time(), true);
		$startYear = 1900 + ($today[tm_mon] < 9 ? $today[tm_year] : $today[tm_year]+1);
		$firstTraining = mktime(0, 0, 0, 3, 31, $startYear); // march 31st this year or next
		$firstTraining += (4-date('w', $firstTraining))*24*3600; // tuesday following last sunday in March
		return $firstTraining;
	}

	function eindeTraining()
	{
		return mktime(0, 0, 0, 9, 30, date('Y', eersteTraining()));
	}
	function volgendeTraining()
	{
		$firstTraining = eersteTraining();
		$today=localtime(time(),true);
		$thisDay=date('j');
		$thisMonth = date('m');
		$thisYear=date('Y');
		$nextTraining = mktime(0, 0, 0, $thisMonth, $thisDay, $thisYear);
		if ($firstTraining >= $nextTraining) return $firstTraining;
		// nextTraining is now today, but must be set to next Tuesday
		$wkDay = date('w', $nextTraining);
		if ($wkDay <=2) {
			$nextTraining += (2-$wkDay)*24*3600; // this weeks tuesday
		} else {
			$nextTraining += (9-$wkDay)*24*3600; // next weeks tuesday
		}
		return $nextTraining;
	}
	function volgendeDonderdagTraining()
	{
		$firstTraining = eersteDonderdagTraining();
		$today=localtime(time(),true);
		$thisDay=date('j');
		$thisMonth = date('m');
		$thisYear=date('Y');
		$nextTraining = mktime(0, 0, 0, $thisMonth, $thisDay, $thisYear);
		if ($firstTraining >= $nextTraining) return $firstTraining;
		// nextTraining is now today, but must be set to next Thursday
		$wkDay = date('w', $nextTraining);
		if ($wkDay <=4) {
			$nextTraining += (4-$wkDay)*24*3600; // this weeks tuesday
		} else {
			$nextTraining += (11-$wkDay)*24*3600; // next weeks tuesday
		}
		return $nextTraining;
	}
			
	function maakDatumSelectOpties()
	{
		$listDate = volgendeTraining();
		$lastDate = eindeTraining();
		for ($selected=FALSE ; $listDate < $lastDate ; $listDate+=7*24*3600) {
			printf('<option value="%s">%s</option>\n',
				date('Y-m-d', $listDate),
				date('d-m-Y', $listDate));
		}
	}

	function maakDonderdagDatumSelectOpties()
	{
		$listDate = volgendeDonderdagTraining();
		$lastDate = eindeTraining();
		for ($selected=FALSE ; $listDate < $lastDate ; $listDate+=7*24*3600) {
			printf('<option value="%s">%s</option>\n',
				date('Y-m-d', $listDate),
				date('d-m-Y', $listDate));
		}
	}
	function trainingAanmelden(
		$naam,
		$email,
		$opmerking) {
		$sql = " INSERT INTO trainingsmaatjes 
			(trainingsmaatje_id, spot_id, datum, naam, emailadres, opmerking, token, aangemeld) VALUES 
			('','87','$value','$naam','$email','$opmerking','$token','1') ";

		mysql_query($sql);
	}

	function sendTrainingsMail(
		$naam,
		$email,
		$opmerking) {
			$token = md5(uniqid(rand(), true));
			$onderwerp = "Bevestiging aanmelding gevorderdentrainingen";

			$bericht = "Hoi ".stripslashes($naam).",

				Leuk dat je op de dinsdagavonden naar de Gevorderdentraining toe komt. We beginnen om 19.00u met de training. 
				Kom op tijd, je surfpak aantrekken en je zeil optuigen duurt altijd langer dan je denkt.

				Mocht je onverhoopt toch een keer niet kunnen komen, meld je dan even af via onderstaande link
				http://surf.wvleidschendam.nl/training_afmelden.php



				Groeten en tot dinsdagavond,
				De trainers van WV Leidschendam		
				";

			mail(stripslashes($email),$onderwerp,$bericht,"From: training@wvleidschendam.nl\n");
		}
	function checkEmail($email)
	{
		if(eregi("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$]", $email)) { 
			traceThis("checkEmail invalid syntax");
			return FALSE; }
		list($Username, $Domain) = split("@",$email);
		if (!getmxrr($Domain, $MXHost)) { 
			traceThis("checkEmail  getmxr failed");
			return FALSE;
		}
		/* if(fsockopen($Domain, 25, $errno, $errstr, 30)) { return TRUE; }
		else{
			traceThis("checkEmail fsockopen failed");
			return FALSE;
		} */
		return TRUE;
	}

	function aanmeldenTraining($trainingsNaam, $trainingsEmail, $trainingsOpmerking, $trainingsDatum)
	{
		$datum = date("Y-m-d 00:00:00", strtotime($trainingsDatum));
		$naam = addslashes($trainingsNaam);
		$email = addslashes($trainingsEmail);
		$opmerking = addslashes($trainingsOpmerking);
		$token = md5(uniqid(rand(), true));

		// Controleren of er niet toevallig is aangemeld -> afgemeld en weer opnieuw aangemeld
		$sql_check = " SELECT * FROM trainingsmaatjes WHERE emailadres = '$email' AND datum = '$datum' ";
		$result_aanmeldingen = mysql_query($sql_check);
		$aanmeldingen = mysql_fetch_array($result_aanmeldingen);

		if (is_array($aanmeldingen)) {
			if ($aanmeldingen['token'] != '') {
				$token = $aanmeldingen['token'];
			}

			// update het bestaande record
			$sql = "UPDATE trainingsmaatjes SET ".
				"aangemeld = 1, opmerking = '$opmerking' ".
				"WHERE emailadres = '$email' AND token = '".$aanmeldingen[token].
				"' AND datum = '$datum' "; 
		} else {
			// nieuw record invoegen
			$sql = " INSERT INTO trainingsmaatjes 
				(trainingsmaatje_id, spot_id, datum, naam, emailadres, opmerking, token, aangemeld) VALUES 
				('','87','$datum','$naam','$email','$opmerking','$token','1') ";
		}
		traceThis("aanmeldenTraining query: $sql");
		mysql_query($sql);
	}
	
	/* start db */
	$db = new dataBase();
	$db->initialise($mysql_user, $mysql_password, $mysql_host, $mysql_dbName);
?>
