<?php
/*
 * teksten.lib.php
 *
 * class to access users table
 *
 * 29-12-2012 : Huug	: Creation
 */
require_once "table.lib.php";

class teksten extends table
{
    protected $structure = array(
        "id" => array(
            "label" => "Tekst nr.",
            "default" => "Nieuw",
            "role" => "public",
            "mandatory" => "0",
            "type" => "number",
            "protected" => "1",
            "check" => ""),
        "rubriek_id" => array(),
        "titel" => array(
            "label" => "Titel",
            "default" => "",
            "role" => "public",
            "mandatory" => "1",
            "type" => "number",
            "protected" => "0",
            "check" => ""),
        "tekst" => array(
            "label" => "Tekst",
            "default" => "0",
            "role" => "public",
            "mandatory" => "1",
            "type" => "textarea",
            "protected" => "0",
            "check" => ""),
        "bron" => array(
            "label" => "Bron",
            "default" => "",
            "role" => "public",
            "mandatory" => "0",
            "type" => "text",
            "protected" => "0",
            "check" => ""),
        "tekst_timestamp" => array(
            "label" => "Last update",
            "default" => "now",
            "role" => "public",
            "mandatory" => "0",
            "type" => "datetime-local",
            "protected" => "1",
            "check" => ""));


	private $tbDefine="SQL_TBTEKSTEN";

    /*
     * get a text, replace the fields in the text with
     * values from the associated array
     * The fields are marked <<key>> where key is a key
     * from the fields array
     * */
    public function getTekstExpanded($id, $fields)
    {
    	return $this->getTekstExpandedSomeHow($id, $fields, true);
	}
/*
 * get a text, replace the fields in the text with
 * values from the associated array
 * The fields are marked <<key>> where key is a key
 * from the fields array
 * */
public function getTekstExpandedPlain($id, $fields)
{
    return $this->getTekstExpandedSomeHow($id, $fields, false);
}
	/*
	 * get a text, replace the fields in the text with
	 * values from the associated array
	 * The fields are marked <<key>> where key is a key
	 * from the fields array
	 * */
    public function getTekstExpandedSomeHow($id, $fields, $html)
    {
	    $tekst = $this->getTekstSomeHow($id, $html);
	    $pattern = array();
	    $replacement = array();
	    foreach ($fields as $key => $val) {
		array_push($pattern, "/<<".$key.">>/");
		array_push($replacement, $val);
	    }
	    foreach(array("titel", "tekst") as $part) {
		$tekst[$part] = preg_replace(
		    $pattern, $replacement, $tekst[$part]);
	    }
	    return $tekst;
	}

    /**
     * get a single text, based on id column
     * @param id: int id of tekst
     * return tekst marked down
     * @return mixed assoc array tekst or false
     */
    public function getTekst($id)
    {
        return $this->getTekstSomeHow($id, true);
    }

    /**
     * get a single text, based on id column
     * @param id: int id of tekst
     * return tekst plain
     * @return mixed assoc array tekst or false
     */
    public function getTekstPlain($id)
    {
        return $this->getTekstSomeHow($id, false);
    }


    /**
     * get a single text, based on id column
     * @param id: int id of tekst
     * @param html: boolean html return tekst marked down
     * @return mixed assoc array tekst or false
     */
    public function getTekstSomeHow($id, $html) {
        $result = $this->readSelect(array("id" => $id));
        $tekst = $this->fetch_assoc($result);
        if (!$tekst) return false;
        // several texts have been fixed with <br/> when stored,
        // lose those
        $tekst["tekst"] = preg_replace("/<br\s*\/*\s*>/", "",
            $tekst["tekst"]);
        if ($html) {
            $tekst["tekst"] = genParseDownParse($tekst["tekst"]);
        }
        return $tekst;
    }

	public function __construct()
	{
		if (defined($this->tbDefine)) {
			parent::__construct(SQL_TBTEKSTEN);
		} else {
			genSetError($this->tbDefine." not defined");
		}
		$this->structure['rubriek_id'] = general::getCategoryDefinition();
	
	}
}

