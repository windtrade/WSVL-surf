<?php
/*
 * calendar.lib.php
 *
 * class to access calendar table
 *
 * 31-03-2013 : Huug	: Creation
 */
require_once "table.lib.php";

class Calendar extends table
{
    public $tbDefine = "SQL_TBCALENDAR";

    protected $structure = array(
	"id" => array(
	    "label" => "id",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "hidden",
	    "protected"  => "0",
	    "check" => ""),
	"category" => array(
	    "label" => "category",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "hidden",
	    "protected"  => "0",
	    "check" => ""),
	"start" => array(
	    "label" => "Aanvang Datum/tijd",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "datetime-local",
	    "protected"  => "0",
	    "check" => ""),
	"end" => array(
	    "label" => "Einde Datum/tijd",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "datetime-local",
	    "protected"  => "0",
	    "check" => ""),
	"name" => array(
	    "label" => "Naam",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "text",
	    "protected"  => "0",
	    "check" => ""),
	"location" => array(
	    "label" => "Locatie",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "text",
	    "protected"  => "0",
	    "check" => ""),
	"url" => array(
	    "label" => "Web",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "text",
	    "protected"  => "0",
	    "check" => "")
	);
    private $spareStructure = array(
	"veld" => array(
	    "label" => "qqq",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "text",
	    "protected"  => "0",
	    "check" => ""),
	"event_id" => array(
	    "label" => "qqq",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "text",
	    "protected"  => "0",
	    "check" => "")
	);
    
    private $returnHTML = false;

	public function __construct()
	{
		if (defined($this->tbDefine)) {
			parent::__construct(SQL_TBCALENDAR);
		} else {
			genSetError($this->tbDefine." not defined");
		}
	}

	public function getUpcoming($category)
	{
	    $today = new DateTime();
	    $today = $today->format('Y-m-d');
	    $retval = array();
	    $queryArr = array();
	    $this->addTerm($queryArr, "category", "=", $category);
	    $this->addTerm($queryArr, "start", ">=", $today);
	    $query = $this->readQuery(
		$queryArr,
		array("start" => "ASC"),
		array("id", "start"),
		"DISTINCT");
	    if (!$query) return $retval;
        $oldReturnHTML = $this->returnHTML;
        $this->returnHTML = true;
	    while ($row = $this->fetch_assoc($query))  {
		  array_push($retval, $row);
	    }
        $this->returnHTML = $oldReturnHTML;    
	    return $retval;
	}

	public function getAllFrom($id, $start)
	{
	    $retval = array();
	    $query = $this->readQuery(
		array(
		    array("col"=>"id", "oper"=>"=", "val"=>"$id"),
		    array("col"=>"start", "oper"=>">=", "val"=>"$start")
		),
		array("start" => "ASC")
	    );
	    if (!$query) return $retval;
        $oldReturnHTML = $this->returnHTML;
        $this->returnHTML = true;
	    while ($row = $this->fetch_assoc($query)) {
		array_push($retval, $row);
	    }
        $this->returnHTML = $oldReturnHTML;
	    return $retval;
	}

	public function getEventsFromCalendar(
	    $start)
	{
	    $retval = array();
	    $cmd = "SELECT id, ".
		"MIN(start) start, ".
		"COUNT(id) count ".
		"FROM ".SQL_TBCALENDAR." ".
		"WHERE start >= \"$start\" ".
		"GROUP BY id ".
		"ORDER by start ASC";
	    $result = mysql_query($cmd);
	    if (!$result) {
		$this->tbError(NULL);
		return $retval;
	    }
        $oldReturnHTML = $this->returnHTML;
        $this->returnHTML = true;
	    while ($row = $this->fetch_assoc($query)) {
            array_push($retval, $row);
	    }
        $this->returnHTML = $oldReturnHTML;
	    return $retval;
	}

	public function getEventList($id)
	{
		$result = $this->readSelect(Array(
			"id" => $id));
		if (!$result) return false;
		$retVal = Array();
		while ($row = mysql_fetch_assoc($result)) {
		    array_push($retval, $row);
		}
		return $retVal;
	}

	public function deleteAllFromEvent($id)
	{
	    return $this->deleteMany(array("id" => $id));
	}
}

?>
