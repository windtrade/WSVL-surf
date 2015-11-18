<?php
/*
 * users.lib.php
 *
 * class to access users table
 *
 * 08-10-2011 : Huug	: Creation
 */
require_once "table.lib.php";

class users extends table
{
    private $tbDefine="SQL_TBUSERS";

    protected $structure = array(
	"id" => array(
	    "label" => "ID",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" =>  "number",
	    "protected" => "1",
	    "check" => ""),
	"relnr" => array(
	    "label" => "Verenigingsnr.",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" =>  "text",
	    "protected" => "1",
	    "check" => ""),
	"bondnr" => array(
	    "label" => "Verbondsnr.",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" =>  "text",
	    "protected" => "1",
	    "check" => ""),
	"modifieddate" => array(
	    "label" => "Laatst gewijzigd",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" =>  "text",
	    "protected" => "1"),
	"modifiedby" => array(
	    "label" => "Gewijzigd door",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" =>  "text",
	    "protected" => "1"),
	"roepnaam" => array(
	    "label" => "Roepnaam",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "1",
	    "type" => "text",
	    "protected" => "0",
	    "check" => ""),
	"naam" => array(
	    "label" => "Achternaam",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "1",
	    "type" => "text",
	    "protected" => "0",
	    "check" => ""),
	"voorvoegsel"=> array(
	    "label" => "Voorletters en evt. -voegsel",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "1",
	    "type" => "text",
	    "protected" => "0",
	    "check" => ""),
	"straat" => array(
	    "label" => "Adres",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "1",
	    "type" => "text",
	    "protected" => "0",
	    "check" => ""),
	"huisnr" => array(
	    "label" => "Huisnr.",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "1",
	    "type" => "text",
	    "protected" => "0",
	    "check" => ""),
	"postcode" => array(
	    "label" => "Postcode",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "1",
	    "type" => "text",
	    "protected" => "0",
	    "regexp" => "[0-9]{4}\\s*[A-Za-z]{2}",
	    "msg" => "Vier cijfers en twee letters",
	    "check" => ""),
	"plaats" => array(
	    "label" => "Woonplaats",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "1",
	    "type" => "text",
	    "protected" => "0",
	    "check" => ""),
	"telefoonnr" => array(
	    "label" => "Telefoon",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "tel",
	    "protected" => "0",
	    "regexp" => "[ +()0-9]{10,15}",
	    "msg" => "Gebruik alleen cijfers en haakjes()",
	    "check" => ""),
	"mobielnr" => array(
	    "label" => "Mobiel",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "tel",
	    "protected" => "0",
	    "regexp" => "[ +()0-9]{10,15}",
	    "msg" => "Gebruik alleen cijfers en haakjes()",
	    "check" => ""),
	"gebdatum" => array(
	    "label" => "Geb. datum",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "date",
	    "protected" => "0",
	    "check" => ""),
	"lidsoort" => array(
	    "label" => "Lidmaatschap",
	    "default" => "",
	    "role" => ROLE_MEMBERADMIN,
	    "mandatory" => "0",
	    "type" => "text",
	    "protected" => "0",
	    "check" => ""),
	"email" => array(
	    "label" => "Email",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "email",
	    "protected" => "0",
	    "check" => ""),
	"emailOuder" => array(
	    "label" => "Email Ouder",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "email",
	    "protected" => "0",
	    "check" => ""),
	"wachtwoord" => array(
	    "label" => "Wachtwoord",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "password",
	    "protected" => "0",
	    "check" => ""),
	"nick" => array(
	    "label" => "Bijnaam",
	    "default" => "",
	    "role" => "public",
	    "mandatory" => "0",
	    "type" => "text",
	    "protected" => "0",
	    "check" => "")
	);

    public function get($id)
    {
	$result = parent::get(array(
	    array(
		"col" => "id",
		"oper" => "=",
		"val" => $id)));
	return $result;
    }
	public function __construct()
    {
	if (defined($this->tbDefine)) {
	    parent::__construct(SQL_TBUSERS);
	} else {
	    genSetError($this->tbDefine." not defined");
	}
    }

    private function pwEncrypt(&$arr)
    {
	if (array_key_exists("wachtwoord", $arr)) {
	    $arr["wachtwoord"] = password_hash(
		$arr["wachtwoord"],
		PASSWORD_BCRYPT, 
		array("cost" => GEN_PASSWORD_COST));
	}
    }

    /*
     * generate a random password
     */
    static public function randomPassword() {
	$alphabet =
	    "-*^#@_abcdefghijklmnopqrstuwxyz".
	    "ABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	$pass = array(); //remember to declare $pass as an array
	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	for ($i = 0; $i < 8; $i++) {
	    $n = rand(0, $alphaLength);
	    $pass[] = $alphabet[$n];
	}
	return implode($pass); //turn the array into a string
    }
    /*
     * return all users with matching email address
     */
    public function getClan($id)
    {
	$user = $this->get($id);
	if ($user === false) return false;
	$retval = array();
	array_push($retval, $user);
	if (!preg_match('/SURF/i',$user["lidsoort"])) return $retval;
	$sqlCmd = "SELECT * FROM ".$this->getTable()." WHERE ";
	$query = false;
	foreach (array($user["email"], $user["emailOuder"]) as $email) {
	    if ($email == "") continue;
	    if ($query) $sqlCmd .= ' or ';
	    $sqlCmd .= "LOWER('$email') = LOWER(email) or ".
		"LOWER('$email') = LOWER(emailOuder)";
	    $query = true;
	}
	// perform query only when there is a selection some email
	if ($query) {
	    $query = $this->query($sqlCmd);
	}
	while ($query && $row = mysql_fetch_assoc($query)) {
	    if ($row["id"] != $user["id"]) array_push($retval, $row);
	}
	return $retval;
    }

    public function readSelect()
    {
	$nrArgs =func_num_args();
	$allArgs= func_get_args();
	if ($nrArgs < 1 || $nrArgs > 2) {
	    genSetError(__FUNCTION__."wrong number of arguments ($nrArgs)".
		"expecting 1 or 2");
	    return false;
	}
	$whereArr= array_shift($allArgs);
	if ($nrArgs > 1) {
	    $orderArr= array_shift($allArgs);
	} else {
	    $orderArr=array();
	}

	$this->pwEncrypt($whereArr);
	return parent::readSelect($whereArr, $orderArr);
    }

    private function passwordRemove(&$arr)
    {
	if (array_key_exists("wachtwoord", $arr)) {
	    unset($arr["wachtwoord"]);
	}
    }

    public function update($old, $new)
    {
	$this->passwordRemove($old);
	$this->pwEncrypt($new);
	# TODO: these fields block the update, unclear why
	//unset($old["mobielnr"]);
	// unset($old["gebdatum"]);
	$keys = array_keys($old);
	#genSetError("nr of keys=".count($keys));
	while (count($keys) > 0) {
	    if ($result=parent::update($old, $new)) {
		return $result;
	    }
	    $key = array_pop($keys);
	    unset($old[$key]);
	}
	return $result;
    }

    public function insert($new)
    {
	$this->pwEncrypt($new);
	return parent::insert($new);
    }

    public function delete($old)
    {
	if (array_key_exists("wachtwoord", $old)) {
	    unset($old["wachtwoord"]);
	}
	return parent::delete($old);
    }

    public function create()
    {
	if (!defined("SQL_TBUSERS")) {
	    genSetError("SQL_TBUSERS not defined");
	    return;
	}
	$sqlCmd =<<<EOF
			-- phpMyAdmin SQL Dump
			-- version 2.11.9.4
			-- http://www.phpmyadmin.net
			--
			-- Host: localhost
			-- Generatie Tijd: 17 Oct 2011 om 23:04
			-- Server versie: 4.1.22
			-- PHP Versie: 5.2.11

			SET SQL_MODE=\"NO_AUTO_VALUE_ON_ZERO\";

			--
			-- Database: `wvleid01_surfclub`
			--

			-- --------------------------------------------------------
			--
			-- Tabel structuur voor tabel $this->table
			--
			CREATE TABLE IF NOT EXISTS $this->table (
			`id` int(10) unsigned NOT NULL auto_increment,
			`rel_nr` int(10) unsigned NOT NULL default '0',
			`bond_nr` int(10) unsigned NOT NULL default '0',
			`modified_at` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
			`modified_by` int(11) NOT NULL default '0',
			`roepnaam` varchar(255) NOT NULL default '',
			`naam` varchar(255) NOT NULL default '',
			`voorvoegsel` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL default '',
			`straat` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL default '',
			`huisnr` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL default '',
			`postcode` varchar(10) character set utf8 collate utf8_unicode_ci NOT NULL default '',
			`plaats` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL default '',
			`telefoonnr` varchar(15) character set utf8 collate utf8_unicode_ci NOT NULL default '',
			`geb_datum` date NOT NULL default '0000-00-00',
			`lidsoort` varchar(20) character set utf8 collate utf8_unicode_ci NOT NULL default '',
			`email` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL default '',
			`wachtwoord` varchar(32) character set utf8 collate utf8_unicode_ci NOT NULL default '',
			PRIMARY KEY  (`id`),
			KEY `rel_nr` (`rel_nr`,`bond_nr`)
			) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
			--
			-- Gegevens worden uitgevoerd voor tabel $this->table
			--
			INSERT INTO $this->table VALUES(1, 0, 0, '2011-10-07 17:31:57', 0, 'Systeem', 'Systeem', '', '', '', '', '', '', '0000-00-00', '', 'wsvlsite@windtrade.nl', '20500f92a58c34de7209d5052af61e07');
EOF;
    }
}
?>
