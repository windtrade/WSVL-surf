<?php
/*
 * event_presence.lib.php
 *
 * class to access event presence table
 *
 * 03-01-2014 : Huug : Creation
 */
require_once "table.lib.php";

class EventPresence extends table
{
    private $tbDefine = "SQL_TBEVENTPRESENCE";

    protected $structure = array(
	"eventId" => array(
	    "label" => "Evenement id",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "1",
	    "type" => "number",
	    "check" => ""),
	"eventStart" => array(
	    "label" => "Evenement Aanvang",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "datetime-local",
	    "check" => ""),
	"userId" => array(
	    "label" => "Deelnemer id",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "1",
	    "type" => "number",
	    "check" => ""),
	"userRole" => array(
	    "label" => "Functie",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "number",
	    "check" => ""),
	"registered" => array(
	    "label" => "Aangemeld",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "boolean",
	    "check" => ""),
	"present" => array(
	    "label" => "Aanwezig",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "boolean",
	    "check" => "")
	);

    public function getUserCalendar($userId, $start)
    {
	$retval = array();
	$query = $this->readQuery(
	    array(
		array("col"=>"userId", "oper"=>"=","val"=>$userId),
		array("col"=>"eventStart", "oper"=>">=","val"=>$start)
	    ),
	    array("eventStart" => "ASC", "eventId" => "ASC")
	);
	if (!$query) {
	    $this->tbError(NULL);
	    return $retval;
	}
	while ($row = $this->fetch_assoc($query)) {
	    array_push($retval, $row);
	}
	return $retval;
    }

    public function __construct()
    {
	if (defined($this->tbDefine)) {
	    parent::__construct(SQL_TBEVENTPRESENCE);
	} else {
	    genSetError($this->tbDefine." not defined");
	}
    }
}

?>
