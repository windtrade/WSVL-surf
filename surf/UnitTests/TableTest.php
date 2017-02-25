<?php

/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 9-1-2017
 * Time: 21:31
 */
require_once "..\\..\\..\\all_config.inc.php";
require_once "..\\library\\general.lib.php";
require_once "..\\library\\table.lib.php";

class testClass extends table
{
    public $structure = array(
        array('c' => "col1", 'o' => "=", 'v'=> "value1"),
        array('c' => "col2", 'o' => "operator", 'v'=> "value2"),
        array('c' => "col3", 'o' => ">", 'v'=> "value3"),
        array('c' => "col4", 'o' => ">=", 'v'=> "value4"),
        array('c' => "col5", 'o' => "<", 'v'=> "value5"),
        array('c' => "col6", 'o' => "<=", 'v'=> "value6"),
        array('c' => "col7", 'o' => "!=", 'v'=> "value7"),
        array('c' => "col8", 'o' => ">=", 'v'=> "value8"),
        array('c' => "col9", 'o' => "IN", 'v'=> "value9"),
        array('c' => "col10", 'o' => "NOT IN", 'v'=> array("value10", "value11"))
    );
    public function __construct()
    {
        parent::__construct("testTable");
    }
}
class TableTest extends PHPUnit_Framework_TestCase
{
    public function testWhereArray()
    {
        $testObject = new testClass();
        $testObject->initQuery();
        $fails = array();
        $oks = array();
        foreach($testObject->structure as $term) {
            try {
                $testObject->addTerm($term['c'], $term['o'], $term['v']);
                array_push($oks, $term['o']);
            } catch (Exception $e) {
                array_push($fails, $term['o']);
            }
        }
        print("Fails: ".join(", ", $fails)."\n");
        print("Oks: ".join(", ", $oks)."\n");
        assert(count($oks) == 9 && count($fails) == 1);
    }

    public function testQueryClause()
    {
        $tO = new testClass();
        $tO->initQuery();
        assert($tO->makeWhereClauseExpanded() == "", "whereClause should be empty");
        $tO->addTerm("col1", "=", "2");
        $tO->addTerm("col2", ">", "2012");
        print("Where Clause:".$tO->makeWhereClauseExpanded()."\n");
        assert(preg_split("/ AND /", $tO->makeWhereClauseExpanded()) == 2, "whereClause should have 2 terms");
    }

}