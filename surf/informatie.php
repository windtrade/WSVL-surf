<?php

require_once "library/all_config.inc.php";
require_once "calendar.lib.php";
require_once "event.lib.php";
require_once "eventregister.lib.php";
require_once "general.lib.php";
require_once "teksten.lib.php";
require_once "users.lib.php";
require_once "userSession.lib.php";

class informatie
{

    private $teksten;
    private $calendar;
    private $event;
    private $eventRegister;
    private $users;

    private $eventList;

    private $userColumns = array(
        "roepnaam",
        "naam",
        "voorvoegsel",
        "telefoonnr",
        "gebdatum",
        "email");

    public function getTeksten()
    {
        $nrs = array(20, 19); // standaard: club en geschiedenis
        $tab = "";
        if (array_key_exists("tab", $_REQUEST)) {
            $tab = $_REQUEST["tab"];
        }
        if (strtolower($tab) == "surfpool")
            $nrs = array(22, 28);
        else
            if (strtolower($tab) == "surfles") {
                $nrs = array(24, 28);
                $data = $this->getData(general::INSTRUCTION);
            } else
                if (strtolower($tab) == "wedstrijden")
                    $nrs = array(21, 28);
                else
                    if (strtolower($tab) == "gww")
                        $nrs = array(21, 28);
        $teksten = array();
        foreach ($nrs as $nr) {
            if ($tekst = $this->teksten->getTekst($nr)) {
                array_push($teksten, $tekst);
            }
        }
        return $teksten;
    }

    public function makeObjects()
    {
        $this->calendar = new Calendar();
        $this->event = new event();
        $this->eventRegister = new eventRegister();
        $this->teksten = new teksten();
        $this->users = new users();
        $this->userSession = new userSession();
    }

    /*
    * This function expects:
    * $_POST[fd] assoc array:
    * * "user" => assoc array for $this->users table object
    * * "eventRegistration" => assoc array for $this->eventRegistration
    *   table object
    * * * [id][start] => "" its presence says it all
    */
    public function handleFormData()
    {
        genLogVar('$_POST', $_POST);
        if (!array_key_exists('fd', $_POST))
            return false;
        $fd = $_POST["fd"];
        if (!is_array($fd))
            return false;
        if (genGetPageCache("NOROBOT") || general::reCAPTCHAverify()) {
            genSetPageCache("NOROBOT", "OK");
        } else {
            return false;
        }
        $hasRegistration = false;
        foreach ($fd as $group => $arr) {
            genLogVar(__class__ . ":" . __function__ . " group:", $group);
            if ($group == "user") {
                if (!$this->users->isValid($arr, $this->userColumns)) {
                    genLogVar(__class__ . ":" . __function__ . " isValidUser", false);
                    return false;

                } elseif ($group == "eventRegister") {
                    // No need to validate registration,
                    // false dates will be ignored
                    $hasRegistration = true;
                }
            }
        }
        if (!$hasRegistration) {
            genLogVar(__class__ . ":" . __function__ . " hasRegistration:", $hasRegistration);
            genSetError("Geef één of meer data op");
            return false;
        }
        $fd["user"]["lidsoort"] = "STARTER";
        $fd["user"]["wachtwoord"] = $this->users->randomPassword();
        $this->users->insert($fd["user"]);
        $fd["user"]["id"] = $this->users->getLastId();
        $this->register($fd);
        $starts = array();
        foreach ($fd["eventRegister"] as $event) {
            foreach (array_keys($event) as $start) {
                array_push($starts, $start);
            }
        }
        // make up the mail message
        $fields = $fd["user"];
        $fields["start"] = implode(", ", $starts); //comma separated list of selected dates
        $mail = $this->teksten->getTekstExpanded(30, $fields, false);
        $from = "surfles@wvleidschendam.nl";
        genSendMail($mail, $from, $fd["user"]["email"]);
        // send it to administration, leave out password
        unset($fields["wachtwoord"]);
        $mail = $this->teksten->getTekstExpanded(30, $fields, false);
        genSendMail($mail, $from, $from);
        return $fd;
    }

    private function getEventList($category, $start)
    {
        $whereArr = array();
        if ($category != general::NONE) {
            array_push($whereArr, array(
                "col" => "category",
                "oper" => "=",
                "val" => $category));
        }
        if ($start != "") {
            array_push($whereArr, array(
                "col" => "start",
                "oper" => ">=",
                "val" => $start));
        }
        $orderArr = array(
            "category" => "ASC",
            "id" => "ASC",
            "start" => "ASC");
        $result = $this->calendar->readQuery($whereArr, $orderArr);
        $retval = array();
        if (!$result)
            return $retval;
        $lastId = -1;
        while ($row = mysql_fetch_assoc($result)) {
            if ($row{"id"} != $lastId) {
                $lastId = $row{"id"};
                $retval[$lastId] = array("calendar" => array());
            }
            array_push($retval[$lastId] {
                "calendar"}
            , $row);
        }
        foreach (array_keys($retval) as $id) {
            $retval[$id] {
                "event"}
            = $this->event->get($id);
        }
        return $retval;
    }

    private function register(&$fd)
    {
        $ok = true;
        // build a list per event with all selected start(-datetime)
        $newStarts = array();
        foreach (array_keys($this->eventList) as $key)
            $newStarts[$key] = array();
        foreach ($fd["eventRegister"] as $key => $list) {
            // skip registration for nonexistent events
            if (!array_key_exists($key, $fd["eventRegister"]))
                continue;
            $newStarts[$key] = array_keys($fd["eventRegister"][$key]);
        }

        // Build a sorted list of all start dates for every event
        $calStarts = array();
        foreach (array_keys($this->eventList) as $id) {
            $calStarts[$id] = array();
            foreach ($this->eventList[$id]["calendar"] as $cal) {
                array_push($calStarts[$id], $cal["start"]);
            }
            sort($calStarts[$id]);
        }
        //sort($calStarts);

        // Step 1: Update existing registrations for this user
        foreach (array_keys($newStarts) as $evId) { // foreach event Td
            foreach ($this->eventRegister->getEventForUser($evId, $fd["user"]["id"]) as $evReg) {
                $newEventStartsForId = $newStarts[$evId];
                $idx = array_search($evReg["start"], $newEventStartsForId);
                if ($idx === false) {
                    if ($evReg["enrolled"]) {
                        $this->eventRegister->update($evReg, array("enrolled" => 0));
                        genLogVar(__class__ . ":" . __function__ . "update enrolled = 0 evReg:", $evReg);
                    }
                } else {
                    if (!$evReg["enrolled"]) {
                        $this->eventRegister->update($evReg, array("enrolled" => 1));
                        genLogVar(__class__ . ":" . __function__ . "update enrolled = 1 evReg:", $evReg);
                    }
                    array_splice($newStarts[$evId], $idx, 1);
                }
            }
        }
        foreach (array_keys($newStarts) as $evId) {
            foreach ($newStarts[$evId] as $nS) {
                if (array_search($nS, $calStarts[$evId]) !== false) {
                    $evReg = array(
                        "id" => $evId,
                        "start" => $nS,
                        "userId" => $fd["user"]["id"],
                        "enrolled" => 1);
                    $this->eventRegister->insert($evReg);
                    genLogVar(__class__ . ":" . __function__ . "insert evReg:", $evReg);
                }
            }
        }
    }
    public function toForm($fd)
    {
        if (!is_array($fd))
            $fd = array();
        if (!array_key_exists("user", $fd))
            $fd["user"] = array();
        if (!array_key_exists("eventRegister", $fd))
            $fd["eventRegister"] = array();
        $result = array("user" => array(), "eventRegister" => array());
        $result["user"] = $this->users->toForm($fd["user"], $this->userSession, array(),
            // hide these
            $this->userColumns); // include these
        foreach ($this->eventList as $id => $data) {
            $result["eventRegister"][$id] = array();
            if (!array_key_exists($id, $fd["eventRegister"])) {
                $fd["eventRegister"][$id] = array();
            }
            foreach ($data["calendar"] as $calendar) {
                $enrolled = 0;
                if (array_key_exists($calendar["start"], $fd["eventRegister"][$id])) {
                    $enrolled = 1;
                }
                array_push($result["eventRegister"][$id], $this->makeFormElement($id, $calendar["start"],
                    $enrolled));
            }
        }
        return $result;
    }

    /*
    * build a assoc array with elements for a single checkbox
    */
    private function makeFormElement($id, $start, $checked)
    {
        $dt = new DateTime($start);
        $label = $dt->format("d-m-Y");
        $name = "fd[eventRegister][$id][$start]";
        return array(
            "label" => $label,
            "name" => $name,
            "checked" => $checked);
    }

    public function getData($fd)
    {
        $data = array();
        if (strtolower($_REQUEST["tab"]) == "surfles") {
            $data = $this->toForm($fd);
        }
        return $data;
    }

    public function __construct()
    {
        $this->makeObjects();
        $this->eventList = $this->getEventList(general::INSTRUCTION, date("Y-01-01 00:00"));
        $fd = $this->handleFormData();
        $teksten = $this->getTeksten();
        $data = $this->getData($fd);
        genSmartyAssign("teksten", $teksten);
        genSmartyAssign("data", $data);
        genSmartyDisplay("wsvl_Informatie.tpl");
    }
}

$something = new informatie();
