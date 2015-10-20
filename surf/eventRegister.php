<?php
/*
 * This page allow the user to register for one, some or all instances
 * of an event
 *
 * 03-01-2014 : Huug Peters : Creation
 */
error_reporting(E_ALL);
require_once "library/all_config.inc.php";
require_once "general.lib.php";
require_once "event.lib.php";
require_once "eventregister.lib.php";
require_once "calendar.lib.php";

class eventRegistation
{
    private $event;
    private $eventRegister;
    private $calendar;
    private $userSession;

    private $today;

    private function getCalendarList()
    {
	$now = new DateTime();
	$start = $now->format("Y-m-d");
	$calList = $this->calendar->getEventsFromCalendar($start);
	$retval = array();
	while ($cal = array_shift($calList)) {
	    $evt = $this->event->get($cal["id"]);
	    if ($evt) {
		array_push($retval, array (
		    "calendar" => $cal,
		    "event" => $evt));
	    }
	}
	return $retval;
    }

    private function getMyFutureCalendar($userId)
    {
	$retval = $this->eventRegister->getUserCalendar(
	    $userId, $this->today);
	return $retval;
    }

    private function makeRegisterElt($calendar, $userId, $enrolled)
    {
	$retval["entry"] = implode("x", array(
	    $calendar["id"],
	    $userId,
	    $calendar["start"])
	);
	$retval["entry"] = preg_replace("/ /", "T", $retval["entry"]);
	$retval["name"] = $calendar["name"];
	$retval["start"] = $calendar["start"];
	$retval["url"] = $calendar["url"];
	$retval["enrolled"] = $enrolled;
	return $retval;
    }

    private function getRegistration($eventId, $userId)
    {
	$retval["event"]=$this->event->get($eventId);
	$calendar = $this->calendar->getAllFrom($eventId, $this->today);
	$eventRegister = $this->eventRegister->getEventForUser($eventId, $userId);
	$retval["registerList"] = array();
	if (count($calendar) ==0) return $retval;
	$registerList = array();
	$cMax = count($calendar);
	$eMax = count($eventRegister);
	$c = 0;
	$e = 0;
	while ($c < $cMax && $e < $eMax) {
	    // genSetError("=====================================================");
	    $thisCal= $calendar[$c];
	    $thisEvReg= $eventRegister[$e];
	    if ($thisCal["start"] <  $thisEvReg["start"]) {
		# never before enrolled...
		array_push($registerList,
		    $this->makeRegisterElt($thisCal, $userId, 0));
		$c++;
	    } elseif ($thisCal["start"] == $thisEvReg["start"]) {
		# copy enrollment;
		array_push($registerList,
		    $this->makeRegisterElt($thisCal, $userId, $thisEvReg["enrolled"]));
		$c++;
		$e++;
	    } else /*if ($thisCal["start"] >= $thisEvReg["start"]) */ {
		# enrollment for non existent calendar item
		# this would be data error...
		$e++;
	    }
	}
	while ($c < $cMax) {
	    $thisCal= $calendar[$c];
	    array_push($registerList,
		$this->makeRegisterElt($thisCal, $userId, 0));
	    $c++;
	} 
	$retval["registerList"] = $registerList;
	return $retval;
    }

    public function eventRegisterInsertOrUpdate( $elt)
    {
	preg_replace("/T/", " ", $elt["entry"]);
	list($eR["id"], $eR["userId"], $eR["start"]) =
	    preg_split("/x/", $elt["entry"]);
	$eR["enrolled"] = $elt["enrolled"];
	$this->eventRegister->insertOrUpdate($eR);
    }
    
    /*
     * arguments: current eventRegistration & formdata
     */
    private function processFormData(&$cR, $formData)
    {
	// genDumpVar("formData=", $formData);
	// genDumpVar("cR=", $cR);
	$keys = array_keys($formData["calendar"]);
	sort($keys);
	$regs = array();
	$j = 0;
	$jMax=count($cR["registerList"]);
	while (count($keys)) {
	    $elt = array_shift($keys);
	    preg_replace("/T/", " ", $elt);
	    while ($j < $jMax) {
		$old = $cR["registerList"][$j];
		if ($old["entry"] < $elt) {
		    if ($old["enrolled"]) {
			$cR["registerList"][$j]["enrolled"] = 0;
			$this->eventRegisterInsertOrUpdate(
			    $cR["registerList"][$j]);
		    }
		} elseif ($old["entry"] == $elt) {
		    if (!$old["enrolled"]) {
			$cR["registerList"][$j]["enrolled"] = 1;
			$this->eventRegisterInsertOrUpdate(
			    $cR["registerList"][$j]);
		    }
		} else {
			    break;
			}
		$j++;
	    }
	}
	while ($j < $jMax) {
	    if ($cR["registerList"][$j]["enrolled"]) {
		$old = $cR["registerList"][$j];
		$cR["registerList"][$j]["enrolled"] = 0;
		$this->eventRegisterInsertOrUpdate(
		    $cR["registerList"][$j]);
	    }
	    $j++;
	}
    }


	
    public function __construct()
    {
	$now = new DateTime();
	$this->today = $now->format("Y-m-d");
	$this->event = new event();
	$this->eventRegister = new eventregister();
	$this->calendar = new calendar();
	$this->userSession = new userSession();

	# build list with events and first calendardate
	$calendarList = $this->getCalendarList();
	$savedEventId=$this->userSession->getSessionData("eventId");
	$savedUserId=$this->userSession->getSessionData("userId");
	if (array_key_exists("fd_search_id", $_REQUEST)) {
	    $eventID =  $_REQUEST["fd_search_id"];
	} elseif ($savedEventId === false) {
	    $eventID = $calendarList[0]["event"]["id"];
	} else {
	    $eventId = $savedEventId;
	}
	if (array_key_exists("fd_search_userId", $_REQUEST)) {
	    $userId =  $_REQUEST["fd_search_userId"];
	} elseif ($savedUserId === false) {
	    $userId = $this->userSession->getUserId();
	} else {
	    $userId = $savedUserId;
	}
	if ($userId === false) {
	    genSetError("Je moet wel ingelogd zijn om je "
		."hiervoor op te kunnen geven");
	}

	$curRegistration = $this->getRegistration($eventID, $userId);
	if (array_key_exists("fd", $_REQUEST)) {
	    $this->processFormData($curRegistration, $_REQUEST["fd"]);
	}
	genSmartyAssign("calendarList", $calendarList);
	genSmartyAssign("curRegistration", $curRegistration);
	genSmartyDisplay("wsvl_eventregister.tpl");
    }
}

$something = new eventRegistation
?>
