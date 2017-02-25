<?php

/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 17-1-2017
 * Time: 19:41
 */
require_once'..\..\..\all_config.inc.php';
require_once '..\library\event.lib.php';

class eventTest extends PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $event = new event();
        $example = $event->get(61, true);
        assert($example !== false, "get event");
        assert(strpos($example['detail'], '<p>') >= 0, "HTML converted");
    }

}
