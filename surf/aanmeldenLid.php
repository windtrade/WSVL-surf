<?php
/*
 * aanmeldenLid.php
 *
 * registration new member
 *
 * 21-11-2015 Huug Peters
 */

require_once "library/all_config.inc.php";
require_once "contact.lib.php";
require_once "general.lib.php";
require_once "users.lib.php";
require_once "user_roles.lib.php";
require_once "userSession.lib.php";

class aanmeldenLid
{
    private $contact;
    private $teksten;
    private $users;
    private $user_roles;
    private $userSession;
    private $interests= array(
	"surfles" => "Ik wil eerst leren windsurfen",
	"training" => "Ik wil meedoen met de clubtrainingen",
	"sufpool" => "Ik wil de spullen van de club gebruiken");

    private function sendAlert($action, $data)
    {
	$user = $data["user"];
	$interest = $data["interest"];
	$contact = $data["contact"];
	$tekst = $this->teksten->getTekst(26);
	/* trick: undo the NL2BR */
	$tekst["tekst"] = preg_replace('/<br\s*\/*>/', "", $tekst["tekst"]);
	/* Build list of addresses to inform */
	$emails = array();
	foreach ($this->user_roles->getUsersWithRoles(ROLE_MEMBERADMIN) as $id)
	{
	    $tmp = $this->users->get($id);
	    if (array_key_exists('email', $tmp))
		array_push($emails, $tmp['email']);
	}
	$allEmails = implode(',', $emails);
	$public ="";
	$private = "";
	foreach ($user as $col => $val) {
	    $line =  $this->users->getLabel($col).": ".$val."\n";
	    if ($col != 'wachtwoord') {
		$public .= $line;
	    } else {
		$private .= $line;
	    }
	}
	foreach ($interest as $col => $val) {
	    if (array_key_exists($col, $this->interests)) {
		$public .= $this->interests[$col]."\n";
	    }
	}
	foreach ($contact as $col => $val) {
	    $line =  $this->contact->getLabel($col).": ".$val."\n";
	    if ($col != 'wachtwoord') {
		$public .= $line;
	    } else {
		$private .= $line;
	    }
	}
	$headers = 'From: WVLeidschendam Surf<surf@wvleidschendam.nl>'."\r\n".
	    'Reply-To: surf@wvleidschendam.nl'."\r\n".
	    'X-Mailer: PHP/'. phpversion();
	mail($allEmails, "$action ".$tekst["titel"],
	    $tekst['tekst']."\n$public\n", $headers);
	$emails = array($user['email']);
	if (strlen($user['emailOuder']) > 0 &&
	    $user["emailOuder"] != $user["email"])
	{
	    array_push($emails, $user['emailOuder']);
	}
	$allEmails = implode(',', $emails);
	mail($allEmails, "$action ".$tekst["titel"],
	    $tekst['tekst']."\n$public\n$private\n",
	    $headers);
    }

    public function toForm($fd)
    {
	$data["user"] = $this->users->toForm($fd["user"], $this->userSession,
	    array("wachtwoord" => "hide"));
	$data["interest"] = array();
	foreach ($this->interests as $field => $label) {
	    $data["interest"][$field]["name"] = $field;
	    $data["interest"][$field]["label"] = $label;
	    $data["interest"][$field]["checked"] = "1";
	    $data["interest"][$field]["protected"] = "0";
	    $data["interest"][$field]["type"] = "checkbox";
	    $data["interest"][$field]["value"] = 
		(array_key_exists($field, $fd["interest"]) ?
		$fd["interest"][$field] : "");
	}
	$data["contact"]["id"] =
	    $this->contact->columnToForm(
		$fd["contact"],
		"id",
	       	$this->userSession);
	$data["contact"]["message"] =
	    $this->contact->columnToForm(
		$fd["contact"],
		"message",
	       	$this->userSession);
	return $data;
    }

    private function insertContact(&$fd)
    {
	$contact = $fd["contact"];
	$contact["category"] = general::GENERAL;
	$contact["from_id"] = $fd["user"]["id"];
	$contact["subject"] = "Aanvraag Lidmaatschap WV Leidschendam";
	$contact["message"] = "";
	foreach ($fd["interest"] as $col => $val) {
	    if (array_key_exists($col, $this->interests)) {
		$contact["message"] .= $this->interests[$col]."\n";
	    }
	}
	$contact["message"] .= $fd["contact"]["message"];
	if ($contact["message"] == "") return;
	$this->contact->insert($contact);
	$fd["contact"]["id"] = $this->contact->getLastId();
    }

    private function insert(&$fd)
    {
	if (!$this->users->insert($fd["user"])) {
	    return;
	}
	$fd["user"]["id"] = $this->users->getLastId();
	$this->insertContact($fd);
	$this->sendAlert("Aangemeld", $fd);
    }

    private function updateContact(&$fd)
    {
	$old = array("id" => $fd["contact"]["id"]);
	# only the message could change
	$contact = array("message" => "");
	foreach ($fd["interest"] as $col => $val) {
	    if (array_key_exists($col, $this->interests)) {
		$contact["message"] .= $this->interests[$col]."\n";
	    }
	}
	$contact["message"] .= $fd["contact"]["message"];
	if ($contact["message"] == "") {
	    $contact["message"] = get_class($this)."::".__FUNCTION__.
		": message was cleared";
	}
	$this->contact->update($old, $contact);
    }

    private function update(&$oldUser, &$fd)
    {
	$this->users->update($oldUser, $fd["user"]);
	if (!array_key_exists("id", $fd["contact"]))
	{
	    $this->insertContact($fd);
	} else {
	    $this->updateContact($fd);
	}
    }

    public function __construct()
    {
	$this->contact = new Contact();
	$this->teksten = new teksten();
	$this->users = new Users();
	$this->user_roles =  new user_roles();
	$this->userSession = new UserSession();

	if(array_key_exists("fd", $_REQUEST)) {
	    $fd = $_REQUEST["fd"];
	} else {
	    $fd = array();
	}
	if (!array_key_exists("user", $fd))	$fd["user"]=array();
	if (!array_key_exists("interest", $fd))	$fd["interest"] = array();
	if (!array_key_exists("contact", $fd))	$fd["contact"] = array();

	$command = "";
	if (array_key_exists("command", $_REQUEST)) {
	    $command = $_REQUEST["command"];
	}
	if ((genGetPageCache("NOROBOT") || general::reCAPTCHAverify())) {
	    genSetPageCache("NOROBOT", "OK");
	    if ($command == "AANMELDEN") {
		if ($this->users->isValid($fd["user"])) {
		    $this->insert($fd);
		    genSetError("Hartelijk bedankt voor je aanmelding, hieronder ".
			"kun je jouw gegevens zonodig nog bijwerken");
		    $command = "BIJWERKEN";
		}
	    } else if ($command == "BIJWERKEN") {
		if ($this->users->isValid($fd["user"])) {
		    $old = $this->userSession->getSessionData("user");
		    if (!is_array($old) || !array_key_exists("id", $old)) {
			genSetError("Geen gegevens beschikbaar om bij te werken");
		    } else if (!array_key_exists("id", $fd["user"])) {
			genSetError("Ingevoerde gegevens missen identificatie");
		    } else if ($old["id"] != $fd["user"]["id"]) {
			genSetError("Ingevoerde gegevens zijn geen bewerking");
		    } else {
			$this->update($old, $fd);
			$this->sendAlert("Bijgewerkt", $fd);
			genSetError("Je gegevens zijn bijgewerkt");
		    }
		}
	    }
	}
	if ($command == "") $command = "AANMELDEN";
	$this->userSession->setSessionData("user", $fd["user"]);
	$data = $this->toForm($fd);

	genSmartyAssign("data", $data);
	genSmartyAssign("command", $command);
	genSmartyDisplay("wsvl_aanmeldenLid.tpl");
    }
}

$something = new aanmeldenLid();
