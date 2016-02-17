<?php

/**
 * @author Huug Peters
 * @copyright 2015
 * libraryTest.php
 */
 require_once "library/all_config.inc.php";
 require_once "general.lib.php";
 require_once "teksten.lib.php";
 
 genLogVar('$_REQUEST', $_REQUEST);
 
 genDumpvar("menuItem",genGetMenuItem("informatie.php","tarieven"));
 
 $teksten = new teksten();
 
 $tekst = $teksten->getTekst(33);
 
 $data= $tekst["tekst"];
 genDumpvar('$_server', $_SERVER);
 
genSmartyAssign("data", $data);
genSmartyDisplay('wsvl_testFunction.tpl')

?>