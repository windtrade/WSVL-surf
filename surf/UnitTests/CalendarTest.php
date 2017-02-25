<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 29-12-2016
 * Time: 22:07
 */
require_once "..\..\..\all_config.inc.php";
require_once "..\library\general.lib.php";
require_once "..\library\calendar.lib.php";


class CalendarTest extends PHPUnit_Framework_TestCase
{
    private $obj;
    function __construct()
    {
        $this->obj = new Calendar();
    }

    function testInsert() {
        print "Testing ".__CLASS__.":".__FUNCTION__."\n";
        $calendar = new Calendar();
        $now = new DateTime();
        $today = $now->format("Y-m-d");
        $input = array
        (
            "id" => 60,
             "category" => "2",
             "start" => $now->format("Y-m-d H:i:s"),
             "end" => $today." 23:59:00",
             "name" => "test insert",
             "location" => "insert location",
             "url" => "http://go.to/insert"
        );
        assert($calendar->insert($input), __FUNCTION__." insert");
        // read what you just inserted
        $calendar->initQuery();
        $calendar->addTerm("id", "=", $input["id"]);
        $calendar->addTerm("category", "=", $input["category"]);
        $calendar->addTerm("start", "=", $input["start"]);
        assert($calendar->isUniqueWhereClause(), __FUNCTION__." read back query");
        $result = array();
        $sth = $calendar->readQuery();
        while ($sth && $row = $calendar->fetch_assoc($sth)) {
            array_push($result, $row);
        }
        print("Found ".count($result)." rows\n");
        assert (count($result) == 1, __FUNCTION__. "read back" );
        $output = array_shift($result);
        $ok = true;
        foreach(array_keys($input) as $key) {
            if ($input[$key] != $output[$key]){
                print("\$input[$key]=".$input[$key]."!= \$output[$key]=".$output[$key]."\n");
                    $ok = false;
            }
        }
        assert ($ok, __FUNCTION__." compare input and read back");
    }

    function testGetUpcoming() {
        print "Testing ".__CLASS__.":".__FUNCTION__."\n";
        $calendar = new Calendar();
        $result = $calendar->getUpcoming(2  );
        // print('getUpcoming(60, "2001-01-01"): '.print_r($result, true));
        print("Found ".count($result)." rows\n");
        assert (count($result) > 1);
    }

    function testGetAllFrom() {
        print "Testing ".__CLASS__.":".__FUNCTION__."\n";
        $calendar = new Calendar();
        $result = $calendar->getAllFrom(60, "2001-01-01");
        // print('getAllFrom(60, "2001-01-01"): '.print_r($result, true));
        print("Found ".count($result)." rows\n");
        assert (count($result) > 1);
    }

    function testGetEventsFromCalendar() {
        print("Testing ".__CLASS__.":".__FUNCTION__."\n");
        $calendar = new Calendar();
        $result = $calendar->getEventsFromCalendar("2016-01-01");
        print("Found ".count($result)." events from calendar");
        assert(count($result) > 0);
    }

    function testGetEventList() {
        print("Testing ".__CLASS__.":".__FUNCTION__."\n");
        $calendar = new Calendar();
        $result = $calendar->getEventCalendar(60);
        print("Found ".count($result)." events from calendar");
        assert(count($result) > 0);
    }

    function testGetCategoryCalendar() {
        $calendar = new Calendar();
        $list = $calendar->getCategoryCalendar(
            array(), // All
            array(general::INSTRUCTION),
            "2010-01-01",
            array("start")
        );
        assert(count($list) > 0, __FUNCTION__." get data");
        $lastStart = "";
        foreach($list as $elt) {
            assert($elt["start"] >= $lastStart, __FUNCTION__." order");
            assert($elt["category"] != general::INSTRUCTION, __FUNCTION__." exclusion");
            $lastStart = $elt["start"];
        }
    }

    function testDeleteAllFromEvent() {
        print("Testing ".__CLASS__.":".__FUNCTION__."\n");
        $calendar = new Calendar();
        $events = $calendar->getEventCalendar(60);
        print("Found ".count($events)." records\n");
        $calendar->deleteAllFromEvent(60);
        $countAfterDelete = count($calendar->getEventCalendar(60));
        print("Found ".$countAfterDelete." records after delete\n");
        foreach ($events as $event) {
            $calendar->insert($event);
        }
        $events = $calendar->getEventCalendar(60);
        print("Found ".count($events)." records after restore\n");
        assert($countAfterDelete == 0);
    }
}
