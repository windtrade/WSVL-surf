<?php
	include "../library/config.inc.php";
	include "../library/layout.lib.php";
	include "../library/db.lib.php";
	
	/* start db */
	$db = new dataBase();
	$db->initialise($mysql_user, $mysql_password, $mysql_host, $mysql_dbName);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ontvangers groepen overzicht</title>
</head>

<body>
<?php
	$result_groepen = mysql_query(" SELECT * FROM nieuwsbrief_ontvangers_groepen ORDER BY groepnaam ASC ");
	$aantal_groepen = mysql_num_rows($result_groepen);

	if($aantal_groepen > 0)
	{
		while($groep_data = mysql_fetch_array($result_ontvangers))
		{
			// groep naam = hyperlink naar ontvangers in deze groep
		}
	}

?>
<form name="newGroep" id="newGroep" method="post" action="add_ontvangersgroep.php" enctype="multipart/form-data"><strong>Nieuwe ontvangers groep aanmaken</strong>
  <table width="75%" border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td width="22%">Groepnaam : </td>
      <td width="78%">&nbsp;
      <input name="groepnaam" type="text" id="groepnaam" size="32" /></td>
    </tr>
    <tr>
      <td>Aktief : </td>
      <td>&nbsp;
      <input name="aktief" type="checkbox" id="aktief" value="1" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;
      <input type="submit" name="Submit" value="  OPSLAAN  " /></td>
    </tr>
  </table>
</form>
</body>
</html>
