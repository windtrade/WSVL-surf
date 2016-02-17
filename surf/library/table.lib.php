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
    private $table = null;
    private $lastId = 0;
    // supported operators.
    private $operators = array(
        "=",
        "!=",
        "<",
        ">",
        "<=",
        ">=",
        "IN",
        "NOT IN");

    public function __construct($table)
    {
        $this->table = SQL_PREFIX . $table;
    }

    /**
     * Normalize values to match the possible values in the database
     */ 
    private function normalizeRecord($rec)
    {
        foreach (array_keys($rec) as $key) {
            switch (strtolower($this->structure[$key]["type"])) {
                case "checkbox":
                    $value = strtolower($rec[$key]);
                    /** Boolean value, make it 0 or 1 */
                    if (is_numeric($rec[$key])) {
                        $rec[$key] = ($rec[$key] ? 1 : 0);
                    } elseif ($rec[$key] === true) {
                        $rec[$key] = 1;
                    } elseif ($rec[$key] === false) {
                        $rec[$key] = 0;
                    } elseif ($value == "on") {
                        $rec[$key] = 1;
                    } elseif ($value == "off") {
                        $rec[$key] = 0;
                    } elseif (strstr("jy", substr($value, 0, 1)) !== false) {
                        $rec[$key] = 1;
                    } else {
                        $rec[$key] = 0;
                    }
                    break;
            }
        }
    }

public function getTable()
{
    return $this->table;
}
private function setDateTimeLocalToDefault(&$dt, $default)
{
    $nullDate = "0000-00-00 00:00:00";
    if ($default == $nullDate || $default == "") {
        $dt = $nullDate;
        return;
    }
    try {
        $defDT = new DateTime($default);
    }
    catch (exception $e) {
        genSetError("Geen geldige datum/tijd beschrijving: \"$default\"");
        $dt = "0000-00-00 00:00:00";
        return;
    }
    $dt = $defDT->format("Y-m-d H:i:s");
}

private function fixDateTimeLocal(&$dt, $struct)
{
    $sub = array(
        # pattern => replacement
        "/^(\d{4}-\d{2}-\d{2})$/" => "$1T$3",
        "/^(\d{4}-\d{2}-\d{2})([T: ])(\d{2}(:\d{2})(:\d{2})?)$/i" => "$1T$3",
        "/^(\d{2})-(\d{2})-(\d{4})$/" => "$3-$2-$1:T00:00:00",
        "/^(\d{2})-(\d{2})-(\d{4})([T: ])(\d{2}(:\d{2}{1:2})?)$/" => "$3-$2-$1T$5",
        "/^(\d4)(\d2)(\d2)$/" => "$1-$2-$3:T00:00:00",
        "/^(\d4)(\d2)(\d2)(\d2)(\d2)]\d*$/" => "$1-$2-$3T$4:$5");

    if (strlen($dt) == 0) {
        $this->setDateTimeLocalToDefault($dt, $struct["default"]);
    }
    foreach ($sub as $pat => $rep) {
        if (preg_match($pat, $dt)) {
            $dt = preg_replace($pat, $rep, $dt);
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
        if (!array_key_exists($k, $this->structure))
            continue;
        if ($this->structure[$k]["type"] == "datetime_local") {
            fixDateTimeLocal($arr[$k]);
        }
    }
}

public function fetch_assoc($query)
{
    $arr = mysql_fetch_assoc($query);
    if (!$arr) {
        return $arr;
    }
    if (!property_exists(get_class($this), 'structure'))
        return $arr;
    foreach ($arr as $k => $v) {
        $arr[$k] = iconv("UTF-8", "UTF-8//IGNORE", $v);
        if (!array_key_exists($k, $this->structure))
            continue;
        if ($this->structure[$k]["type"] == "datetime_local") {
            $arr[$k] = preg_replace("/ /", "T", $v, 1);
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
    if (preg_match("/(^\d{4})[-\/]?(\d{2})[-\/]?(\d{2})[T ]?(\d{2}):?(\d{2})/", $val,
        $matches)) {
        $val = sprintf("%04d-%02d-%02dT%02d:%02d", $matches[1], $matches[2], $matches[3],
            $matches[4], $matches[5]);
        return true;
    }
    if (preg_match("/(^\d{2})[-\/](\d{2})[-\/](\d{4})[T ]?(\d{2}):?(\d{2}):?/", $val,
        $matches)) {
        $val = sprintf("%04d-%02d-%02dT%02d:%02d", $matches[3], $matches[2], $matches[1],
            $matches[4], $matches[5]);
        return true;
    }
    return false;
}
/*
* ok = isValid(&$data [ , $include=null])
* when $include is an array, only fields names
* listed in $include are validated
*/
public function isValid(&$data, $include = null)
{
    $ok = true;
    foreach (array_keys($this->structure) as $key) {
        if (is_array($include) && !in_array($key, $include))
            continue;
        if ($this->structure[$key]["type"] == "checkbox") {
            if (!array_key_exists($key, $data)) {
                $data[$key] = $this->structure[$key]["default"];
            }
        }
    }
    foreach ($this->structure as $key => $struct) {
        $fieldOK = true;
        if ($struct["protected"] != "0") {
            if (!array_key_exists($key, $data))
                continue;
            if ($data[$key] == $struct["default"]) {
                continue;
            }
        }
        # TODO better check on missing fields
        if (!array_key_exists($key, $data))
            continue;
        if ($struct["mandatory"] && (!array_key_exists($key, $data) || strlen($data[$key]) ==
            0)) {
            genSetError("Veld \"" . $struct["label"] . "\" is niet ingevuld");
            $fieldOK = false;
            if ($struct["mandatory"])
                continue;
        }
        $data[$key] = stripslashes($data[$key]);
        if ($struct["type"] == "number" && !preg_match("/^\d+$/", $data[$key])) {
            genSetError("Veld \"" . $struct["label"] . "\" is geen getal: \"" . $data[$key] .
                "\"");
            $fieldOK = false;
        } elseif ($struct["type"] == "datetime-local") {
            if (!$this->fixDateTimeLocal($data[$key], $struct)) {
                genSetError("Veld \"" . $struct["label"] . "\" is niet correct ingevuld");
                $fieldOK = false;
            }
        } elseif ($struct["type"] == "checkbox" && ($data[$key] != $struct["checked"] &&
        $data[$key] != $struct["default"])) {
            genSetError("Veld \"" . $struct["label"] . "\" heeft een vreemde waarde: \"" . $data[$key] .
                "\"");
            $fieldOK = false;
        }
        if ($fieldOK && array_key_exists("regexp", $struct) && $struct["regexp"] != "") {
            $regex = "/^" . $struct["regexp"] . "\$/";
            if (!preg_match($regex, $data[$key])) {
                $fieldOK = false;
                if (array_key_exists("msg", $struct) && $struct["msg"] != "") {
                    genSetError("Veld '" . $struct["label"] . "': " . $struct["msg"]);
                } else {
                    genSetError("Veld '" . $struct["label"] . "' is niet correct ingevuld");
                }
            }
        }
        $ok = $ok && $fieldOK;
    }
    return $ok;
}

public function columnToForm($data, $name, $userSession)
{
    $result = array();
    if (!property_exists(get_class($this), 'structure'))
        return $result;
    if (!array_key_exists($name, $this->structure))
        return $result;
    $field = $this->structure[$name];
    $default = (array_key_exists("default", $field) ? $field["default"] : "");
    $field["name"] = $name;
    if (array_key_exists($name, $data)) {
        $field["value"] = $data[$name];
    } elseif ($field["type"] == 'datetime-local') {
        $this->setDateTimeLocalToDefault($field["value"], $default);
    } else {
        $field["value"] = $default;
    }
    return $field;
}

/*
* toForm
* Build an array from the table structure with the available data
* merged into the table structure as value attribute.
* All elements from the hide array are kept out of the result
* Only elements from include array (when specified) are included
*/
public function toForm()
{
    $result = array();
    if (!property_exists(get_class($this), 'structure'))
        return $result;

    $nrArgs = func_num_args();
    $allArgs = func_get_args();
    if ($nrArgs < 2 || $nrArgs > 4)
        return $result;
    $data = array_shift($allArgs);
    $userSession = array_shift($allArgs);
    if ($nrArgs >= 3) {
        $hide = array_shift($allArgs);
    } else {
        $hide = "none";
    }
    if ($nrArgs >= 4) {
        $include = array_shift($allArgs);
    } else {
        $include = "all";
    }

    foreach ($this->structure as $name => $field) {
        if (is_array($include) && !in_array($name, $include))
            continue;
        //if (!$userSession->hasRole($field["role"])) continue;
        if (is_array($hide) && in_array($name, $hide))
            continue;
        $default = (array_key_exists("default", $field) ? $field["default"] : "");
        $field["name"] = $name;
        if (array_key_exists($name, $data)) {
            $field["value"] = $data[$name];
        } elseif ($field["type"] == 'datetime-local') {
            $this->setDateTimeLocalToDefault($field["value"], $default);
        } else {
            $field["value"] = $default;
        }
        array_push($result, $field);
    }
    return $result;
}

public function tbError($msg)
{
    if (!isset($msg)) {
        $msg = get_class($this) . ": " . mysql_error();
    }
    // genSetError($msg);
    genLogVar("DB error", $msg);
}

private function makeQueryTerm($arr)
{
    $retval = $arr["col"] . " " . $arr["oper"] . " ";
    if (is_array($arr["val"])) {
        $val = "('" . join("','", $arr["val"]) . "')";
    } else {
        $val = "'" . $arr["val"] . "'";
    }
    $retval .= $val;
    return $retval;
}

// Expects array(array(column, rel. operator, value)[, ...])
private function makeQueryClause($arr)
{
    if (0 == count($arr))
        return "";
    $whereClause = "";
    $elt = array_shift($arr);
    $result = "WHERE " . $this->makeQueryTerm($elt);
    while ($elt = array_shift($arr)) {
        $result .= " AND " . $this->makeQueryTerm($elt);
    }
    return $result;
}

private function makeWhereClause($arr)
{
    if (0 == count($arr))
        return "";
    $whereClause = "";
    $busy = false;
    foreach (array_keys($arr) as $key) {
        if ($busy) {
            $whereClause .= " and";
        } else {
            $whereClause = "where ";
        }
        $whereClause .= sprintf(' %s="%s"', $key, mysql_real_escape_string($arr[$key]));
        $busy = true;
    }
    return $whereClause;
}

private function makeOrderByClause($arr)
{
    $orderByClause = "";
    if (count($arr) > 0)
        $orderByClause = "ORDER BY";
    $sep = "";
    foreach ($arr as $key => $val) {
        $orderByClause .= " $sep $key $val";
        $sep = ",";
    }
    return $orderByClause;
}

private function isUniqueWhereClause($whereClause)
{
    $cmd = sprintf("select * from %s %s", $this->table, $whereClause);
    $result = mysql_query($cmd);
    if (!$result) {
        $this->tbError(null);
        return false;
    }
    $numRows = mysql_num_rows($result);
    switch ($numRows) {
        case 1:
            return true;
            break;
        default:
            $this->tbError(sprintf("%d rows in %s %s", $numRows, $this->table, $whereClause));
            return false;
            break;
    }
}

public function addTerm(&$list, $column, $oper, $val)
{
    $operIdx = array_search($oper, $this->operators);
    if ($operIdx === false) {
        genSetError(__file__ . ":" . __function__ . ": unsupported operator in $column, $oper, $val");
        return false;
    }
    if (is_int($column)) {
        genSetError(__file__ . ":" . __function__ . ": InValid column name $column");
    }
    array_push($list, array(
        "col" => $column,
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
/**
 * whereArr = array(array(col => col, oper => oper, val => val)[, ...])
 */
public function readQuery()
{
    if (!genDBConnected()) {
        genSetError(__file__ . ":" . __function__ . " Geen database connectie");
        return false;
    }
    $nrArgs = func_num_args();
    $allArgs = func_get_args();
    if ($nrArgs > 4) {
        genSetError(__file__ . ":" . __function__ . "wrong number of arguments ($nrArgs)" .
            "expecting 0, 1 or 2");
        return false;
    }
    if ($nrArgs == 0) {
        $whereArr = array();
    } else {
        $whereArr = array_shift($allArgs);
    }
    if ($nrArgs >= 2) {
        $orderArr = array_shift($allArgs);
    } else {
        $orderArr = array();
    }
    if ($nrArgs >= 3) {
        $cols = join(",", array_shift($allArgs));
    } else {
        $cols = "*";
    }
    if ($nrArgs >= 4) {
        $distinct = array_shift($allArgs);
    } else {
        $distinct = "";
    }
    if (!is_array($whereArr)) {
        genLogVar(__function__ . ":" . __line__ . ": arg 1 is not an array of arrays:",
            $whereArr);
        return false;
    }

    foreach ($whereArr as $elt) {
        if (!is_array($elt)) {
            genLogVar(__function__ . ":" . __line__ . ": arg 1 is not an array of arrays:",
                $whereArr);
            return false;
        }
        if (array_key_exists("col", $elt)) {
            if (is_int($elt["col"]) || !array_key_exists($elt["col"], $this->structure)) {
                genLogVAr(__function__ . ": invalid column name: '" . $elt["col"] . "'");
                logvar(__function__ . "whereArr=", $whereArr);
                logvar(__function__ . "colums are ", $this->structure);
                return false;
            }
        } else {
            genLogVAr(__function__ . "invalid whereArr:", $whereArr);
            break;
        }
    }

    $cmd = sprintf("select %s %s from %s %s %s", $distinct, $cols, $this->table, $this->
        makeQueryClause($whereArr), $this->makeOrderByClause($orderArr));
    //genSetError(__FUNCTION__.":".__LINE__." cmd=$cmd");
    $result = mysql_query($cmd);
    if (!$result) {
        $this->tbError($cmd);
        $this->tbError(null);
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
    $nrArgs = func_num_args();
    $allArgs = func_get_args();
    if ($nrArgs < 1 || $nrArgs > 2) {
        genSetError(__file__ . ":" . __function__ . "wrong numner of arguments ($nrArgs)" .
            "expecting 1 or 2");
        return false;
    }
    $whereArr = array_shift($allArgs);
    if ($nrArgs > 1) {
        $orderArr = array_shift($allArgs);
    } else {
        $orderArr = array();
    }

    if (!genDBConnected()) {
        genSetError(__file__ . ":" . __function__ . " Geen database connectie");
        return false;
    }
    $testKeys = array_keys($whereArr);
    if (count($testKeys) && is_int($testKeys[0])) {
        genSetError(__file__ . ":" . __function__ . "Numerieke kolomnaam");
        return false;
    }
    $cmd = sprintf("select * from %s %s %s", $this->table, $this->makeWhereClause($whereArr),
        $this->makeOrderByClause($orderArr));
    $result = mysql_query($cmd);
    if (!$result) {
        $this->tbError(null);
    }
    return $result;
}

public function insert($arr)
{
    if (!genDBConnected())
        return false;
    // Keys of $arr must be non-numeric
    // That makes $arr an associatve array
    $testKeys = array_keys($arr);
    if (!count($testKeys)) {
        $this->tbError("Leeg record kan niet worden ingevoerd");
        return false;
    }
    if (is_int($testKeys[0])) {
        $this->tbError(__file__ . ":" . __function__ . "ongeldige kolomnaam: ", $testKey[0]);
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
        #if (is_numeric($arr[$key])) {
        #	$valList .= $arr[$key];
        #    } else {
        $valList .= '"' . mysql_real_escape_string(iconv("UTF-8", "UTF-8//IGNORE", $arr[$key])) .
            '"';
        #    }
    }
    $sqlcmd = sprintf("INSERT INTO %s (%s) values (%s)", $this->table, $colList, $valList);
    genLogVar(__class__ . ":" . __function__ . ":" . __line__ . " insert Command: ",
        $sqlcmd);
    $result = mysql_query($sqlcmd);
    if ($result) {
        $this->lastId = mysql_insert_id();
    } else {
        genLogVar("mysql Error", mysql_error());
        $this->tbError(null);
        return false;
    }
    return true;
}

/*
* delete must delete just a single row in every call
* hence the hassle with the sellect before the delete.
*/
public function delete($arr)
{
    if (!genDBConnected())
        return false;
    $whereClause = $this->makeWhereClause($arr);
    if (!$this->isUniqueWhereClause($whereClause)) {
        $msg = __file__ . ":" . __function__ . " attempting multiple delete " . $whereclause;
        //genSetError($msg);
        genLogVar("delete", $msg);
        return false;
    }
    $cmd = sprintf("DELETE FROM %s %s", $this->table, $whereClause);
    $result = mysql_query($cmd);
    if (!$result) {
        genLogVar("line :" . __line__ . ": ", $cmd);
        $this->tbError(null);
        return false;
    }
    return true;
}

public function deleteMany($arr)
{
    if (!genDBConnected())
        return false;
    $whereClause = $this->makeWhereClause($arr);

    $cmd = sprintf("DELETE FROM %s %s", $this->table, $whereClause);
    $result = mysql_query($cmd);
    if (!$result) {
        genLogVar("Line:" . __line__ . ": ", $cmd);
        $this->tbError(null);
    }
    return $result;
}
/*
* update must update just a single row in every call
* hence the hassle with the select before the update.
*/
public function update($old, $new)
{
    if (!genDBConnected())
        return false;
    $whereClause = $this->makeWhereClause($old);
    if (!$this->isUniqueWhereClause($whereClause))
        return false;

    $busy = false;
    foreach (array_keys($new) as $key) {
        if ($busy) {
            $setClause .= ",";
        } else {
            $setClause = "SET";
        }
        $setClause .= sprintf(' %s="%s"', $key, mysql_real_escape_string(iconv("UTF-8",
            "UTF-8//IGNORE", $new[$key])));
        $busy = true;
    }
    if ($busy) {
        $cmd = sprintf("UPDATE %s %s %s", $this->table, $setClause, $whereClause);
        $result = mysql_query($cmd);
        if (!$result) {
            genLogVar("Line:" . __line__, $cmd);
            $this->tbError(null);
            return false;
        }
    }
    return true;
}

public function getColumns()
{
    if (!genDBConnected())
        return false;
    // The number of available fieldnames returned by
    // mysql_list_fields is unknown. But this is a sweet
    // workaround
    // Step 1: get the nr of columns
    $result = mysql_query("SHOW COLUMNS FROM " . $this->table);
    if (!$result) {
        $this->tbError(null);
        return false;
    }
    $nrOfColumns = mysql_num_rows($result);
    // Step 2: get the column names
    $columns = array();
    $result = mysql_list_fields(SQL_DBASE, $this->table);
    for ($i = 0; $i < $nrOfColumns; $i++) {
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

public function query($sqlCmd)
{
    $result = mysql_query($sqlCmd);
    if (!$result) {
        $this->tbError(null);
    }
    return $result;
}

public function get($arr)
{
    $retval = false;
    $query = $this->readQuery($arr);
    if ($query) {
        if (mysql_num_rows($query) == 1) {
            $retval = $this->fetch_assoc($query);
        } else {
            $this->tbError(__class__ . ":" . __function__ . ": " . mysql_num_rows($query) .
                " rijen gevonden ");
        }
    } else {
        $this->tbError(null);
    }
    return $retval;
}

public function getLabel($col)
{
    if (!property_exists(get_class($this), 'structure'))
        return $col;
    if (!array_key_exists($col, $this->structure))
        return "Onbekend: $col";
    if (strlen($this->structure[$col]["label"]) == 0)
        return $col;
    return $this->structure[$col]["label"];
}
}
?>
