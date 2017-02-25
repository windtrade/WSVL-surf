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
    $this->addTerm($queryArr,"enrolled", "!=", 0);
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
	$whereArr = array();
	$this->addTerm($whereArr, "id", '=', $id);
	$this->addTerm($whereArr, "userId", '=', $userId);
	$order = array( "start" => "ASC");
	$qry = $this->readQuery($whereArr, $order);
	$retval = $this->fetch_assoc($qry);
	return $retval;
    }

    public function get($id, $start, $userId)
    {
        return $this->getOne(array(
            "id" => $id,
            "start" => $start,
            "userId" => $userId
        ));
    }

    public function register($id, $start, $userId, $enrolled)
    {
        if (!$enrolled) {
            // if you don't want to enroll and never were,
            // we don't need to write a record
            $old=$this->get($id, $start, $userId);
            if (!$enrolled) return true;
        }
        return $this->insertOrUpdate(array(
            "id" => $id,
            "start" => $start,
            "userId" => $userId,
            "enrolled" => $enrolled));
    }

    public function insertOrUpdate($arr)
    {
        $old = array();
        foreach (array('id', 'userId', 'start') as $k) {
            $this->addTerm($k, '=', $arr[$k]);
            $old[$k] = $arr[$k];
        }
        $qr = $this->readQuery();
        $rows = $this->fetch_assoc_all($qr);
        switch (count($rows)) {
            case 0:
                return $this->insert($arr);
            case 1:
                return $this->update($old, $arr);
            default:
                $msg = "$this->tbDefine: multiple instances for".
                    implode("/", $arr);
                $this->tbError($msg);
                break;
        }
        return false;
    }
}

