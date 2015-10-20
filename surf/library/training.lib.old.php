<?php
/*
	Supporting functies voor de trainings pagina's
	feb 2011 Huug Peters
	01-04-2011 : huug : fixed volgendeTraining
*/
	function eersteTraining()
	{
		$today = localtime(time(), true);
		$startYear = 1900 + ($today[tm_mon] < 9 ? $today[tm_year] : $today[tm_year]+1);
		$firstTraining = mktime(0, 0, 0, 3, 31, $startYear); // march 31st this year or next
		$firstTraining += (2-date('w', $firstTraining))*24*3600; // tuesday following last sunday in March
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
	/* start db */
	$db = new dataBase();
	$db->initialise($mysql_user, $mysql_password, $mysql_host, $mysql_dbName);
?>
