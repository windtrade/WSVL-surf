<?php
/*
	Administratie rondom de training
	We hebben deze tabs/functies gedfinieerd
	login = formulier
	authenticate = na login, gaat door naar
	presentie = wie heeft zich aangemeld en is aanwezig
*/
	
session_start();
$_SESSION['msg']="";
$_SESSION['thisUrl'] = "http://".$_SERVER['HTTP_HOST'];
if ($_SERVER['SERVER_PORT'] != 80) $_SESSION['thisUrl'] .= ':'.$_SERVER['SERVER_PORT'];
$_SESSION['thisUrl'] .= $_SERVER['SCRIPT_NAME'];

include "library/config.inc.php";
include "library/cheats.lib.php";
include "../surf/cms/library/login_new.lib.php";
include "library/db.lib.php";
include "library/training.lib.php";

class loginForm {
	private $messages = array (
		'default' => 'Log eerst even in',
		'error' => 'login geweigerd',
		'incompleet' => 'Geef Naam en WW',
		'timeOut' => 'log opnieuw in'
	);
	
	private $msg;
	
	private $target;
	private $form;
	function __construct()
	{
		$msg = 'default';
		$this->target=$_SERVER['SCRIPT_NAME']."?tab=authenticate";
		$this->form = <<<EOT
		<form method="POST" action="%s">
		<table>
		<tr>
		<tr><td colspan="2">%s</td></tr>
		<td>Naam:</td>
		<td><input type="text" name="user_name" width="10" value="%s">
		</tr>
		<tr>
		<td>WW:</td>
		<td><input type="password" name="password" width="10">
		</tr>
		<tr>
		<td><input type="submit" name="LOGIN" value="LOG IN" width="10">
		<td><input type="reset" name="WISSEN" value="WISSEN" width="10">
		</tr>
		</table>
		</form>
EOT;
	}

	public function authenticate($log)
	{
		if (!isset($_POST['user_name']) || !isset($_POST['password'])) {
			// traceThis("incompleet");
			$this->setMsg('incompleet');
			return FALSE;
		} else {
			if ($log->login2($_POST['user_name'],$_POST['password'])) {
				// traceThis("Login gelukt");
				return TRUE;
			} else {
				// traceThis("Login mislukt");
				$this->setMsg('error');
			}
		}
		return FALSE;
	}

	public function setMsg($msg) {
		if (isset($this->messages[$msg])) {
			$this->msg=$msg;
		} else {
			$this->msg='default';
		}
	}

	public function formGet() {
		$retval= sprintf($this->form, $this->target, $this->messages[$this->msg], $_SESSION["user_name"]);
		return $retval;
		
	}
}

class deelnemerForm {

	private $msg;
	private $form;

	public function __construct() {
		$this->target=$_SERVER['SCRIPT_NAME']."?tab=deelnemersave";
		$this->form = <<<EOT
		<form method="POST" action="%s">
		<input type="hidden" name ="training" value = "%s">
		<table>
		<tr>
		<tr><td colspan="2">%s</td></tr>
		<td>Naam:</td>
		<td><input type="text" name="deelnemer" width="10" value="%s">
		</tr>
		<tr>
		<td>email:</td>
		<td><input type="email" name="deelnemerEmail" width="10" value="%s">
		</tr>
		<tr>
		<td><input type="submit" name="INVOEREN" value="INVOEREN" width="10">
		<td><input type="reset" name="WISSEN" value="WISSEN" width="10">
		</tr>
		</table>
		</form>
EOT;
	}

	public function setMsg($msg) {
		if (isset($this->messages[$msg])) {
			$this->msg=$msg;
		} else {
			$this->msg='default';
		}
	}


	public function formGet($training) {
		// traceThis('formGet \$_SESSION["deelnemer"]='.$_SESSION["deelnemer"]."...");
		// traceThis('formGet \$_SESSION["deelnemerEmail"]='.$_SESSION["deelnemerEmail"]."...");
		$retval= sprintf($this->form, $this->target, $training,
			$this->messages[$this->msg], $_SESSION["deelnemer"],
			$_SESSION["deelnemerEmail"]);
		return $retval;
	}

}

function formTarget()
{
	
	$deelnemerForm = new deelnemerForm();
	$form = "";
	traceThis('$_REQUEST:');
	traceThis(showAssocArray($_REQUEST));
	if (preg_match("/^\d\d\d\d-\d\d-\d\d$/", $_REQUEST["training"])) {
		$training = $_REQUEST["training"];
	} else {
		$training =  date('Y-m-d', volgendeTraining());
	}
	$sql = " SELECT * FROM trainingsmaatjes WHERE datum = '".
			$training.
			" 00:00:00' ORDER BY aangemeld DESC, naam ASC ";
	// traceThis($sql);
	$result = mysql_query($sql);
	if ($result) {
		$aantalDeelnemers = mysql_num_rows($result);
		$kop=$aantalDeelnemers." aanmeldingen voor ".$training;
	} else {
		$kop=mysql_error();
	}
	$form .= '<form method="POST" action="'.$_SERVER['thisUrl'].'?tab=presentiesave">'."\n";
	$form .= "<input type=\"hidden\" name=\"training\" value=\"$training\">";
	$form .= "<table>\n";
	$form .= "<tr><td colspan=\"3\">".$kop."</td></tr>\n";
	if ($result && $aantalDeelnemers > 0) {
		$form .= "<tr><td>Naam</td><td>+</td><td>-</td></tr>\n";
		$lastAangemeld = -1;
		while ($row = mysql_fetch_array($result)) {
			if ($lastAangemeld != $row['aangemeld']) {
				$lastAangemeld = $row['aangemeld'];
				$form .= "<tr><td colspan='3'><b>";
				if ($lastAangemeld) {
					$form .= "Aangemeld";
				} else {
					$form .= "Afgemeld";
				}
					$form .= "</b></td><td>";
			}
			// traceThis(showAssocArray($row));
			$form .= "<tr><td>".stripslashes(ucfirst($row['naam']))."</td><td>";
			$fieldName = "aanwezig_".$row['trainingsmaatje_id']."_".$row['token'];
			$checked = ($row['aanwezig'] ? "Checked " : "");
			$form .= '<input type="radio" '.
				'name="'.$fieldName.'" value="1"'.
				$checked."></td><td>";
			$checked = ($row['aanwezig'] ? "" : "Checked ");
			$form .= '<input type="radio" '.
				'name="'.$fieldName.'" value="0"'.
				$checked."></td>";
				$form .= "</tr>\n";	
		}
		$form .= "<tr><td><input type=\"submit\" value=\"Bewaren\"></td>";
		$form .= "<td><input type=\"reset\" value=\"Wissen\"></td></tr>\n";
	}
	$form .= "</table>";
	$form .= "</form>\n";
	$form .= "<br><br>";
	$form .= $deelnemerForm->formGet($training);
	$form .= "<br><br>";
	$form .= '<form method="POST" action="'.$_SESSION['thisUrl'].'">';
	$form .= 'Of kies andere datum: <input type="text" name="training" value="'.
		 date('Y-m-d', volgendeTraining()).'"> <input type="submit" value="Ga"><br>';
	$form .= '</form>';

	return $form;
}

$page =<<<EOT
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<head>
<meta name="viewport" content="width=device-width, height=device-height">  
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<meta name="google" value="notranslate">
<title>WV Leidschendam Registratie Training</title>
<body>
%s
%s
</body>
</html>
EOT;

function saveDeelnemer()
{
	if (strlen($_POST['deelnemer']) >= 2) {
		traceThis("Deelnemer valide..".$_POST['deelnemer']."..");
		if (checkEmail($_POST['deelnemerEmail'])) {
			traceThis("valide mail ..".$_POST['deelnemerEmail']."..");
			// traceThis($_POST['training']);
			aanmeldenTraining($_POST['deelnemer'], $_POST['deelnemerEmail'], "", $_POST['training']);
			$_POST['deelnemer'] = "";
			$_POST['deelnemerEmail'] = "";
		} else {
			traceThis("invalide mail ..".$_POST['deelnemerEmail']."..");
		}
	} else {
		traceThis("Deelnemer invalide..".$_POST['deelnemer']."..");
	}
	$_SESSION['deelnemer'] = $_POST['deelnemer'];
	$_SESSION['deelnemerEmail'] = $_POST['deelnemerEmail'];
}
		
function savePresentie() {
	$sqlTemplate='UPDATE trainingsmaatjes SET aanwezig=%s WHERE trainingsmaatje_id=%s AND token="%s"';
	foreach ($_POST as $key => $value) {
		$karr = preg_split('/_/', $key);
		if ($karr[0] != 'aanwezig') continue;
		if (!is_numeric($kar[1]) || !isset($karr[2])) {
			$_SESSION['msg'] .= 'Vreemde POST parameter: '.$karr[0]."_".$karr[1]."_".$kar[2];
		}
		$sql=sprintf($sqlTemplate, $value, $karr[1], $karr[2]);
		// traceThis($sql);
		$result=mysql_query($sql);
		if (! $result) {
			$_SESSION['msg'] .= mysql_error();
			continue;
		}
	}
}

function presentieForm() {

	traceThis("presentieForm");
	$log = new login();
	$logForm = new loginForm();
	$deelnemerForm = new deelnemerForm();
	$curTab = (isset($_REQUEST['tab'])? $_REQUEST['tab']: "presentie");
	/*
	 * First process the login form, when it is there
	 */
	if ($curTab == 'authenticate') {
		// traceThis("In authenticate");
		// traceThis("User ".$_POST['user_name']. "password ".$_POST['password']);
		if ($logForm->authenticate($log)) {
			$curTab = 'presentie';
		} else {
			return $logForm->formGet();
		}
	}

	/*
	 * New here or been away too long?
	 */
	if (!$log->stillActive()) {
		$log->clearPrivileges();
		$logForm->setMsg('timeOut');
		$curTab='login';
	}
	traceThis("curtab \"$curTab\"");
	if ($curTab=='login') {
		return $logForm->formGet();
	}
	if ($curTab=='deelnemersave') {
		saveDeelnemer();
		// en dan gewoon doorgaan met presentie
		$curTab = 'presentie';
	}
	if ($curTab=='presentiesave') {
		// traceThis('Saving presentie');
		// traceThis(showAssocArray($_POST));
		savePresentie();
		// en dan gewoon doorgaan met presentie
		$curTab = 'presentie';
	}
	if ($curTab=='presentie') {
		return formTarget();
	}
}

printf ($page, $_SESSION['msg'],presentieForm().
"<br><A HREF=\"".$_SESSION['thisUrl']."\">laad opnieuw</A><br>".
	(function_exists('traceDump')? traceDump() : "boe"));

?>
