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

class Index
{
    
    private $news;
    private $teksten;
    function __construct()
    {
        $this->news = new News();
        $this->teksten = new Teksten();
    }

    function buildHotNews()
    {
        $img = new image();
        $hotNews = array();
        $result = $this->news->getHot();
        if ($result) {
            while ($item = $this->news->fetch_assoc($result)) {
                if ($item["news_image"]) {
                    $item["news_image"] =
                        $img->getUrl($item["news_image"], "small" );
                } else {
                    $item["news_image"] = "";
                }
                array_push( $hotNews, $item);
            }
        };
        return $hotNews;
    }
    function buildAboutUs()
    {
        $this->teksten->readSelect(array(
            "id" => TEKSTEN_ID_ABOUT_US,
            "rubriek_id" => TEKSTEN_RUBRIEK_ID_GENERAL));
        $result = $this->teksten->readQuery();
        if ($result) {
            $items = $this->teksten->fetch_assoc_all($result);
            $item = array_shift($items);
        } else {
            $item = array("tekst" => "Niet beschikbaar");
        }
        genSmartyAssign("aboutUs", $item["tekst"]);
    }

    function buildNewsList($hotNews)
    {
        $newsItems = array();
        $result = $this->news->getPublic();
        $hotIds = array();
        foreach ($hotNews as $item) {
            array_push($hotIds, $item['news_id']);
        }
        if ($result) {
            while ((count($newsItems) < 20) && $item = $this->news->fetch_assoc($result)) {
                if ($item["news_image"]) {
                    $item["news_image"] =
                        IMAGE_ROOT_URL."news/".
                        $item["news_id"]."small.jpg";
                } else {
                    $item["news_image"] = "";
                }
                if (array_search($item["news_id"], $hotIds) === false) {
                    array_push($newsItems, $item);
                }
            }
        }
        return $newsItems;
    }

    public function displayPage()
    {
        $hotNews = $this->buildHotNews();
        $this->buildAboutUs();
        $newsList = $this->buildNewsList($hotNews);
        if (count($hotNews) == 0) {
            array_push($hotNews, array_shift($newsList));
        }
        genSmartyAssign("newsItems", $newsList);
        genSmartyDisplay('wsvl_Home.tpl');
    }
}

(new Index())->displayPage();