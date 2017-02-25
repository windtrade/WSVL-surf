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
    /**
     * DATABASE constructor.
     */
    function DATABASE()
	{
		$pdo = null;
        try {
        	$dsn = sprintf('mysql:dbname=%s;host=%s', SQL_DBASE, SQL_DBHOST);
            $pdo = new PDO ($dsn,
                    SQL_DBUSER,
                    SQL_DBPSWD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (exception $e) {
        	genLogVar(__FUNCTION__." PDO error ", $e->getMessage());
		}
		return $pdo;
	}

	function isConnected()
	{
		return (array_key_exists('dbLink', $_SESSION) && $pdo != null);
    }
}
?>
