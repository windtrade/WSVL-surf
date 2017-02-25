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
require_once "calendar.lib.php";
require_once "image.lib.php";

class kalenderbeheer
{
    private $event;
    private $calendar;
    private $image;
    private $userSession;

    private function dateTimeAdd($dt, $interval, $unit)
    {
	$result = $dt;
	$dto = new DateTime($dt);
	if ($unit == 'week') {
	    $unit = 'day';
	    $interval = 7*$interval;
	}
	$dto->modify("+ $interval $unit");
	$result = $dto->format('Y-m-d\TH:i:s');
	return $result;
    }

    private function copyCalendarItem($item, $cp)
    {
	$result = array();
	for ($i = 0 ; $i < $cp["count"] ; $i++) {
	    $item['start'] = $this->dateTimeAdd($item['start'], $cp['interval'], $cp['unit']);
	    $item['end'] = $this->dateTimeAdd($item['end'], $cp['interval'], $cp['unit']);
	    array_push($result, $item);
	}
	return $result;
    }
    
	
    private function isValidEvent(&$data)
    {
	$ok = true;
	if (!array_key_exists("event", $data)) {
	    genSetError("Evenement gegevens ontbreken");
	    $ok = false;
	}
	if (!array_key_exists("calendar", $data)) {
	    genSetError("Kalenderdata voor dit evenement ontbreken");
	    $ok = false;
	}
	$oldEvent = $this->userSession->getSessionData("event");
	if (array_key_exists("id", $data["event"]) && 
	    $data["event"]["id"] != $oldEvent["id"]) {
		genSetError("De gegevens zijn gecorrumpeerd");
		$ok = false;
	    }
	if (!$this->event->isValid($data["event"])) {
	    $ok = false;
	}
	$newCal = array();

	foreach($data["calendar"] as $item) {
	    $allContent = "";
	    foreach($item as $elt) $allContent .= $elt;
	    if ( $allContent == "") continue; // skip empty items
	    $item["id"] = $data["event"]["id"];
	    $item["category"] = $data["event"]["category"];
	    if (!$this->calendar->isValid($item)) {
		$ok = false;
		continue;
	    }
	    $newCal[$item["start"]] = $item;

	}
	if ($ok && array_key_exists("copy",$data)) {
	    $copies = array();
	    $cp = $data["copy"];
	    if ($cp["count"] >= 0 && $cp["count"] <= 26 &&
		$cp["interval"] >= 0 && $cp["interval"] < 10 &&
		preg_match("/^(hour|day|week|month)$/",$cp["unit"])) {
		    $copies = $this->copyCalendarItem($item, $cp);
		} else { 
		    $ok = false;
		    genSetError("ongeldige copieer gegevens: ".print_r($cp,true));
		}
	    foreach ($copies as $copy) {
		$newCal[$copy["start"]] = $copy;
	    }
	}
	if ($ok) {
	    ksort($newCal);
	    $data["calendar"] = array_values($newCal);
	}
	return $ok;
    }

    private function toForm($data) {
	if (!array_key_exists("event", $data)) $data["event"] = array();
	if (!array_key_exists("calendar", $data)) $data["calendar"] = array();

	$result = array(
	    "event" => $this->event->toForm(
		$data["event"],
		$this->userSession,
		array()),
	    "image" => $this->image->toForm(
		array(),
		$this->userSession,
		array()),
	    "calendar" => array());
	foreach ($data["calendar"] as $calendar) {
	    array_push($result["calendar"],
		$this->calendar->toForm(
		    $calendar,
		    $this->userSession,
		    array("id", "category")
		));
	}
	array_push($result["calendar"],
	    $this->calendar->toForm(
		array(),
		$this->userSession,
		array("id", "category")
	    )
	);
	return $result;
    }

    private function saveEvent(&$data)
    {
        $dt = new DateTime();
        $data["event"]["timestamp"] = $dt->format("Y-m-d H:i:s");
        $data["event"]["author_id"] = $this->userSession->getUserId();
        $data["image"]["userId"] = $this->userSession->getUserId();
        if (array_key_exists( "id", $data["event"]) &&
            $data["event"]["id"] != $this->event->getDefault("id")) {

            if (!$this->event->update(
                $this->userSession->getSessionData("event"),
                $data["event"])) return false;
            $result = $this->calendar->deleteMany(array("id" => $data["event"]["id"]));
            if (!$result) return false;
        } else {
            $result = $this->event->insert($data["event"]);
            if (!$result) return false;
            $data["event"]["id"] = $this->event->getLastId();
        }
        $data["image"]["eventId"] = $data["event"]["id"];
        $data["image"]["category"] = $data["event"]["category"];
        $data["image"]["fileField"] = "fd__image__img";
        $newImageData = $this->image->insert($data["image"]);
        if ($newImageData) {
            $oldEvent = $data["event"];
            $data["image"] = $newImageData;
            $data["event"]["image"] = $data["image"]["id"] =
                $this->image->getLastId();
            $this->event->update($oldEvent, $data["event"]);
        }
        unset($data["image"]["fileField"]);
        foreach ($data["calendar"] as $calendar) {
            $calendar["id"] = $data["event"]["id"];
            $calendar["category"] = $data["event"]["category"];
            $result = $this->calendar->insert($calendar);
            if (!$result) return false;
        }
        $this->event->initQuery();
        $this->event->addTerm("id", '=', $data["event"]["id"]);
        $result = $this->event->readQuery();
        if ($result) {
            $new = $this->event->fetch_assoc($result);
            $data["event"] = $new;
        } else {
            genSetError("Nix gelezen");
        }
    }

    public function getEventList($start)
    {
        $result = array();
        $this->event->initQuery();
        if ($start >0) {
            $this->event->addTerm("id", "<", $start);
        } else {
            $whereArray = array();
        }
        $this->event->addOrderTerm("id", "DESC");
        $query = $this->event->readQuery();
        if ($query) {
            $i = 0;
            $result = $this->event->fetch_assoc_all($query);
        }
        return $result;
    }

    /**
     * @param $fd associate array [event][id] = key
     * @return bool true: successful
     */
    private function getEvent(&$fd) {
        if (!array_key_exists("event", $fd) ||
            !array_key_exists("id", $fd["event"])) {
            genSetError(__FUNCTION__.": missing event id");
            return false;
        }
        $whereArr = array();
        $this->addTerm($whereArr, 'id', '=', $fd['event']['id']);
        $query = $this->event->readQuery($whereArr);
        if (!$query) {
            return false;
        }
        $events= $this->event->fetch_assoc($query);
        $nrRows = count($events);
        if ($nrRows == 1) {
            $fd["event"] = $events[0];
        } else {
            genSetError(__FUNCTION__.": Event ".$fd["event"]["id"]." $nrRows x gevonden");
            return false;
        }
        // where clause does not change :-)
        $query = $this->calendar->readQuery($whereArr);
        if (!$query) {
            return false;
        }
        $fd["calendar"] =  $this->calendar->fetch_assoc($query);
        return true;
    }
	
    public function __construct()
    {
	$this->event = new event();
	$this->calendar = new calendar();
	$this->image = new image();
	$this->userSession = new userSession();
	$data = array(
	    "event" => array(),
	    "calendar" => array(),
	    "copy" => array());

	if (array_key_exists("action", $_REQUEST)) {
	    $action = $_REQUEST["action"];
	} else {
	    $action = "";
	}
    
    $currentId = 0;
	if (array_key_exists("fd", $_REQUEST)) {
	    $formData = $_REQUEST["fd"];
	    if (array_key_exists("event", $formData)) {
		switch ($action) {
		case "saveEvent":
		    if ($this->isValidEvent($formData))
			$this->saveEvent($formData);
		    $currentId = $formData["event"]["id"];
		    break;
		case "showEvent":
		    $this->getEvent($formData);
		    $currentId = $formData["event"]["id"];
		    break;
		case "deleteEvent":
		    $this->deleteEvent($formData);
		    $currentId = 0;
		    break;
		default:
		    $currentId = $formData["event"]["id"];
		    break;
		}
	    } else {
		$formData = array("event" => array( "id" => $this->event->getDefault("id")));
	    }
	} else {
	    $formData = array("event" => array( "id" => $this->event->getDefault("id")));
	}
	$this->userSession->setSessionData("event", $formData["event"]);
	$data = $this->toForm($formData);
	genAddJavascriptFile("formhandling");
	genSmartyAssign("eventList", $this->getEventList($formData["event"]["id"]));
	genSmartyAssign("currentId", $formData["event"]["id"]);
	genSmartyAssign("data", $data);
	genSmartyDisplay("wsvl_kalenderBeheer.tpl");
    }
}

$something = new kalenderbeheer();
?>
