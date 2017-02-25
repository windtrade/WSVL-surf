<?php

/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 26-1-2017
 * Time: 22:54
 */
require_once '../../../all_config.inc.php';
require_once '../library/news.lib.php';

class newsTest extends PHPUnit_Framework_TestCase
{
    public function testGet() {
        $news = new news();
        $result = $news->get(17);
        assert($result != false,  get_class($news).'::get');
        foreach ($news->getColumns() as $column) {
            assert(
                isset($result[$column]), get_class($news).'::get 1 - '.$column
            );
            assert(
                $result[$column] !== null, get_class($news).'::get 2 - '.$column
            );
        }
    }

    public function testGetFunctions()
    {
        $news = new news();
        $sth = $news->getHot();
        $result = $news->fetch_assoc_all($sth);
        $today = (new DateTime())->format("Y-m-d");
        $tomorrow = (new DateTime('tomorrow'))->format("Y-m-d");
        foreach ($result as $r) {
            assert($r['news_hotFrom'] <= $tomorrow, get_class($news).'::getHot()(hotFrom)');
            assert($r['news_hotTo'] >= $today, get_class($news).'::getHot()(hotTo)');
        }

        $sth = $news->getPublic();
        $result = $news->fetch_assoc_all($sth);
        $tomorrow = (new DateTime('tomorrow'))->format("Y-m-d");
        foreach ($result as $r) {
            assert($r['news_hotFrom'] <= $tomorrow, get_class($news).'::getHot()(hotFrom)');
        }

        $sth = $news->getAll();
        $result = $news->fetch_assoc_all($sth);
        $lastNews_id = 1024*1024*1024;
        foreach ($result as $r) {
            assert($r['news_id'] <= $lastNews_id, get_class($news) . '::getHot()(hotFrom)');
            $lastNews_id = $r['news_id'];
        }
    }

}
