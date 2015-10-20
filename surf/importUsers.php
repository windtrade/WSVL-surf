<?php
/*
 * importUsers.php
 *
 * Load a CSV file with user data and match it with
 * existing users
 *
 * 07-11-2011 Huug Creation
 */

error_reporting(E_ALL);
session_start();
require_once "library/all_config.inc.php";
require_once "general.lib.php";
require_once "database.lib.php";
require_once "users.lib.php";
require_once "dataimport.lib.php";

function validateUploadedFile(&$importObject)
{
	$file = $importObject->getImportFile();
	if (!isset($file) || strlen($file) == 0) {
		genSetError("Geen naam van upload bestand beschikbaar");
		return false;
	}

	if (!$importObject->loadImportFile()) return false;
	return TRUE;
}

function showColumnSelect($importObject)
{
	genSmartyAssign('impColumns', $importObject->getImportColumns());
	genSmartyAssign('tbColumns', $importObject->getTableColumns());
	genSmartyAssign('users', $importObject->getUploadedUsers());
}

function saveUploadedFile(&$importObject)
{
	if (!array_key_exists("importFile", $_FILES)) {
		genSetError("Geen upload bestand");
		return false;
	}
	$name = $_FILES["importFile"]["name"];
	if (!($_FILES["importFile"]["error"] === UPLOAD_ERR_OK)) {
		genSetError("Fout by uploaden van ".$name." fout ".$_FILES["importFile"]["error"]);
		return false;
	}
	$tmp_name = $_FILES["importFile"]["tmp_name"];
	$i = 1;
	$newName=FILE_UPLOAD_DIR."/".$name;
	while (file_exists($newName) && $i < 100) {
		$i++;
		$newName = FILE_UPLOAD_DIR."/".$name.".".sprintf("%02d", $i);
	}
	if ($i >= 100) {
		genSetError("Too many instances of $name");
		return false;
	}
	move_uploaded_file($tmp_name, $newName);
	// Keep the name, no directory info
	$importObject->setImportFile($name.".".sprintf("%02d", $i));
	return true;
}

function validateInputStep2(&$importObject)
{
	if (isset($_FILES) && array_key_exists("importFile", $_FILES)) {
		if (!saveUploadedFile($importObject)) return false;
		$_POST["importfile"] = $importObject->getImportFile();
	} elseif (!(isset($_POST) && array_key_exists("importFile", $_POST))) {
		genSetError("Geen import bestand beschikbaar");
		return false;
	}
	return validateUploadedFile($importObject);
}

function addPostValToArray(&$arr, $idx, $val)
{
	$thisIdx = array_shift($idx);
	// at the end of idx: just add value
	if (count($idx) == 0) {
		$arr[$thisIdx] = $val;
	} else {
		// multiple dimensions left: add array when necessary
		if (!array_key_exists($thisIdx, $arr)) {
			$arr[$thisIdx] = array();
		}
		addPostValToArray($arr[$thisIdx], $idx, $val);
	}
	return;
}

function getArrayFromArray($label)
{
	$arr = array();
	$match = "/^".$label."_"."/";
	foreach ($_POST as $key => $val) {
		if (!preg_match($match, $key)) continue;
		$idx = preg_split("/_/", $key);
		array_shift($idx); // drop the label
		if (!isset($dimensions)) $dimensions=count($idx);
		if (count($idx) != $dimensions) {
			genSetError("Post variables ".$label."_* have varying dimensions");
			return false;
		}
		addPostValToArray($arr, $idx, $val);
	}
	return $arr;
}

function validateInputStep3(&$importObject)
{
	$postOK = TRUE;
	$destColumn = genGetArrayFromArray($_POST, "destColumn");
	$uniqueKey = (array_key_exists("uniqueKey", $_POST)? $_POST["uniqueKey"]: "");
	$primaryMatchColumn = (array_key_exists("primaryMatchColumn", $_POST)? $_POST["primaryMatchColumn"]: "");
	$alternateMatchColumn = (array_key_exists("alternateMatchColumn", $_POST)? $_POST["alternateMatchColumn"]: "");
	// $destColumn moet:
	// - niet false zijn
	// - niet leeg zijn
	// - 1-dimensionaal zijn, test daarom het eerste element van het array
	// importObject test de inhoud
	//
	if ($destColumn === false) {
		$postOK = false;
	} elseif (count ($destColumn) == 0) {
		genSetError("Geen Bestemmings kolommen beschikbaar");
		$otherPostOk = false;
	} elseif (is_array($destColumn[array_shift(array_keys($destColumn))])) {
		genSetError("Bestemmingskolommen is meer-dimensionaal");
		$postOK = false;
	} elseif (!$importObject->setDestColumn($destColumn)) {
		$postOK = false;
	}

	if (strlen($uniqueKey) == 0) {
		genSetError("\"Uniek veld\" niet opgegeven");
		$postOK = false;
	} elseif ( !$importObject->setUniqueKey($uniqueKey)) {
		$postOK = false;
	}
	if (strlen($primaryMatchColumn) == 0) {
		genSetError("\"Koppelveld\" niet opgegeven");
		$postOK = FALSE;
	} elseif ( !$importObject->setPrimaryMatchColumn($primaryMatchColumn)) {
		$postOK = false;
	}
	if (strlen($alternateMatchColumn) == 0) {
		genSetError("\"2e koppelveld\" niet opgegeven");
		$postOK = false;
	} elseif ( !$importObject->setAlternateMatchColumn($alternateMatchColumn)) {
		$postOK = FALSE;
	}
	return $postOK;
}

function importDisplay($importObject)
{
	genAddJavascriptFile("formhandling");
	genSetFormStep($importObject->getFormstep());
	genSmartyAssign('importFile', $importObject->getImportFile());
	genSmartyAssign('uniqueKey', $importObject->getUniqueKey());
	genSmartyAssign('primaryMatchColumn', $importObject->getPrimaryMatchColumn());
	genSmartyAssign('alternateMatchColumn', $importObject->getAlternateMatchColumn());
	genSmartyAssign('impColumns', $importObject->getImportColumns());
	genSmartyAssign('tbColumns', $importObject->getTableColumns());
	genSmartyAssign('resident', $importObject->getResident());
	genSmartyAssign('defined', $importObject->getDefined());
	genSmartyDisplay("templates/wsvl_importUsers.tpl");
}

function importUsersStep1(&$importObject)
{
	// Not much doing here
}
function importUsersStep2(&$importObject)
{
	showColumnSelect($importObject);
	genSmartyAssign('users', $importObject->getUploadedUsers());
}

function importUsersStep3(&$importObject)
{
	$processingPage = $_SERVER['PHP_SELF'];
	$processingPage = preg_replace('/^(.*)(\.php)$/i', '${1}Process${2}', $processingPage);
	genAddJavascriptDeclaration("processingPage", $processingPage);
	$resident = $importObject->getResident();
	$uniqueKey = $resident["uniqueKey"];
	$matchUsers = array();
	$matchedUsers = $importObject->getMatchUsers();
	if (count($matchedUsers)>0) {
		$nrOfColumns = count($matchedUsers[0]["upload"]) +
		count($importObject->getDecisions()) + 1;
	} else {
		$nrOfColumns = 0;
	}
	$i = 0;
	foreach ($matchedUsers as $elt) {
		$name = "error_".$i;
		$errorField = "<td name=\"$name\" id=\"$name\" display=\"none\" colspan=\"$nrOfColumns\"></td>";
		array_push($matchUsers, $errorField);
		$uploadRow = "";
		$name = "decision_".$i;
		$decisions =$importObject->getDecisions();
		$resVal = (array_key_exists($name, $resident)? $resident[$name] : 
				array_shift(array_keys($decisions)));
		$data = "";
		foreach ( $importObject->getDecisions() as $val => $text) {
			$data .= "<td title=\"$text\">".
				($val=="UPDATE" && count($elt["match"])==0 ?
				"x" :
				"<input type=\"radio\" ".
				"name=\"$name\" ".
				"id=\"$name\" value=\"$val\"".
				($val==$resVal? " checked ":"").
				"onClick=processDecision() ".
				"/>").
				"</td>";
		}
		$uploadRow .= $data;
		$data = "";
		$name = "match_".$i;
		$resVal = (array_key_exists($name, $resident)? $resident[$name] : "");
		if (count($elt["match"]) > 0) {
			$data = "<select name=\"$name\", id=\"$name\">\n";
			$data .= "<option value=\"\">geen</option>\n";
			foreach ($elt["match"] as $val) {
				$data .= "<option value=\"$val\"".
					($val == $resVal? " selected=\"selected\"": "").
					">$val</option>\n";
			}
			$data .= "</select>\n";
		} else {
			$data = "<input type=\"hidden\" name=\"$name\" id=\"$name\" value=\"\" />geen";
		}
		$uploadRow .= "<td>$data</td>";
		foreach ($elt["upload"] as $key => $val) {
			$name="upload_".$i."_".$key;
			$uploadRow .= "<td>"."<input id=\"$name\" name=\"$name\"".
			       " type=\"text\" value=\"".$val."\" \></td>\n";
			$j = 0;
			foreach ($elt["data"] as $dbData) {
				// name data_<row>_<unique key>_<column>
				$j++;
			}
		}
		array_push($matchUsers, $uploadRow);
		$uploadKeys = array_keys($elt["upload"]);
		foreach ($elt["data"] as $dbData) {
			// empty cels to allow the radiobuttons + the unique key of the record
			$dataRow = "<td /><td /><td />";
			$dataRow .= "<td name=\"data_key_$i\">".$dbData[$uniqueKey]."</td>";
			for ($j=0 ; $j<count($uploadKeys) ; $j++) {
				$key = $uploadKeys[$j];
				$name = "data_".$i."_".$dbData[$uniqueKey]."_".$key;
				$val = $dbData[$key];
				$input = "<input id=\"$name\" name=\"$name\" ".
					"type=\"hidden\" value=\"".$val."\" />";
				$dataRow .= "<td>".$input.$val."</td>";
			}
			array_push($matchUsers, $dataRow);
		}
		$i++;
	}
	genSmartyAssign("matchUsers", $matchUsers);
}

$importObject = new importUsers("");

if (array_key_exists('step', $_POST)) {
	$step = $_POST['step'];
} else {
	$step = 1;
}
switch ($step) {
case 2:
	if (!validateInputStep2($importObject)) {
		$step--;
	}
	break;
case 3:
	if (!validateInputStep3($importObject)) {
		$step--;
	}
	break;
default:
	break;
}
$importObject->setFormStep($step);
switch ($step) {
case 1:
	importUsersStep1($importObject);
	break;
case 2:
	importUsersStep2($importObject);
	break;
case 3:
	importUsersStep3($importObject);
	break;
default:
	genSetError("Onbekende stap in ".__FILE__.": ".$step);
	$step = 1;
}
importDisplay($importObject);
?>
