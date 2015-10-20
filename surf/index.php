<?php
/*
 * index.php
 *
 * Front page of Surf dpt.
 * 20-12-2012 Huug (Re)Creation
 */
error_reporting(E_ALL);
session_start();
require_once "library/all_config.inc.php";
require_once "general.lib.php";
require_once "database.lib.php";
require_once "image.lib.php";
require_once "news.lib.php";
require_once "teksten.lib.php";

function buildHotNews($newsObj)
{
    $img = new image();
    $hotNews = array();
    $result = $newsObj->getHot();
    if ($result) {
	while ($item = mysql_fetch_assoc($result)) {
	    if ($item["news_image"]) {
		$item["news_image"] =
		    $img->getUrl($item["news_image"], "small" );
	    } else {
		$item["news_image"] = "";
	    }
	    array_push( $hotNews, $item);
	}
    }
    genSmartyAssign("hotNews", $hotNews);
    return $hotNews;
}
function buildAboutUs($tekstenObj)
{
	$result = $tekstenObj->readSelect(
		array("id" => TEKSTEN_ID_ABOUT_US,
		"rubriek_id" => TEKSTEN_RUBRIEK_ID_GENERAL));
	if ($result) {
		$item = mysql_fetch_assoc($result);
	} else {
		$item = array("tekst" => "Niet beschikbaar");
	}
	genSmartyAssign("aboutUs", $item["tekst"]);
}

function buildNewsList(&$newsObj, $hotNews)
{
	$newsItems = array();
	$result = $newsObj->getPublic();
	if ($result) {
		while ($item = mysql_fetch_assoc($result)) {
			if ($item["news_image"]) {
				$item["news_image"] =
					IMAGE_ROOT_URL."news/". 
					$item["news_id"]."small.jpg";
			} else {
				$item["news_image"] = "";
			}
			for ($i = 0; $i < count($hotNews); $i++) {
				if ($hotNews[$i]["news_id"] == $item["news_id"]) {
					break;
				}
			}
			if ($i >= count($hotNews)) array_push( $newsItems, $item);
			# limited news list
			if (count($newsItems) > 20) {
			    break;
			}
		}
	}
	genSmartyAssign("newsItems", $newsItems);
}

$newsObj = new news();
$tekstenObj = new teksten();
$hotNews = buildHotNews($newsObj);
buildAboutUs($tekstenObj);
buildNewsList($newsObj, $hotNews);
genSmartyDisplay('wsvl_Home.tpl');
?>
