<?php
/*
 * database.inc.php
 *
 * class DATABASE - access database
 * Including thise file opens a database connection and 
 * stores its resource as $THE_WORLD["DB"]
 *
 * Check whether the database is connected:
 * global $THE_WORLD // necessary within a function
 * if ($THE_WORLD["DB"]->isConnected()) {
 * 	// do something;
 * } else {
 * 	// do something else
 * }
 * closing the database again:
 * global $THE_WORLD // necessary within a function
 * $THE_WORLD["DB"]->close();
 */

class DATABASE
{
	private $DBLINK = NULL;

	function DATABASE()
	{
		$this->DBLINK =
			@mysql_connect(
				SQL_DBHOST,
				SQL_DBUSER,
				SQL_DBPSWD);
		if ($this->DBLINK) {
			mysql_select_db(SQL_DBASE);
		} else {
			genSetError(mysql_error());
		}
	}

	function close()
	{
		if ($this->DBLINK) {
			mysql_close($this->DBLINK);
			$this->DBLINK = NULL;
		}
	}

	function isConnected()
	{
		return ($this->DBLINK);
	}
}
?>
