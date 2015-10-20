<?php
/*
 * dataimport.lib.php
 * Classes for importing structured textfiles
 *
 * 20-10-2011 Huug
 */

require_once "general.lib.php";
require_once "users.lib.php";
error_reporting(E_ALL);

class importUsers extends general
{

	private $formStep = 0;
	private $importColumns=array();
	private $resident = array(
		"importFile" => "",
		"formStep" => 0,
		"destColumn" => array(),
		"primaryMatchColumn" => "",
		"alternateMatchColumn" => ""
	);
	private $uploadedUsers = array();
	private $qualifiedUsers = array();
	private $objUsers;
	private $uniqueKey;
	private $primaryMatchColumn;
	private $alternateMatchColumn;

	private $defined = array(
		"decisions" => array(
			"SKIP" => "Overslaan",
			"INSERT" => "Nieuw",
			"UPDATE" => "Bijwerken"
		)
	);

	public function __construct($fileName)
	{
		$this->objUsers = new users();
		$this->setResident($_POST);
		if (!isSet($fileName) || strlen($fileName)==0) {
			if (strlen($this->resident["importFile"]) > 0) {
				$this->loadImportFile(
					$this->resident["importFile"]);
			}
		} else {
			$this->setImportFile($fileName);
		}
	}

	public function getDecisions()
	{
		return $this->defined["decisions"];
	}
	
	public function setResident($arr)
	{
		foreach(array_keys($this->resident) as $key) {
			if (is_array($this->resident[$key])) {
				$this->resident[$key] = genGetArrayFromArray($arr, $key);
			} elseif (array_key_exists($key, $arr)) {
				$this->resident[$key] = $arr[$key];
			}
		}
	}

	public function loadImportFile()
	{
		if (!is_readable(FILE_UPLOAD_DIR."/".$this->resident["importFile"])) {
			genSetError("Unable to read ".$this->resident["importFile"]);
			return false;
		}
		$contents = file_get_contents(FILE_UPLOAD_DIR."/".$this->resident["importFile"]);
		// This only works for iso-8859 encoded strings
		// But thats what you 'll most likely get from a .csv file
		$contents = utf8_encode($contents);
		$lines = preg_split("/\n/", $contents);
		$lineNr = 0;
		$fields = array();
		while ($line = array_shift($lines)) {
			$lineNr++;
			$fields = preg_split("/;/", $line);
			if ($fields[1]) {
				break;
			}
		}
		// $fields should hold the columnnames
		$this->importColumns = $fields;
		$nrOfColumns = count($this->importColumns);

		$i = 0;
		$this->uploadedUsers = array();
		$ok = true;
		while ($line = array_shift($lines)) {
			$lineNr++;
			if (!strlen($line)) continue;
			$fields = preg_split("/;/", $line);
			if (count($fields) != $nrOfColumns) {
				$ok = false;
				genSetError("Aantal velden op regel ".
					$lineNr." (".count($fields).") ".
					"wijkt af van aantal kolommen (".
					$nrOfColumns.")");
			}
			$this->uploadedUsers[$i++] = $fields;
		}
		return $ok;
	}

	public function getDefined()
	{
		return $this->defined;
	}

	public function getImportColumns()
	{
		return $this->importColumns;
	}

	public function getImportColumnCount()
	{
		return count($this->getImportColumns());
	}

	public function setDestColumn($destColumn)
	{
		$errors = array();
		$cols = array();
		foreach (array_keys($destColumn) as $colNr) {
			$val = $destColumn[$colNr];
			if (strlen($val)==0) continue;
			if (array_key_exists($val, $cols)) {
				if (!array_key_exists($val, $errors)) {
					$errors[$val] = array($colNr);
				}
				array_unshift($errors[$val], $colNr);
			} else{
				$cols[$val] = $val;
			}
		}
		foreach ($errors as $key => $arr) {
			genSetError("Kolomnaam ". $key. " is " .count($arr). "x geselecteerd");
		}
		$this->resident["destColumn"] = $destColumn;
		return (count($errors) == 0);
	}

	public function getUploadedUsers()
	{
		return $this->uploadedUsers;
	}

	public function getQualifiedUsers()
	{
		return $this->qualifiedUsers;
	}

	public function getTableColumns()
	{
		return $this->objUsers->getColumns();
	}

	public function getFormStep()
	{
		return $this->resident["formStep"];
	}

	public function setFormStep($formStep)
	{
		$this->resident["formStep"] = $formStep;
	}

	public function getUniqueKey()
	{
		if (isset($this->resident["uniqueKey"])) {
			return $this->resident["uniqueKey"];
		} else {
			return "";
		}
	}

	public function setUniqueKey($key)
	{
		$this->resident["uniqueKey"] = $key;
		if (isset($this->resident["destColumns"])  && 
			0!=count(array_intersect($this->resident["destColumns"], array($key)))) {
			genSetError("De waarde van \"Uniek veld\" (".
				$key.") is een geselecteerde kolom");
			return false;
		}
		return true;
	}

	public function getPrimaryMatchColumn()
	{
		if (isset($this->resident["primaryMatchColumn"])) {
			return $this->resident["primaryMatchColumn"];
		} else {
			return "";
		}
	}

	public function setPrimaryMatchColumn($col)
	{
		$this->resident["primaryMatchColumn"] = $col;
		if (isset($this->resident["destColumns"])  && 
			0==count(array_intersect($this->resident["destColumns"], array($col)))) {
			genSetError("De waarde van \"Koppel veld\" (".
				$col.") is geen geselecteerde kolom");
			return false;
		}
		return true;
	}

	public function getAlternateMatchColumn()
	{
		if (isset($this->resident["alternateMatchColumn"])) {
			return $this->resident["alternateMatchColumn"];
		} else {
			return "";
		}
	}

	public function setAlternateMatchColumn($col)
	{
		$this->resident["alternateMatchColumn"] = $col;
		if (isset($this->resident["destColumns"])  && 
			0==count(array_intersect($this->resident["destColumns"], array($col)))) {
			genSetError("De waarde van \"2e koppel veld\" (".
				$col.") is geen geselecteerde kolom");
			return false;
		}
		return true;
	}

	public function getImportFile()
	{
		if (isset($this->resident["importFile"])) {
			return $this->resident["importFile"];
		} else {
			return "";
		}
	}

	private function genFlattenArray($key, $val)
	{
		if (!is_array($val)) return array($key=>$val);
		$result = array();
		foreach ($val as $key2 => $val2) {
			$arr = $this->genFlattenArray( $key."_".$key2, $val2);
			foreach ($arr as $key3 => $val3) {
				$result[$key3] = $val3;
			}
		}
		return $result;
	}

	public function getResident()
	{
		$result = array();
		foreach ($this->resident as $key => $val) {
			if (is_array($val)) {
				$arr = $this->genFlattenArray($key, $val);
				foreach($arr as $key2 => $val2) {
					$result[$key2] = $val2;
				}
			} else {
				$result[$key] = $val;
			}
		}
		return $result;
	}

	public function setImportFile($file)
	{
		if (!isset($file) || strlen($file)==0) {
			genSetError("geen naam als importbestand");
			return false;
		}

		if (!file_exists(FILE_UPLOAD_DIR."/".$file)) {
			genSetError("Bestand bestaat niet: ".$file);
			return false;
		}
		$this->resident["importFile"] = $file;

		return $this->loadImportFile();
	}

	private function matchUser($uploadedUser)
	{
		$result = array();
		$result["upload"] = array();
		$primQuery = array();
		$altQuery = array();
		if (!array_key_exists("destColumn", $this->resident)) return $result;
		if (!is_array($this->resident["destColumn"])) return $result;
		foreach(array_keys($this->resident["destColumn"]) as $i) {
			$col = $this->resident["destColumn"][$i];
			if (strlen($col) == 0) {genSetError($msg); continue; }
			if ($col == $this->resident["primaryMatchColumn"]) {
				if (strlen($uploadedUser[$i]) > 0) {
					$primQuery[$col] = $uploadedUser[$i];
				}
			} elseif ($col == $this->resident["alternateMatchColumn"]) {
				if (strlen($uploadedUser[$i]) > 0) {
					$altQuery[$col] = $uploadedUser[$i];
				}
			}
			$result["upload"][$col] = $uploadedUser[$i];
		}

		if (count($primQuery) == 0) $primQuery = $altQuery;
		$read = $this->objUsers->readSelect($primQuery);
		if (mysql_num_rows($read)==0) {
			$read = $this->objUsers->readSelect($altQuery);
		}
		if ($read) {
			$result["data"] = array();
			$result["match"] = array();
			while ($rec=mysql_fetch_assoc($read)) {
				array_push($result["data"], $rec);
				array_push($result["match"], $rec[$this->resident["uniqueKey"]]);
			}
		} else {
			return false;
		}
		return $result;
	}

	public function getMatchUsers()
	{
		$result = array();
		if (count($this->uploadedUsers)==0) {
			genSetError("Geen records geladen uit bestand \"".
				$this->resident["importFile"]."\"");
		}
		foreach ($this->uploadedUsers as $uploadedUser) {
			$userMatch = $this->matchUser($uploadedUser);
			if ($userMatch === false) continue;
			array_push($result, $userMatch);
		}
		return $result;
	}
}
?>
