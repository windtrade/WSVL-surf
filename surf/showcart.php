<?php
/* start output buffering */
ob_start();

/* start the session */
session_start();

/* includes */
include "library/config.inc.php";
include "library/layout.lib.php";
include "library/db.lib.php";
include "library/shop.php";

/* start db */
$db = new dataBase();
$db->initialise($mysql_user, $mysql_password, $mysql_host, $mysql_dbName);

/* start lay_out */
$lay_out = new LayOut();
$product = new shop();

	



if($_GET[remove_id] !=null){
				//Remove is ok
				
				$_SESSION[shoppingcart] = $product->remove($_SESSION[shoppingcart], $_GET[remove_id]);
			}
			if($_GET[increase_id] !=null){
				// increase by one
				
				$_SESSION[shoppingcart] = $product->increase($_SESSION[shoppingcart], $_GET[increase_id]);
			}
			if($_GET[decrease_id] != null){
				
				$_SESSION[shoppingcart] = $product->decrease($_SESSION[shoppingcart], $_GET[decrease_id]);
			}
			
			

?>


		
<?php 

		$body = "		<div class=\"rechterDeel\">\n";
		
		$body .= "		</div>	\n";
		$body .= "		<!-- EINDE VAN HET RECHTERDEEL -->\n\n";

		$body .= "	</div>\n";
		$body .= "	<!-- AFSLUITEN VAN DE TWEE DELEN -->\n\n";
//Show products in cart
			$temp_cart = $_SESSION[shoppingcart];
			$arrayLength = count($temp_cart);
			$total = 0;
			
			
			$lay_out->partTwoText .=  "<table class=\"td2\">\n\t<tr>\n\t\t<td class=\"td2\">\n\t\t\tProduct\n\t\t</td>\n\t\t<td class=\"td2\">\n\t\t\tAantal\n\t\t</td>\n\t\t<td class=\"td2\">\n\t\t\tPrijs per stuk\n\t\t</td>\n\t\t<td class=\"td2\">\n\t\t\tTotaal\n\t\t</td>\n\t\n\t\t<td class=\"td2\">\n\t\t\tVerwijderen\n\t\t</td>\n\t\t<td class=\"td2\">\n\t\t\tVerminderen\n\t\t</td>\n\t\t<td class=\"td2\">\n\t\t\tVermeerderen\n\t\t</td></tr>";
			for ($i = 0; $i < $arrayLength; $i= $i +2){
   				//echo "arrayName at[" . $i . "] is: [" .$temp_cart[$i] . "]<br>\n";
				if ($temp_cart[$i]!=0){
					$test = new shop();
					$oldi = $i +1;
//					$tempProduct = $test->getProduct($temp_cart[$i]);
					$price = 0.50;
					$aantal = $temp_cart[$oldi];
					$sub = $price * $aantal;
					$price2 = number_format($price, 2, ",", ".");
					$sub2 = number_format($sub, 2, ",", ".");
					if ($aantal >=2){
						$lay_out->partTwoText .=  "\n\t<tr>\n\t\t<td class=\"td3\">\n\t\t\t  <img src=\"/images/event/photo/$temp_cart[$i]-thumb.jpg\" /> \n\t\t</td>\n\t\t<td class=\"td3\">\n\t\t\t $aantal\n\t\t</td>\n\t\t<td class=\"td3\">\n\t\t\t$price2\n\t\t</td>\n\t\t<td class=\"td3\">\n\t\t\t $sub2\n\t\t</td>\n\t\n\t\t<td class=\"td3\">\n\t\t\t<a class=\"link1\" href=\"showcart.php?remove_id= $i\">X</a\n\t\t</td>\n\t\t<td class=\"td3\">\n\t\t\t<a class=\"link1\" href=\"showcart.php?decrease_id= $i\">--</a>\n\t\t</td>\n\t\t<td class=\"td3\">\n\t\t\t<a class=\"link1\" href=\"showcart.php?increase_id= $i\">++</a>\n\t\t</td></tr>";
					}
					if ($aantal ==1)
					{
						$lay_out->partTwoText .=  "\n\t<tr>\n\t\t<td class=\"td3\">\n\t\t\t  <img src=\"/images/event/photo/$temp_cart[$i]-thumb.jpg\" /> \n\t\t</td>\n\t\t<td class=\"td3\">\n\t\t\t $aantal\n\t\t</td>\n\t\t<td class=\"td3\">\n\t\t\t$price2\n\t\t</td>\n\t\t<td class=\"td3\">\n\t\t\t $sub2\n\t\t</td>\n\t\n\t\t<td class=\"td3\">\n\t\t\t<a class=\"link1\" href=\"showcart.php?remove_id= $i\">X</a\n\t\t</td>\n\t\t<td class=\"td3\">\n\t\t\t&nbsp;\n\t\t</td>\n\t\t<td class=\"td3\">\n\t\t\t<a class=\"link1\" href=\"showcart.php?increase_id= $i\">++</a>\n\t\t</td></tr>";
					}
					$total = $total + $sub;

				}
			}
			if ($total ==0){
				$lay_out->partTwoText .=  "\t<tr>\n\t\t<td class=\"td3\">\n\t\t\t<span class=\"bold\">Uw winkelwagen is leeg</span.\n\t\t</td>\n\t\t<td class=\"td3\">\n\t\t\t\n\t\t</td>\n\t\t<td class=\"td3\">\n\t\t\t\n\t\t</td>\n\t\t<td class=\"td3\">\n\t\t\t\n\t\t</td>\n\t\n\t\t<td class=\"td3\">\n\t\t\t\n\t\t</td>\n\t\t<td class=\"td3\">\n\t\t\t\n\t\t</td>\n\t\t<td class=\"td3\">\n\t\t\t\n\t\t</td></tr>";
			}
			else {
			$total2 = number_format($total, 2, ",", ".");
			$lay_out->partTwoText .=  "\t<tr>\n\t\t<td class=\"td3\">\n\t\t\t\n\t\t</td>\n\t\t<td class=\"td3\">\n\t\t\t\n\t\t</td>\n\t\t<td class=\"td3\">\n\t\t\tTotaal zonder<br />verzendkosten\n\t\t</td>\n\t\t<td class=\"td3\">\n\t\t\t<span class=\"bold\"> $total2</span> Euro\n\t\t</td>\n\t\n\t\t<td class=\"td3\">\n\t\t\t\n\t\t</td>\n\t\t<td class=\"td3\">\n\t\t\t\n\t\t</td>\n\t\t<td class=\"td3\">\n\t\t\t\n\t\t</td></tr>";
			}//echo $total;
			$lay_out->partTwoText .=  "</table>\n";
			if ($total !=0){
			$lay_out->partTwoText .=  "<a href=\"counter.php\"><img src=\"images/shop/kassa.gif\" border=\"0\" alt=\"Kassa\" /></a>";
			}


		
//$queryFoto = "SELECT * FROM foto WHERE foto_id = '$_GET[photo_id]' ORDER BY foto_id DESC LIMIT 1";
//$sqlFoto = mysql_query($queryFoto) or die("Error");
$i = 0;
$lay_out->titelImage = "images/kop_fotogalerij.gif";



/*
while($objFoto = mysql_fetch_object($sqlFoto))
{
$query = "select * from event where event_id = '$objFoto->event_id'";
$sql = mysql_query($query) or die("error");
while($obj=mysql_fetch_object($sql)){
	$lay_out->topEventId = $obj->event_id;
	$lay_out->partTwoText = "<div style=\"padding: 2%;\"><b>$obj->event_title</b> <br />";
	$lay_out->partTwoText .= date("d-m-Y", strtotime($obj->event_timestamp))." <br />";
	$lay_out->partTwoText .= nl2br($obj->event_text)."</div>";
	$lay_out->partTwoShit = 0;
	}
	
			$image = "$objFoto->foto_id.jpg";		

		$queryFoto1 = "SELECT * FROM foto WHERE foto_id > '$_GET[photo_id]' AND event_id = '$objFoto->event_id' ORDER BY foto_id ASC LIMIT 1";
		$sqlFoto1 = mysql_query($queryFoto1) or die("Error");
		if($objFoto1 = mysql_fetch_object($sqlFoto1))
			$next = " || <a href=\"viewphoto.php?photo_id=$objFoto1->foto_id\">Volgende Foto</a> &raquo; ";

		$queryFoto1 = "SELECT * FROM foto WHERE foto_id < '$_GET[photo_id]' AND event_id = '$objFoto->event_id' ORDER BY foto_id DESC LIMIT 1";
		$sqlFoto1 = mysql_query($queryFoto1) or die("Error");
		if($objFoto1 = mysql_fetch_object($sqlFoto1))
			$prev = "&laquo; <a href=\"viewphoto.php?photo_id=$objFoto1->foto_id\">Vorige Foto</a> || ";

		$over = "<a href=\"viewevent.php?event_id=$objFoto->event_id\">Overzicht</a>";
		
			$lay_out->partTwoText .= "          <center>$prev   $over  $next<br /> ";
		
			$lay_out->partTwoText .= "<img src=\"images/event/photo/$image\" border=\"1\" /><br /><a href=\"?photo_id=$_GET[photo_id]&cart=true&tab=$_GET[tab]\">Bestel deze foto</a><br />";
			$lay_out->partTwoText .= "          $prev $over   $next</center><p>&nbsp;</p> ";
		

$i++;

		


}
         
$lay_out->partTwoText .= "</tr></table> ";
*/

/* parse lay_out */			
echo $lay_out->build();





/* send page to client */

ob_end_flush();
?>
