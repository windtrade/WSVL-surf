<?php
require_once "library/all_config.inc.php";
require_once "general.lib.php";
require_once "teksten.lib.php";
require_once "calendar.lib.php";
require_once "event.lib.php";
require_once "eventregister.lib.php";

DEFINE("CUID", "currentUserId");

class trainingbeheer
{
    private $userSession;
    private $trainingsDays = array(2, 4); // Tuesday, Thursday
    private $teksten;
    private $users;
    private $event;
    private $eventRegister;
    private $calendar;
    private $information = array(21);
    private $tempPassword;
    private $eventList;
    private $userClan;
    private $currentUser;

    private function getPresent($eventList)
    {
        $result = array();
        $upcoming = array();
        foreach ($eventList as $key => $val) {
            if (count($val["calendar"]) == 0)
                continue;
            $upcoming[$val["calendar"][0]["start"]] = $key;
        }
        ksort($upcoming);
        // $upcoming = (start, id)...
        // $upcoming = $this->calendar->getUpcoming(general::TRAINING);
        foreach ($upcoming as $start => $id) {
            $participants = $this->eventRegister->getParticipants($id, $start);
            $names = array();
            foreach ($participants as $userId) {
                $user = $this->users->get($userId);
                if ($user)
                    array_push($names, $user["roepnaam"] . " " . $user["voorvoegsel"] . " " . $user["naam"]);
            }
            array_push($result, array(
                "id" => $id,
                "start" => $start,
                "names" => $names));
        }
        return $result;
    }

    public function __get($field)
    {
        genSetError("trying to access $field");
    }

    private function getInformation()
    {
        $retval = array();
        foreach ($this->information as $id) {
            $result = $this->teksten->readSelect(array("id" => $id));
            if ($result) {
                $row = mysql_fetch_assoc($result);
                array_push($retval, $row);
            }
        }
        return $retval;
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

    /*
    * make a collection of registrations of a single user
    * for a list of events
    */
    private function getUserDates($start, $userId, $eventIds)
    {
        $retval = array();
        foreach ($eventIds as $id) {
            $retval[$id] = $this->eventRegister->getEventForUser($id, $userId);
            while (count($retval[$id]) && $retval[$id][0]["start"] < $start) {
                array_shift($retval["id"]);
            }
        }
        return $retval;
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

    private function toForm($eventList, $userData)
    {
        $result = array();
        foreach (array_keys($eventList) as $id) {
            if (count($eventList[$id]["calendar"]) == 0)
                continue;
            $result[$id] = array();
            $result[$id]["event"] = $eventList[$id]["event"];
            $result[$id]["eventRegister"] = array();
            $c = 0;
            $cCount = count($eventList[$id]["calendar"]);
            $e = 0;
            $eCount = count($userData[$id]);
            while ($c < $cCount && $e < $eCount) {
                $start = $eventList[$id]["calendar"][$c]["start"];
                if ($start < $userData[$id][$e]["start"]) {
                    array_push($result[$id]["eventRegister"], $this->makeFormElement($id, $start, 0));
                    $c++;
                } else
                    if ($start == $userData[$id][$e]["start"]) {
                        array_push($result[$id]["eventRegister"], $this->makeFormElement($id, $start, $userData[$id][$e]["enrolled"]));
                        $c++;
                        $e++;
                    } else {
                        // This would be weird:
                        // a user date that is not on the calendar
                        $e++;
                    }
            }
            while ($c < $cCount) {
                $start = $eventList[$id]["calendar"][$c]["start"];
                array_push($result[$id]["eventRegister"], $this->makeFormElement($id, $start, 0));
                $c++;
            }
        }
        return $result;
    }

    private function clanToUserList()
    {
        $userList = array();
        if ($this->userClan) {
            foreach ($this->userClan as $usr) {
                $userId = $usr["id"];
                $userList["$userId"] = $usr["roepnaam"] . " " . $usr["voorvoegsel"] . " " . $usr["naam"];
            }
        }
        return $userList;
    }

    private function displayTraining($formData)
    {
        /*
        * All events from training category with present and future
        * start dates are displayed. One block per event
        * Per event we give:
        * - Event data
        * - All present and future dates for the event as list of
        * - - date/time
        * - - user presence for current user.
        * - list of participants for the upcoming event date
        */
        $currentUserId = -1;
        if (array_key_exists("currentUserId", $_REQUEST)) {
            $currentUserId = $_REQUEST["currentUserId"];
        }
        if ($this->userSession->isLoggedIn()) {
            if ($currentUserId == -1) {
                $currentUserId = $this->userSession->getUserAttr("id");
            }
        }
        $eventList = $this->getEventList(general::TRAINING, date("Y-m-d 00:00")); // start today
        $userDates = $this->getUserDates(date("Y-m-d 00:00"), $currentUserId, array_keys
            ($eventList));
        $data = $this->toForm($eventList, $userDates);

        $this->userSession->setSessionData(CUID, $currentUserId);
        genSmartyAssign(CUID, $currentUserId);
        genSmartyAssign("userList", $this->clanToUserList());
        genSmartyAssign("data", $data);
        genSmartyAssign("present", $this->getPresent($eventList));
        genSmartyAssign("formData", $formData);
        genSmartyAssign("information", $this->getInformation());
        genSmartyDisplay("wsvl_training.tpl");
    }

    private function sendMail($dateList, $naam, $email)
    {
        $tekst = $this->teksten->getTekst(25);
        if (!$tekst)
            return false;
        $msg = $tekst["tekst"];
        $msg = preg_replace('/<br *\/>/', '', $msg);
        $msg = preg_replace('/\[naam\]/i', $naam, $msg);
        $msg = preg_replace('/\[email\]/i', $email, $msg);
        if (preg_match('/\?/', $_SERVER["REQUEST_URI"])) {
            $firstOperator = "&";
        } else {
            $firstOperator = "?";
        }
        $dagen = array("dinsdag", "donderdag");
        foreach ($dateList as $list) {
            $dag = array_shift($dagen);
            $msg .= "\n";
            foreach ($list as $item) {
                $msg .= "voor " . $dag . " " . $item["printDatum"] . " " . "http://" . $_SERVER["SERVER_NAME"] .
                    $_SERVER["REQUEST_URI"] . $firstOperator . "action=afmelden" . "&fd_token=" . $item["token"] .
                    "&fd_datum=" . $item["datum"] . "\n";
            }
        }
        $headers = 'From: training@wvleidschendam.nl' . "\r\n" .
            'Reply-To: training@wvleidschendam.nl' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
        return (mail($email, $tekst["titel"], $msg, $headers));
    }


    private function randomPassword()
    {
        $alphabet = "-*^#@_abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    private function registerUser(&$fd)
    {
        genLogVar("User data", $fd["user"]);
        $ok = true;
        foreach ($fd["user"] as $field => $val) {
            if ($field == "voorvoegsel")
                continue;
            if ($val == "") {
                genSetError("Je moet wel al je contactgevens invullen");
                $ok = false;
                break;
            }
        }
        if (!$ok)
            return $ok;
        genLogVar("OK", $ok);
        $this->tempPassword = users::randomPassword();
        $fd["user"]["wachtwoord"] = $this->tempPassword;
        $fd["user"]["lidsoort"] = "TRAINING";
        $fd["user"]["EmailOuder"] = $fd["user"]["email"];
        if ($ok) {
            $ok = $this->users->insert($fd["user"]);
            genLogVar("User data", $fd["user"]);
            if ($ok) {
                $fd["user"]["id"] = $this->users->getLastId();
                $old["id"] = $fd["user"]["id"];
                // We need a nick name to login
                $fd["user"]["nick"] = $fd[CUID] . "_+_" . $fd["user"]["roepnaam"];
                if ($this->users->update($old, $fd["user"])) {
                    genLogVar("Insert compleet - User data", $fd["user"]);
                    $_REQUEST["login"] = $fd["user"]["nick"];
                    $_REQUEST["password"] = $fd["user"]["wachtwoord"];
                    $this->userSession->login();
                } else {
                    genLogVar("Insert incompleet - Userdata", $fd["user"]);
                    $ok = false;
                }
            }
        }
        genLogVar(__FUNCTION__."returns", $ok);
        return $ok;
    }

    private function registerTraining($eventList, &$fd)
    {
        $ok = true;
        if (!array_key_exists("id", $fd["user"]))
            $fd["user"]["id"] = -1;
        if ($fd["user"]["id"] < 0) {
            // Do not register nothing for an unknown user
            if (count($fd["eventRegister"]) <= 0) {
                genSetError("Je hebt je voor geen enkele datum opgegeven");
                return $ok;
            }
            $ok = $ok && $this->registerUser($fd);
            if (!$ok)
                return $ok;
        }
        if (!$this->partOfTheClan($fd["user"]["id"])) {
            return false;
        }

        // build a list per event with all selected start(-datetime)
        $newStarts = array();
        foreach (array_keys($eventList) as $key)
            $newStarts[$key] = array();
        foreach ($fd["eventRegister"] as $key => $list) {
            // skip registration for nonexistent events
            if (!array_key_exists($key, $fd["eventRegister"]))
                continue;
            $newStarts[$key] = array_keys($fd["eventRegister"][$key]);
        }

        // Build a sorted list of all start dates for every event
        $calStarts = array();
        foreach (array_keys($eventList) as $id) {
            $calStarts[$id] = array();
            foreach ($eventList[$id]["calendar"] as $cal) {
                array_push($calStarts[$id], $cal["start"]);
            }
            sort($calStarts[$id]);
        }

        // Step 1: Update existing registrations for this user
        foreach (array_keys($newStarts) as $evId) { // foreach event Td
            foreach ($this->eventRegister->getEventForUser($evId, $fd["user"]["id"]) as $evReg) {
                $newEventStartsForId = $newStarts[$evId];
                $idx = array_search($evReg["start"], $newEventStartsForId);
                if ($idx === false) {
                    if ($evReg["enrolled"]) {
                        $this->eventRegister->update($evReg, array("enrolled" => 0));
                    }
                } else {
                    if (!$evReg["enrolled"]) {
                        $this->eventRegister->update($evReg, array("enrolled" => 1));
                    }
                    array_splice($newStarts[$evId], $idx, 1);
                }
            }
        }
        foreach (array_keys($newStarts) as $evId) {
            foreach ($newStarts[$evId] as $nS) {
                if (array_search($nS, $calStarts[$evId]) !== false) {
                    $this->eventRegister->insert(array(
                        "id" => $evId,
                        "start" => $nS,
                        "userId" => $fd["user"]["id"],
                        "enrolled" => 1));
                }
            }
        }
    }

    private function makeObjects()
    {
        $this->userSession = new UserSession();
        $this->teksten = new Teksten();
        $this->event = new Event();
        $this->eventRegister = new EventRegister();
        $this->calendar = new Calendar();
        $this->users = new Users();
    }

    private function partOfTheClan($id)
    {
        foreach ($this->userClan as $user) {
            if ($user["id"] == $id)
                return true;
        }
        return false;
    }

    private function determineUser()
    {
        if ($this->userSession->isLoggedIn()) {
            $id = $this->userSession->getUserAttr("id");
            $this->userClan = $this->users->getClan($this->userSession->getUserAttr("id"));
        } else {
            $userClan = array();
        }

    }

    public function __construct()
    {
        $formData = array();
        $this->makeObjects();
        $this->determineUser();
        $eventList = $this->getEventList(general::TRAINING, date("Y-m-d 00:00")); // start today

        $goRegister = false;
        if (array_key_exists("fd", $_POST)) {
            $formData = $_POST["fd"];
            $goRegister = true;
        }
        if (!array_key_exists("user", $formData)) {
            $formData["user"] = array();
        }
        if (!array_key_exists("eventRegister", $formData)) {
            $formData["eventRegister"] = array();
        }
        if ($goRegister && (genGetPageCache("NOROBOT") || general::reCAPTCHAverify())) {
            genSetPageCache("NOROBOT", "OK");
            $this->registerTraining($eventList, $formData);
        }
        genLogVar('_REQUEST', $_REQUEST);
        $this->displayTraining($formData);
    }
}

$something = new trainingbeheer();

?>
