<?php
/*
 * eventregister.lib.php
 *
 * class to access Event Register table
 *
 * 19-02-2014 : Huug	: Creation
 */
require_once "table.lib.php";

class eventregister extends table
{
    private $tbDefine="SQL_TBEVENTREGISTER";

    protected $structure = array(
	"id" => array(
	    "label" => "Evenementnr.",
	    "default" => "Nieuw",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "number",
	    "protected" => "1",
	    "check" => ""),
	"start" => array(
	    "label" => "Start Datum-tijd",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "datetime_local",
	    "protected" => "1",
	    "check" => ""),
	"userId" => array(
	    "label" => "Gebruikersnr.",
	    "default" => "Nieuw",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "number",
	    "protected" => "1",
	    "check" => ""),
	"enrolled" => array(
	    "label" => "Aangemeld",
	    "default" => "0",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "checkbox",
	    "checked" => "1",
	    "protected" => "0",
	    "check" => ""),
	"present" => array(
	    "label" => "Aanwezig",
	    "default" => "0",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "checkbox",
	    "checked" => "1",
	    "protected" => "0",
	    "check" => ""),
	"lastUpdate" => array(
	    "label" => "Laatst gewijzigd",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "datetime_local",
	    "protected" => "1",
	    "check" => "")
	);

    public function __construct()
    {
	if (defined($this->tbDefine)) {
	    parent::__construct(SQL_TBEVENTREGISTER);
	} else {
	    genSetError($this->tbDefine." not defined");
	}
    }
    public function getParticipants($id, $start)
    {
	$retval = array();
	$queryArr = array();
	$this->addTerm($queryArr, "id", "=", $id);
	$this->addTerm($queryArr, "start", "=", $start);
	$query = $this->readQuery($queryArr, array("start" => "ASC"));
	if (!$query) return $retval;
	while ($row = $this->fetch_assoc($query)) {
	    array_push($retval, $row["userId"]);
	}
	return $retval;
    }


    public function getEventForUser(
	$id, /* Event Id */
	$userId)
    {
	$retval = array();
	$whereArr = array();
	$this->addTerm($whereArr, "id", '=', $id);
	$this->addTerm($whereArr, "userId", '=', $userId);
	$order = array( "start" => "ASC");
	$qry = $this->readQuery($whereArr, $order);
	while ($qry && ($row = mysql_fetch_assoc($qry))) {
	    array_push($retval, $row);
	}
	return $retval;
    }

    public function get($id, $start, $userId)
    {
	$whereArr = array();
	$this->addTerm($whereArr, "id", '=', $id);
	$this->addTerm($whereArr, "start", '=', $start);
	$this->addTerm($whereArr, "userId", '=', $userId);
	$qry = $this->readQuery($whereArr, array());
	if (!$qry) return false;
	if (mysql_num_rows($qry) >0) {
	    return mysql_fetch_assoc($qry);
	}
	return false;
    }

    public function register($id, $start, $userId, $enrolled)
    {
	if (!$enrolled) {
	    // if you don't want to enroll and never were,
	    // we don't need to write a record
	    if (($old=$this->get($id, $start, $userId))) {
		$new=$old;
		$new["enrolled"] = $enrolled;
		$this->update($old, $new);
	    }
	} else {
	    $this->insertOrUpdate(array(
		"id" => $id,
		"start" => $start,
		"userId" => $userId,
		"enrolled" => $enrolled));
	}
    }

    public function insertOrUpdate($arr)
    {
	$whereArr = array();
	$old = array();
	foreach (array('id', 'userId', 'start') as $k) {
	    $this->addTerm($whereArr, $k, '=', $arr[$k]);
	    $old[$k] = $arr[$k];
	}
	$qr = $this->readQuery($whereArr);
	switch (mysql_num_rows($qr)) {
	case 0:
	    $this->insert($arr);
	    break;
	case 1:
	    $this->update($old, $arr);
	    break;
	case 2:
	    $msg = "$this->tbDefine: multiple instances for".
		implode("/", $arr);
	    $this->tbError($msg);
	    break;
	}
    }
}
?>
