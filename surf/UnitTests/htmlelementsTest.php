<?php

/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 18-1-2017
 * Time: 21:11
 */
require_once'..\..\..\all_config.inc.php';
require_once '..\library\image.lib.php';
require_once '..\library\htmlElements.lib.php';

class htmlelementsTest extends PHPUnit_Framework_TestCase
{
    public function testHEelement()
    {
        $he = new htmlElements();
        $smarty = false;
        $param = array();
        $result = $he->HEelement($param, $smarty);
        assert(
            (strpos($result, '<!--') == 0) &&
            (strpos($result, 'tag') > 0).
            'error on tag');
        $param['tag'] = 'p';
        $result = $he->HEelement($param, $smarty);
        assert(
            (strpos($result, '<!--') == 0) &&
            (strpos($result, 'value') > 0).
            'error on value');
        $param['value'] = 'value';
        $result = $he->HEelement($param, $smarty);
        assert(
            (strpos($result, '<p>') == 0) &&
            (strpos($result, 'value') > 0).
            'build <p> tag');
        $param['style'] = 'classy';
        $result = $he->HEelement($param, $smarty);
        assert(
            (strpos($result, '<p>') == 0) &&
            (strpos($result, 'style="classy"') > 0).
            'build <p> tag with attribute');
    }

    public function testHEanchor()
    {
        $smarty = false;
        $he = new htmlElements();
        $params = array(
            'href' => 'test.org?piet=gek',
            'inner' => 'my link',
            'style' => 'classy'
        );
        $result = $he->HEanchor($params, $smarty);
        $strpos['a'] = strpos($result, "<a");
        $strpos['href'] = strpos($result,'href="http://'.$params['href'].'"');
        $strpos['inner'] = strpos($result, ">".$params['inner']."<");
        $strpos['endA'] = strpos($result, "</a>");
        assert(
            ($strpos["a"] == 0) &&
            ($strpos["href"] >0) &&
            ($strpos['inner']>0) &&
            ($strpos["endA"] > 0)
        );
    }

    public function testHEimage()
    {
        $smarty = false;
        $he = new htmlElements();
        $p = array(
            'id' => 205
        );
        $result = $he->HEimage($p, $smarty);
        assert(preg_match('/<i.*\/>/', $result), "image element");
    }

    public function testHEtext() {
        $smarty = false;
        $he = new htmlElements();
        $p = array(
        );
        $result = $he->HEtext($p, $smarty);
        assert(preg_match('/^<!-- HEtext.*>$/', $result), "parameter presence");
        $p['textId'] = "1e";
        $result = $he->HEtext($p, $smarty);
        assert(preg_match('/^<!-- HEtext.*>$/', $result), "parameter numeric");
        $p['textId'] = "-1";
        $result = $he->HEtext($p, $smarty);
        assert(preg_match('/^<!-- HEtext.*>$/', $result), "parameter positive");
        $p['textId'] = "1";
        $result = $he->HEtext($p, $smarty);
        assert(preg_match('/^.+/', $result), "read");
        $p['textId'] = "15555";
        $result = $he->HEtext($p, $smarty);
        assert(strlen($result) == 0, "non existent");
    }

    public function testHEcssmenu()
    {
        $smarty = false;
        $he = new htmlElements();
        global $mainMenu;
        $_SERVER['REQUEST_URI'] = "mytest.org";
        $_SERVER['REMOTE_ADDR'] = "1.2.3.4";
        $result = $he->HEcssmenu(array("menu" => $mainMenu), $smarty);
        assert(preg_match('/^<ul>/', $result), "menu");
        assert(preg_match('/<.ul>$/', $result), "menu");
    }

    public function  testHEbuildURI()
    {
        $smarty = false;
        $he = new htmlElements();
        $_SERVER['REQUEST_URI'] = "/default.php?fiets=bel";
        $_SERVER['SERVER_NAME'] = "mytest.org";
        $p = array(
            "var1" => "val1",
            "var2" => "val2",
            "var3" => "val3",
        );
        $result = $he->HEbuildURI($p, $smarty);
        assert(strpos($result, 'default') < strpos($result,'?'), "default uri");
        assert(strpos($result, 'var1') > strpos($result,'?'), "parameters");
        assert(strpos($result,'fiets') == false);
        $p['uri'] = 'mypage.php?kept1=keptval1';
        $result = $he->HEbuildURI($p, $smarty);
        assert(strpos($result, 'mypage') < strpos($result,'?'), "specific uri");
        $p['keep'] = 'kept1,kept2';
        $result = $he->HEbuildURI($p, $smarty);
        assert(strpos($result, 'kept1') > strpos($result,'?'), "kept parameters");
    }

    public function testHEsocial()
    {
        $smarty = false;
        $he = new htmlElements();
        $_SERVER['REQUEST_URI'] = "/default.php?fiets=bel";
        $_SERVER['SERVER_NAME'] = "mytest.org";
        $_SERVER['SERVER_PORT'] = "8080";
        $_SERVER['SERVER_NAME'] = "mytest.org";
        $p = array();
        $result = $he->HEsocial($p, $smarty);
        assert(strpos($result, 'class="fb') > 0, "facebook button");
    }
}
