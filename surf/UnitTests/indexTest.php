<?php

/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 22-2-2017
 * Time: 20:57
 */
require_once '../surf/index.php';

class indexTest extends PHPUnit_Framework_TestCase
{
public function testBuildHotNews(){
    $index = new Index();
    $hotNews = $index->buildHotNews();
    assert(count($hotNews) > 0, __FUNCTION__."nothing found");
}
public function testBuildAboutUs(){

}
public function testBuildNewsList(){
    $index = new Index();
    $hotNews = $index->buildHotNews();
    $otherNews = $index->buildNewsList($hotNews);
    assert(count($otherNews) > 0, __FUNCTION__."nothing found");
    $hotIds = array();
    $newsIds = array();
    foreach ($hotNews as $news) { array_push($hotIds, $news["news_id"]);}
    foreach ($otherNews as $news) { array_push($newsIds,$news["news_id"]);}
    foreach ($hotIds as $hotId) {
        assert(array_search($hotId, $otherNews) === false, __FUNCTION__." duplicate");
    }

}
}
