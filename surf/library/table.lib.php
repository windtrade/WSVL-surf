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
    private $listOperators = array(
        "IN",
        "NOT IN"
    );
    private $singleOperators = array(
        "=",
        "!=",
        "<",
        ">",
        "<=",
        ">="
    );

    private $operators;

    protected $pdo;
    protected $whereArray;
    protected $columns;
    protected $orderArray;
    protected $groupArray;
    protected $distinct;

    public function __construct($table)
    {
        global $pdoGlobal;
        $this->operators = array_merge(
            $this->singleOperators,
            $this->listOperators);
        $this->table = SQL_PREFIX . $table;
        if ($pdoGlobal == null) {
            $this->makePDO();
        }
        $this->initQuery();
    }
    public function initQuery() {
        $this->whereArray = array(
            'terms' => array(),
            'data' => array()
        );
        $this->orderArray =  array();
        $this->groupArray =  array();
        $this->columns = array();
        $this->distinct = "";
    }
    private function makePDO() {
        global $pdoGlobal;
        try {
            $dsn = sprintf('mysql:dbname=%s;host=%s', SQL_DBASE, SQL_DBHOST);
            $pdoGlobal = new PDO ($dsn,
                SQL_DBUSER,
                SQL_DBPSWD);
            $pdoGlobal->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdoGlobal->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (exception $e) {
            genLogVar(__FUNCTION__." PDO error ", $e->getMessage());
            die("Aaarghhhh! No Database :-(");
        }
    }

    /**
     * Normalize values to match the possible values in the database
     */
    protected function normalizeRecord($rec)
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

    public function fetch_assoc($sth)
    {
        if (!$sth) return false;
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $row = $this->reformatRow($row);
        }
        return $row;
    }

    public function fetch_assoc_all($sth)
    {
        $result = array();
        while ($row = $this->fetch_assoc($sth)) {
            array_push($result, $row);
        }
        return $result;
    }

    private function reformatRow($row) {
        $hasStructure = property_exists(get_class($this), 'structure');
        foreach ($row as $k => $v) {
            $row[$k] = iconv("UTF-8", "UTF-8//IGNORE", $v);
            if (!$hasStructure || !array_key_exists($k, $this->structure))
                continue;
            if ($this->structure[$k]["type"] == "datetime_local") {
                $row[$k] = preg_replace("/ /", "T", $row[$k], 1);
            }
        }
        return $row;
    }

    private function isValidTel(&$val)
    {
        
        $newVal = preg_replace("/[*\-+()\s]/", "", $val);
        $result = $newVal == "" || preg_match("/^[0-9]{10,15}$/", $newVal);
        if ($result) {
            $val = $newVal;
        }
        return $result;
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
                $msg = "niet ingevuld";
                $fieldOK = false;
            }
            if ($fieldOK) {
                $data[$key] = stripslashes($data[$key]);
                if ($struct["type"] == "number" && !preg_match("/^\d+$/", $data[$key])) {
                    $msg = "geen getal: \"" . $data[$key] . "\"";
                    $fieldOK = false;
                } elseif ($struct["type"] == "datetime-local") {
                    if (!$this->fixDateTimeLocal($data[$key], $struct)) {
                        $msg = "niet correct ingevuld";
                        $fieldOK = false;
                    }
                } elseif ($struct["type"] == "checkbox" && ($data[$key] != $struct["checked"] &&
                $data[$key] != $struct["default"])) {
                    $msg = "vreemde waarde: \"" . $data[$key] . "\"";
                    $fieldOK = false;
                } elseif ($struct["type"] == "tel") {
                    $fieldOK = $this->isValidTel($data[$key]);
                    if (!$fieldOK) {
                        $msg = $struct["msg"];
                    }
                } elseif ($fieldOK && array_key_exists("regexp", $struct) && $struct["regexp"] != "") {
                    $regex = "/^" . $struct["regexp"] . "\$/";
                    if (!preg_match($regex, $data[$key])) {
                        $fieldOK = false;
                        if (array_key_exists("msg", $struct) && $struct["msg"] != "") {
                            $msg = $struct["msg"];
                        } else {
                            $msg = "is niet correct ingevuld";
                        }
                    }
                }
            }
            if (!$fieldOK) {
                genLogVar("Veld '" . $struct["label"], $msg);
                genSetError("Veld '" . $struct["label"] . "': " . $msg);
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
        global $pdoGlobal;
        $errorInfo = $pdoGlobal->errorInfo();
        if (!$errorInfo[0]) return false;
        if (!isset($msg)) {
            $msg = get_class($this) . " PDO error: " . $errorInfo[0] . "=" . $errorInfo[2];
        }
        genLogVar("DB error", $msg);
        print $msg;
        return true;
    }

    // TODO: fix this one
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

    /**
     * @param $arr - array of query terms
     * @return string "WHERE ...." or ""
     * @throws Exception
     */
    private function makeWhereClause()
    {
        $reason = 'faulty query array';
        $result = join(" AND ", $this->whereArray['terms']);
        if (strlen($result) > 0) $result = "WHERE ".$result;
        // we used to be able to have clauses with multiple values, do we need 'm
        // if (0 == count($arr))
        //     return "";
        // $whereClause = "";
        // $elt = array_shift($arr);
        // $result = "WHERE " . $this->makeQueryTerm($elt);
        // while ($elt = array_shift($arr)) {
        //     $result .= " AND " . $this->makeQueryTerm($elt);
        // }
        return $result;
    }

    public function makeWhereClauseExpanded()
    {
        $result = array();
        for ($i = 0; $i < count($this->whereArray['terms']); $i++) {
            array_push($result,
                $this->whereArray['terms'][$i].
                $this->whereArray['data'][$i]
            );
        }
        return join(" AND ", $result);
    }
/**
    private function makeWhereClauseObsolete($arr)
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
            $whereClause .= sprintf(' %s="%s"', $key, myOBSOLETEsql_real_escape_string($arr[$key]));
            $busy = true;
        }
        return $whereClause;
    }
*/
    private function makeOrderByClause()
    {
        $orderByClause = "";
        if (count($this->orderArray) > 0) {
            $orderByClause = "ORDER BY " . join(", ", $this->orderArray);
        }
        return $orderByClause;
    }
    
    public function makeGroupByClause()
    {
        $groupByClause = "";
        if (count($this->groupArray) > 0) {
            $groupByClause = "GROUP BY " . join(", ", $this->groupArray);
        }
        return $groupByClause;
    }

    public function isUniqueWhereClause()
    {
        global $pdoGlobal;
        $this->addColumn("count(*) cnt");
        $sth = $this->readQuery();
        if (!$sth) {
            $this->tbError(null);
            return false;
        }
        $row = $this->fetch_assoc($sth);
        switch ($row['cnt']) {
            case 1:
                return true;
                break;
            default:
                $this->tbError(sprintf("%d rows in %s %s",
                    $row['cnt'],
                    $this->table,
                    $this->makeWhereClauseExpanded()));
                return false;
                break;
        }
    }

    /**
     * @param $column
     * @param $operator:  valid
     * @param $values: mixed value or array of values
     * @return bool valid term or not
     */
    public function addTerm($column, $operator, $values)
    {
        if (!is_array($values)) $values = array($values);
        $parameters = array_merge(array(), $values);
        foreach ($parameters as $key => $value) {
            $parameters[$key] = "?";
        }
        $parameterString = " (".join(",", $parameters).")";
        $operatorIdx = array_search($operator, $this->operators);
        if ($operatorIdx === false) {
            throw new Exception(__CLASS__ . ":" . __FUNCTION__ .
                ": unsupported operator in $column, $operator, (".
                join(", ", array($values)).")"
            );
        }
        if (!$this->hasColumn($column)) {
            throw new Exception("$column does not exist in ".$this->table);
        }
        array_push($this->whereArray['terms'], $column." ".$operator. $parameterString);
        $this->whereArray['data'] = array_merge($this->whereArray['data'], $values);
        return true;
    }

    public function addColumn($column) {
        if (!$this->hasColumn($column)) {
            throw new Exception("$column does not exist in ".$this->table);
        }
        array_push($this->columns, $column);
    }

    public function addColumns() {
        $all_args = func_get_args();
        foreach ($all_args as $column) {
            $this->addColumn($column);
        }
    }

    private function isValidWhereArray() {
        if (!is_array($this->whereArray)) return false;
        if (!array_key_exists('terms', $this->whereArray)) $this->whereArray['terms'] = array();
        if (!array_key_exists('data', $this->whereArray)) $this->whereArray['data'] = array();
        if (count($this->whereArray) != 2 || (count($this->whereArray['terms']) != count($this->whereArray['data']))) {

            return false;
        }
        foreach ($this->whereArray as $elt) {
            if ($this->isValidWhereClause($elt)) return false;
        }
        return true;
    }
    private function isValidWhereClause($elt) {
        if (!is_array($elt)) {
            genLogVar(__CLASS__.":".__FUNCTION__.": faulty element:", $elt);
            return false;
        }
        if (array_key_exists("col", $elt)) {
            if (is_int($elt["col"]) || !array_key_exists($elt["col"], $this->structure)) {
                genLogVAr(__CLASS__.":".__FUNCTION__.": invalid column name: '" . $elt["col"] . "'");
                GenLogVar(__CLASS__.":".__function__ . "colums are ", $this->structure);
                return false;
            }
        } else {
            genLogVAr(__CLASS__.__function__ . "invalid whereArr (missing column name):", print_r($elt,true));
            return false;
        }
        return true;
    }

    public function addOrderTerm($column, $order) {
        if (!$this->hasColumn($column)) {
            throw new Exception("Invalid column: ".print_r($column, true));
        }
        array_push($this->orderArray, "$column $order");
    }

    public function addGroupTerm() {
        $columns = func_get_args();
        foreach ($columns as $column) {
            if (!$this->hasColumn($column)) {
                throw new Exception("Invalid column: " . print_r($column, true));
            }
            array_push($this->groupArray, $column);
        }
    }

    public function addDistinct()
    {
        $this->distinct = "DISTINCT";
    }

    /**
     * Test whether the aggregate contains an existing column
     * It is not the perfect test, but it helps for stupid typos
     * @param $aggregate some aggregate containing a column
     * @return bool
     */
    private function hasColumn($aggregate) {
        if (!property_exists($this, 'structure')) return true;
        if (!is_array($this->structure)) return true;
        $parts = preg_split('/[-+()]/', $aggregate);
        $wantCount = false;
        while (count($parts)) {
            $column = array_shift($parts);
            $wantCount = (strtolower($column) == "count"? true: $wantCount);
            if ($wantCount && ($column=='*')) return true;
            if (is_numeric($column)) continue;
            if (array_key_exists($column, $this->structure)) return true;
        }
        return false;
    }

    /*!
    * Read according to optional query ordered according to order argument
    *
    * \code
    * $result = $table->readQuery([ $whereArr[, $orderArr[, what]]]);
    * \endcode
    * ** Example
    * \code
    * // Select all
     * $table->initQuery();
    * $sth = $table->readQuery();
    * while ($row = $table->fetch_assoc($sth)) {
    *     print_r($row);
    * }
    * // Select some
     * $table->initQuery();
    * $table->addTerm('modifiedDate', '>', "2013-03-08");
    * $sth = $table->readQuery();
    * while ($row = $table->fetch_assoc($sth)) {
    *     print_r($row);
    * }
    * // Select some in some order
    * $table->addTerm('modifiedDate', '>', "2013-03-08")
    * $table=>addOrderTerm("modifiedDate',"DESC");
     * $table->addOrderTerm('category' => 'ASC');
    * $sth = $table->readQuery($whereArr), $orderArr);
    * while ($row = $table->fetch_assoc($sth)) {
    *     print_r($row);
    * }
    * \endcode
    */
    public function readQuery()
    {
        global $pdoGlobal;

        //foreach ($this->whereArray['terms'] as $elt) {
        //    if (!is_array($elt)) {
        //        print_r($elt);
        //        genLogVar(__function__ . ":" . __line__ . ": arg 1 is not an array of arrays:",
        //            $this->whereArray);
        //        genLogVar(__CLASS__.":".__FUNCTION__.": faulty element:", $elt);
        //        return false;
        //    }
        //    if (array_key_exists("col", $elt)) {
        //        if (is_int($elt["col"]) || !array_key_exists($elt["col"], $this->structure)) {
        //            genLogVar(__CLASS__.":".__FUNCTION__.": invalid column name: '" . $elt["col"] . "'");
        //            GenLogVar(__CLASS__.":".__function__ . "whereArr=", $this->whereArray);
        //            GenLogVar(__CLASS__.":".__function__ . "colums are ", $this->structure);
        //            return false;
        //        }
        //    } else {
        //        genLogVAr(__CLASS__.__function__ . "invalid whereArr (missing column name):", $this->whereArray);
        //        break;
        // //}
        //}

        $cols = join(', ', $this->columns);
        if (strlen($cols) == 0) $cols = '*';
        $cmd = sprintf("select %s %s from %s %s %s %s", $this->distinct, $cols, $this->table,
            $this->makeWhereClause(), $this->makeGroupByClause(), $this->makeOrderByClause());
        $result = $pdoGlobal->prepare($cmd);
        //genSetError(__FUNCTION__.":".__LINE__." cmd=$cmd");
        $result->execute($this->whereArray['data']);
        if (!$result) {
            $this->tbError($cmd);
            $this->tbError(null);
        }
        return $result;
    }

    /**
     * @param whereArr( optional) for readSelect, default empty array
     * @param orderArr( optional) for readSelect, default empty array
     * @return array|bool
     */
    public function getSelect()
    {
        $allArgs = func_get_args();
        if (count ($allArgs) > 2) {
            $this->tbError(__CLASS__ . ":" . __FUNCTION__ . ": Too many arguments: " . join(", ", $allArgs));
            return false;
        }
        $whereArr = array();
        if (count($allArgs))
        {
            $whereArr = array_shift($allArgs);
        }
        $orderArr = array();
        if (count($allArgs))
        {
            $orderArr = array_shift($allArgs);
        }

        $sth = $this->readSelect($whereArr, $orderArr);
        return $this->fetch_assoc_all($sth);
    }

    /**
     * @return array all rows matching the prepared query
     */
    public function getQuery()
    {
        $sth = $this->readQuery();
        return $this->fetch_assoc_all($sth);
    }

    /**
     * @param whereArr assoc array, each element is interpreted as <column> = <value> in the query
     * @param orderArr( optional) for readSelect, (default empty) assoc array, each element is interpreted
     *          order by <column> <order>
     * @return array|bool
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


        $this->initQuery();
        foreach ($whereArr as $key => $value) {
            $this->addTerm($key, '=', $value);
        }
        foreach ($orderArr as $key => $value) {
            $this->addOrderTerm($key, $value);
        }
        return $this->readQuery();
    }

    public function insert($arr)
    {
        global $pdoGlobal;
        if ($pdoGlobal == null)return false;
        // Keys of $arr must be non-numeric
        // That makes $arr an associative array
        if (!count($arr)) {
            $this->tbError("Leeg record kan niet worden ingevoerd");
            return false;
        }
        $cols = array();
        $placeHolders = array();
        $values = array();
        foreach ($arr as $key => $value) {
            if (!$this->hasColumn($key)) {
                throw new Exception("Column $key not defined in ".$this->getTable());
            }
            array_push($cols, $key);
            array_push($placeHolders,"?");
            array_push($values, $value);
        }
        $colList = join(", ", $cols);
        $placeHolderList = join(", ", $placeHolders);
        $sqlcmd = sprintf("INSERT INTO %s (%s) values (%s)", $this->table, $colList, $placeHolderList);
        genLogVar(__class__ . ":" . __function__ . ":" . __line__ . " insert Command: ",
            $sqlcmd);
        $sth = $pdoGlobal->prepare($sqlcmd);
        $result = $sth->execute($values);
        if ($result) {
            $this->lastId = $pdoGlobal->lastInsertId();
        } else {
            $this->tbError(null);
            return false;
        }
        return true;
    }
    public function assocToWhere($assoc)
    {
        $this->initQuery();
        foreach ($assoc as $column => $value) {
            $this->addTerm($column, "=", $value);
        }
    }

    /*
    * delete must delete just a single row in every call
    * hence the hassle with the select before the delete.
    */
    public function delete($old)
    {
        global $pdoGlobal;
        $this->assocToWhere($old);
        $whereClause = $this->makeWhereClause();
        if (!$this->isUniqueWhereClause()) {
            $msg = __file__ . ":" . __function__ . " attempting multiple delete " . $whereClause;
            //genSetError($msg);
            genLogVar(__FUNCTION__, $msg);
            return false;
        }
        $cmd = sprintf("DELETE FROM %s %s", $this->table, $whereClause);
        $sth = $pdoGlobal->prepare($cmd);
        $result = $sth->execute($this->whereArray['data']);
        if (!$result) {
            genLogVar("line :" . __line__ . ": ", $cmd);
            $this->tbError(null);
            return false;
        }
        return true;
    }

    public function deleteMany()
    {
        global $pdoGlobal;
        $whereClause = $this->makeWhereClause();

        $cmd = sprintf("DELETE FROM %s %s", $this->table, $whereClause);
        $sth = $pdoGlobal->prepare($cmd);
        $result = $sth->execute($this->whereArray['data']);

        if (!$result) {
            genLogVar(__FUNCTION__.":" . __line__ . ": ", $cmd);
            $this->tbError(null);
        }
        return $result;
    }
    /**
    * update must update just a single row in every call
    * hence the hassle with the select before the update.
     * @param $old: assoc array holding old values for columns
     * @param $new: assoc array holding zero or more new values
     * @return bool: indicating success
     */
    public function update($old, $new)
    {
        global $pdoGlobal;
        if (!$pdoGlobal) return false;
        $this->assocToWhere($old);
        if (!$this->isUniqueWhereClause()) {
            return false;
        }

        $updates = array();
        $data = array();
        foreach ($new as $key => $val) {
            array_push($updates, $key." = ?");
            array_push($data, $val);
        }
        if (!count($updates)) return true;
        $cmd = sprintf("UPDATE %s SET %s %s",
            $this->table,
            join(', ', $updates),
            $this->makeWhereClause());
        $data = array_merge($data, $this->whereArray['data']);
        $sth = $pdoGlobal->prepare($cmd);
        $result = $sth->execute($data);
        if (!$result) {
            genLogVar(__CLASS__.">".__FUNCTION__.":". __line__, $cmd);
            $this->tbError(null);
            return false;
        }
        return true;
    }

    public function getColumns()
    {
        if (property_exists($this, 'structure')) {
            return array_keys($this->structure);
        }
        return false;
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

    public function getOne($arr)
    {
        $retVal = false;
        $sth = $this->readSelect($arr);
        if ($sth) {
            if ($sth->rowCount() == 1) {
                $retVal = $this->fetch_assoc($sth);
            } else {
                $this->tbError(__class__ . ":" . __function__ . ": " . $sth->rowCount() .
                    " rijen gevonden ");
            }
        }
        return $retVal;
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

    /**
     * perform a parsedown on the contents of any field of type textarea
     */
    public function parseDown(&$row)
    {
        foreach ($row as $k => $v) {
            if (array_key_exists($k, $this->structure) && is_array($this->structure[$k])) {
                if ($this->structure[$k]["type"] == "textarea") {
                    $row[$k] = genParseDownParse($v);
                }
            }
        }
    }

    /**
     * convert a record to text in a label: value format
     * for fields with value matching any of their options the matching opotion is used
     */
    public function toText()
    {
        $nrArgs = func_num_args();
        $result = "";
        $data = ($nrArgs > 0 ? func_get_arg(0) : array());
        $html = ($nrArgs > 1 ? func_get_arg(1) : false);
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                if (array_key_exists($key, $this->structure) && array_key_exists("options", $this->
                    structure[$key]) && array_key_exists($val, $this->structure[$key]["options"])) {
                    $val = $this->structure[$key]["options"][$val];
                }
                $result .= $key . ":" . $val . "\n";
            }
        }
        if ($html) {
            $result = genParseDownParse($result);
        }
        return $result;
    }
}
?>
