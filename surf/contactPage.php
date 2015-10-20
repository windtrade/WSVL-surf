<?php
/*
 * contactPage.php
 *
 * registration new member
 *
 * 31-12-2014 Huug Peters
 */

require_once "library/all_config.inc.php";
require_once "contact.lib.php";
require_once "general.lib.php";
require_once "users.lib.php";
require_once "user_roles.lib.php";
require_once "userSession.lib.php";
require_once "teksten.lib.php";

class contactPage
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
	$tekst = $this->teksten->getTekst(27);
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

	$allEmails = implode(',', $emails);
	mail($allEmails, "$action ".$tekst["titel"],
	    $tekst['tekst']."\n$public\n$private\n",
	    $headers);
    }

    public function toForm($fd)
    {
	$includeFields = array(
	    "user" => array(
		"id", "roepnaam", "naam", "telefoonnr", "email"),
	    "contact" => array(
		"id", "category", "subject", "message")
	);
	$object = array(
	    "user" => $this->users,
	    "contact" => $this->contact);
	foreach ($includeFields as $group => $list) {
	    $data[$group] = array();
	    foreach ($list as $field) {
		array_push($data[$group],
		    $object[$group]->columnToForm(
			$fd[$group], $field,
			$this->userSession));
	    }
	}
	return $data;
    }

    private function insertContact(&$fd)
    {
	$contact = $fd["contact"];
	$contact["from_id"] = $fd["user"]["id"];
	$this->contact->insert($contact);
	$fd["contact"]["id"] = $this->contact->getLastId();
    }

    private function store($old, &$fd)
    {
	if (is_array($old) && array_key_exists("id", $old)) {
	    $oldId = array("id" => $old["id"]);
	    $this->users->update($oldId, $fd["user"]);
	} else {
	    if (!$this->users->insert($fd["user"])) return;
	    $fd["user"]["id"] = $this->users->getLastId();
	}
	$this->insertContact($fd);
	$this->sendAlert("Vraag of opmerking verzonden: ", $fd);
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

	if ($command == "VERSTUUR") {
	    if (genGetPageCache("NOROBOT") || general::reCAPTCHAverify()) {
		genSetPageCache("NOROBOT", "OK");
		$old = $this->userSession->getSessionData("user");
		if ($this->users->isValid($fd["user"])) {
		    $this->store($old, $fd);
		    genSetError("Hartelijk bedankt voor je bericht, je krijgt zo snel mogelijk antwoord.");
		    genSetError("Een kopie van je bericht is naar je emailadres verstuurd.");
		    genSetError("Je  kunt nu eventueel nog een ander bericht versturen");
		    foreach (array_keys($fd["contact"]) as $field) {
			$fd["contact"][$field] = "";
		    }
		    $command = "";
		}
	    }
	}
	if ($command == "") $command = "VERSTUUR";
	$this->userSession->setSessionData("user", $fd["user"]);
	$data = $this->toForm($fd);

	genSmartyAssign("sectionCount", 1); # just the top part
	genSmartyAssign("data", $data);
	genSmartyAssign("command", $command);
	genSmartyDisplay("wsvl_contact.tpl");
    }
}

$something = new contactPage();
