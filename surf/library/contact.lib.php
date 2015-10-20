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

    public function insert(&$new)
    {
	if (!parent::insert($new)) return false;
	$new["id"]  = $this->getLastId();
	if (!array_key_exists("conversation", $new) || 
	    $new["conversation"] <= 0)
	{
	    $this->update(
		array("id" => $new["id"]),
		array("conversation" => $new["id"]));
	}
	$new = $this->get($new["id"]);
	return true;
    }

    public function get($id)
    {
	return parent::get(array(
	    array(
		"col" => "id",
		"oper" => "=",
	       	"val" => $id)));
    }

    public function getConversation($conversation)
    {
	$query = $this->readQuery(array(
	    array(
		"col" => "conversation",
		"oper" => "=",
	       	"val" => $conversation)));
	if ($query == false) return false;
	$result = array();
	while ($row=mysql_fetch_assoc($query)) {
	    array_push($result, $row);
	}
	return $result;
    }
}
