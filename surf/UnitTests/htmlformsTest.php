<?php

/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 26-1-2017
 * Time: 21:09
 */

require_once '../library/htmlforms.lib.php';

class htmlformsTest extends PHPUnit_Framework_TestCase
{
    public function testHFlabeledField()
    {
        $fieldTypes = array(
            "text" => array("expected" => '<!-- 12--><td>text</td><td><input type="text" size="50" name="prefix[name_text]" value="value" /></td>'),
            "textarea" => array("expected" => '<td>textarea</td><td><textarea rows="4.0833333333333" name="prefix[name_textarea]">value</textarea></td>'),
            "date" => array("expected" => '<!-- 12--><td>date</td><td><input type="date" size="50" name="prefix[name_date]" value="value" /></td>'),
            "email" => array("expected" => '<!-- 12--><td>email</td><td><input type="email" size="50" name="prefix[name_email]" value="value" /></td>'),
            "number" => array("expected" => '<!-- 12--><td>number</td><td><input type="number" size="50" name="prefix[name_number]" value="value" /></td>'),
            "password" => array("expected" => '<!-- 12--><td>password</td><td><input type="password" size="50" name="prefix[name_password]" value="value" /></td>'),
            "tel" => array("expected" => '<!-- 12--><td>tel</td><td><input type="tel" size="50" name="prefix[name_tel]" value="value" /></td>'),
            "url" => array("expected" => '<!-- 12--><td>url</td><td><input type="url" size="50" name="prefix[name_url]" value="value" /></td>'),
            "datetime-local" => array("expected" => '<!-- 12--><td>datetime-local</td><td><input type="datetime-local" size="50" name="prefix[name_datetime-local]" value="value" /></td>'),
            "checkbox" => array("expected" => '<td>checkbox</td><td><input name="prefix[name_checkbox]" type="checkbox" checked value=" 1" /></td>'),
            "select" => array("expected" => '<td>select</td><td><select name="prefix[name_select]"><option value="0" selected>opt1</option><option value="1" >opt2</option><option value="2" >opt3</option><option value="3" >opt4</option></select></td>'),
            "image" => array("expected" => '<td>image</td><td><input name="prefix__name_image" type="file" value="value" />'),
            "other"=> array("expected" => '<td>other</td><td><!-- unsupported input type: other --><input name="prefix[name_other]" type="hidden" value="value" />value</td>'),
        );

        $smarty = false;
        $hf = new htmlforms();

        foreach ($fieldTypes as $type => $info) {
            $p["prefix"] = "prefix";
            $p["data"]["name"] = "name_".$type;
            $p["data"]["label"] = $type;
            $p["data"]["type"] = $type;
            $p["data"]["value"] = "value";
            $p["data"]["checked"] = true;
            $p["data"]["options"] = array("opt1", "opt2", "opt3", "opt4");
            $result = $hf->HFlabeledField($p, $smarty);
            //print($type.'='.$result."\n");
            //print($type.'='.$info["expected"]."\n");
            assert (($result === $info["expected"]), $type);
        }
    }

}
