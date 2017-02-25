<?php

/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 17-1-2017
 * Time: 22:36
 */
require_once'..\..\..\all_config.inc.php';
require_once '..\library\eventregister.lib.php';

class eventregisterTest extends PHPUnit_Framework_TestCase
{
    public function testInsertUpdateAndGet()
    {
        $er = new eventregister();
        $register = array(
            'id' => 66,
            'userId' => 1,
            'start' => "2014-11-23 11:00",
            'enrolled' => 1
        );
        assert($er->insertOrUpdate($register), "eventregister insert");
        $stored = $er->get($register['id'], $register['start'], $register['userId'] );
        assert($stored && is_array($stored) && $stored['enrolled'], "eventregister get");
        $register['enrolled'] = 0;
        assert($er->insertOrUpdate($register), "eventregister insert");
        $stored = $er->get($register['id'], $register['start'], $register['userId'] );
        assert($stored && is_array($stored) && !$stored['enrolled'], "eventregister get");
    }

    public function testRegister(){

        $er = new eventregister();
        $rg = array(
            'id' => 66,
            'userId' => 1,
            'start' => "2014-11-23 11:00",
            'enrolled' => 1
        );
        assert($er->register($rg['id'], $rg['start'], $rg['userId'], $rg['enrolled']), "register");$rg = array(
            'id' => 66,
            'userId' => 100000,
            'start' => "2014-11-23 11:00",
            'enrolled' => 0
        );
        assert($er->register($rg['id'], $rg['start'], $rg['userId'], $rg['enrolled']), "register");
    }
}
