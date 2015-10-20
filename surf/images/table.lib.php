<?php
/*
 * table.inc.php
 * Define generic class for all tables
 *
 * 08-10-2011
 */

require_once "userSession.lib.php";

class table
{
    private $table = NULL;
    private $lastId = 0;
    // supported operators.
    private $operators = array("=", "<", ">", "<=", ">=");

    public function __construct($table)
    {
	$this->table = 
	    SQL_PREFIX.$table;
    }

    private function fixDateTimeLocal(&$dt)
    {
	$sub = array (
	    # pattern => replacement
	    "/^(\d{4}-\d{2}-\d{2})$/" => "$1T$3",
	    "/^(\d{4}-\d{2}-\d{2})([T: ])(\d{2}(:\d{2})(:\d{2})?)$/i" => "$1T$3",
	    "/^(\d{2})-(\d{2})-(\d{4})$/" => "$3-$2-$1:T00:00:00",
	    "/^(\d{2})-(\d{2})-(\d{4})([T: ])(\d{2}(:\d{2}{1:2})?)$/" =>
	    "$3-$2-$1T$5",
	    "/^(\d4)(\d2)(\d2)$/" => "$1-$2-$3:T00:00:00",
	    "/^(\d4)(\d2)(\d2)(\d2)(\d2)]\d*$/" => "$1-$2-$3T$4:$5"
	);
	    
	foreach ($sub as $pat => $rep) {
	    if (preg_match($pat, $dt)) {
		$dt = preg_replace($pat, $rep,$dt);
		return true;
	    }
	}
	genSetError("Datum/tijd niet herkend: $dt");
	return false;
    }

    private function fixData(&$arr)
    {
	if (!property_exists(get_class($this), 'structure'))
	    return;
	foreach (array_keys($arr) as $k) {
	    if (!array_key_exists($k, $this->structure)) continue;
	    if ($this->structure[$k]["type"]=="datetime_local") {
		fixDateTimeLocal($arr[$k]);
	    }
	}
    }

    public function fetch_assoc($query)
    {
	$arr = mysql_fetch_assoc($query);
	if (!$arr) return $arr;
	if (!property_exists(get_class($this), 'structure')) return $arr;
	foreach ($arr as $k => $v) {
	    if (!array_key_exists($k, $this->structure)) continue;
	    if ($this->structure[$k]["type"]=="datetime_local") {
		$arr[$k]  = preg_replace("/ /","T", $v, 1);
	    }
	}
	return $arr;
    }

    /*
     * Accepts date-time formats
     * yyyy-mm-ddThhmm<whatever>
     * yyyymmddhhmm
     * dd-mm-yyyyThh:mm
     * In stead of '-', '/' can be used
     * 'T' may be ' '
     * ':' is optional
     * Anything beyond the minutes is discarded
     */
    private function isValidDateTimeLocal(&$val)
    {
	if (preg_match("/(^\d{4})[-\/]?(\d{2})[-\/]?(\d{2})[T ]?(\d{2}):?(\d{2})/",
	    $val, $matches)) {
		$val = sprintf("%04d-%02d-%02dT%02d:%02d",
		    $matches[1], $matches[2], $matches[3], 
		    $matches[4], $matches[5]);
		return true;
	    }
	if (preg_match("/(^\d{2})[-\/](\d{2})[-\/](\d{4})[T ]?(\d{2}):?(\d{2}):?/",
	    $val, $matches)) {
		$val = sprintf("%04d-%02d-%02dT%02d:%02d",
		    $matches[3], $matches[2], $matches[1], 
		    $matches[4], $matches[5]);
		return true;
	    }
	genSetError(__FILE__.":".__FUNCTION__." matches=".print_r($matches, true));
	return false;
    }
    public function isValid(&$data)
    {
	$ok = true;
	foreach (array_keys($this->structure) as $key) {
	    if ($this->structure[$key]["type"] == "checkbox") {
		if (!array_key_exists($key, $data)) {
		    $data[$key] = $this->structure[$key]["default"];
		}
	    }
	}
	foreach ($this->structure as $key => $struct) {
	    if ($stuct["protected"] != "0") {
		if (!array_key_exists($key, $data)) continue;
		if ($data[$key] == $struct["default"]) {
		    continue;		
		}
	    }
	    if ($struct["mandatory"] && strlen($data[$key]) == 0) {
		genSetError("Veld \"".$struct["label"]."\" is niet ingevuld");
		$ok = false;
		continue;
	    }
	    if ($struct["type"] == "number" && !preg_match("/^\d+$/", $data[$key])) {
		genSetError("Veld \"".$struct["label"]."\" is geen getal: \"".
		    $data[$key]."\"");
		$ok = false;
		continue;
	    } elseif ($struct["type"] == "datetime-local") {
		if (!$this->fixDateTimeLocal($data[$key])) {
		    genSetError("Veld \"".$struct["label"].
			"\" is niet correct ingevuld");
		    $ok = false;
		}
	    } elseif ($struct["type"] == "checkbox" && 
		($data[$key] != $struct["checked"] &&
		$data[$key] != $struct["default"])) {
		genSetError("Veld \"".$struct["label"].
		    "\" heeft een vreemde waarde: \"". $data[$key]."\"");
		$ok = false;
	    }
	}
	return $ok;
    }

    public function toForm($data, $userSession, $hide)
    {
	$result = array();
	if (!property_exists(get_class($this), 'structure'))
	    return $result;
	foreach ($this->structure as $name => $field) {
	    //if (!$userSession->hasRole($field["role"])) continue;
	    if (is_array($hide) && in_array($name, $hide)) continue;
	    $field["name"] = $name;
	    if (array_key_exists($name, $data)) {
		$field["value"] = $data[$name];
	    } else {
		$field["value"] = $field["default"];
	    }
	    array_push($result, $field);
	}
	return $result;
    }

    public function tbError($msg)
    {
	if (!isset($msg)) {
	    $msg = get_class($this).": ".mysql_error();
	}
	genSetError($msg);
    }

    private function makeQueryTerm($arr)
    {
	return $arr["col"]." ".$arr["oper"]." '".$arr["val"]."'";
    }

    private function makeQueryClause($arr)
    {
	if (0 == count($arr)) return "";
	$whereClause = "";
	$elt = array_shift($arr);
	$result = "WHERE ".$this->makeQueryTerm($elt);
	while ($elt = array_shift($arr)) {
	    $result .= " AND ".$this->makeQueryTerm($elt);
	}
	return $result;
    }

    private function makeWhereClause($arr)
    {
	if (0 == count($arr)) return "";
	$whereClause = "";
	$busy = FALSE;
	foreach (array_keys($arr) as $key) {
	    if ($busy) {
		$whereClause .= " and";
	    } else {
		$whereClause = "where ";
	    }
	    $whereClause .= sprintf(' %s="%s"', $key,
		mysql_real_escape_string($arr[$key]));
	    $busy = TRUE;
	}
	return $whereClause;
    }

    private function makeOrderByClause($arr)
    {
	$orderByClause = "";
	if (count($arr) > 0) $orderByClause = "ORDER BY";
	$sep = "";
	foreach ($arr as $key => $val) {
	    $orderByClause .= "$sep $key $val";
	    $sep = ",";
	}
	return $orderByClause;
    }

    private function isUniqueWhereClause($whereClause)
    {
	$cmd = sprintf("select * from %s %s",
	    $this->table, $whereClause);
	$result = mysql_query($cmd);
	if (!$result) {
	    $this->tbError(NULL);
	    return FALSE;
	}
	$numRows = mysql_num_rows($result);
	switch ($numRows) {
	case 1: return TRUE;
	break;
	default: $this->tbError(sprintf("%d rows in %s %s",
	    $numRows, $this->table, $whereClause));
	    return FALSE;
	    break;
	}
    }

    public function addTerm(&$list, $column, $oper, $val)
    {
	$operators = array("=", "<", ">", "<=", ">=");
	$operIdx = array_search($oper, $operators);
	if ($operIdx === false) {
	    genSetError(__FILE__.":".__FUNCTION__.": unsupported operator in $column, $oper, $val");
	    return false;
	}
	if (is_int($column)) {
	    genSetError(__FILE__.":".__FUNCTION__.": InValid column name $column");
	}
	array_push($list, array("col" => $column,
	    "oper" => $oper,
	    "val" => $val));
	return true;
    }

    /*
    private function makeQueryClause($whereArr)
    {
	if (0==count($whereArr)) return "";
	$elt = array_shift($whereArr);
	$retVal = "WHERE ".$elt["col"].$elt["oper"].$elt["val"];
	while ($elt = array_shift($whereArr)) {
	    $retval .= "AND "..$elt["col"].$elt["oper"].$elt["val"];
	}
	return $retVal;
    }
     */

    /*!
     * Read according to optional query ordered according to order argument
     *
     * \code
     * $result = $table->readQuery([ $whereArr[, $orderArr]]);
     * \endcode
     * ** Example
     * \code
     * // Select all
     * $result = $table->readQuery();
     * while ($row = mysql_fetch_assoc($result)) {
     *     print_r($row);
     * }
     * // Select some
     * $table->addTerm($whereArr, 'modifiedDate', '>', "2013-03-08")
     * $result = $table->readQuery($whereArr);
     * while ($row = mysql_fetch_assoc($result)) {
     *     print_r($row);
     * }
     * // Select some in some order
     * $table->addTerm($whereArr, 'modifiedDate', '>', "2013-03-08")
     * $order = array("modifiedDate' => "DESC", 'category' => 'ASC');
     * $result = $table->readQuery($whereArr), $orderArr)
     * while ($row = mysql_fetch_assoc($result)) {
     *     print_r($row);
     * }
     * \endcode
     */
    public function readQuery()
    {
	if (!genDBConnected()) {
	    genSetError(__FILE__.":".__FUNCTION__. " Geen database connectie");
	    return false;
	}
	$nrArgs =func_num_args();
	$allArgs= func_get_args();
	if ($nrArgs > 2) {
	    genSetError(__FILE__.":".__FUNCTION__."wrong number of arguments ($nrArgs)".
		"expecting 0, 1 or 2");
	    return false;
	}
	if ($nrArgs == 0) {
	    $whereArr = array();
	} else {
	    $whereArr= array_shift($allArgs);
	}
	if ($nrArgs == 2) {
	    $orderArr= array_shift($allArgs);
	} else {
	    $orderArr=array();
	}

	foreach ($whereArr as $elt) {
	    if (!is_array($elt)) {
		genSetError(__FILE__.":".__FUNCTION__.": arg 1 is not an array of arrays");
		return false;
	    }
	    if (array_key_exists("col", $elt)) {
		if (is_int($elt["col"])) {
		    genSetError(__FILE__.":".__FUNCTION__.
			" invalid column name: '".$elt["col"]."'");
		    return false;
		}
	    }
	}

	$cmd = sprintf("select * from %s %s %s",
	    $this->table, $this->makeQueryClause($whereArr),
	    $this->makeOrderByClause($orderArr));
	$result = mysql_query($cmd);
	if (!$result) {
	    $this->tbError($cmd);
	    $this->tbError(NULL);
	}
	return $result;
    }


    /*!
     * obsolete, user readSelect with 2 arguments
     */
    public function readSelectOrdered($whereArr, $orderArr)
    {
	return $this->readSelect($whereArr, $orderArr);
    }

    /*
     * \brief make a selection for reading
     * arguments:
     * $whereArr: assoc array of column and value pairs
     * \returns result to be used in mysql_fetch... calls
     */
    public function readSelect()
    {
	$nrArgs =func_num_args();
	$allArgs= func_get_args();
	if ($nrArgs < 1 || $nrArgs > 2) {
	    genSetError(__FILE__.":".__FUNCTION__."wrong numner of arguments ($nrArgs)".
		"expecting 1 or 2");
	    return false;
	}
	$whereArr= array_shift($allArgs);
	if ($nrArgs > 1) {
	    $orderArr= array_shift($allArgs);
	} else {
	    $orderArr=array();
	}

	if (!genDBConnected()) {
	    genSetError(__FILE__.":".__FUNCTION__. " Geen database connectie");
	    return false;
	}
	$testKeys = array_keys($whereArr);
	if (count($testKeys) && is_int($testKeys[0])) {
	    genSetError(__FILE__.":".__FUNCTION__. "Numerieke kolomnaam");
	    return false;
	}
	$cmd = sprintf("select * from %s %s %s",
	    $this->table, $this->makeWhereClause($whereArr),
	    $this->makeOrderByClause($orderArr));
	$result = mysql_query($cmd);
	if (!$result) {
	    $this->tbError(NULL);
	}
	return $result;
    }

    public function insert($arr)
    {
	genSetError(get_class($this).":".__FILE__.":".__FUNCTION__.":".__LINE__);
	if (!genDBConnected()) return FALSE;
	genSetError(get_class($this).":".__FILE__.":".__FUNCTION__.":".__LINE__);
	// Keys of $arr must be non-numeric
	// That makes $arr an associatve array
	$testKeys = array_keys($arr);
	if (!count($testKeys)) {
	    $this->tbError("Leeg record kan niet worden ingevoerd");
	    return false;
	}
	genSetError(get_class($this).":".__FILE__.":".__FUNCTION__.":".__LINE__);
	if (is_int($testKeys[0])) {
	    $this->tbError(__FILE__.":".__FUNCTION__."ongeldige kolomnaam: ",$testKey[0]);
	    return false;
	}
	$colList = "";
	$valList = "";
	foreach (array_keys($arr) as $key) {
	    if (strlen($colList)) {
		$colList .= ", ";
		$valList .= ", ";
	    }
	    $colList .= $key;
	    if (is_numeric($arr[$key])) {
		$valList .= $arr[$key];
	    } else {
		$valList .= '"'.mysql_real_escape_string($arr[$key]).'"';
	    }
	}
	$sqlcmd = sprintf("INSERT INTO %s (%s) values (%s)",
	    $this->table, $colList, $valList);
	genSetError(get_class($this).":".__FILE__.":".__FUNCTION__.":".__LINE__);
	genSetError("insert Command: ".$sqlcmd);
	$result = mysql_query($sqlcmd);
	if ($result) {
	    $this->lastId = mysql_insert_id();
	} else {
	    $this->tbError(NULL);
	    return FALSE;
	}
	return TRUE;
    }

    /*
     * delete must delete just a single row in every call
     * hence the hassle with the sellect before the delete.
     */
    public function delete($arr)
    {
	if (!genDBConnected()) return FALSE;
	$whereClause = $this->makeWhereClause($arr);
	if (!$this->isUniqueWhereClause($whereClause)) {
	    genSetError(__FILE__.":".__FUNCTION__." attempting multiple delete ".
		$whereclause);
	    return FALSE;
	}
	$cmd = sprintf("DELETE FROM %s %s",
	    $this->table, $whereClause);
	$result = mysql_query($cmd);
	if (!$result) {
	    $this->tbError(NULL);
	    return FALSE;
	}
	return TRUE;
    }

    public function deleteMany($arr)
    {
	if (!genDBConnected()) return FALSE;
	$whereClause = $this->makeWhereClause($arr);

	$cmd = sprintf("DELETE FROM %s %s",
	    $this->table, $whereClause);
	$result = mysql_query($cmd);
	if (!$result) {
	    $this->tbError(NULL);
	}
	return $result;
    }
    /*
     * update must update just a single row in every call
     * hence the hassle with the select before the update.
     */
    public function update($old, $new)
    {
	if (!genDBConnected()) return FALSE;
	$whereClause = $this->makeWhereClause($old);
	if (!$this->isUniqueWhereClause($whereClause)) return FALSE;

	$busy = FALSE;
	foreach (array_keys($new) as $key) {
	    if ($busy) {
		$setClause .= ",";
	    } else {
		$setClause = "SET";
	    }
	    $setClause .= sprintf(' %s="%s"', $key,
		mysql_real_escape_string($new[$key]));
	    $busy = TRUE;
	}
	if ($busy) {
	    $cmd = sprintf("UPDATE %s %s %s",
		$this->table, $setClause,
		$whereClause);
	    $result = mysql_query($cmd);
	    if (!$result) {
		$this->tbError(NULL);
		return FALSE;
	    }
	}
	return TRUE;
    }

    public function getColumns()
    {
	if (!genDBConnected()) return FALSE;
	// The number of available fieldnames returned by
	// mysql_list_fields is unknown. But this is a sweet
	// workaround
	// Step 1: get the nr of columns
	$result = mysql_query("SHOW COLUMNS FROM ".$this->table);
	if (!$result) {
	    $this->tbError(NULL);
	    return FALSE;
	}
	$nrOfColumns = mysql_num_rows($result);
	// Step 2: get the column names
	$columns = array();
	$result = mysql_list_fields(
	    SQL_DBASE,
	    $this->table);
	for ($i=0 ; $i < $nrOfColumns ; $i++) {
	    array_push($columns, mysql_field_name($result, $i));
	}
	return $columns;
    }

    public function getLastId()
    {
	return $this->lastId;
    }

    public function getTableName()
    {
	return $this->table;
    }

    public function getDefault($column)
    {
	if (array_key_exists($column, $this->structure)) {
	    return $this->structure[$column]["default"];
	}
	genSetError("Column $column not defined");
	return; 
    }
     public function get($arr)
     {
	 $retval = false;
	 $query = $this->readQuery($arr);
	 if ($query) {
	     if (mysql_num_rows($query) == 1) {
		 $retval = $this->fetch_assoc($query);
	     } else {
		 $this->tbError(__FILE__.":".__FUNCTION__.": ".mysql_num_rows($query)." rijen gevonden");
	     }
	 } else {
	     $this->tbError(NULL);
	 }
	 return $retval;
     }
}
?>
