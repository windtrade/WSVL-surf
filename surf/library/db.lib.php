<?php
/* **********************************************************************
   **	dataBase library of Content Management System				   **
   **********************************************************************
   ** Created 27-7-04 Erwin Marges									   **
   ********************************************************************** */

class dataBase{
	function initialise($mysql_user, $mysql_password, $mysql_host, $mysql_dbName){
		mysql_connect($mysql_host, $mysql_user, $mysql_password);
		mysql_select_db($mysql_dbName);
	}
	// or die(mysql_errno($link) . ": " . mysql_error($link). "<br />\n");
}
?>
