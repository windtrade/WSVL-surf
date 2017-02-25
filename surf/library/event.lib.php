<?php
/*
* event.lib.php
*
* class to access users table
*
* 14-02-2013 : Huug	: Creation
*/
require_once "general.lib.php";
require_once "table.lib.php";

class event extends table
{
    private $tbDefine = "SQL_TBEVENT";

    const GENERAL = "0";
    const TRAINING = "1";
    const COMPETITION = "2";
    const TRIP = "3";

    protected $structure = array(
        "id" => array(
            "label" => "Evenementnr.",
            "default" => "Nieuw",
            "role" => "public",
            "mandatory" => "0",
            "type" => "number",
            "protected" => "1",
            "check" => ""),
        "timestamp" => array(
            "label" => "Laatste wijziging",
            "default" => "",
            "role" => "public",
            "mandatory" => "0",
            "type" => "datetime_local",
            "protected" => "1",
            "check" => ""),
        "category" => array(),
        "title" => array(
            "label" => "Titel",
            "default" => "",
            "role" => "public",
            "mandatory" => "1",
            "type" => "text",
            "protected" => "0",
            "size" => "40",
            "check" => ""),
        "text" => array(
            "label" => "Beschrijving",
            "default" => "",
            "role" => "public",
            "mandatory" => "0",
            "type" => "textarea",
            "protected" => "0",
            "check" => ""),
        "detail" => array(
            "label" => "Uitgebreid",
            "default" => "",
            "role" => "public",
            "mandatory" => "0",
            "type" => "textarea",
            "protected" => "0",
            "check" => ""),
        "onTop" => array(
            "label" => "Bovenaan",
            "default" => "0",
            "role" => "public",
            "mandatory" => "0",
            "type" => "checkbox",
            "checked" => "1",
            "protected" => "0",
            "check" => ""),
        "onCalendar" => array(
            "label" => "Vermelden in kalender",
            "default" => "0",
            "role" => "public",
            "mandatory" => "0",
            "type" => "checkbox",
            "checked" => "1",
            "protected" => "0",
            "check" => ""),
        "showOnImages" => array(
            "label" => "In galerie opnemen",
            "default" => "0",
            "role" => "public",
            "mandatory" => "0",
            "type" => "checkbox",
            "checked" => "1",
            "protected" => "0",
            "check" => ""),
        "image" => array(
            "label" => "Afbeelding",
            "default" => "0",
            "role" => "public",
            "mandatory" => "0",
            "type" => "number",
            "protected" => "0",
            "check" => ""),
        "author_id" => array(
            "label" => "Auteur",
            "default" => "",
            "role" => "public",
            "mandatory" => "0",
            "type" => "system",
            "protected" => "1",
            "check" => ""));

    public function get()
    {
        if (func_num_args() == 0) {
            genLogVar(__function__ . "No argument passed");
            return false;
        }
        $textHTML = true;
        $i = 0;
        if (func_num_args() >= 1) {
            $id = func_get_arg($i++);
        }
        if (func_num_args() >= 2) {
            $textHTML = func_get_arg($i++);
        }
        $result = $this->getOne(array(
                "id" => $id));
        if ($textHTML) {
            $this->parseDown($result);
        }
        return $result;
    }

    public function __construct()
    {
        if (defined($this->tbDefine)) {
            parent::__construct(SQL_TBEVENT);
        } else {
            genSetError($this->tbDefine . " not defined");
        }
        $this->structure["category"] = general::getCategoryDefinition();
    }
}
?>

