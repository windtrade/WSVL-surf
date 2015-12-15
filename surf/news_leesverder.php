<?php
/*
* news_leesverder.php
*
* display single newsitem amd overview of more news
* 18-03-2012 Huug Creation
* 
*/
error_reporting(E_ALL);
session_start();
require_once "library/all_config.inc.php";
require_once "general.lib.php";
require_once "database.lib.php";
require_once "news.lib.php";
require_once "image.lib.php";

function buildNewsItem($newsObj, &$newsArr)
{
    genSmartyAssign("news_id", "");
    genSmartyAssign("news_title", "");
    genSmartyAssign("news_short", "");
    genSmartyAssign("news_message", "");
    genSmartyAssign("news_date", "");
    genSmartyAssign("news_image", "");
    genSmartyAssign("news_imgUrl", "");
    $img = new image();
    if (!isset($_REQUEST["news_id"])) {
        genSetError("Geen nieuwsbericht gekozen");
        return;
    }
    $newsKey["news_id"] = $_REQUEST["news_id"];

    $result = $newsObj->readSelect($newsKey);
    if (!$result) {
        genSetError("Nieuwsbericht niet gevonden");
        return;
    }
    $newsArr = $newsObj->get4HTML($_REQUEST["news_id"]);
    if ($newsArr === false)
        $newsArr = array();
    $newsArr["news_img_url"] = "";
    if ($newsArr["news_image"] > 0) {
        $newsArr["news_imgUrl"] = $img->getUrl($newsArr["news_image"], "large");
    }
    genSmartyAssign("news_id", $newsArr["news_id"]);
    genSmartyAssign("title", $newsArr["news_title"]);
    genSmartyAssign("news_title", $newsArr["news_title"]);
    if ($newsArr["news_short"] != "") {
        $description = $newsArr["news_short"];
    } else
        if ($newsArr["news_message"] != "") {
            $description = $newsArr["news_message"];
        }
    if (strlen($description) >= 100) {
        $description = mb_substr($desciption, 0, 96) . " ...";
    }
    genSmartyAssign("description", $description);

    genSmartyAssign("news_short", $newsArr["news_short"]);
    genSmartyAssign("news_message", $newsArr["news_message"]);
    genSmartyAssign("news_date", $newsArr["news_timestamp"]);
    genSmartyAssign("image", $newsArr["news_image"]);
    genSmartyAssign("news_image", $newsArr["news_image"]);
    genSmartyAssign("news_imgUrl", $newsArr["news_imgUrl"]);
}

function buildNewsList($newsObj, $newsArr)
{
    $newsIds = array();
    $newsTitles = array();

    // For ze fjoetuur
    // $startDate = $endDate = $newsArr["news_timestamp"];

    $now = new DateTime();
    $now = $now->format('Y-m-d H:i:s');
    $stopAt = new DateTime();
    $stopAt->modify('-2 year');
    $stopAt = $stopAt->format("Y-01-01 00:00:00");
    $whereArr = array(array(
            "col" => "news_hotFrom",
            "oper" => "<=",
            "val" => $now));
    $result = $newsObj->readQuery($whereArr, array("news_hotFrom" => "DESC"));
    if ($result) {
        while ($news = $newsObj->fetch_assoc($result)) {
            if ($news["news_hotFrom"] < $stopAt)
                break;
            array_push($newsIds, $news["news_id"]);
            array_push($newsTitles, $news["news_title"]);
        }
    }
    genSmartyAssign("newsIds", $newsIds);
    genSmartyAssign("newsTitles", $newsTitles);
}

$newsObj = new news();
$newsArr = array();
buildNewsItem($newsObj, $newsArr);
buildNewsList($newsObj, $newsArr);
genSmartyDisplay('wsvl_newsLeesverder.tpl');
?>
