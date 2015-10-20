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
	$newsArr = mysql_fetch_assoc($result);
	$newsArr["news_img_url"] = "";
	if ($newsArr["news_image"] > 0) {
	    $newsArr["news_imgUrl"] = $img->getUrl(
		$newsArr["news_image"], "large");
	}
	genSmartyAssign("news_id", $newsArr["news_id"]);
	genSmartyAssign("news_title", $newsArr["news_title"]);
	genSmartyAssign("news_short", $newsArr["news_short"]);
	genSmartyAssign("news_message", $newsArr["news_message"]);
	genSmartyAssign("news_date", $newsArr["news_timestamp"]);
	genSmartyAssign("news_image", $newsArr["news_image"]);
	genSmartyAssign("news_imgUrl", $newsArr["news_imgUrl"]);
}

function buildNewsList($newsObj, $newsArr)
{
	$newsIds = array();
	$newsTitles = array();

	// For ze fjoetuur
	// $startDate = $endDate = $newsArr["news_timestamp"];

	$result = $newsObj->readSelectOrdered(
		array(),
		array ("news_id" => "DESC"));
	if ($result) {
		while ($news = mysql_fetch_assoc($result)) {
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
