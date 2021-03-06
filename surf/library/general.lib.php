<?php
/*
* general.lib.php: class and functions for general purposes
*
* It should be included immediately after the config include
*
* 21-10-2011 Huug
*/

require_once "database.lib.php";
require_once "htmlforms.lib.php";
require_once "htmlElements.lib.php";
require_once "Smarty.class.php";
require_once "Parsedown.php";
require_once "teksten.lib.php";

/* Global PDO Database connection */
$pdoGlobal = null;
/**
 * general
 * 
 * @package WSVL Surf
 * @author Huug Peters
 * @copyright 2015
 * @version $Id$
 * @access public
 */

class general
{
    private $errors = array();
    private $infos = array();
    private $traces = array();
    private $javascriptFiles = array();
    private $javascriptStatements = array();
    private $smarty;
    private $parsedown;
    private $htmlforms;
    private $htmlElements = false;
    private $db;
    private $formStep = 0;
    private $action;
    public $teksten;

    const NONE = "0";
    const GENERAL = "1";
    const TRAINING = "2";
    const COMPETITION = "3";
    const TRIP = "4";
    const INSTRUCTION = "5";

    private $og = array(
        "url" => "",
        "title" => "",
        "description" => "",
        "site_name" => "",
        "image" => "");

    public function __construct()
    {
        global $our_timezone;
        if (!isset($_SESSION)) {
            genSetError("starting session");
            session_start();
        }
        if (!array_key_exists('loggedIn', $_SESSION))
            $_SESSION['loggedIn'] = 0;
        if (array_key_exists('SERVER_NAME', $_SERVER)) {
            $this->action = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
        }
        if (!isset($our_timezone))
            $our_timezone = "Europe/Amsterdam";
        if (!date_default_timezone_set($our_timezone)) {
            genSetError("Could not set timezone to $our_timezone");
        }
        $this->smarty = new Smarty();
        $this->parsedown = new Parsedown();
        $this->htmlforms = new htmlforms();
        $this->teksten = new Teksten();
    }

    /**
     * Complex constants can only be defined in static functions like this one:
     */
    public static function getCategories()
    {
        return array(
            self::NONE => "Kies een categorie",
            self::GENERAL => "Algemeen",
            self::TRAINING => "Training/Instructie",
            self::INSTRUCTION => "Beginners instructie",
            self::COMPETITION => "Wedstrijden",
            self::TRIP => "Surftrips");
    }

    public static function getCategoryDefinition()
    {
        return array(
            "label" => "Categorie",
            "default" => self::GENERAL,
            "role" => "public",
            "mandatory" => "0",
            "type" => "select",
            "options" => self::getCategories(),
            "protected" => "0",
            "check" => "");
    }

    private function mustLogin()
    {
        global $mainMenu;
        $self = substr($_SERVER['PHP_SELF'], 1);
        foreach ($mainMenu as $item) {
            if ($item["url"] == $self) {
                return $item["mustLogin"];
            }
            foreach ($item["subMenu"] as $subItem) {
                if ($subItem["url"] == $self) {
                    return $subItem["mustLogin"];
                }
            }
        }
        $this->trace("not found: $self");
        return 0; // can't find it: be wise...
    }

    public function setDatabase($db)
    {
        $this->db = $db;
    }

    public function setError($msg)
    {
        array_push($this->errors, nl2br(htmlEntities($msg)));
    }

    public function getError()
    {
        return array_pop($this->errors);
    }

    public function getErrors()
    {
        $result = array();
        $nrArgs = func_num_args();
        $allArgs = func_get_args();
        $format = "";
        if ($nrArgs != 0) {
            $format = array_shift($allArgs);
        }
        if ($format == "") {
            $result = $this->errors;
        } else {
            $result = genArrayToAssoc($this->errors, $format);
        }
        $this->errors = array();
        return $result;
    }

    public function setInfo($msg)
    {
        array_push($this->infos, nl2br(htmlEntities($msg)));
    }

    public function getInfos()
    {
        $result = array();

        $result = array();
        $nrArgs = func_num_args();
        $allArgs = func_get_args();
        $format = "";
        if ($nrArgs != 0) {
            $format = array_shift($allArgs);
        }
        if ($format == "") {
            $result = $this->infos;
        } else {
            $result = genArrayToAssoc($this->infos, $format);
        }
        $this->infos = array();
        return $result;
    }

    public function setFormStep($formStep)
    {
        $this->formStep = $formStep;
    }

    public function smartyRegister_function($inner, $function)
    {
        $this->smarty->register_function($inner, $function);
    }

    /*
    * when necessary and possible set the proper open graph attribute
    */
    public function smartyAssign($name, $var)
    {
        $this->smarty->assign($name, $var);
        if (array_key_exists($name, $this->og)) {
            if (!is_array($var)) {
                $this->og[$name] = $var;
            } else {
                genLogVar(__function__ . "value og[" . $name . "] is een array", $var);
            }
        }
    }

    /**
     * add object graph (og) data to smarty
     * HTML tags are removed from text values;
     */
    private function smartyAddOG()
    {
        foreach ($this->og as $key => $val) {
            if ($val == "") {
                switch ($key) {
                    case "title":
                        $val = "WV Leidschendam Windsurfen en Sup";
                        break;
                    case "description":
                        $val = "WV Leidschendam, de vaart erin sinds 1982";
                        break;
                    case "site_name":
                        $val = "WVLeidschendam Windsurfles, -trainingen, -wedstrijden en -weekends";
                        break;
                    case "image":
                        $val = DEFAULT_OG_IMAGE;
                        continue;
                }
            }
            $val = preg_replace('/<[^>]>/', '', $val);
            if ($key == "image")
                $val = image::getUrl($val, "large");
            $this->og[$key] = $val;
        }
        $this->og["url"] = genCurPageURL();
        $this->smartyAssign("og", $this->og);
    }

    public function smartyDisplay($template)
    {
        # comes from configuration
        global $mainMenu;
        $currentTab = "";
        if (array_key_exists("tab", $_REQUEST)) {
            $currentTab = $_REQUEST["tab"];
        }
        $currentSubTab = "";
        if (array_key_exists("subTab", $_REQUEST)) {
            $currentSubTab = $_REQUEST["subTab"];
        }
        $now = new DateTime();
        $this->trace("PHP versie: " . PHP_MAJOR_VERSION . "." . PHP_MINOR_VERSION . "." .
            PHP_RELEASE_VERSION);
        $this->addJavascriptFile("general");
        $this->addJavascriptFile(JQUERY_SRC);
        $this->addJavascriptFile(RECAPTCHA_API);
        #$this->addJavascriptFile("jquery-ui-1.10.0.custom.min");
        if (!$this->htmlElements) {
            $this->htmlElements = new htmlElements();
        }
        $this->smarty->registerPlugin('function', 'HFform', array($this->htmlforms,
                'HFform'));
        $this->smarty->registerPlugin('function', 'HFlabeledField', array($this->
                htmlforms, 'HFlabeledField'));
        $this->smarty->registerPlugin('function', 'HFrecaptcha', array($this->htmlforms,
                'HFrecaptcha'));
        $this->smarty->registerPlugin('function', 'HFsubmit', array($this->htmlforms,
                'HFsubmit'));
        $this->smarty->registerPlugin('function', 'HFreset', array($this->htmlforms,
                'HFreset'));
        $this->smarty->registerPlugin('function', 'HEelement', array($this->
                htmlElements, 'HEelement'));
        $this->smarty->registerPlugin('function', 'HEanchor', array($this->htmlElements,
                'HEanchor'));
        $this->smarty->registerPlugin('function', 'HEimage', array($this->htmlElements,
                'HEimage'));
        $this->smarty->registerPlugin('function', 'HEtext', array($this->htmlElements,
                'HEtext'));
        $this->smarty->registerPlugin('function', 'HEcssmenu', array($this->
                htmlElements, 'HEcssmenu'));
        $this->smarty->registerPlugin('function', 'HEbuildURI', array($this->
                htmlElements, 'HEbuildURI'));
        $this->smarty->registerPlugin('function', 'HEsocial', array($this->htmlElements,
                'HEsocial'));
        $this->smarty->assign("template", $template);
        $this->smarty->assign('imageRoot', IMAGE_ROOT_URL);
        $this->smarty->assign('formStep', $this->formStep);
        $this->smarty->assign('action', $this->action);
        $this->smarty->assign('currentTab', $currentTab);
        $this->smarty->assign('currentSubTab', $currentSubTab);
        $this->smarty->assign('mainMenu', $mainMenu);
        $this->addJavascriptdeclaration("session_lastactive", $now->format('d-m-Y H:i'));
        $this->smarty->assign('session_timeout', SESSION_TIMEOUT);
        $this->smarty->assign('loggedIn', $_SESSION['loggedIn']);
        if (array_key_exists('tab', $_REQUEST) && $_REQUEST['tab'] == 'login') {
            $mustLogin = 1;
        } else {
            $mustLogin = $this->mustLogin();
        }
        $this->smarty->assign('mustLogin', $mustLogin);
        $this->addJavascriptDeclaration("gLoggedIn", $_SESSION['loggedIn']);
        $this->smarty->assign('loggedIn', $_SESSION['loggedIn']);
        if ($_SESSION['loggedIn']) {
            $this->smarty->assign('session_name', $_SESSION['user']['nick']);
        }
        $this->smarty->assign('NOROBOT', genGetPageCache("NOROBOT"));
        $this->smarty->assign('stylesheet', STYLESHEET_0);
        $this->smarty->assign('javascriptFiles', $this->javascriptFiles);
        $this->smarty->assign('javascriptStatements', $this->javascriptStatements);
        $this->smartyAddOG();
        $this->smarty->assign('errors', $this->errors);
        $this->smarty->assign('infos', $this->infos);
        $this->smarty->assign('traces', $this->traces);
        $this->smarty->display($template);
    }

    public function parseDownText($text)
    {
        $result = $this->parsedown->text($text);
        return $result;
    }

    /** Convert Markdown text to HTML */
    public function parseDownParse($text)
    {
        return $this->parsedown->parse($text);
    }

    public function DBConnected()
    {
        if (is_object($this->db)) {
            return $this->db->isConnected();
        }
        return false;
    }

    public function DBClose()
    {
        if (is_object($this->db)) {
            $this->db->close();
        }
    }

    public function trace($msg)
    {
        array_push($this->traces, $msg);
    }

    public function addJavascriptStatement($statement)
    {
        array_push($this->javascriptStatements, $statement);
    }

    public function addJavascriptDeclaration($var, $value)
    {
        array_push($this->javascriptStatements, "var " . $var . "= \"" . $value . "\";");
    }

    public function addJavascriptFile($script)
    {
        if (!preg_match('/.*\.js/i', $script)) {
            $script .= ".js";
        }
        if (preg_match('/^http[s]+:/', $script)) {
            // external script: done
            array_push($this->javascriptFiles, $script);
            return;
        }
        $internalScriptName = JAVASCRIPT_INTERNAL_DIR . "/" . $script;
        $externalScriptName = JAVASCRIPT_DIR . "/" . $script;
        if (file_exists($internalScriptName)) {
            array_push($this->javascriptFiles, $externalScriptName);
        } else {
            $this->setError("$script ($externalScriptName) bestaat niet");
        }
    }

    public static function reCAPTCHAverify()
    {
        if (!array_key_exists("g-recaptcha-response", $_POST))
            return false;
        $response = $_POST["g-recaptcha-response"];
        $google = "https://www.google.com/recaptcha/api/siteverify?";
        $secret = RECAPTCHA_SECRET;
        $remoteip = $_SERVER["REMOTE_ADDR"];
        $curl = curl_init($google . "secret=$secret&remoteip=$remoteip" . "&response=$response");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 1);
        $gResponse = curl_exec($curl);
        if (curl_errno($curl)) {
            genSetError("recaptcha error: " . curl_error($curl));
            return false;
        }
        curl_close($curl);
        $gRespAssoc = json_decode($gResponse, true);
        $OK = ($gRespAssoc["success"] == 1);
        if (!$OK) {
            genSetError("Robots kunnen niet windsurfen of suppen " .
                "en zijn ongezellig op kamp, sorry");
        }
        return $OK;
    }
}

$general = new general();

# Returns an url with session ID, when necessary.
# That is, when no session copokie is available;
function genSessionUrl($url)
{
    if (preg_match('/^https?:\/\/(' . $_SERVER['SERVER_NAME'] . '|' . $_SERVER['SERVER_ADDR'] .
        ')/', $url)) {
        if (SID)
            $url .= '?' . SID;
    }
    return preg_replace('/[?](.*)[?]/', '?${1}&', $url);
}

function genSetError($msg)
{
    global $general;
    if (is_object($general)) {
        $general->setError($msg);
    }
}
function genSetInfo($msg)
{
    global $general;
    if (is_object($general)) {
        $general->setInfo($msg);
    }
}
function genDumpVar($label, $var)
{
    genSetError($label . "=" . print_r($var, true));
}

function genGetError()
{
    global $general;
    if (is_object($general)) {
        return $general->getError();
    }
    return "";
}
function genGetErrors()
{
    global $general;
    $nrArgs = func_num_args();
    $allArgs = func_get_args();
    $format = "";
    if ($nrArgs != 0) {
        $format = array_shift($allArgs);
    }
    if (is_object($general)) {
        return $general->getErrors($format);
    }
    return array();
}
function genGetInfos()
{
    global $general;
    $nrArgs = func_num_args();
    $allArgs = func_get_args();
    $format = "";
    if ($nrArgs != 0) {
        $format = array_shift($allArgs);
    }
    if (is_object($general)) {
        return $general->getInfos($format);
    }
    return array();
}

function genSmartyRegister_function($inner, $function)
{ // TODO: unfinished work
    global $general;
    if (is_object($general)) {
        $general->smarty_register_function($inner, $function);
    }
}

function genSmartyAssign($name, $var)
{
    global $general;
    if (is_object($general)) {
        $general->smartyAssign($name, $var);
    }
}

function genSmartyDisplay($name)
{
    global $general;
    if (strlen($name) == 0)
        $name = DEFAULT_TEMPLATE;
    if (is_object($general)) {
        $general->smartyDisplay($name);
    }
}

function genParseDownParse($text)
{
    global $general;
    //return Parsedown::parse($text);
    return $general->parseDownParse($text);
}

function genParseDownText($text)
{
    global $general;
    return $general->parseDownText($text);
}

function genSetDatabase($db)
{
    global $general;
    return $general->setDatabase($db);
}

function genDBConnected()
{
    global $general;
    if (is_object($general)) {
        return $general->DBConnected();
    }
    return false;
}

function genDBClose()
{
    global $general;
    if (is_object($general)) {
        $general->DBClose();
    }
}

function genTrace()
{
    global $general;
    if (is_object($general)) {
        $nrArgs = func_num_args();
        $allArgs = func_get_args();
        $msg = "";
        while (count($nrArgs) > 1) {
            $msg .= array_shift($args) . "=";
            $msg .= print_r(array_shift($args), true) . "\n";
        }
        $msg = print_r(array_shift($args), true);
        $general->trace($msg);
    }
}

function genSetFormStep($step)
{
    global $general;
    if (is_object($general)) {
        $general->setFormStep($step);
    }
}

function genArrayValToArray(&$arr, $idx, $val)
{
    $thisIdx = array_shift($idx);
    // at the end of idx: just add value
    if (count($idx) == 0) {
        $arr[$thisIdx] = stripslashes($val);
    } else {
        // multiple dimensions left: add array when necessary
        if (!array_key_exists($thisIdx, $arr)) {
            $arr[$thisIdx] = array();
        }
        genArrayValToArray($arr[$thisIdx], $idx, $val);
    }
    return;
}

function genGetArrayFromArray($srcArr, $label)
{
    $arr = array();
    if (!is_Array($srcArr)) {
        genSetError(__function__ . ": 1st argument must be array");
        return $arr;
    }
    $match = "/^" . $label . "_" . "/";
    foreach ($srcArr as $key => $val) {
        if (!preg_match($match, $key))
            continue;
        $idx = preg_split("/_/", $key);
        array_shift($idx); // drop the label
        if (!isset($dimensions))
            $dimensions = count($idx);
        if (count($idx) != $dimensions) {
            genSetError("Array variables " . $label . "_* have varying dimensions");
            return false;
        }
        genArrayValToArray($arr, $idx, $val);
    }
    return $arr;
}

function genAddJavascriptStatement($statement)
{
    global $general;
    $general->addJavascriptStatement($statement);
}

function genAddJavascriptDeclaration($var, $value)
{
    global $general;
    $general->addJavascriptDeclaration($var, $value);
}

function genAddJavascriptFile($script)
{
    global $general;
    $general->addJavascriptFile($script);
}

function genCompareClasses($class, $otherClass)
{
    $className = $class; // the class you're trying to extend
    genSetError("CLASS : $className\n\n========\n\n");
    $refClass = new ReflectionClass($className);
    foreach ($refClass->getMethods() as $refMethod) {
        genSetError("METHOD : " . $refMethod->getName() . "\n\n");
        genSetError("getNumberOfParameters()         : " . $refMethod->
            getNumberOfParameters() . "\n");
        genSetError("getNumberOfRequiredParameters() : " . $refMethod->
            getNumberOfRequiredParameters() . "\n");
        genSetError("\n");
        foreach ($refMethod->getParameters() as $refParameter) {
            genSetError($refParameter . "\n");
        }
        genSetError("\n--------\n\n");
    }
    $className = otherClass; // the class you're trying to extend
    genSetError("CLASS : $className\n\n========\n\n");
    $refClass = new ReflectionClass($className);
    foreach ($refClass->getMethods() as $refMethod) {
        genSetError("METHOD : " . $refMethod->getName() . "\n\n");
        genSetError("getNumberOfParameters()         : " . $refMethod->
            getNumberOfParameters() . "\n");
        genSetError("getNumberOfRequiredParameters() : " . $refMethod->
            getNumberOfRequiredParameters() . "\n");
        genSetError("\n");
        foreach ($refMethod->getParameters() as $refParameter) {
            genSetError($refParameter . "\n");
        }
        genSetError("\n--------\n\n");
    }
}

function genFirstDate($wDay, $fMonth, $fDay, $lMonth, $lDay)
{
    $today = localtime(time(), true);
    $startYear = 1900 + ($today["tm_mon"] < $lMonth ? $today["tm_year"] : $today["tm_year"] +
        1);
    $firstDate = mktime(0, 0, 0, $fMonth, $fDay, $startYear, 0); // this year or next
    // weekday following $fSay/$fMonth
    $firstDate += ($wDay - date('w', $firstDate)) * 24 * 3600;
    return $firstDate;
}
function genLastDate($wDay, $fMonth, $fDay, $lMonth, $lDay)
{
    $today = localtime(time(), true);
    $startYear = 1900 + ($today["tm_mon"] < $lMonth ? $today["tm_year"] : $today["tm_year"] +
        1);
    $lastDate = mktime(0, 0, 0, $lMonth, $lDay, $startYear, 0); // this year or next
    $lastDate += ($wDay - date('w', $lastDate) - 7) * 24 * 3600;
    return $lastDate;
}

function genNextDate($wDay, $fMonth, $fDay, $lMonth, $lDay)
{
    $firstDate = genFirstDate($wDay, $fMonth, $fDay, $lMonth, $lDay);
    $today = localtime(time(), true);
    $thisDay = date('j');
    $thisMonth = date('m');
    $thisYear = date('Y');
    $nextDate = mktime(0, 0, 0, $thisMonth, $thisDay, $thisYear, 0);
    if ($firstDate >= $nextDate)
        return $firstDate;
    // nextDate is now today, but must be set to next $wDay
    $wkDay = date('w', $nextDate);
    if ($wkDay <= $wDay) {
        $nextDate += ($wDay - $wkDay) * 24 * 3600; // this weeks $wDay
    } else {
        $nextDate += (7 + $wDay - $wkDay) * 24 * 3600; // next weeks $wDay
    }
    return $nextDate;
}

function genDateSeries($wDay, $fMonth, $fDay, $lMonth, $lDay)
{
    $result = array();
    $listDate = genNextDate($wDay, $fMonth, $fDay, $lMonth, $lDay);
    $lastDate = genLastDate($wDay, $fMonth, $fDay, $lMonth, $lDay);
    while ($listDate <= $lastDate) {
        array_push($result, $listDate);
        $listDate += 7 * 24 * 3600;
    }
    return $result;
}

/*
* return text $textId ass assoc array, or an empty array
*/
function genGetTekst($textId)
{
    global $general;
    if (!is_numeric($textId) or $textId <= 0)
        return array();
    if (!($result = $general->teksten->getTekst($textId))) {
        $result = array();
    }
    return $result;
}

function genSetSessionData($file, $name, $value)
{
    $_SESSION[$file][$name] = $value;
}
function genGetSessionData($file, $name)
{
    if (array_key_exists($file, $_SESSION) && array_key_exists($name, $_SESSION[$file])) {
        return $_SESSION[$file][$name];
    }
    return false;
}

function genSetPageCache()
{
    $nrArgs = func_num_args();
    $allArgs = func_get_args();
    if ($nrArgs < 2)
        return;
    $data = array_pop($allArgs);
    while (count($allArgs) > 1) {
        $newData = array(array_pop($allArgs) => $data);
        $data = $newData;
    }
    genSetSessionData($_SERVER["PHP_SELF"], $allArgs[0], $data);
}

/*
* looking for getSessionData( <self>, arg1 {, [arg2] } ...
*/
function genGetPageCache()
{
    $nrArgs = func_num_args();
    $allArgs = func_get_args();
    if ($nrArgs < 1)
        return false;
    $result = genGetSessionData($_SERVER["PHP_SELF"], array_shift($allArgs));
    while ($result && count($allArgs)) {
        $key = array_shift($allArgs);
        if (!array_key_exists($key, $result))
            return false;
        $result = $result[$key];
    }
    return $result;
}

function genSendMail($message, $from, $addressees)
{
    if (!is_array($addressees))
        $addressees = array($addressees);
    $headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    foreach ($addressees as $to) {
        if (!strlen($to))
            continue;
        mail($to, $message["titel"], $message["tekst"], $headers);
    }
}

function genRegisterEvent($eventList, &$fd)
{
    $ok = true;
    if (!array_key_exists("id", $fd["user"]))
        $fd["user"]["id"] = -1;
    if ($fd["user"]["id"] < 0) {
        // Do not register nothing for an unknown user
        if (count($fd["eventRegister"]) <= 0)
            return $ok;
        $ok = $ok && $this->registerUser($fd);
        if (!$ok)
            return $ok;
    }
    //TODO: add test on user_id

    // build a list per event with all selected start(-datetime)
    $newStarts = array();
    foreach (array_keys($eventList) as $key)
        $newStarts[$key] = array();
    foreach ($fd["eventRegister"] as $key => $list) {
        // skip registration for nonexistent events
        if (!array_key_exists($key, $fd["eventRegister"]))
            continue;
        $newStarts[$key] = array_keys($fd["eventRegister"][$key]);
    }

    // Build a sorted list of all start dates for every event
    $calStarts = array();
    foreach (array_keys($eventList) as $id) {
        $calStarts[$id] = array();
        foreach ($eventList[$id]["calendar"] as $cal) {
            array_push($calStarts[$id], $cal["start"]);
        }
        sort($calStarts[$id]);
    }
    //sort($calStarts);

    // Step 1: Update existing registrations for this user
    foreach (array_keys($newStarts) as $evId) { // foreach event Td
        foreach ($this->eventRegister->getEventForUser($evId, $fd["user"]["id"]) as $evReg) {
            $newEventStartsForId = $newStarts[$evId];
            $idx = array_search($evReg["start"], $newEventStartsForId);
            if ($idx === false) {
                genSetError(__line__ . ' afmelden voor ' . $evReg["start"]);
                if ($evReg["enrolled"]) {
                    $this->eventRegister->update($evReg, array("enrolled" => 0));
                }
            } else {
                genSetError(__line__ . ' aanmelden voor ' . $evReg["start"]);
                if (!$evReg["enrolled"]) {
                    $this->eventRegister->update($evReg, array("enrolled" => 1));
                }
                array_splice($newStarts[$evId], $idx, 1);
            }
        }
    }
    foreach (array_keys($newStarts) as $evId) {
        foreach ($newStarts[$evId] as $nS) {
            if (array_search($nS, $calStarts[$evId]) !== false) {
                $this->eventRegister->insert(array(
                    "id" => $evId,
                    "start" => $nS,
                    "userId" => $fd["user"]["id"],
                    "enrolled" => 1));
            }
        }
    }
}

function hidePasswords(&$var)
{
    $pwdLabels = array("wachtwoord");
    if (!is_array($var))
        return;
    foreach (array_keys($var) as $key) {
        if (is_array($var[$key])) {
            hidePasswords($var[$key]);
        } else {
            foreach ($pwdLabels as $label) {
                $pattern = "/" . $label . "/i";
                $result = preg_match($pattern, $key);
                if ($result === false) {
                    genSetError("Sorry, matchfoutje");
                    return;
                }
                switch ($result) {
                    case 0:
                        break;
                    case 1:
                        $var[$key] = "*******";
                        break;
                }
            }
        }
    }
}

function genURI() {
    return (array_key_exists("REQUEST_URI", $_SERVER)? $_SERVER["REQUEST_URI"]: "REQUEST_URI");
}

function genLogWrite() {
    $label = __FILE__;
    $label = preg_replace('/(public_html)(.).*/', '$1$2files$2log_', $label);
    $dt = new DateTime();
    $label .= $dt->format('Ymd') . '.txt';
    $fh = false;
    try {
        $fh = fopen($label, 'a');
    } catch (Exception $e) {
        error_log($e->getMessage(), 0);
    }
    $allArgs = func_get_args();
    while($line = array_shift($allArgs)) {
        $output = $dt->format("d-m-Y H:i:s ==> ").genURI()." ".$line;
        if ($fh) {
            fwrite($fh, $output."\n");
        } else {
            error_log($output, 0);
        }
    }
    if ($fh) {
        fclose($fh);
    }
}

// Write to public_html/files/logYYYYMMDD.txt
function genLogVar($name, $var)
{
    $args = func_get_args();
    if (count ($args)) return;
    $name = array_shift($args);
    $class = __CLASS__ . "";
    if (strlen($class) == 0)
        $class = "NOCLASS";
    hidePasswords($var);
    $source = array_key_exists("REMOTE_ADDR", $_SERVER)? $_SERVER["REMOTE_ADDR"]: "no server";
    $text = "(" . $source . ") " . $class . ": " . $name;
    if (count(args)) $text .= "=";
    while (count($args)) {
        $text .= (print_r($var, true))."\n";
    };
    genLogWrite(
        $text);
}

function genCurPageURL()
{
    $nrArgs = func_num_args();
    $allArgs = func_get_args();
    $pageURL = 'http';
    if (isset($_SERVER['HTTPS']) && filter_var($_SERVER['HTTPS'],
        FILTER_VALIDATE_BOOLEAN)) {
        $pageURL .= "s";
    }
    $pageURL .= "://";

    if (array_key_exists("SERVER_NAME", $_SERVER)) {
        $pageURL .= $_SERVER["SERVER_NAME"];
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= ":" . $_SERVER["SERVER_PORT"];
        }
        $elts = explode('?', $_SERVER["REQUEST_URI"]);
        $pageURL .= array_shift($elts); // now only arguments are left
        $args = explode('&', implode('?', $elts));
        $params = array();
        foreach ($args as $arg) {
            $elts = explode('=', $arg);
            if (count($elts)) {
                $params[$elts[0]] = (count($elts) > 1 ? $elts[1] : "");
            }
        }
        for ($i = 0; $i < $nrArgs; $i++) {
            if (is_array($allArgs[$i])) {
                foreach ($allArgs[0] as $key => $val) {
                    $params[$key] = $val;
                }
            } else {
                list($key, $val) = explode('=', $allArgs[$i]);
                $params[$key] = $val;
            }
        }
        $elts = array();
        foreach ($params as $key => $val) {
            array_push($elts, "$key=" . urlencode(urldecode($val)));
        }
        if (count($elts)) {
            $pageURL .= "?" . implode('&', $elts);
        }
    }
    return $pageURL;
}
/**
 * Add messages to $data
 * Convert $data to JSON string and write it as response
 * with appropriate headers
 * then exit;
 */
function genJSONResponse($data)
{
    $now = new DateTime();
    $now->modify("-1s");
    $now = $now->format("D, j M Y H:i:s e");
    if (headers_sent())
        return;
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: ' . $now);
    header('Content-type: application/json');
    $data["errors"] = genGetErrors("msg");
    $data["infos"] = genGetInfos("msg");
    $output = json_encode($data);
    print ($output);
    genLogVar(__function__ . '$output', $output);
    exit(0);
}

/**
 * turn an array into array of assoc arrays:
 * {val, val, ...} ==> {{label => val}, {label => val}, {label => val}, ...}}
 */
function genArrayToAssoc($arr, $label)
{
    $result = array();
    while ($val = array_shift($arr)) {
        array_push($result, array($label => $val));
    }
    return $result;
}

/**
 * return menu item from menu branche or any sub menu
 * or false when no match was found
 */
function genGetMenuItemFromArray($arr, $url, $tab, $bestYet)
{
    if (0 == count($arr))
        return false;
    foreach ($arr as $e) {
        foreach (array("url", "tab") as $key) {
            if (!array_key_exists($key, $e)) {
                $e[$key] = "";
            }
        }
        if ($url == $e["url"]) {
            if ($e["mustLogin"]) {
                if (!$bestYet)
                    $bestYet = $e;
            }
            if ($tab == $e["tab"]) {
                return $e;
            }
        }
        if (array_key_exists("subMenu", $e)) {
            $result = genGetMenuItemFromArray($e["subMenu"], $url, $tab, $bestYet);
            if ($result) {
                if ($result["tab"] == $tab) {
                    return $result;
                }
                if (!$bestYet || $bestYet["tab"] != "") {
                    $bestYet = $result;
                }
            }
        }
    }
    return $bestYet;
}

/**
 * Return first menu item from $mainMenu with matching url and tab
 * or false when not found
 */
function genGetMenuItem($url, $tab)
{
    global $mainMenu;
    $url = preg_replace('/^\/*/', "", $url);
    // genLogVar(__function__ . ' $url?$tab', $url . "?" . $tab);
    $result = genGetMenuItemFromArray($mainMenu, $url, $tab, false);
    // genLogVar(__function__ . " result", $result);
    return $result;
}
/**
 * If the page is not listed, you must be logged in for it
 */
function genGetRequiredAuthority($url)
{
    $mustLogin = true;
    $role = "";
    if ($url) {
        /** $url = page[?var=val[&var=val]...] */
        $a["tab"] = "";
        $elts = explode('?', $url);
        if (count($elts) > 1) {
            $args = explode("&", $elts[1]);
            foreach ($args as $arg) {
                $val = "";
                list($key, $val) = explode('=', $arg);
                $a[$key] = $val;
            }
        }
        $menuItem = genGetMenuItem($elts[0], $a["tab"]);
        //genLogVar(__function__ . ":menuitem", $menuItem);
        if ($menuItem) {
            if (array_key_exists("role", $menuItem)) {
                $role = $menuItem["role"];
            }
            if (array_key_exists("mustLogin", $menuItem)) {
                $mustLogin = (0 != $menuItem["mustLogin"]);
            }
        }
    }
    return array("mustLogin" => $mustLogin, "role" => $role);
}

function genIsAuthorized($userSession)
{
    $reqAuth = genGetRequiredAuthority($_SERVER["REQUEST_URI"]);
    $result = true;
    if ($reqAuth["mustLogin"]) {
        $result = false;
        if ($userSession->isLoggedIn()) {
            $result = $userSession->hasRole($reqAuth["role"]);
        }
    }
    return $result;
}

function genGetMustLogin()
{
    $nrArgs = func_num_args();
    $allArgs = func_get_args();
    if ($nrArgs == 0) {
        if (!array_key_exists("REQUEST_URI", $_SERVER)) return false;
        $uri = $_SERVER["REQUEST_URI"];
    } else {
        $uri = $allArgs[0];
    }
    $reqAuth = genGetRequiredAuthority($uri);
    //genLogVar(__file__ . ":" . __function__ . ' $uri=', $uri]);
    //genLogVar(__file__ . ":" . __function__ . ' $reqAuth=', $reqAuth);
    return $reqAuth["mustLogin"];
}
/** return the assoc array that makes up the menu */
function genGetMenu()
{
    global $mainMenu;
    return $mainMenu;
}

/** get $_POST['fd'] as far as it matches expected */
function genGetFormdata($expected)
{
    if (!array_key_exists('fd', $_POST)) {
        genSetError("Geen gegevens ontvangen");
        genLogVar(__file__ . ":" . __function__ . "Geen POST data REQUEST", $_REQUEST);
        return false;
    }
    $result = array();
    return $result;
}

/**
 * return arguments wrapped in HTML comment
 */
function genHTMLcomment()
{
    $result = "<!-- ";
    $numArs = func_num_args();
    $args = func_get_args();
    while ($args) {
        $arg = array_shift($args);
        $result .= print_r($arg, true);
    }
    $result .= " -->";
    return $result;
}
/**
 * return list of names of participants for event $id at $start
 */
function genGetParticipantNames($eventRegister, $users, $eventID, $start)
{
    $ok = true;
    $names = array();
    if (!is_object($eventRegister)) {
        genSetError("eventRegister not defined");
        $ok = false;
    }
    if (!is_object($users)) {
        genSetError("users not defined");
        $ok = false;
    }
    if ($ok) {
        $participants = $eventRegister->getParticipants($eventID, $start);
        foreach ($participants as $userId) {
            $user = $users->get($userId);
            if ($user)
                array_push($names, $user["roepnaam"] . " " . $user["voorvoegsel"] . " " . $user["naam"]);
        }
    }
    return $names;
}

/**
 *
 * @param $arr
 * @param $xtra
 */
function genArrayMergeOrPush(&$arr, $xtra)
{
    $numericArr = false;
    foreach (array_keys($arr) as $key) {
        if (is_numeric($key)) $numericArr = true;
    }
    if (is_array($xtra)) {
        foreach (array_keys($xtra) as $key) {
            if (is_numeric($key) != $numericArr) {
                genLogVar(__FUNCTION__.": ", "cannot merge assoc and regular array \$arr".print_r($arr, true), $xtra );
                throw new Exception("Incompatible Data, see log");
            }
        }
        array_merge($arr, $xtra);
        return;
    }
    if (!$numericArr) {
        genLogVar(__FUNCTION__ . ": ", "cannot push scalar to assoc array \$arr" . print_r($arr, true), $xtra);
        throw new Exception("Incompatible Data, see log");
    }
    array_push($arr, $xtra);
    return;
}

/*
* if you want to change or check the cost of password encryption
* un-comment this block

* $timeTarget = 0.05; // 50 milliseconds 

* $cost = 8;
* do {
* $cost+  +;
* $start = microtime(true);
* password_hash("test", PASSWORD_BCRYPT, array("cost" => $cost));
* $end = microtime(true);
* } while (($end - $start) < $timeTarget);

* genSetError( "Appropriate Cost Found: " . $cost);
*/

if (is_object($general)) {
    $general->setDatabase(new Database());
}

if (count(array_keys($_POST))) {
    genLogVar("Loading ". __FILE__ . ":" . '$_POST', $_POST);
}
?>
