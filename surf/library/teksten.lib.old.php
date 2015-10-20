<?php
/*
 * teksten.lib.php
 *
 * class to access users table
 *
 * 29-12-2012 : Huug	: Creation
 */
require_once "table.lib.php";

class teksten extends table
{
	private $tbDefine="SQL_TBTEKSTEN";

	public function __construct()
	{
		if (defined($this->tbDefine)) {
			parent::__construct(SQL_TBTEKSTEN);
		} else {
			genSetError($this->tbDefine." not defined");
		}
	
	}
}
?>
