<?php

/**
 * @author Huug Peters
 * @copyright 2016
 */
require_once "library/all_config.inc.php";
require_once "general.lib.php";
require_once "userSession.lib.php";
genLogVar(__file__ . ":" . "request", $_REQUEST);
if (!array_key_exists("JSON", $_REQUEST) || !array_key_exists("action", $_REQUEST)) {
    genLogVar(__file__ . ":" . "lost request", $_REQUEST);
    exit;
}

/**
 * return HTML for the menu without enclosing DIV
 */
function buildMenu($hE)
{
    /** Smarty part of the interface is kindly ignored */
    $response["menu"] = $hE->HEcssmenu(array("menu" => genGetMenu("mainMenu")), $dummySmarty);
    genJSONResponse($response);
}

/**
 * User must be logged in [ and have the proper role ]
 * roles are not centrally administrated, the pages will/should
 * kick any unauthorized visitor out
 */
function checkAuthority($uS)
{
    $mustLogin = false;
    genLogVar(__file__ . ":" . __function__ . ":" . '$_GET', $_GET);
    $authorized = array_key_exists("targetURL", $_GET);
    if ($authorized) {
        $mustLogin = genGetMustLogin($_GET["targetURL"]);
    }
    /** not yet implemented
     * $requiredRole = genRequiredRole($_GET["targetURL"]);
     */
     $isLoggedIn = $uS->isLoggedIn();
     if ($mustLogin && !$isLoggedIn) {
        genSetError("Je bent niet meer aangemeld");
     }
    $authorized = $authorized && (!$mustLogin || $isLoggedIn);
    //genLogVar(__FILE__.":".__LINE__, array(
    //"authorized" => $authorized,
    //"mustLogin" => $mustLogin,
    //"isLoggedIn" => $uS->isLoggedIn(false)));

    /** not yet implemented
     * $authorized = $authorized && $uS->hasRole($requiredRole);
     */
    if (!$authorized) {
        genSetError("Log eerst even in, voor je verder gaat");
    }
    $response = array("status" => true, "authorized" => $authorized);
    genJSONResponse($response);
}

$uS = new userSession();
$hE = new htmlElements();
switch ($_REQUEST["action"]) {
    case "JSONlogin":
        $uS->JSONlogin();
        break;
    case "JSONlogout":
        $uS->JSONlogout();
        break;
    case "JSONauthority":
        checkAuthority($uS);
    case "JSONmenu":
        buildMenu($hE);
        break;
}

?>  