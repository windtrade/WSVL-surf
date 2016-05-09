<?php
/*
 * testconfig.php
 *
 * Test the configuration module for proper functionality
 *
 * 07-10-2011 Huug Creation
 */
#error_reporting(E_ALL);
require_once "library/all_config.inc.php";
require_once "general.lib.php";
require_once "cheats.lib.php";
require_once "Smarty.class.php";
require_once "database.lib.php";
require_once "users.lib.php";
#require_once "user_roles.lib.php";
require_once "dataimport.lib.php";

function showTHE_WORLD()
{
	global $THE_WORLD;
	traceThis("In showTHE_WORLD");
	traceThis(showAssocArray($THE_WORLD));
}

function testDatabase()
{
	genSetError("Testing the DB connection");
	if (genDBConnected()) {
		genSetError("The database is connected");
	} else {
		genSetError("The database is not connected");
	}
	$users = new users();
	$newUser = array(
		"rel_nr" => "1",
		"bond_nr" => "123456",
		//"modified_at" => "qqq",
		"modified_by" => "0",
		"roepnaam" => "roepnaam",
		"naam" => "naam",
		"voorvoegsel" => "voorv",
		"straat" => "straat",
		"huisnr" => "21",
		"postcode" => "2324 BR",
		"plaats" => "leiden",
		"telefoonnr" => "0715761262",
		"geb_datum" => "14-07-1957",
		"lidsoort" => "qqq",
		"email" => "peters@windtrade.nl",
		"wachtwoord" => "wachtwoord"
	);
	$users->delete(array("roepnaam" => "woepnaam"));
	$newUser["straat"] = "nieuwstraat";
	$users->insert($newUser);
	genSetError("Ready for update");
	$users->update(
		array("straat" => "pieuwstraat"),
		array("roepnaam" => "groepnaam",
		"naam" => "kerstman"));
	genSetError("Closing the DB connection");
	genDBClose();
	genSetError("done, see what happened");
	if (genDBConnected()) {
		genSetError("The database is connected");
	} else {
		genSetError("The database is not connected");
	}
	genSmartyDisplay("wvLeidschendam.tpl");
}
function testDataImport()
{
	$imp = new importUsers("/files/110929Surfleden.csv");
	$impColumns = $imp->getImportColumns();
	$users = $imp->getUsers();
	$tbColumns = $imp->getTableColumns();
	$smarty = new Smarty();
	
	$minCols = $maxCols = count($impColumns);
	$i = 0;
	foreach ($users as $user) {
		if (count($user) < $minCols) {
			traceThis("Probleem in $i");
			$minCols = count($user);
		} else if (count($user) > $maxCols) {
			traceThis("Probleem in $i");
			$maxCols = count($users);
		}
		$i++;
	}
	if ($minCols == $maxCols) {
		$smarty->assign('action',$_SERVER['PHP_SELF']);
		$smarty->assign('step','1');
		$smarty->assign('impColumns', $impColumns);
		$smarty->assign('uniqueKey', 
			(isset($uniqueKey)? $uniqueKey : ""));
		$smarty->assign('primaryMatchColumn', 
			(isset($primaryMatchColumn)? $primaryMatchColumn : ""));
		$smarty->assign('alternateMatchColumn', 
			(isset($alternateMatchColumn)? $alternateMatchColumn : ""));
		$smarty->assign('tbColumns', $tbColumns);
		$smarty->assign('users', $users);
	} else {
		$imp->genError("import bestand heeft ".
			"verschillende rijlengtes($minCols-$maxCols)");
	}
	$smarty->display('templates/wsvl_users.tpl');
}

function testGenGetArrayFromArray()
{
	$msg = "<form method=\"POST\" action=\"http://".$_SERVER['SERVER_NAME'].
			$_SERVER['PHP_SELF']."\">";
	for ($i=0 ; $i<10 ; $i++) {
		for ($j=0; $j < 3 ; $j++) {
			$name = "wsvl_".$i."_".$j;
			$val = 10*$i + $j;
			$msg .= "<input type=\"hidden\" name=\"".$name."\" value=\"". $val . "\">";
		}
	}
	$msg .= "<input type=\"submit\" name=\"submit\" value=\"Go cat, go!\">";
	$msg .= "</form>";
	genSetError('$_POST='. print_r($_POST, true));
	genSetError('WSVL='.print_r(genGetArrayFromArray($_POST, "wsvl"),true));
	genSetError($msg);
	genSmartyDisplay('templates/wvLeidschendam.tpl');
}

function testMakeWhereClause()
{
	$users = new users();
	$whereArr = array ( "rel_nr" => "10" );
	$result = $users->readSelect($whereArr);
	genSetError('$result='.print_r($result, true));
	genSmartyDisplay('templates/wvLeidschendam.tpl');
}

function testAddJavascriptFile()
{
	genAddJavascriptFile("piet");
	genAddJavascriptFile("formhandling.js");
	genAddJavascriptFile("formhandling.JS");
	genAddJavascriptFile("formhandling");
	genSmartyDisplay('wvLeidschendam.tpl');
}

function testUserRoles()
{
	$userRoles = new user_roles();
	$userId = 53;
	$role = "SYSTEM";
	genSetError("aan het begin");
	genSetError("User ".$userId." heeft ".
		($userRoles->hasRole($userId, $role)? "" : "niet ").
		"de rol ".$role);
	if ($userRoles->hasRole($userId, $role)) {
		$userRoles->delete(array(
			"user_id" => $userId,
			"role" => $role));
	} else {
		$userRoles->insert(array(
			"user_id" => $userId,
			"role" => $role));
	}
	genSetError("aan het eind");
	genSetError("User ".$userId." heeft ".
		($userRoles->hasRole($userId, $role)? "" : "niet ").
		"de rol ".$role);
	genSmartyDisplay('wvLeidschendam.tpl');
}

function testMenu()
{
	genSmartyAssign("naam", "piet");
	genSmartyAssign("piet","=gek");
	$url = "http://surfdev.wvleidschendam.nl/file.php?piet=gek";
	genSetError($url." wordt ".GenSessionUrl($url));
	$url = "http://surf.wvleidschendam.nl/file.php?piet=gek";
	genSetError($url." wordt ".GenSessionUrl($url));
	genSmartyDisplay("wvLeidschendam.tpl");
	//genSmartyDisplay("wvLeidschendam menutest.tpl");
}
/**
// testDataImport();
// testDatabase();
// testGenGetArrayFromArray();
//testMakeWhereClause();
//testAddJavascriptFile();
// testUserRoles();
//testMenu();
*/
?>
<html>
<head>
</head>
<body>
<?php
print("_GET=".print_r($_GET, true));
?>
<form action="<?php $_SERVER["PHP_SELF"]?>" method="get">
veld 1:<input type="text" name="veld1"/>
veld 2:<input type="text" name="veld2" />
<input type="submit" value="ga"/>
</form>
</body>
</html>
