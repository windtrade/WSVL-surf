<?php
/*
 * showPersonal.php
 *
 * Personal page of Surf dpt.
 * 20-12-2012 Huug (Re)Creation
 */
error_reporting(-1);
session_start();
require_once "library/all_config.inc.php";
require_once "general.lib.php";
require_once "database.lib.php";
require_once "users.lib.php";
require_once "user_roles.lib.php";
require_once "userSession.lib.php";

class showPersonal
{
	public function __construct()
	{
	
		$uS = new userSession();
		genSmartyDisplay("wsvl_showPersonal.tpl");
	}
}
$sp = new showPersonal();
?>
