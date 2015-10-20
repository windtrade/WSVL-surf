<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Leden analyse</title>
</head>

<body>
<?php

	$sql_woonplaatsen = " 
		SELECT 
			plaats, 
			COUNT( relatie_nr ) AS hoeveel, 
			( ( 100 * COUNT( relatie_nr ) ) / 67 ) AS perc
		FROM users_ledenadm_import
		GROUP BY plaats
		ORDER BY hoeveel DESC ";



	$sql_leeftijden = " 
		SELECT 
			( YEAR( CURDATE( ) ) - YEAR( geb_datum ) ) - ( RIGHT( CURDATE( ) , 5 ) < RIGHT( geb_datum, 5 ) ) AS leeftijd, 
			COUNT( relatie_nr ) AS hoeveel
		FROM users_ledenadm_import
		GROUP BY 
			( YEAR( CURDATE( ) ) - YEAR( geb_datum ) ) - ( RIGHT( CURDATE( ) , 5 ) < RIGHT( geb_datum, 5 ) )
		HAVING leeftijd > 0
		ORDER BY leeftijd ASC ";

?>
</body>
</html>
