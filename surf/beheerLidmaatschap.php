<?php
/*
* beheerLidmaatschap.php
*
* Allows the user to update his (or others) membership data
* 20-12-2012 Huug (Re)Creation
*/
error_reporting(-1);
session_start();
require_once "library/all_config.inc.php";
require_once "general.lib.php";
require_once "database.lib.php";
require_once "teksten.lib.php";
require_once "users.lib.php";
require_once "user_roles.lib.php";
require_once "userSession.lib.php";

class beheerLidmaatschap
{
    private $userSession;
    private $teksten;
    private $users;
    private $userRoles;

    function saveOriginalData($data)
    {
        $_SESSION[__file__] = $data;
    }

    function getOriginalUserData()
    {
        if (array_key_exists(__file__, $_SESSION) && array_key_exists("user", $_SESSION[__file__]) &&
            is_array($_SESSION[__file__]["user"]))
            return $_SESSION[__file__]["user"];
        // Where did the data go...
        return array();
    }

    function testIncomingUserData($inc, $key)
    {
        $orig = userSession::getSessionData('found');
        if (array_key_exists('id', $orig[0]['user']) && array_key_exists($key, $inc) &&
            $inc[$key] == $orig[0]['user']['id']) {
            return true;
        }
        // This so wrong...
        return false;
    }

    function findUsersAndRoles($search)
    {
        if (!count($search)) {
            $search["id"] = $_SESSION["user"]["id"];
        }
        $result = $this->users->readSelect($search);
        if (!$result)
            return false;
        if (0 == mysql_num_rows($result)) {
            $msg = "Geen gegevens gevonden: ";
            foreach ($search as $key => $val) {
                $msg .= " $key=$val";
            }
            genSetError($message);
            return false;
        }
        $retVal = array();
        while ($user = mysql_fetch_assoc($result)) {
            $roles = $this->userRoles->getRoles($user["id"]);
            if (!$roles)
                $roles = array();
            array_push($retVal, array("user" => $user, "roles" => $roles));
        }
        if ($this->userSession->hasRole(ROLE_SYSTEM)) {
            $result = $this->users->readQuery();
            while ($user = mysql_fetch_assoc($result)) {
                $roles = array();
                if (!$roles)
                    $roles = array();
                array_push($retVal, array("user" => $user, "roles" => $roles));
            }
        }
        return $retVal;
    }

    function presentUsersAndRoles($found)
    {
        global $fields;
        genSmartyAssign("user", array());
        if (!is_array($found) || count($found) == 0) {
            genSetError("Geen Lidmaatschapsgegevens gevonden");
            return;
        }
        $current = array_shift($found);
        $this->saveOriginalData($current);
        $result = array();
        foreach (array_keys($current["user"]) as $key) {
            if ($key == "wachtwoord")
                continue;
            array_push($result, $this->users->columnToForm($current["user"], $key, $this->
                userSession));
        }
        genSmartyAssign("user", $result);
        $result = array();

        foreach ($fields["userRoles"] as $role) {
            $disabled = "disabled";
            if ($this->userSession->hasRole(ROLE_SYSTEM)) {
                $disabled = "";
            }
            array_push($result, array(
                "label" => $role["text"],
                "type" => $role["type"],
                "name" => "fd" . "[" . "role" . "][" . $role["value"] . "]",
                "value" => $role["value"],
                "checked" => (array_key_exists($role["value"], $current["roles"]) ? "checked" :
                    ""),
                "disabled" => $disabled));
        }
        genSmartyAssign("roleId", $current["roles"]["user_id"]);
        genSmartyAssign("roles", $result);
        $list = array();
        while ($current = array_shift($found)) {
            $text = $current["user"]["nick"];
            $text .= "(" . $current["user"]["roepnaam"];
            $text .= "=" . $current["user"]["naam"];
            $text .= ", " . $current["user"]["voorvoegsel"] . ")";
            array_push($list, array("id" => $current["user"]["id"], "text" => $text));

        }
        genSmartyAssign("other", $list);
        return;
    }

    public function resetPassword($data)
    {
        if (!$this->userSession->hasRole(ROLE_MEMBERADMIN)) {
            genSetError("Daar kunnen we niet aan beginnen");
            return;
        }
        if (!array_key_exists("id", $data)) {
            genSetError("Geen gebruikersnummer ontvangen");
            return;
        }
        $old = array("id" => $data["id"]);
        $newWachtwoord = users::randomPassword();
        $new = array("wachtwoord" => $newWachtwoord);
        $this->users->update($old, $new);
        $user = $this->users->get($old["id"]);
        $user["wachtwoord"] = $newWachtwoord;
        $message = $this->teksten->getTekstExpanded(29, $user, false);
        genSendMail($message, EMAIL_SYSTEM, array($user["email"], $user["emailOuder"]));
        unset($user["wachtwoord"]);
        $message = $this->teksten->getTekstExpanded(29, $user, false);
        $message["titel"] = "Ter informatie: " . $message["titel"];
        genSendMail($message, EMAIL_SYSTEM, array(EMAIL_SYSTEM));
    }

    public function isValidPassword($data)
    {
        if (!array_key_exists("oldWachtwoord", $data)) {
            $data["oldWachtwoord"] = "";
        }
        if (!array_key_exists("oldId", $data) || !array_key_exists("newWachtwoord", $data) ||
            !array_key_exists("chkWachtwoord", $data)) {
            genSetError("Incompleet formulier ontvangen");
            return false;
        }
        if (!$this->testIncomingUserData($data, "oldId")) {
            return false;
        }
        if (!strlen($data["newWachtwoord"])) {
            genSetError("Nieuw wachtwoord is leeg");
            return false;
        }
        if ($data["newWachtwoord"] != $data["chkWachtwoord"]) {
            genSetError("Nieuw wachtwoord en controle zijn niet gelijk");
            return false;
        }
        $search = array("id" => $data["oldId"]);
        $result = $this->users->readSelect($search);
        if (!$result)
            return false;
        if (mysql_num_rows($result) == 0) {
            genSetError("Gebuiker niet gevonden: " . $data["oldId"]);
            return false;
        }
        if (!$this->userSession->hasRole(ROLE_SYSTEM)) {
            if (!$this->userSession->isCurrentUser($data["oldId"])) {
                genSetError("Wachtwoord kan niet worden gewijzigd");
                genLogVar(__function__ . ": Wachtwoord kan niet worden gewijzigd " . $data["oldId"]);
                return false;
            }
            $oldUser = $this->users->fetch_assoc($result);
            if (strlen($oldUser["wachtwoord"])) {
                if (password_verify($data["oldWachtwoord"])) {
                    genSetError("Het oude wachtwoord klopt niet");
                    return false;
                } else {
                    genSetError("Het oude wachtwoord ontbreekt");
                    return false;
                }
            }
        }
        return true;
    }

    public function updatePassword($data)
    {
        if ($this->users->update(array("id" => $data["oldId"]), array("wachtwoord" => $data["newWachtwoord"],
                "modifiedby" => $this->userSession->getUserId()))) {
            genSetError("Wachtwoord gewijzigd");
        }
    }

    public function isValidUserData(&$old, &$data)
    {
        global $fields;
        $ok = true;
        $nrEmails = 0;
        $nrEmailFieldsTested = 0;
        if (!$this->testIncomingUserData($data, "id"))
            return false;
        foreach ($fields["user"] as $field => $props) {
            if (!array_key_exists($field, $data))
                continue;
            if (array_key_exists($field, $old)) {
                $oldData = preg_replace("/[0\-\/]/", "", $old[$field]);
                // unchanged data is always right
                if ($oldData == $data[$field])
                    continue;
            }
            if ($props["type"] == "email") {
                $nrEmailFieldsTested++;
                if (!strlen($data[$field]))
                    continue;
                if (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                    $ok = false;
                    genSetError("Ongeldig email adres ingevuld bij: " . $props["text"] . " (" . $data[$field] .
                        ")");
                } else {
                    $nrEmails++;
                }
            } elseif ($props["type"] == "tel") {
                if (!preg_match("/^[+(]?\d+[ )-]?\d+([ -]\d+)?$/", $data[$field])) {
                    $ok = false;
                    genSetError("Ongeldig telefoonnummer, gebruik bijv. (071) 611989");
                }
            } elseif ($props["type"] == "date" && strlen($data[$field]) > 0) {
                $dd = preg_split("/-/", $data[$field]);
                if (count($dd) <= 1) {
                    $dd = preg_split("/\//", $data[$field]);
                }
                if (count($dd) != 3) {
                    $ok = false;
                    genSetError("'" . $data[$field] . "' in '" . $props["text"] .
                        "' is geen goede datum");
                    continue;
                }
            } else {
                if (preg_match("/^\s*$/", $data[$field])) {
                    $ok = false;
                    genSetError("Veld '" . $props['text'] . "' is niet ingevuld");
                }
            }
        }
        if ($nrEmailFieldsTested && !$nrEmails) {
            $ok = false;
            genSetError("Geen emailadres opgegeven");
        }
        return $ok;
    }

    public function updateUserData($data)
    {
        $oldData = $this->getOriginalUserData();
        // unset($oldData['id']);
        // unset($oldData['relnr']);
        // unset($oldData['bondnr']);
        // unset($oldData['modifieddate']);
        // unset($oldData['modifiedby']);
        // unset($oldData['roepnaam']);
        // unset($oldData['naam']);
        // unset($oldData['voorvoegsel']);
        // unset($oldData['straat']);
        // unset($oldData['huisnr']);
        // unset($oldData['postcode']);
        // unset($oldData['plaats']);
        // unset($oldData['telefoonnr']);
        // unset($oldData['gebdatum']);
        // unset($oldData['lidsoort']);
        // unset($oldData['email']);
        // unset($oldData['emailOuder']);
        // unset($oldData['wachtwoord']);
        // unset($oldData['nick']);
        // genSetError("old keys: ".join(array_keys($oldData),"/"));
        if ($this->users->update($oldData, $data)) {
            genSetInfo("De persoonsgegevens zijn bijgewerkt");
        } else {
            genSetError("De persoonsgegevens zijn niet bijgewerkt");
        }
    }

    public function isValidRoleData($data)
    {
        return ($this->testIncomingUserData($data, "id"));
    }

    public function updateRoleData($data)
    {
        $id = $data["id"];
        unset($data["id"]);
        if (!$this->userRoles->deleteAll($id)) {
            genSetError("Verwijderen oude functies $id is mislukt");
            return false;
        }
        foreach ($data as $key => $val) {
            if (!$this->userRoles->insert(array("user_id" => $id, "role" => $val))) {
                genSetError("Invoeren nieuwe functies $id is mislukt");
                return false;
            }
        }
        genSetError("Lidmaatschapsfuncties bijgewerkt");
        return true;
    }

    function __construct()
    {
        $this->teksten = new teksten();
        $this->userSession = new userSession();
        $this->users = new Users();
        $this->userRoles = new User_roles();
        if (isset($_REQUEST["action"])) {
            $action = $_REQUEST["action"];
        } else {
            $action = "";
        }
        if (!array_key_exists("fd", $_REQUEST))
            $_REQUEST["fd"] = array();
        $formData = $_REQUEST["fd"];
        if (!array_key_exists("pw", $formData))
            $formData["pw"] = array();
        if (!array_key_exists("user", $formData))
            $formData["user"] = array();
        if (!array_key_exists("role", $formData))
            $formData["role"] = array();
        if (!array_key_exists("search", $formData))
            $formData["search"] = array();

        if ($this->userSession->isLoggedIn()) {
            if ($action == "updatePassword") {
                if ($this->isValidPassword($formData["pw"])) {
                    $this->updatePassword($formData["pw"]);
                }
                $found = $this->findUsersAndRoles(array("id" => $formData["pw"]["oldId"]));
            } elseif ($action == "updateUser") {
                if ($this->isValidUserData($this->getOriginalUserData(), $formData["user"])) {
                    $this->updateUserData($formData["user"]);
                }
                $found = $this->findUsersAndRoles(array("id" => $formData["user"]["id"]));
            } elseif ($action == "updateRoles") {
                if ($this->isValidRoleData($formData["role"])) {
                    $this->updateRoleData($formData["role"]);
                }
                $found = $this->findUsersAndRoles($formData["user"]);
            } elseif ($action == "resetPassword") {
                $this->resetPassword($formData["search"]);
                $found = $this->findUsersAndRoles($formData["search"]);
            } else {
                $found = $this->findUsersAndRoles($formData["search"]);
            }
            userSession::setSessionData('found', $found);
            $this->presentUsersAndRoles($found);
        }
        genSmartyAssign("search", $formData["search"]);
        genSmartyDisplay("wsvl_userBeheer.tpl");
    }
}

$something = new beheerLidmaatschap();

?>
