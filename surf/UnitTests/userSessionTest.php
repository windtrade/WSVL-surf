<?php

/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 5-2-2017
 * Time: 19:03
 */
require_once '../../../all_config.inc.php';
require_once '../library/general.lib.php';
require_once '../library/userSession.lib.php';
class userSessionTest extends PHPUnit_Framework_TestCase
{
    public function testDoLogin()
    {
        $_SERVER["REMOTE_ADDR"] = "1.2.3.4";
        $testPassword = 'test';
        $uS = new userSession();
        $u = new users();
        $newUser = $user = $u->get(1);
        assert($user, "user to test with");
        $newUser['wachtwoord'] = $testPassword;
        $newUser['nick'] = 'nick';
        $newUser['email'] ="mail@domain.org";
        assert($u->update($user, $newUser), 'setting password');
        $_REQUEST['login'] = $newUser['nick'];
        $_REQUEST['password'] = $testPassword;
        $uS->login();
        assert($uS->isLoggedIn(), "login with nick");


    }
}
