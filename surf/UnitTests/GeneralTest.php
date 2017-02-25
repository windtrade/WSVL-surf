<?php
/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 3-1-2017
 * Time: 23:27
 */
require_once'..\..\..\all_config.inc.php';
require_once '..\library\general.lib.php';


class GeneralTest extends PHPUnit_Framework_TestCase
{
    private $obj;
    function __construct()
    {
        print "construct".__CLASS__."\n";
        $this->obj = new General();
    }

    function testGenLogWrite() {
        print __CLASS__." - ".__FUNCTION__."\n";
        try {
            genLogWrite("fiets", "bel", "toon");
        } catch (Exception $e) {
            assert(false, __FUNCTION__." " . $e->getMessage());
        }
        print(__FUNCTION__."OK\n");
    }

    function testGenLogVar() {
        print __CLASS__." - ".__FUNCTION__."\n";
        try {
            $piet = "gek";
            genLogVar("fiets", "bel", $piet);
        } catch (Exception $e) {
            assert(false, __FUNCTION__." " . $e->getMessage());
        }
        print(__FUNCTION__."OK\n");
    }


    function tryArrayMergeOrPush($arr, $xtra,$mustFail) {
        try {
            genArrayMergeOrPush($arr, $xtra);
        } catch (Exception $e) {
            print $e->getMessage()."\n";
            return($mustFail);
        };
        return (!$mustFail);
    }

    function testGenArrayMergeOrPush()
    {
        $assoc_array1 = array(
            "elt1" => "val1",
            "elt2" => "val2"
        );
        $assoc_array2 = array(
            "elt1" => "val11",
            "elt3" => "val12"
        );
        $regular_array1 = array(
            "val3",
            "val4"
        );
        $regular_array2 = array(
            "val5",
            "val6"
        );
        $scalar = "val7";
        $regular_array1 = array(
            "val3",
            "val4"
        );
        // These should work (last argument false) or not (true);
        assert($this->tryArrayMergeOrPush($assoc_array1, $scalar, true), "Merge scalar w assoc");
        assert($this->tryArrayMergeOrPush($assoc_array1, $regular_array1, true), "Merge regular w assoc");
        assert($this->tryArrayMergeOrPush($assoc_array1, $assoc_array2, false), "Merge assoc w assoc");
        assert($this->tryArrayMergeOrPush($regular_array1, $scalar, false), "Merge assoc w regular");
        assert($this->tryArrayMergeOrPush($regular_array1, $regular_array2, false), "Merge regular w regular");
        assert($this->tryArrayMergeOrPush($regular_array1, $assoc_array1, true), "Merge regular w assoc");
    }
}
