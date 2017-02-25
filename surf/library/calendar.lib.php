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
	    $retVal = array();
	    $this->addTerm("category", "=", $category);
	    $this->addTerm("start", ">=", $today);
	    $this->addOrderTerm("start", "ASC");
	    $query = $this->readQuery();
	    if (!$query) return $retVal;
        $oldReturnHTML = $this->returnHTML;
        $this->returnHTML = true;
	    while ($row = $this->fetch_assoc($query))  {
		  array_push($retVal, $row);
	    }
        $this->returnHTML = $oldReturnHTML;    
	    return $retVal;
	}

    /**
     * @param $id: id of the event
     * @param $start: eraliest startdate
     * @return array calendar records
     */
	public function getAllFrom($id, $start)
	{
	    $retVal = array();

        $this->addTerm("id", "=", $id);
		$this->addTerm("start", ">=", "$start");
		$this->addOrderTerm("start", "ASC");

	    $query = $this->readQuery();
	    if (!$query) return $retVal;
        $oldReturnHTML = $this->returnHTML;
        $this->returnHTML = true;
        while ($row = $this->fetch_assoc($query)) {
            array_push($retVal, $row);
        }
        $this->returnHTML = $oldReturnHTML;
        return $retVal;
	}

    /**
     * select all ids of upcoming events
     * @param $start: string minimum date in selection
     * @return array (id= Event Id, start= Earliest date for id, count=nr of calendar events for this event
     */
	public function getEventsFromCalendar(
	    $start)
	{
	    $retVal = array();
	    $this->addTerm("start", ">=", $start);
	    $this->addColumns("id", "MIN(start) start", "COUNT(id) count");
	    $this->addOrderTerm("start",  "ASC");
	    $this->addGroupTerm("id");
	    $sth = $this->readQuery();

        $oldReturnHTML = $this->returnHTML;
        $this->returnHTML = true;
	    while ($row = $this->fetch_assoc($sth)) {
            array_push($retVal, $row);
	    }
        $this->returnHTML = $oldReturnHTML;
	    return $retVal;
	}

    /**
     * @param $id: int event id
     * @return array|bool all calendar records for id or failure
     */
	public function getEventCalendar($id)
	{
	    $this->addTerm("id", '=', $id);
		$sth = $this->readQuery();
		if (!$sth) return false;
		$retVal = Array();
		while ($row = $this->fetch_assoc($sth)) {
		    array_push($retVal, $row);
		}
		return $retVal;
	}

    /**
     * @param $included: array categories to include in the list, take all when empty
     * @param $excluded: array categories to exclude from the list, exclude none when empty
     * @param $start: string valid sql date time minimum start time
     * @param $order: array of columns to order by (ASC)
     * @return array
     */
    public function getCategoryCalendar($included, $excluded, $start, $order)
    {
        $this->initQuery();
        if (count($included)) {
            $this->addTerm("category", "IN", $included);
        }
        if (count($excluded)) {
            $this->addTerm("category", "NOT IN", $excluded);
        }
        if ($start != "") {
            $this->addTerm("start", ">=", $start);
        }
        foreach ($order as $column) {
            $this->addOrderTerm($column, "ASC");
        }$result = $this->readQuery();
        $retVal = array();
        if ($result) {
            $retVal = $this->fetch_assoc_all($result);
        }
        return $retVal;
    }

    /**
     * delete calendar entries for id
     * @param $id int event id
     * @return mixed true = success
     */
	public function deleteAllFromEvent($id)
	{
        $this->addTerm("id", '=', $id);
	    return $this->deleteMany();
	}
}


