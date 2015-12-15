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


    public function insert($new)
    {
        $dt = new DateTime();
        $new["news_timestamp"] = $dt->format("Y-m-d H:i:s");
        return parent::insert($new);
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
        $this->structure["news_rubriek_id"] = general::getCategoryDefinition();
    }

    public function getPublic() # Select all public News
        # in reversed order by publication date (=hotFrom)
    {
        $today = new DateTime();
        $tomorrow = new DateTime();
        $today->modify("today");
        $tomorrow->modify("tomorrow");
        $sqlCmd = "SELECT * FROM " . $this->getTableName() . " where " .
            "news_hotFrom <= '" . $tomorrow->format('Y-m-d') . "' " .
            "ORDER BY news_hotFrom DESC";
        $result = mysql_query($sqlCmd);
        if (!$result) {
            genSetError("SqlCommand: " . $sqlCmd);
            $this->tbError(null);
            return $result;
        }
        if (0 < mysql_num_rows($result))
            return $result;
        # nothing hot, return the most recent news
        $sqlCmd = "SELECT * FROM " . $this->getTableName() . " where " .
            "news_hotFrom =< '" . $tomorrow . format('Y-m-d') .
            "' ORDER BY news_id DESC LIMIT 1";
        $result = mysql_query($sqlCmd);
        if (!$result) {
            $this->tbError(null);
            return $result;
        }
        return $result;
    }

    // Text fields are marked down
    public function fetch_assoc($query)
    {
        $result = parent::fetch_assoc($query);
        if (!$result)
            return $result;
        if ($this->returnHTML) {
            foreach ($result as $k => $v) {
                if (is_array($this->structure[$k])) {
                    if ($this->structure[$k]["type"] == "text"
                    || $this->structure[$k]["type"] == "textarea") {
                        $result[$k] = genParseDownParse($v);
                    }
                }
            }
        }
        return $result;
    }

    public function get($news_id)
    {
        $sqlCmd = "SELECT * FROM " . $this->getTableName() . " where " . "news_id= " . $news_id;
        $result = mysql_query($sqlCmd);
        if (!$result) {
            genSetError("SqlCommand: " . $sqlCmd);
            $this->tbError(null);
            return $result;
        }
        if (0 == mysql_num_rows($result)) {
            genSetError("News $news_id does not exist");
            return false;
        }
        return $this->fetch_assoc($result);
    }

    public function get4HTML($news_id)
    {
        $oldReturn = $this->returnHTML;
        $this->returnHTML = true;
        $result = $this->get($news_id);
        /* TODO: obsolete 13-12-2015
        foreach ($result as $key => $val) {
        $result["$key"]=nl2br($val);
        }
        */
        return $result;
    }


    public function getHot() # Select all hot News
    {
        $today = new DateTime();
        $tomorrow = new DateTime();
        $today->modify("today");
        $tomorrow->modify("tomorrow");
        $sqlCmd = "SELECT * FROM " . $this->getTableName() . " where " .
            "news_hotFrom <= '" . $tomorrow->format('Y-m-d') . "' and " . "news_hotTo >= '" .
            $today->format('Y-m-d') . "' " . "ORDER BY news_hotTo DESC";
        $result = mysql_query($sqlCmd);
        if (!$result) {
            genLogVar("SqlCommand: " . $sqlCmd);
            $this->tbError(null);
            return $result;
        }
        if (0 < mysql_num_rows($result))
            return $result;
        # nothing hot, return the most recent news
        $sqlCmd = "SELECT * FROM " . $this->getTableName() . " where " .
            "news_hotFrom <= '" . $tomorrow->format('Y-m-d') .
            "' ORDER BY news_id DESC LIMIT 1";
        $result = mysql_query($sqlCmd);
        if (!$result) {
            $this->tbError(null);
            return $result;
        }
        return $result;
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
-- Gecreëerd: 09 Feb 2011 om 14:20
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
