<?PHP
/*
 * tarif.lib.php
 *
 * class to access tarif table
 *
 * 01-03-2015 : Huug	: Creation
 */
require_once "table.lib.php";

class Tarif extends table
{
    public $tbDefine = "SQL_TBTARIF";

    protected $structure = array(
	"id" => array(
	    "label" => "id",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "number",
	    "protected"  => "0",
	    "check" => ""),
	"valid_from" => array(
	    "label" => "Geldig vanaf",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "1",
	    "type" => "text",
	    "protected"  => "0",
	    "check" => ""),
	"description" => array(
	    "label" => "Omschrijving",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "1",
	    "type" => "text",
	    "protected"  => "0",
	    "check" => ""),
	"price" => array(
	    "label" => "Prijs",
	    "default" => "0,00",
	    "role" => "public",
	    "mandatory" => "1",
	    "type" => "text",
	    "protected"  => "0",
	    "check" => ""),
	"last_update" => array(
	    "label" => "Gewijzigd",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "o",
	    "type" => "datetime",
	    "protected"  => "1",
	    "check" => ""),
	"updated_by" => array(
	    "label" => "Gewijzigd door",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "",
	    "protected"  => "1",
	    "check" => "")
	);
    public function get($id, $valid_from)
    {
	genSetError("Tarif ".__FUNCTION__." $id $valid_from");
	return parent::getOne(
	    array(
		array(
		    "col"  => "id",
		    "oper" => "=",
		    "val" => $id),
		array(
		    "col" => "valid_from",
		    "oper" => "=",
		    "val" => $valid_from)
		)
	    );
    }


	public function __construct()
	{
		if (defined($this->tbDefine)) {
			parent::__construct(SQL_TBTARIF);
		} else {
			genSetError($this->tbDefine." not defined");
		}
	}

}
