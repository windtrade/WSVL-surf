<?php
error_reporting(E_ALL);
// $docRoot is the top level for this 'logical' subdomain
// It works better than $docRoot, because that 
// points at <server>/~<domain owner>/public_html when you 
// don't use the regular subdomain name to access the pages
$docRoot = preg_replace('/[^\/]*\/[^\/]*$/', '', __FILE__);
// Define the place of libraries here
// Make it a string of separated pathnames
// set_include_path(get_include_path() . PATH_SEPARATOR . $path);
set_include_path(get_include_path() .
PATH_SEPARATOR . $docRoot."/library".
PATH_SEPARATOR . $docRoot."/../ParseDown".
PATH_SEPARATOR . $docRoot."/../Smarty/libs");
// All constant values get defined here:
define("GEN_PASSWORD_COST", "10");
define("DEFAULT_TEMPLATE", "wvleidschendam.tpl");
define("FILE_UPLOAD_DIR", $docRoot."/../files/");
define("IMAGE_ROOT_URL", "http://surf.wvleidschendam.nl/images/");
define("IMAGE_FILE_ROOT", $docRoot."/../surf/images/");
define("JAVASCRIPT_DIR", "javascript/");

# time out in minutes
define("SESSION_TIMEOUT", 10);
# Datetime objects love this:
$our_timezone="Europe/Amsterdam";

define("STYLESHEET_DIR", "css/");
define("STYLESHEET_0", STYLESHEET_DIR."general.css");
define("JAVASCRIPT_INTERNAL_DIR", $docRoot."/".JAVASCRIPT_DIR);

define("SQL_DBASE", "wvleid01_surfclub");
define("SQL_DBUSER", "wvleid01_surf");
define("SQL_DBPSWD", "uAzMZ4kd");
define("SQL_DBHOST", "localhost");

define("RECAPTCHA_API", "https://www.google.com/recaptcha/api.js");
define("RECAPTCHA_SECRET", "6Le2twETAAAAAON47QO8i_gulAZfJGCofJPQvUE7");
define("RECAPTCHA_SITE",   "6Le2twETAAAAACBtab8pq02ShjA8ex-3KV4-RXoA");

define("JQUERY_SRC","https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js");

// compatibility with older versions
$mysql_user = SQL_DBUSER;
$mysql_password = SQL_DBPSWD;
$mysql_host = SQL_DBHOST;
$mysql_dbName = SQL_DBASE;
// Defines for records from TEKSTEN table
define ("TEKSTEN_ID_ABOUT_US", "1");
define ("TEKSTEN_RUBRIEK_ID_GENERAL", "0");
//define("SQL_PREFIX", "v2_0_");
define("SQL_PREFIX", "");
define("SQL_TBCALENDAR", "v2_0_calendar");
define("SQL_TBCONTACT", "v2_0_contact");
define("SQL_TBEVENT", "v2_0_event");
define("SQL_TBIMAGE", "image");
define("SQL_TBEVENTREGISTER", "v2_eventregister");
define("SQL_TBNEWS", "news");
define("SQL_TBTEKSTEN", "teksten");
define("SQL_TBTRAININGSMAATJES", "trainingsmaatjes");
define("SQL_TBTARIF", "v2_0_tarif");
define("SQL_TBUSERS", "v2_0_users");
define("SQL_TBUSER_ROLES", "v2_0_user_roles");

// $SQL_ENCODING should be made GLOBAL wherever
// it is required
$SQL_ENCODING = array(
    SQL_TBEVENT => "iso-latin1",
    SQL_TBNEWS => "iso-latin1",
    SQL_TBTEKSTEN => "utf-8",
    SQL_TBUSERS => "utf-8",
    SQL_TBUSER_ROLES => "utf-8"
);
// $USER_ROLES defines valid roles that any user can have.
// The values with each key do not have a meaning
$USER_ROLES = array(
    "SYSTEM" => 0,
    "ORGANISER" => 0,
    "MEMBER" => 0,
    "MEMBERADMI" => 0,
    "EDITOR" => 0);

$NAVIGATION_BASE = $_SERVER["SERVER_NAME"];

if (!array_key_exists('tab', $_REQUEST)) {
    // by default tab will be page name
    $_REQUEST['tab'] =
	preg_replace('/^.*\/(.*).php/', '${1}', $_SERVER["PHP_SELF"]);
}
$personalMenu = array(
    array(
	"tab" => "login",
    "onclick" => "login",
	"url" => $_SERVER["PHP_SELF"],
	"label" => "Aanmelden",
	"mustLogin" => 0,
	"subMenu" => array()),
    array(
	"tab" => $_REQUEST['tab']."&action=logout",
    "onclick" => "logout",
	"url" => $_SERVER["PHP_SELF"],
	"label" => "Afmelden",
	"mustLogin" => 1,
	"subMenu" => array()),
    array(
	"tab" => "membership",
	"url" => "beheerLidmaatschap.php",
	"label" => "Mijn gegevens",
	"mustLogin" => 1,
	"subMenu" => array()),
    array(
	"tab" => "register",
	"url" => "eventRegister.php",
	"label" => "Aan- en afmelden evenementen",
	"mustLogin" => 1,
	"subMenu" => array()),
    array(
	"tab" => "nieuwsBeheer",
	"url" => "nieuwsbeheer.php",
	"label" => "Redactie",
	"mustLogin" => 1,
	"subMenu" => array()),
    array(
	"tab" => "beheerTarief",
	"url" => "beheerTarief.php",
	"label" => "Tarieven",
	"mustLogin" => 1,
	"subMenu" => array()),
    array(
	"tab" => "kalenderBeheer",
	"url" => "kalenderbeheer.php",
	"label" => "Beheer evenementen",
	"mustLogin" => 1,
	"subMenu" => array())
    );
$infoMenu = array(
    array(
	"tab" => "surfles",
	"url" => "informatie.php",
	"label" => "Windsurfles",
	"mustLogin" => 0,
	"subMenu" => array()),
    array(
	"tab" => "surfpool",
	"url" => "informatie.php",
	"label" => "Surfpool",
	"mustLogin" => 0,
	"subMenu" => array()),
    array(
	"tab" => "aanmelden",
	"url" => "aanmeldenLid.php",
	"label" => "Lid worden",
	"mustLogin" => 0,
	"subMenu" => array())
);
# menu top level, define submenus here above
$mainMenu = array(
    array(
	"tab" => "home",
	"url" => "index.php",
	"label" => "Home",
	"mustLogin" => 0,
	"subMenu" => array()
    ),
    array(
	"tab" => "informatie",
	"url" => "informatie.php",
	"label" => "Informatie",
	"mustLogin" => 0,
	"subMenu" => $infoMenu
    ),
    array(
	"tab" => "kalender",
	"url" => "kalender.php",
	"label" => "Kalender",
	"mustLogin" => 0,
	"subMenu" => array()
    ),
    array(
	"tab" => "training",
	"url" => "training.php",
	"label" => "Training",
	"mustLogin" => 0,
	"subMenu" => array()
    ), /*
    array(
	"tab" => "foto",
	"url" => "foto.php",
	"label" => "Foto's",
	"mustLogin" => 0,
	"subMenu" => array()
    ),
    array(
	"tab" => "verslagen",
	"url" => "verslagen.php",
	"label" => "Wedstrijden &amp; Verslagen",
	"mustLogin" => 0,
	"subMenu" => array()
    ), */
    array(
	"tab" => "forum",
	"url" => "http://forum.wvleidschendam.nl/index.php",
	"label" => "Forum",
	"mustLogin" => 0,
	"subMenu" => array()
    ),
    array(
	"tab" => "contact",
	"url" => "contactPage.php",
	"label" => "Contact",
	"mustLogin" => 0,
	"subMenu" => array()
    ),
    array(
	"tab" => "personal",
	"url" => "showPersonal.php",
	"label" => "Voor jou",
	"mustLogin" => 0,
	"subMenu" => $personalMenu)
    );
# defines for the user roles
# Values can only be max 10 chars long
define("ROLE_SYSTEM",      "SYSTEM");
define("ROLE_ORGANISER",   "ORGANISER");
define("ROLE_EDITOR",      "EDITOR");
define("ROLE_MEMBERADMIN", "MEMBERADMI");
define("ROLE_MEMBER",      "MEMBER");

#defines for standard emails
define ("EMAIL_SYSTEM", "surf.wvleidschendam@gmail.com");
define ("EMAIL_MEMBERADMIN", "ledendaministratie@wvleidschendam.nl");

$fields = array(
    "calendar" => array(
	"datetime" => array("type" => "datetime-local", "mode" => "edit", "text" => "Datum (+tijd)"),
	"name" => array("type" => "text", "mode" => "edit", "text" => "Naam deel event"),
	"location" => array("type" => "text", "mode" => "edit", "text" => "Locatie"),
	"url" => array("type" => "text", "mode" => "edit", "text" => "Link")
    ),
    "event" => array(
	"id" => array("type" =>  "hidden", "mode" => "edit", "text" => "ID"),
	"name" => array("type" => "text", "mode" => "edit", "text" => "Naam"),
	"location" => array("type" => "text", "mode" => "edit", "text" => "Locatie"),
	"url" => array("type" => "text", "mode" => "edit", "text" => "Link")
    ),
    "user" => array(
	"id" => array("type" =>  "hidden", "mode" => "edit", "text" => "ID"),
	"relnr" => array("type" =>  "text", "mode" => "system", "text" => "Verenigngsnr."),
	"bondnr" => array("type" =>  "text", "mode" => "system", "text" => "Verbondsnr."),
	"modifieddate" => array("type" =>  "text", "mode" => "protected", "text" => "Laatst gewijzigd"),
	"modifiedby" => array("type" =>  "text", "mode" => "protected", "text" => "Door"),
	"roepnaam" => array("type" => "text", "mode" => "edit", "text" => "Roepnaam"),
	"naam" => array("type" => "text", "mode" => "edit", "text" => "Achternaam"),
	"voorvoegsel"=> array("type" => "text", "mode" => "edit", "text" => "Voorvoegsel"),
	"straat" => array("type" => "text", "mode" => "edit", "text" => "Adres"),
	"huisnr" => array("type" => "text", "mode" => "edit", "text" => "Huisnr."),
	"postcode" => array("type" => "text", "mode" => "edit", "text" => "Postcode"),
	"plaats" => array("type" => "text", "mode" => "edit", "text" => "Woonplaats"),
	"telefoonnr" => array("type" => "tel", "mode" => "edit", "text" => "Telefoon"),
	"mobielnr" => array("type" => "tel", "mode" => "edit", "text" => "Mobiel"),
	"gebdatum" => array("type" => "date", "mode" => "edit", "text" => "Geb. datum"),
	"lidsoort" => array("type" => "text", "mode" => "edit", "text" => "Lidmaatschap"),
	"email" => array("type" => "email", "mode" => "edit", "text" => "Email"),
	"emailOuder" => array("type" => "email", "mode" => "edit", "text" => "Email Ouder"),
	//"wachtwoord" => array("type" => "password", "text" => "Wachtwoord"),
	"nick" => array("type" => "text", "mode" => "edit", "text" => "Bijnaam")
    ),
    "userRoles" => array(
	array("type" => "checkbox", "text" => "Betalend lid", "value" => ROLE_MEMBER),
	array("type" => "checkbox", "text" => "Redacteur", "value" => ROLE_EDITOR),
	array("type" => "checkbox", "text" => "Organisator", "value" => ROLE_ORGANISER),
	array("type" => "checkbox", "text" => "LedenAdminisratie", "value" => ROLE_MEMBERADMIN),
	array("type" => "checkbox", "text" => "Beheerder", "value" => ROLE_SYSTEM)
    )
);

define ("DEFAULT_OG_IMAGE", "http://surfdev.wvleidschendam.nl/images/wsvl_logo2015.jpg");
