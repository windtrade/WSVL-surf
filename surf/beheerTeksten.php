<?php

/**
 * @author Huug Peters
 * @copyright 2016
 */

require_once "library/all_config.lib";
+
require_once "general.lib.php";
require_once "teksten.lib.php";

class beheerTekst
{
    private $userSession;
    private $teksten;
    
    public function __construct() {
        $this->userSession = new userSession();
        $this->teksten = new teksten();
        $authorized = genIsAuthorized();
        $fd = genGetFormdata(array("teksten" => array()));
    }

}

?>