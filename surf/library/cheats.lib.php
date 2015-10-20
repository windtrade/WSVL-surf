<?php
session_start();

function showSession() {
	$form = 'What\'s in $_SESSION:<BR>';
	if (isset($_SESSION)) {
		$form .= 'Duck, here comes $_SESSION<br>';
		foreach ($_SESSION as $key => $val) {
			$form .=sprintf('$_SESSION[%s]=%s<br>', $key, $val);
		}
		$form .= 'That\'s it<br>';
	} else {
		$form .= 'Alas, there is no $_SESSION<br>';
	}
	return $form;
}

function showServer() {
	$form = 'What\'s in $_SERVER:<BR>';
	if (isset($_SERVER)) {
		$form .= 'Duck, here comes $_SERVER<br>';
		foreach ($_SERVER as $key => $val) {
			$form .=sprintf('$_SERVER[%s]=%s<br>', $key, $val);
		}
		$form .= 'That\'s it<br>';
	} else {
		$form .= 'Alas, there is no $_SERVER<br>';
	}
	return $form;
}

function showAssocArray($arr) {
	$form = 'What\'s in $_SERVER:<BR>';
	if (isset($arr)) {
		$form .= 'Duck, here comes $_SERVER<br>';
		foreach ($arr as $key => $val) {
			$form .=sprintf('key [%s]=%s<br>', $key, $val);
		}
		$form .= 'That\'s it<br>';
	} else {
		$form .= 'Alas, there is no $_SERVER<br>';
	}
	return $form;
}

function traceThis($text) {
	if (!isset($_SESSION['traceThis'])) {
		$_SESSION['traceThis'] = array();
	}
	array_push($_SESSION['traceThis'], $text);
}

function traceDump() {
	$retval = "\n<!--";
	if (!count($_SESSION['traceThis'])) $retval .= "\n"."nothing traced";
	while (count($_SESSION['traceThis'])) {
		$retval .= "\n".array_shift($_SESSION['traceThis']);
	}
	$retval .= "\n-->";
	return $retval;
}

?>
