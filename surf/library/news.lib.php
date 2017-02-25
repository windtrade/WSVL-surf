<?php
/*
* news.lib.php
*
* class to access users table
*
* 19-03-2012 : Huug	: Creation
*/
require_once "general.lib.php";
require_once "table.lib.php";

class news extends table
{
    private $tbDefine = "SQL_TBNEWS";
    private $returnHTML = false;

    protected $structure = array(
        "news_id" => array(
            "label" => "Berichtnr.",
            "default" => "Nieuw",
            "role" => "public",
            "mandatory" => "0",
            "type" => "number",
            "protected" => "1",
            "check" => ""),
        "news_lastUpdate" => array(
            "label" => "Laatst gewijzigd",
            "default" => "0000-00-00 00:00:00",
            "role" => "public",
            "mandatory" => "0",
            "type" => "datetime-local",
            "protected" => "1",
            "check" => ""),
        "news_author_id" => array(
            "label" => "Auteur",
            "default" => "0",
            "role" => "public",
            "mandatory" => "0",
            "type" => "number",
            "protected" => "1",
            "check" => ""),
        "news_rubriek_id" => array(),
        "news_event_id" => array(
            "label" => "Evenementnr.",
            "default" => "0",
            "role" => "public",
            "mandatory" => "1",
            "type" => "number",
            "protected" => "0",
            "check" => ""),
        "news_event_start" => array(
            "label" => "Datum/tijd",
            "default" => "0000-00-00 00:00:00",
            "role" => "public",
            "mandatory" => "0",
            "type" => "datetime-local",
            "protected" => "0",
            "check" => ""),
        "news_hotFrom" => array(
            "label" => "Actueel vanaf",
            "default" => "midnight tomorrow",
            "role" => "public",
            "mandatory" => "0",
            "type" => "datetime-local",
            "protected" => "0",
            "check" => ""),
        "news_hotTo" => array(
            "label" => "Actueel tot",
            "default" => "midnight +2 week",
            "role" => "public",
            "mandatory" => "0",
            "type" => "datetime-local",
            "protected" => "0",
            "check" => ""),
        "news_title" => array(
            "label" => "Titel",
            "default" => "",
            "role" => "public",
            "mandatory" => "1",
            "type" => "text",
            "protected" => "0",
            "check" => ""),
        "news_image" => array(
            "label" => "Afbeelding",
            "default" => "0",
            "role" => "public",
            "mandatory" => "1",
            "type" => "number",
            "protected" => "0",
            "check" => ""),
        "news_short" => array(
            "label" => "Inleiding",
            "default" => "",
            "role" => "public",
            "mandatory" => "1",
            "type" => "textarea",
            "protected" => "0",
            "check" => ""),
        "news_message" => array(
            "label" => "Bericht",
            "default" => "",
            "role" => "public",
            "mandatory" => "0",
            "type" => "textarea",
            "protected" => "0",
            "check" => ""),
        "news_sticky" => array(
            "label" => "Vaag",
            "default" => "0",
            "role" => "public",
            "mandatory" => "0",
            "type" => "text",
            "protected" => "1",
            "check" => ""));

    public function get($id)
    {
        return $this->getOne(array("news_id" => $id ));
    }

    public function insert($arr)
    {
        $dt = new DateTime();
        $arr["news_timestamp"] = $dt->format("Y-m-d H:i:s");
        return parent::insert($arr);
    }

    public function update($old, $new)
    {
        $dt = new DateTime();
        $new["news_lastUpdate"] = $dt->format("Y-m-d H:i:s");
        return parent::update($old, $new);
    }

    public function __construct()
    {
        if (defined($this->tbDefine)) {
            parent::__construct(SQL_TBNEWS);
        } else {
            genSetError($this->tbDefine . " not defined");
        }
        $this->structure    ["news_rubriek_id"] = general::getCategoryDefinition();
    }

    /**
     * select all news that may be viewed by the public
     * @return mixed: sth as argument for fetch_assoc(_all) or false
     */
    public function getPublic() # Select all public News
        # in reversed order by publication date (=hotFrom)
    {
        $tomorrow = (new DateTime('tomorrow'))->format('Y-m-d');
        $this->initQuery();
        $this->addTerm("news_hotFrom", "<=",$tomorrow);
        $this->addOrderTerm('news_hotFrom', 'DESC');
        $result = $this->readQuery();
        if (!$result) {
            $this->tbError(null);
        }
        return $result;
    }

    /**
     * this allows the use of a class specific fetch_assoc
     * return all records selected by $query
     * @param $sth handle returned by readQuery
     * @return array all selected records
     */
    public function fetch_assoc_all($sth)
    {
        $result = array();
        while ($row = $this->fetch_assoc($sth)) {
            array_push($result, $row);
        }
        return $result;
    }

    /**
     * Text fields are marked down
     * @param $sth handle returned by readQuery
     * @return mixed assoc array of a single record or false
     */
    public function fetch_assoc($sth)
    {
        $result = parent::fetch_assoc($sth);
        if (!$result)
            return $result;
        if ($this->returnHTML) {
            foreach ($result as $k => $v) {
                if (array_key_exists($k, $this->structure) && is_array($this->structure[$k])) {
                    if ($this->structure[$k]["type"] == "textarea") {
                        $result[$k] = genParseDownParse($v);
                    }
                }
            }
        }
        return $result;
    }

    public function get4HTML($news_id)
    {
        $oldReturn = $this->returnHTML;
        $this->returnHTML = true;
        $result = $this->get($news_id);
        $this->returnHTML = $oldReturn;
        return $result;
    }

    /**
     * Select all hot news
     * @return mixed: sth as argument for fetch_assoc(_all) or false
     */
    public function getHot() # Select all hot News
    {
        $today = (new DateTime("today"))->format("Y-m-d");
        $tomorrow = (new DateTime("tomorrow"))->format("Y-m-d");
        $this->initQuery();
        $this->addTerm("news_hotFrom", "<=", $tomorrow);
        $this->addTerm("news_hotTo", '>=', $today);
        $this->addOrderTerm("news_hotTo", "DESC");
        $sth = $this->readQuery();
        return $sth;
    }

    /**
     * Select all hot news
     * @return mixed: sth as argument for fetch_assoc(_all) or false
     */
    public function getAll() # Select all hot News
    {
        $this->initQuery();
        $this->addOrderTerm("news_id", "DESC");
        $sth = $this->readQuery();
        return $sth;
    }

    public function create()
    {
        if (!defined($this->tbDefine)) {
            genSetError("SQL_TBNEWS not defined");
            return;
        }
        $sqlCmd = <<< EOF
-- phpMyAdmin SQL Dump
-- version 2.11.9.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generatie Tijd: 19 Mar 2012 om 21:18
-- Server versie: 4.1.22
-- PHP Versie: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `wvleid01_surfclub`
--

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `news`
--
-- Gecre�erd: 09 Feb 2011 om 14:20
-- Laatst bijgewerkt: 18 Mar 2012 om 07:46
--

CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int(11) NOT NULL auto_increment,
  `news_rubriek_id` int(11) NOT NULL default '0',
  `news_author_id` int(11) NOT NULL default '0',
  `news_timestamp` datetime default NULL,
  `news_title` varchar(255) NOT NULL default '',
  `news_image` int(11) NOT NULL default '0',
  `news_short` text NOT NULL,
  `news_message` text NOT NULL,
  `news_event_id` int(11) NOT NULL default '0',
  `news_sticky` int(11) NOT NULL default '0',
  PRIMARY KEY  (`news_id`),
  KEY `news_author_id` (`news_author_id`),
  KEY `news_timestamp` (`news_timestamp`),
  KEY `news_event_id` (`news_event_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=198 ;

EOF;
    }
}
?>
