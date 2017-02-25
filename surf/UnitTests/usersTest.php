<?php

/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 31-1-2017
 * Time: 22:26
 */
require_once '../../../all_config.inc.php';
require_once '../library/general.lib.php';
require_once '../library/users.lib.php';

class usersTest extends PHPUnit_Framework_TestCase
{
    public function testPassword()
    {
        $users = new users();
        $arr["password"] = $users->randomPassword();
        assert($arr["password"] != "", "Random password");
        $arr["wachtwoord"] = $arr["password"];
        $orig = $arr["wachtwoord"];
        $users->pwEncrypt($arr);
        assert($arr["wachtwoord"] != $orig, "pwdEncrypt fails");
        assert($arr["password"] == $orig, "pwdEncrypt too much");
    }

    public function testGetClan()
    {
        $users =  new users();
        $clan = $users->getClan(1);
        assert($clan !== false, "getClan");
        $start = $users->get(1);
        foreach($clan as $user) {
            assert(
                (strtolower($start["email"]) == strtolower($user["email"])) ||
                (strtolower($start["email"]) == strtolower($user["emailOuder"])) ||
                (strtolower($start["emailOuder"]) == strtolower($user["emailOuder"])) ||
                (strtolower($start["emailOuder"]) == strtolower($user["email"])),
                "getClan mail test"
            );
        }
    }

    public function testNonExistentColumn()
    {
        $users = new users();
        $exceptionThrown = false;
        try {
            $users->readSelect(array('piet' => 'gek'));
        } catch (Exception $e) {
            $exceptionThrown = true;
        }
        assert($exceptionThrown, "Odd column not refused");
    }

    public function testUpdate() {
        $users = new users();
        $user = $users->get(1);
        $oldUser = $user;
        $newUser = $user;
        $newUser['naam'] .= "Updated";
        assert($users->update($oldUser, $newUser),get_class($users)." update");
        $user = $users->get(1);
        assert($user['naam'] == $newUser['naam'], get_class($users)." updated content");
        assert($users->update($user, $oldUser),get_class($users)." update restore");
    }
}
