<?php

/**
 * @author Windtrade, Huug Peters
 * @copyright 2015
 *
 * This page expects formdata structured like this\
 * fd__group__news__<newsfield>
 * ...   
 */
require_once "library/all_config.inc.php";
require_once "general.lib.php";
require_once "news.lib.php";
require_once "image.lib.php";

class nieuwsBeheer
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
            $interval = 7 * $interval;
        }
        $dto->modify("+ $interval $unit");
        $result = $dto->format('Y-m-d\TH:i:s');
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
        if (array_key_exists("news_id", $data["news"]) && $data["news"]["news_id"] != $oldNews["news_id"]) {
            genSetError("De gegevens zijn gecorrumpeerd");
            $ok = false;
        }
        if (!$this->news->isValid($data["news"])) {
            $ok = false;
        }
        return $ok;
    }

    private function toForm($data)
    {
        if (!array_key_exists("news", $data))
            $data["news"] = array();
        $result = array("news" => $this->news->toForm($data["news"], $this->userSession,
                array()), "image" => $this->image->toForm(array(), $this->userSession, array()));
        return $result;
    }

    private function saveNews(&$data)
    {
        $dt = new DateTime();
        $data["news"]["news_updatedBy"] = $this->userSession->getUserId();
        $data["image"]["userId"] = $this->userSession->getUserId();
        if (array_key_exists("news_id", $data["news"]) && $data["news"]["news_id"] != $this->
            news->getDefault("news_id")) {

            if (!$this->news->update($this->userSession->getSessionData("news"), $data["news"]))
                return false;
        } else {
            $data["news"]["news_author_id"] = $this->userSession->getUserId();
            $result = $this->news->insert($data["news"]);
            if (!$result)
                return false;
            $data["news"]["news_id"] = $this->news->getLastId();
        }
        $oldNews = $this->news->get($data["news"]["news_id"]);
        $data["image"]["eventId"] = $data["news"]["news_event_id"];
        if ($data["image"]["category"] != general::NONE) {
            $data["image"]["category"] = $data["news"]["news_rubriek_id"];
        }
        $data["image"]["fileField"] = "fd__image__img";
        $newImageData = $this->image->insert($data["image"]);
        if ($newImageData) {
            $data["image"] = $newImageData;
            $data["news"]["news_image"] = $this->image->getLastId();
            $this->news->update($oldNews, $data["news"]);
        }
        unset($data["image"]["fileField"]);
        $this->news->initQuery();
        $this->news->addTerm("news_id", '=', $data["news"]["news_id"]);
        $result = $this->news->readQuery();
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
        if ($start > 0) {
            $whereArray = array(array(
                    "col" => "news_id",
                    "oper" => "<",
                    "val" => $start));
        } else {
            $whereArray = array();
        }
        $orderArray = array("news_id" => "DESC");
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
        if (!array_key_exists("news", $fd) || !array_key_exists("news_id", $fd["news"])) {
            genSetError(__function__ . ": missing news id");
            return false;
        }
        $query = $this->news->readQuery(array(array(
                'col' => 'news_id',
                'oper' => '=',
                'val' => $fd["news"]["news_id"])));
        if ($query) {
            $items = $this->news->fetch_assoc($query);
            $nrRows = count($items);
            if ($nrRows == 1) {
                $fd["news"] = $items[0];
            } else
                if ($nrRows == 0) {
                    genSetError(__function__ . ": News " . $fd["news"]["news_id"] . " niet gevonden");
                    return false;
                } else {
                    genSetError(__function__ . ": News " . $fd["news"]["news_id"] . " $nrRows x gevonden");
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
        $data = array("news" => array());

        if (array_key_exists("action", $_REQUEST)) {
            $action = $_REQUEST["action"];
        } else {
            $action = "";
        }
        $formData = array("news" => array());
        $formData["news"]["news_id"] = $this->news->getDefault("news_id");
        foreach ($_GET as $key => $val) {
            if (preg_match("/^news_/", $key)) {
                $formData["news"][$key] = $val;
            }
        }
        if (array_key_exists("fd", $_REQUEST)) {
            $formData = $_REQUEST["fd"];
            if (array_key_exists("id", $formData)) {
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
            }
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

$something = new nieuwsBeheer();
?>