<?php

function loginForm() {
	$target="nowhere.windtrade.nl";
	$form = <<<EOT
	<form method="POST" action="%s">
	<table>
	<tr>
	<td>Naam:</td>
	<td><input type="text" name="user" width="10" value="%s">
	</tr>
	<tr>
	<td>WW:</td>
	<td><input type="password" name="user" width="10">
	</tr>
	</table>
EOT;

	return sprintf($form, $target, $_SESSION["user"]);
}
?>
