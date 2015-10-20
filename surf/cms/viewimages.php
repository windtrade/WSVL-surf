<?php
/* start output buffering */
ob_start();

/* start the session */
session_start();

/* includes */
include "library/config.inc.php";
//include "library/layout.lib.php";
include "library/db.lib.php";

/* start db */
$db = new dataBase();
$db->initialise($mysql_user, $mysql_password, $mysql_host, $mysql_dbName);

/* start lay_out */


?>

		

<HTML><HEAD>
<SCRIPT LANGUAGE="JavaScript"><!--
function updateParent(varia) {
	var al 

	var file2 = "<img src='images/event/photo/"+varia+"-thumb.jpg' align='left' class='galleryThumb'>";
	
	opener.document.changeText.eventText.value += file2;

	self.close();
	return false;
}
//--></SCRIPT>
</HEAD>




<?php
if($_GET[event_id]){


	$queryFoto = "SELECT * FROM foto WHERE event_id = '$_GET[event_id]' ORDER BY foto_id ASC";
	$sqlFoto = mysql_query($queryFoto) or die("Error");
	if(mysql_num_rows($sqlFoto)){
		/* Er zijn foto's */
		$i = 0;
		$partTwoText .= "<table><tr>\n";
		while($objFoto = mysql_fetch_object($sqlFoto))
		{

			$image = "$objFoto->foto_id-thumb.jpg";

			$partTwoText .= "</tr><tr>";
			if ( 0 == ($i %2))
				$partTwoText .= "<br />";
			$partTwoText .= "<a href=\"\" onClick=\"updateParent('$objFoto->foto_id');\"><img src=\"../images/event/photo/$image\" class=\"galleryThumb\" height=\"98\" border=\"0\" /></a>";


			$i++;
		}


	}
	else
		$partTwoText = "Er zijn geen foto's bij dit evenement gevonden";
}
$partTwoText .= "</tr></table>";





echo $partTwoText;


/* send page to client */

ob_end_flush();
?>
