<?php

/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 15-1-2017
 * Time: 22:12
 */
require_once'..\..\..\all_config.inc.php';
require_once '..\library\user_roles.lib.php';

define("TESTUSERROLE_USER_ID",100000);

class user_rolesTest extends PHPUnit_Framework_TestCase
{
    public function testGetUsersWithRoles()
    {
        $user_roles = new user_roles();
        assert(count($user_roles->getUsersWithRoles("ORGANISER")) > 0, "getUsersWithRoles");
    }

    public function testHasRole()
    {
        $user_roles = new user_roles();
        assert($user_roles->hasRole(1, "SYSTEM"), "hasRole");
    }

    public function testGetRoles()
    {
        $user_roles = new user_roles();
        $userWithRoles = $user_roles->getRoles(1);
        assert (count($userWithRoles) == 6, "getRoles");
        assert($userWithRoles['user_id'] == 1);
    }

    public function testInsert() {
        $user_roles = new user_roles();
        $definedRoles =  $user_roles->definedRoles();
        foreach ($definedRoles as $definedRole) {
            assert($user_roles->insert(array("user_id" => TESTUSERROLE_USER_ID, "role" => $definedRole)), "insert role ".$definedRole);
        }
        foreach ($user_roles->definedRoles() as $definedRole) {
            assert($user_roles->hasRole(TESTUSERROLE_USER_ID, $definedRole), "Missing role ".$definedRole);
        }

    }

    function testDeleteAll()
    {
        $user_roles = new user_roles();
        $old  = $user_roles->getRoles(TESTUSERROLE_USER_ID);
        assert(count($old) > 1, "No roles for user");
        $user_roles->deleteAll(TESTUSERROLE_USER_ID);
        $new = $user_roles->getRoles(TESTUSERROLE_USER_ID);
        assert(count($new) == 1, "Not all roles deleted");
    }
}
