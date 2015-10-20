<?php
session_start();
error_reporting(E_ALL);
header("Content-type: text/xml");
require_once "library/all_config.inc.php";
require_once "general.lib.php";
require_once "database.lib.php";
require_once "users.lib.php";
require_once "dataimport.lib.php";

$decision = genGetArrayFromArray($_REQUEST, 'decision');
$match = genGetArrayFromArray($_REQUEST, 'match');
$data = genGetArrayFromArray($_REQUEST, 'data');
$upload = genGetArrayFromArray($_REQUEST, 'upload');
$ok = true;
if (array_key_exists("uniqueKey", $_REQUEST)) {
	$uniqueKeyName = $_REQUEST["uniqueKey"];
} else {
	genSetError('Naam primaire sleutel ontbreekt');
	$ok = false;
}
$group = array();
$uniqueKey = array();
$status = array();
$recordError = array();

$users = new users();
if ($ok) {
	if (is_array($decision) && is_array($match) && is_array($data) && is_array($upload)) {
		$keys = array_keys($decision);
	} else {
		$ok = false;
		if (!is_array($decision)) genSetError("Parameter fout in 'decision'");
		if (!is_array($match)) genSetError("Parameter fout in 'match'");
		if (!is_array($data)) genSetError("Parameter fout in 'data'");
		if (!is_array($upload)) genSetError("Parameter fout in 'upload'");
	}
}
while ($ok && count($keys) > 0) {
	$thisKey = array_shift($keys);
	$thisDecision = $decision[$thisKey];
	$thisUniqueKey = 0;
	$thisStatus = 0;
	$thisError = "";
	genSetError("in de loop".', $thisDecision='.$thisDecision);
	if ($thisDecision == "INSERT") {
		if ($users->insert($upload[$thisKey])) {
			array_push($uniqueKey, $users->getLastId());
			$thisStatus = 1;
		} else {
			//$thisError = genGetError();
		}
	} else if ($thisDecision == "UPDATE") {
		genSetError('$thisKey='.$thisKey);
		if (array_key_exists($thisKey, $match)) {
			genSetError('$match[$thisKey]='.$match[$thisKey]);
		} else {
			genSetError('$match['.$thisKey.'] does not exist');
		}
		if (array_key_exists($thisKey, $match) && $match[$thisKey] > 0) {
			genSetError('$match[$thisKey]='.$match[$thisKey]);
			genSetError('count($data)='.count($data));
			// add uniquekey to the $data{}{} to be updated
			$data[$thisKey][$match[$thisKey]][$uniqueKeyName] = $match[$thisKey];
			if ($users->update($data[$thisKey][$match[$thisKey]],
				$upload[$thisKey])) {
					$thisUniqueKey = $match[$thisKey];
					$thisStatus = 1;
					genSetError("OK");
			} else {
				//$thisError = genGetError();
				genSetError("NOT OK");
			}
		} else {
			$thisMatch = (array_key_exists($thisKey, $match) ? $thisKey: "undefined");
			$thisError = "Key \"". $thisMatch."\" not valid";
		}
	} else if ($thisDecision == "SKIP") {
		$thisStatus = 1;
	} else {
		genSetError("Keuze wordt niet ondersteund:\"".$thisDecision."\"");
		$ok = false;
		continue;
	}
	array_push($group, $thisKey);
	array_push($uniqueKey, $thisUniqueKey);
	array_push($status, $thisStatus);
	array_push($recordError, $thisError);
}
/*
genSetError("count(group)=".count($group));
genSetError("count(uniqueKey)=".count($uniqueKey));
genSetError("count(status)=".count($status));
genSetError("count(recordError)=".count($recordError));
 */

genSmartyAssign("uniqueKey", $uniqueKey);
genSmartyAssign("group", $group);
genSmartyAssign("status", $status);
genSmartyAssign("recordError", $recordError);
genSmartyDisplay("wsvl_importUsersProcess.tpl");

?>
