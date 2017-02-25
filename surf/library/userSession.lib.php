<?php
#
#   userSession.lib.php: manage user session
#
#   15-02-2013: Huug: creation
#
require_once "table.lib.php";
require_once "users.lib.php";
require_once "user_roles.lib.php";

class userSession
{
    private $users;
    private $user_roles;

    private function doLogin($reqData)
    {
        $fName = __CLASS__ . ":" . __FUNCTION__;
        $ok = true;
        if (!array_key_exists('login', $reqData)) {
            $login = "";
            genSetError("Geen gebruikersnaam ontvangen");
            $ok = false;
        }
        if (!array_key_exists('password', $reqData)) {
            genSetError("Geen wachtwoord ontvangen");
            $ok = false;
        }
        if (!$ok) return false;
        $login = trim($reqData['login']);
        if (!strlen($login)) {
            genSetError("Gebruikersnaam is leeg");
            $ok = false;
        }
        $password = trim($reqData['password']);
        if (!strlen($password)) {
            genSetError("Wachtwoord is leeg");
            $ok = false;
        }

        if (!$ok) return $ok;
        $usrCount = 0;
        $lastUser = false;
        foreach (array("nick", "email") as $login_key) {
            $sth = $this->users->readSelect(array($login_key => $login));
            $rows = $this->users->fetch_assoc_all($sth);
            genLogVar($fName . ": " . "query result rows", count($rows));
            while ($row = array_shift($rows)) {
                genLogVar($fName . ":" . "**** GELEZEN row", implode(',', array_values($row)));
                if (strlen($row["wachtwoord"])) {
                    genLogVar($fName . ":" . "Test wachtwoord", __line__);
                    if (password_verify($password, $row["wachtwoord"])) {
                        genLogVar($fName . ":" . "wachtwoord oke", __line__);
                        $usrCount++;
                    }
                } else {
                    genLogVar($fName . ":" . "opgeslagen wachtwoord leeg", __line__);
                    $usrCount++;
                }
                $lastUser = $row;
            }
        }
        if ($usrCount != 1) {
            genLogVar($fName . ":" . 'For ' . $login . ' found $usrCount', $usrCount);
            genSetError("Inloggen met $login mislukt");
            return false;
        }

        $this->setWelcome($lastUser);
        $_SESSION['logedIn'] = 1;
        $this->resetSessionData($lastUser);
    }

    public function resetSessionData($user)
    {
        if (array_key_exists('user', $_SESSION) &&
            array_key_exists('user', $_SESSION['user']) &&
            ($user["id"] != $_SESSION['user']['user']["id"])) {
            unset($_SESSION['user']);
        }
        $_SESSION["loggedIn"] = 1;
        $_SESSION['user']['user'] = $user;

        $now = new DateTime();
        $_SESSION["user"]["lastActive"] = $now->format("U");
        $_SESSION["user"]["lastAddress"] = $_SERVER["REMOTE_ADDR"];
        $roles = $this->user_roles->getRoles($_SESSION['user']['user']["id"]);
        $_SESSION['user']['user_roles'] = array("public" => "1");
        while ($role = array_shift($roles)) {
            $_SESSION['user']['user_roles'][$role] = "1";
        }
    }

    public function setWelcome($lastUser)
    {
        if (!is_array($lastUser)) $lastUser = array();
        $info = "Je bent nu aangemeld, ";
        $target = "beste gebruiker";
        foreach (array(
                     "roepnaam",
                     "nick",
                     "naam") as $x) {
            if (
                array_key_exists($x, $lastUser) &&
                $lastUser[$x] != "") {
                $target = $lastUser[$x];
                break;
            }
        }
        $info .= $target;
        genSetInfo($info);
    }

    private function logout($quiet)
    {
        $_SESSION["loggedIn"] = 0;
        if (!$quiet)
            genSetInfo("U bent nu afgemeld");
    }    

    private function testSession()
    {
        $mustLogin = genGetMustLogin();
        $now = new DateTime("Europe/Amsterdam");
        $nowTS = $now->format("U");
        $known = isset($_SESSION["loggedIn"]);
        $known = $known && isset($_SESSION["user"]["lastActive"]);
        $known = $known && isset($_SESSION["user"]["lastAddress"]);
        if ($known) {
            if ((($nowTS - $_SESSION["user"]["lastActive"]) > (SESSION_TIMEOUT * 60)) || ($_SESSION["user"]["lastAddress"] <>
                $_SERVER["REMOTE_ADDR"])) {
                if ($this->isLoggedIn()) {
                    if ($mustLogin) {
                        genSetError("Uw sessie is verlopen");
                    }
                    $this->logout(false);
                }
            }
        } else {
            $this->logout(false);
        }
        $_SESSION["user"]["lastActive"] = $nowTS;
        $lastAddress = "1.2.3.4";
        if (array_key_exists("REMOTE_ADDR",$_SERVER)) {
            $lastAddress = $_SERVER["REMOTE_ADDR"];
        }
        $_SESSION["user"]["lastAddress"] = $lastAddress;
    }

    // process a POST or GET login request;
    public function login()
    {
        return $this->doLogin($_REQUEST);
    }

    /** Handle login JSON request */
    public function JSONlogin()
    {
        $fName = __CLASS__.":".__FUNCTION__.":";
        $response = array();
        if (array_key_exists("JSON", $_GET)) {
            $json = $_GET;
            if (array_key_exists("action", $json) && $json["action"] == "JSONlogin") {
                genLogVar($fName . ":" . "Nu hier", __line__);
                $response["status"] = $this->doLogin($json);
                genLogVar($fName . ":" . "response", $response);
            } else {
                genSetError("geen login ontvangen");
                genLogVar($fName . ":" . "missing JSON:", join(",", array_keys($json)));
            }
        } else {
            GenSetError("Ongelukkig formaat opdracht, sorry");
            genLogVar($fName . ":" . "Missing \$_GET: ", join(",", array_keys($_GET)));
        }
        genJSONResponse($response);
    }

    /** Handle logout JSON request */

    public function JSONlogout()
    {
        $response["status"] = false;
        $json = $_GET;
        if (array_key_exists("JSON", $json)) {
            if (array_key_exists("action", $json) && $json["action"] == "JSONlogout") {
                genLogVar(__file__ . ":" . __function__ . ":" . __line__ . ":json", $json);
                $this->logout();
                genSetInfo("Je bent afgemeld...");
                $response["status"] = true;
            } else {
                GenSetError("Ongelukkig formaat opdracht, sorry");
                genLogVar(__file__ . ":" . "json", $json);
            }
            genJSONResponse($response);
        }
    }

    public function hasRole($role)
    {
        return (isset($_SESSION["loggedIn"]) && isset($_SESSION['user']['user_roles']) &&
            isset($_SESSION['user']['user_roles']) && array_key_exists($role, $_SESSION['user']['user_roles']));
    }

    public function getSessionData($name)
    {
        if (array_key_exists("user", $_SESSION) && array_key_exists("data", $_SESSION['user']) &&
            array_key_exists($name, $_SESSION['user']["data"])) {
            return $_SESSION['user']["data"][$name];
        }
        return false;
    }

    public function setSessionData($name, $data)
    {
        $_SESSION['user']["data"][$name] = $data;
    }

    public function isLoggedIn()
    {
        $result = false;
        if (array_key_exists("loggedIn", $_SESSION)) {
            if ($_SESSION["loggedIn"]) {
                genSetPageCache("NOROBOT", "OK");
                $result = true;
            }
        }
        return $result;
    }

    public function isCurrentUser($id)
    {
        if (array_key_exists("user", $_SESSION) && array_key_exists("id", $_SESSION['user'])) {
            return ($id == $this->getUserId());
        }
        return false;
    }

    /**
     * @param $attr requested attribute 
     * @return mixed false on error
     */
    public function getUserAttr($attr)
    {
        if (array_key_exists("user", $_SESSION) && array_key_exists($attr, $_SESSION['user']['user'])) {
            return $_SESSION['user']['user'][$attr];
        }
        return false;
    }

    public function getUserId()
    {
        return $this->getUserAttr("id");
    }
    
    public function redirectIfNotLogged()
    {
        if ($this->isLoggedIn()) return;
        header("Location: ", $_SERVER["HTTP_HOST"].":".$_SERVER["HTTP_PORT"]);
    }

    public function __construct()
    {
        $this->users = new users();
        $this->user_roles = new user_roles();
        if (array_key_exists("action", $_REQUEST)) {
            switch ($_REQUEST["action"]) {
                case "login":
                    break;
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
