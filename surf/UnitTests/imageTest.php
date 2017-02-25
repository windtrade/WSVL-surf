<?php

/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 19-1-2017
 * Time: 16:35
 */
require_once'..\..\..\all_config.inc.php';
require_once '..\library\image.lib.php';

class imageTest extends PHPUnit_Framework_TestCase
{
    public function testDirFromId()
    {
        $result =image::dirFromId(2010);
        assert(preg_match('/img20\/img10\/$/',$result), __FUNCTION__);
    }
    public function testFileFromId()
    {
        $result =image::fileFromId(2010);
        assert(preg_match('/^0*2010$/',$result), __FUNCTION__);
    }
    public function testGet()
    {
        $img =new image();
        $result =  $img->get(1);
        assert(is_array($result) && $result["id"] == 1, __CLASS__." get");
        $result = $img->getUrl(1, 'large');
        assert($result == "http://surf.wvleidschendam.nl/images/imgNotFound_large.png");
    }
}
