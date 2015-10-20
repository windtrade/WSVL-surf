<?php
#
# This page expects formdata structured like this
# fd__group__event__<eventfield>
# ...
# fd__group___eventdate__<nr>__<eventdatefield>
# ...
require_once "library/all_config.inc.php";
require_once "general.lib.php";
require_once "event.lib.php";
require_once "eventregister.lib.php";
require_once "calendar.lib.php";
require_once "image.lib.php";
require_once "users.lib.php";

class kalender
{
    private $event;
    private $calendar;
    private $image;
    private $userSession;
    private $users;
    private $userFields = array("id", "roepnaam", "naam", "email");

    private function getCalendarList($year)
    {
	$calendar = array();;
	$result = array(
	    "event" => array(),
	    "GENERAL" => array(),
	    "INSTRUCTION" => array(),
	    "TRAINING" => array()
	);

	$jan1st = "-01-01 00:00:00";
	if ($year <= 0) {
	    $now = new DateTime();
	} else {
	    $now = new Datetime($year.$jan1st);
	}
	$start = $now->format("Y").$jan1st;
	$whereArray = array(
	    array(
		"col" => "start",
		"oper" => ">=",
		"val" => $start
	    )
	);
	$orderArray = array(
	    "start" =>  "ASC"
	);
	$ids = array();
	$query = $this->calendar->readQuery($whereArray, $orderArray);
	if ($query) {
	    while ($row = $this->calendar->fetch_assoc($query)) {
		# build a list of events
		$ids[$row["id"]] = $row["id"];
		array_push($calendar, $row);
	    }
	}
	$whereArray = array(
	    array(
		"col" => "id",
		"oper"=> "IN",
		"val" => $ids
	    )
	);
	# find all events in this part of the calendar
	$query = $this->event->readQuery($whereArray);
	if ($query) {
	    while ($row = $this->event->fetch_assoc($query)) {
		$result["event"][$row["id"]] = $row;
	    }
	}
	# set all training and instruction items apart
	$i = 0;
	while ($cal = array_shift($calendar)) {
	    $i++;
	    switch ($result["event"][$cal["id"]]["category"]) {
	    case general::INSTRUCTION:
		if (!array_key_exists($cal["id"],$result["INSTRUCTION"])) {
		    $result["INSTRUCTION"][$cal["id"]] = array();
		}
		array_push($result["INSTRUCTION"][$cal["id"]], $cal);
		break;
	    case general::TRAINING:
		if (!array_key_exists($cal["id"],$result["TRAINING"])) {
		    $result["TRAINING"][$cal["id"]] = array();
		}
		array_push($result["TRAINING"][$cal["id"]], $cal);
		break;
	    default:
		array_push($result["GENERAL"], $cal);
		break;
	    }
	}
	return $result;
    }
    
    /*
     * return the next upcoming event or the selected event
     * as defined by request parameters 
     * currentEventId and currentStart
     */
    private function getCurrentEventItem($data)
    {
	$currentEventId = 0;
	if (array_key_exists('currentEventId', $_REQUEST)) {
	    if (array_key_exists($_REQUEST['currentEventId'], $data['event'])) {
		$currentEventId = $_REQUEST['currentEventId'];
	    }
	}

	if (array_key_exists('currentStart', $_REQUEST)) {
	    $currentStart = $_REQUEST["currentStart"];
	} else {
	    $now = new DateTime();
	    $currentStart = $now->format("Y-m-d");
	}
	foreach ($data['GENERAL'] as $key => $elt) {
	    if ($currentEventId == 0 || $currentEventId == $elt["id"]) {
		if ($elt['start'] >= $currentStart) break;
	    }
	}
	$now = new DateTime();
	$eltStart = new DateTime($elt["start"]);
	$nowDay = $now->format("z");
	$eltStartDay = $eltStart->format("z");
	$dateform = "d-m-Y";
	# Below '\' prevent characters in $dateform being
	# interpreted as datetime format
	switch ($eltStartDay-$nowDay) {
	case 0:
	    $dateform='\V\a\n\d\a\a\g';
	    break;
	case 1:
	    $dateform = '\M\o\r\g\e\n';
	    break;
	case 2:
	    $dateform = '\O\v\e\r\m\o\r\g\e\n';
	    break;
	}
	$elt["startText"] = $eltStart->format("$dateform H:i");
	return $elt;
    }
	
    private function calendarListToText($list)
    {
	$result = array(
	    "event" => $list["event"],
	    "GENERAL" => array(),
	    "INSTRUCTION" => array(
		"link" => "http://".$_SERVER["SERVER_NAME"].
		"/informatie_leesverder.php?tekst=24&rubriek_id=3&".
		"tab=informatie",
		"dates" =>array()
	    ),
	    "TRAINING" => array(
		"link" => "http://".$_SERVER["SERVER_NAME"].
		"/training.php?tab=training",
		"dates" =>array()
	    )
	);
	#
	# reguliere evenementen, geen lessen of trainingen
	#
	foreach ($list["GENERAL"] as $cal) {
	    $evt = $list["event"][$cal["id"]];
	    $elt = $cal;
	    $elt["title"] = $evt["title"];
	    $elt["image"] = $evt["image"];
	    $elt["date"] =preg_split("/[- :]/", $elt["start"]);
	    array_push($result["GENERAL"], $elt);
	}
	foreach (array("INSTRUCTION", "TRAINING") as $typ) {
	    foreach ($list[$typ] as $eltList) {
		foreach ($eltList as $cal) {
		    if (!array_key_exists($cal["id"], $result[$typ]["dates"])) {
			$result[$typ]["dates"][$cal["id"]] = array(
			    "title" => $list["event"][$cal["id"]]["title"],
			    "start" => array()
			);
		    }
		    $dt = new DateTime($cal["start"]);
		    array_push($result[$typ]["dates"][$cal["id"]]["start"],
			array(
			    "date" => $dt->format("d-m"),
			    "time" => $dt->format("H:i")
			));
		}
	    }
	}
	$userData = genGetPageCache("users");
	if ($userData === false) $userData= array();
	$result["form"]["users"] = $this->users->toForm(
	    $userData,$this->userSession, null, $this->userFields);
	return $result;
    }

    private function handleCommand(&$fd)
    {
	$command = $fd["command"];
	if (!in_array($command, array("AANMELDEN", "AFMELDEN"))) return;

	if (!array_key_exists("users", $fd)) {
	    genSetError("Gegevens van de deelnemer ontbreken");
	    return;
	}
	if (!array_key_exists("eventRegister", $fd)) {
	    genSetError("Gegevens van het evenement ontbreken");
	    return;
	}
	$reg = $fd["eventRegister"];
	$us = $fd["users"];

	if (!array_key_exists("id", $us)) { 
	    // Try retrieve user data by email:
	    $clan = array();
	    if ($us["email"] != "") {
		$clan = $this->users->getClan($us["email"]);
	    }
	    if (count($clan) > 1) {
		// eliminate members with different email
		// They were selected by 'email_ouder'
		$smallClan = array();
		foreach ($clan as $member) {
		    if (strtolower($member["email"]) == strtolower($us["email"])) {
			array_push($member, $smallClan);
		    }
		}
		if (count($smallClan) == 1) $clan = $smallClan;
	    }
	    if (count($clan) != 1) {
		// Cannot determine the user that is a registration only
		// situation
		if ($command != "AANMELDEN") {
		    genSetError("Om je af te melden voor een evenement moet je eerst inloggen");
		    return;
		} 
		// validate and write a (very limited) user record
		if ($this->users->isValid($us, $this->userFields)) {
		    $this->users->insert($us);
		    $us["id"] = $this->users->getLastId();
		} else {
		    return;
		}
	    } else {
		foreach ($clan[0] as $key => $val) {
		    $us[$key] = $val;
		}
	    }
	}
	$_SESSION[$_SERVER["PHP_SELF"]]["users"] = $us;
	$reg["userId"] = $us["id"];
	if ($command == "AANMELDEN") {
	    $reg["enrolled"] = 1;
	} else {
	    $reg["enrolled"] = 0;
	}
	$this->eventRegister->register(
	    $reg["id"],
	    $reg["start"],
	    $reg["userId"],
	    $reg["enrolled"]
	);
	$fd["users"] = $us;
    }

    private function makeObjects()
    {
	$this->event = new event();
	$this->eventRegister = new eventRegister();
	$this->calendar = new calendar();
	$this->image = new image();
	$this->userSession = new userSession();
	$this->users = new users();
    }

    private function getFormData()
    {
	if (array_key_exists("fd", $_REQUEST)) {
	    $fd = $_REQUEST["fd"];
	} else {
	    $fd = array();
	}
	if (!array_key_exists("users", $fd)) {
	    $fd["users"] = array();
	}
	if (!array_key_exists("eventRegister", $fd)) {
	    $fd["eventRegister"] = array();
	}

	if (!array_key_exists("command", $fd)) {
	    $fd["command"] ="";
	}
	return $fd;
    }

    private function preparePageCache()
    {
	if ($this->userSession->isLoggedIn()) {
	    genSetSessionData($_SERVER["PHP_SELF"], "users",
		$this->users->get($this->userSession->getUserId()));
	}
    }

    public function __construct()
    {
	$this->makeObjects();
	$this->preparePageCache();
	$data = array(
	    "event" => array(),
	    "calendar" => array());

	if (genGetPageCache("NOROBOT") || general::reCAPTCHAverify()) {
	    genSetPageCache("NOROBOT", "OK");
	    $fd = $this->getFormData();
	    $this->handleCommand($fd);
	}

	$calendarList = $this->getCalendarList(0);
	$currentEventItem = $this->getCurrentEventItem($calendarList);
	$enrolled = 0;
	if (genGetPageCache("users", "id")) {
	    $reg = $this->eventRegister->get(
		$currentEventItem["id"],
		$currentEventItem["start"],
		genGetPageCache("users","id"));
	    $enrolled = $reg["enrolled"];
	}
	$command = "AANMELDEN";
	if ($enrolled) $command = "AFMELDEN";
	$data=$this->calendarListToText($calendarList);
	$data["users"] = genGetPageCache("users");
	if ($data["users"] === false) $data["users"] = array();
	#genAddJavascriptFile("formhandling");
	genDumpVar('$_SESSION', $_SESSION);
	genSmartyAssign("monthNames", array(
	    "?",
	    "januari",	"februari", "maart",
	    "april",	"mei",	    "juni",
	    "juli",	"augustus", "september",
	    "oktober",	"november", "december"));
	genSmartyAssign("currentEventItem", $currentEventItem);
	genSmartyAssign("rightColumns", array("INSTRUCTION", "TRAINING"));
	genSmartyAssign("data", $data);
	genSmartyAssign("command", $command);
	genSmartyAssign("NOROBOT", genGetPageCache("NOROBOT"));
	genSmartyDisplay("wsvl_kalender.tpl");
    }
}

$something = new kalender();
?>

