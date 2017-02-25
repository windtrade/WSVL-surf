<?php

/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 31-1-2017
 * Time: 20:46
 */
require_once '../../../all_config.inc.php';
require_once '../library/general.lib.php';
require_once '../library/teksten.lib.php';

class tekstenTest extends PHPUnit_Framework_TestCase
{
    public function testGetTekst()
    {
        $teksten = new teksten();
        $result =  $teksten->getTekst(1);
        $structure = $teksten->getColumns();
        foreach ($structure as $column) {
            assert(array_key_exists($column, $result), get_class($teksten)." Non existent column ".$column);
        }
        foreach ($result as $column => $value) {
            assert(array_search($column, $structure) !== false, get_class($teksten)."Undefined column ".$column);
        }
        assert(strpos($result['tekst'], '<br') === false, get_class($teksten)." remaining line breaks" );
        assert(strpos($result['tekst'], '<p>') !== false, get_class($teksten)." HTML" );
        $result =  $teksten->getTekstPlain(1, false);
        assert(strpos($result['tekst'], '<p>') === false, get_class($teksten)." Plain" );
        // TODO: test GetTekstExpanded
    }

}
