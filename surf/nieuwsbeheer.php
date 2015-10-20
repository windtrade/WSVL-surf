<?php
#
# This page expects formdata structured like this
# fd__group__news__<newsfield>
# ...
# fd__group___newsdate__<nr>__<newsdatefield>
# ...
require_once "library/all_config.inc.php";
require_once "general.lib.php";
require_once "news.lib.php";
require_once "image.lib.php";

class kalenderbeheer
{
    private $news;
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
    
	
    private function isValidNews(&$data)
    {
	$ok = true;
	if (!array_key_exists("news", $data)) {
	    genSetError("Evenement gegevens ontbreken");
	    $ok = false;
	}
	$oldNews = $this->userSession->getSessionData("news");
	if (array_key_exists("news_id", $data["news"]) && 
	    $data["news"]["news_id"] != $oldNews["news_id"]) {
		genSetError("De gegevens zijn gecorrumpeerd");
		$ok = false;
	    }
	if (!$this->news->isValid($data["news"])) {
	    $ok = false;
	}
	return $ok;
    }

    private function toForm($data) {
	if (!array_key_exists("news", $data)) $data["news"] = array();
	$result = array(
	    "news" => $this->news->toForm(
		$data["news"],
		$this->userSession,
		array()),
	    "image" => $this->image->toForm(
		array(),
		$this->userSession,
		array()));
	return $result;
    }

    private function saveNews(&$data)
    {
	$dt = new DateTime();
	$data["news"]["news_updatedBy"] = $this->userSession->getUserId();
	$data["image"]["userId"] = $this->userSession->getUserId();
	if (array_key_exists( "news_id", $data["news"]) && 
	    $data["news"]["news_id"] != $this->news->getDefault("news_id")) {

	    if (!$this->news->update(
		$this->userSession->getSessionData("news"),
		$data["news"])) return false;
	} else {
	    $data["news"]["news_author_id"] = $this->userSession->getUserId();
	    $result = $this->news->insert($data["news"]);
	    if (!$result) return false;
	    $data["news"]["news_id"] = $this->news->getLastId();
	}
	$oldNews = $this->news->get($data["news"]["news_id"]);
	$data["image"]["eventId"] = $data["news"]["news_event_id"];
	if ($data["image"]["category"] != general::NONE) {
	    $data["image"]["category"] = $data["news"]["news_rubriek_id"];
	}
	$data["image"]["fileField"] = "fd__image__img";
	if ($this->image->insert($data["image"])) {
	    $data["news"]["news_image"] = $this->image->getLastId();
	    $this->news->update($oldNews, $data["news"]);
	}
	unset($data["image"]["fileField"]);
	$result = $this->news->readSelect(array("news_id" => $data["news"]["news_id"]));
	if ($result) {
	    $new = $this->news->fetch_assoc($result);
	    $data["news"] = $new;
	} else {
	    genSetError("Nix gelezen");
	}
    }

    private function getNewsList($start)
    {
	$result = array();
	if ($start >0) {
	    $whereArray = array(
		array(
		    "col" => "news_id",
		    "oper" => "<",
		    "val" => $start
		)
	    );
	} else {
	    $whereArray = array();
	}
	$orderArray = array(
	    "news_id" =>  "DESC"
	);
	$query = $this->news->readQuery($whereArray, $orderArray);
	if ($query) {
	    $i = 0;
	    while (($i < 20) && ($row = $this->news->fetch_assoc($query))) {
		array_push($result, $row);
		$i++;
	    }
	}
	return $result;
    }
    
    private function getNews(&$fd)
    {
	if (!array_key_exists("news", $fd) ||
	    !array_key_exists("news_id", $fd["news"])) {
		genSetError(__FUNCTION__.": missing news id");
		return false;
	    }
	$query = $this->news->readQuery(array(array(
	    'col' => 'news_id',
	    'oper' => '=',
	    'val' => $fd["news"]["news_id"])));
	if ($query) {
	    $nrRows= mySql_num_rows($query);
	    if ($nrRows == 1) {
		$fd["news"] = $this->news->fetch_assoc($query);
	    } else if ($nrRows == 0) {
		genSetError(__FUNCTION__.": News ".$fd["news"]["news_id"]." niet gevonden");
		return false;
	    } else {
		genSetError(__FUNCTION__.": News ".$fd["news"]["news_id"]." $nrRows x gevonden");
		return false;
	    }
	}
	return true;
    }

	
    public function __construct()
    {
	$currentId = -1; // undefined
	$this->news = new news();
	$this->image = new image();
	$this->userSession = new userSession();
	$data = array(
	    "news" => array());

	if (array_key_exists("action", $_REQUEST)) {
	    $action = $_REQUEST["action"];
	} else {
	    $action = "";
	}
	if (array_key_exists("fd", $_REQUEST)) {
	    $formData = $_REQUEST["fd"];
	    if (array_key_exists("id",$formData)) {
		$currentId = $formData["id"];
	    }
	    if (array_key_exists("news", $formData)) {
		switch ($action) {
		case "saveNews":
		    if ($this->isValidNews($formData))
			$this->saveNews($formData);
		    break;
		case "showNews":
		    $this->getNews($formData);
		    break;
		case "deleteNews":
		    $this->deleteNews($formData);
		    break;
		default:
		    break;
		}
	    } else {
		$formData = array("news" => array( "news_id" => $this->news->getDefault("news_id")));
	    }
	} else {
	    $formData = array("news" => array( "news_id" => $this->news->getDefault("news_id")));
	}
	$this->userSession->setSessionData("news", $formData["news"]);
	$data = $this->toForm($formData);
	genAddJavascriptFile("formhandling");
	genSmartyAssign("newsList", $this->getNewsList($currentId));
	genSmartyAssign("currentId", $currentId);
	genSmartyAssign("data", $data);
	genSmartyDisplay("wsvl_nieuwsBeheer.tpl");
    }
}

$something = new kalenderbeheer();
?>
