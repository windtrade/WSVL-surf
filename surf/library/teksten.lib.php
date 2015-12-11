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
	private $tbDefine="SQL_TBTEKSTEN";

	/*
	 * get a text, replace the fields in the text with
	 * values from the associated array
	 * The fields are marked <<key>> where key is a key
	 * from the fields array
	 * */
	public function getTekstExpanded()
	{
	    $nrArgs = func_num_args();
	    $allArgs = func_get_args();
	    if ($nrArgs < 2) return false;
	    $id = array_shift($allArgs);
	    $fields = array_shift($allArgs);
	    if (count($allArgs)) {
		$html = array_shift($allArgs);
	    } else {
		$html = true;
	    }
	    $tekst = $this->getTekst($id, $html);
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

	/*
	 * get a single text, based on id column
	 */
	public function getTekst() {
	    $nrArgs = func_num_args();
	    $allArgs = func_get_args();
	    if ($nrArgs < 1) return false;
	    $id = array_shift($allArgs);
	    if (count($allArgs)) {
		$html = array_shift($allArgs);
	    } else {
		$html = true;
	    }
	    $result = $this->readSelect(array("id" => $id));
	    if ($result && mysql_num_rows($result)) {
		$tekst = mysql_fetch_assoc($result);
		// several texts have been fixed with <br/> when stored,
		// lose those
		
		$tekst["tekst"] = preg_replace("/<br\s*\/\s*>/", "",
		    $tekst["tekst"]);
		if ($html) {
		    /*
            $tekst["tekst"] = preg_replace("/\n/", "<br/>\n",
			$tekst["tekst"]);
            */
            $tekst["tekst"] = genParseDownParse($tekst["tekst"]);
		}
		return $tekst;
	    }
	    return false;
	}

	public function __construct()
	{
		if (defined($this->tbDefine)) {
			parent::__construct(SQL_TBTEKSTEN);
		} else {
			genSetError($this->tbDefine." not defined");
		}
	
	}
}
?>
