<?php
#
#   userSession.lib.php: manage user session
#   
#   15-02-2013: Huug: creation
#
require_once "users.lib.php";
require_once "user_roles.lib.php";

class userSession
{
    private $users;
    private $user_roles;

    public function login()
    {
	$ok = true;
	if (!array_key_exists('login', $_REQUEST)) {
	    genSetError("Geen gebruikersnaam ontvangen");
	    $ok = false;
	} else {
	    $login = trim($_REQUEST['login']);
	    if (!strlen($login)) {
		genSetError("Gebruikersnaam is leeg");
		$ok = false;
	    }
	}
	if (!array_key_exists('password', $_REQUEST)) {
	    genSetError("Geen wachtwoord ontvangen");
	    $ok = false;
	} else {
	    $password = trim($_REQUEST['password']);
	    if (!strlen($password)) {
		genSetError("Wachtwoord is leeg");
		$ok = false;
	    }
	}
	if (!$ok) return;
	$login_key="nick";
	if (strstr($login, "@")) $login_key="email";
	$query = array(
	    $login_key => $login,
	);
	$usrCount = 0;
	$result = $this->users->readSelect($query);
	while ($result && ($row=$this->users->fetch_assoc($result))) {
	    if (strlen($row["wachtwoord"]) &&
		password_verify($password, $row["wachtwoord"]))
	    {
		$usrCount++;
	    }
	    if (!strlen($row["wachtwoord"])) $usrCount++;
	    $lastUser = $row;
	}
	if (!$result || $usrCount != 1) {
	    genSetError("Inloggen met $login mislukt");
	    return;
	}
	$_SESSION["loggedIn"] = 1;
	$_SESSION["user"] = $lastUser;
	$now = new DateTime();
	$_SESSION["user"]["lastActive"] = $now->format("U");
	$_SESSION["user"]["lastAddress"] = $_SERVER["REMOTE_ADDR"];
	$result = $this->user_roles->readSelect(
	    array("user_id" => $_SESSION["user"]["id"]));
	$_SESSION["user"]["user_roles"]=array("public" => "1");
	while ($result && $user_role=mysql_fetch_assoc($result)) {
	    $_SESSION["user"]["user_roles"][$user_role["role"]]="1";
	}
    }

    private function logout()
    {
	unset($_SESSION["user"]);
	$_SESSION["loggedIn"] = 0;
    }

    private function testSession()
    {
	$now = new DateTime("Europe/Amsterdam");
	$nowTS = $now->format("U");
	if (!isset($_SESSION["loggedIn"]) ||
	    !isset($_SESSION["user"]["lastActive"]) ||
	    !isset($_SESSION["user"]["lastAddress"]) ||
	    ($nowTS-$_SESSION["user"]["lastActive"]) > (SESSION_TIMEOUT*60) ||
	    $_SESSION["user"]["lastAddress"]  <> $_SERVER["REMOTE_ADDR"]) {
		$this->logout();
	    }
	$_SESSION["user"]["lastActive"] = $nowTS;
	$_SESSION["user"]["lastAddress"] = $_SERVER["REMOTE_ADDR"];
    }

    public function hasRole($role)
    {
	return (isset($_SESSION["loggedIn"]) &&
	    isset($_SESSION["user"]["user_roles"]) &&
	    isset($_SESSION["user"]["user_roles"]) &&
	    array_key_exists($role, $_SESSION["user"]["user_roles"]));
    }

    public function getSessionData($name)
    {
	if (array_key_exists("user", $_SESSION) &&
	    array_key_exists("data", $_SESSION["user"]) &&
	    array_key_exists($name, $_SESSION["user"]["data"]))
	{
	    return $_SESSION["user"]["data"][$name];
	}
	return false;
    }

    public function setSessionData($name, $data)
    {
	$_SESSION["user"]["data"][$name] = $data;
    }

    public function isLoggedIn()
    {
	if (array_key_exists("loggedIn", $_SESSION))
	{
	    if ($_SESSION["loggedIn"]) {
		genSetPageCache("NOROBOT", "OK");
		return true;
	    }
	}
	return false;
    }

    public function isCurrentUser($id)
    {
	if (array_key_exists("user", $_SESSION) &&
	    array_key_exists("id", $_SESSION["user"])) {
		return ($id == $this->getUserId());
	    }
	return false;
    }

    public function getUserAttr($attr)
    {
	if (array_key_exists("user", $_SESSION) &&
	    array_key_exists($attr, $_SESSION["user"]))
	{
	    return $_SESSION["user"][$attr];
	}
	return false;
    }

    public function getUserId()
    {
	return $this->getUserAttr("id");
    }

    public function __construct()
    {
	$this->users = new users();
	$this->user_roles = new user_roles();
	if (array_key_exists("action", $_REQUEST)) {
	    switch ($_REQUEST["action"]) {
	    case "login":
		$this->login();
		$_REQUEST["action"] = "";
		break;
	    case "logout":
		$_REQUEST["action"] = "";
		$this->logout();
		break;
	    }

	}
	$this->testSession();
    }
}
?>
