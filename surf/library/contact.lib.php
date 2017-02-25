<?php
/*
 * contact.lib.php
 *
 * class to access users table
 *
 * 14-12-2014 : Huug	: Creation
 */
require_once "general.lib.php";
require_once "table.lib.php";

class contact extends table
{
    private $tbDefine="SQL_TBCONTACT";

    protected $structure = array(
	"id" => array(
	    "label" => "Contactnr.",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "number",
	    "protected" => "1",
	    "check" => ""),
	"conversation" => array(
	    "label" => "Gespreksnr.",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "number",
	    "protected" => "1",
	    "check" => ""),
	"category" => array(),
	"from_id" => array(
	    "label" => "Afzender",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "number",
	    "protected" => "1",
	    "check" => ""),
	"timestamp" => array(
	    "label" => "Laatste wijziging",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "datetime_local",
	    "protected" => "1",
	    "check" => ""),
	"updated_by" => array(
	    "label" => "Laatst gewijzigd door",
	    "default" => "0",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "number",
	    "protected" => "1",
	    "check" => ""),
	"last_update" => array(
	    "label" => "Laatste wijziging",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "datetime_local",
	    "protected" => "1",
	    "check" => ""),
	"to_id" => array(
	    "label" => "Geadresseeerde",
	    "default" => "0",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "number",
	    "protected" => "1",
	    "check" => ""),
	"subject" => array(
	    "label" => "Onderwerp",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "1",
	    "type" => "text",
	    "protected" => "0",
	    "size" => "40",
	    "check" => ""),
	"message" => array(
	    "label" => "Vraag of opmerking",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "textarea",
	    "protected" => "0",
	    "check" => "")
	);

    public function __construct()
    {
	if (defined($this->tbDefine)) {
	    parent::__construct(SQL_TBCONTACT);
	} else {
	    genSetError($this->tbDefine." not defined");
	}
	$this->structure["category"] = general::getCategoryDefinition();
    }

    public function store(&$arr)
    {
        $arr['timestamp'] = (new DateTime())->format('Y-m-d H:i:s');
        if (!parent::insert($arr)) return false;
        $arr["id"]  = $this->getLastId();
        if (!array_key_exists("conversation", $arr) ||
            $arr["conversation"] <= 0)
        {
            $this->update(
                array("id" => $arr["id"]),
                array("conversation" => $arr["id"]));
        }
        $arr = $this->get($arr["id"]);
        return true;
    }

    public function get($id)
    {
	return parent::getOne(array("id" => $id));
    }

    public function getConversation($conversation)
    {
        $this->initQuery();
	$query = $this->readSelect(array(
		"conversation" => $conversation));
	if ($query == false) return false;
	$result = $this->fetch_assoc_all($query);
	return $result;
    }
}
