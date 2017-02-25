<?php
/*
 * trainingsmaatjes.lib.php
 *
 * class to access trainingsmaatjes table
 *
 * 31-03-2013 : Huug	: Creation
 */
require_once "table.lib.php";

class Trainingsmaatjes extends table
{
    private $tbDefine="SQL_TBTRAININGSMAATJES";
    private $token;

    public function insert($arr)
    {
	$arr["token"] = $this->token;
	return parent::insert($arr);
    }

    public function getToken()
    {
	return $this->token;
    }

    public function __construct()
    {
	if (defined($this->tbDefine)) {
	    parent::__construct(SQL_TBTRAININGSMAATJES);
	} else {
	    genSetError("Trainingsmaatjes table not defined");
	    return;
	}
	$this->token = $token = md5(uniqid(rand(), true));
    }
}
?>
