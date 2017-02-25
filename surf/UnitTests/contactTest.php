<?php

/**
 * Created by PhpStorm.
 * User: Hugo
 * Date: 16-1-2017
 * Time: 19:32
 */
require_once'..\..\..\all_config.inc.php';
require_once '..\library\contact.lib.php';

class contactTest extends PHPUnit_Framework_TestCase
{
    public function testStore()
    {
        $contact = new contact();
        $data = array(
            "from_id" => 1,
            "subject" => "Test contact",
            "message" => "Hier heb je een boodschap aan",
        );
        $contact->store($data);
        assert(array_key_exists("id", $data) && ($data['id'] >0), "find contact id");

    }

    public function testGetConversation()
    {
        $contact = new contact();
        $contact->initQuery();
        $contact->addColumn("MAX(id) lastId");
        $row= $contact->fetch_assoc($contact->readQuery());
        $lastId = -1;
        if ($row) {
            $lastId = $row["lastId"];
        }
        assert($lastId > 0, "Get last Id=".$lastId);
        $conversation = $contact->getConversation($lastId);
        assert(count($conversation) > 0, "getConversation()");
    }

}
