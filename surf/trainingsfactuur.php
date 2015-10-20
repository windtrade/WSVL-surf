<?php
include "library/all_config.inc.php";
include "general.lib.php";
include "trainingsmaatjes.lib.php";

$deelnemers = array(
array("naam",              "emailadres",                "start",               "eigen materiaal"),
array("Alexandra",         "amlvdbroek@gmail.com",      "2014-04-01 00:00:00", 0),// factuur 16-5
array("Axel Gründemann",   "axelgrundemann@hotmail.com","2014-04-01 00:00:00", 1),// factuur 16-5
array("Christine Visser",  "chris10.m.visser@gmail.com","2014-04-01 00:00:00", 1),// factuur 16-5
array("Daniël van Zeijst", "vanzeijst@casema.nl",       "2014-04-01 00:00:00", 0),// factuur 16-5
array("Femke Luijten",     "femkeluijten@hotmail.com",  "2014-04-01 00:00:00", 1),// factuur 16-5
array("Huug",              "huug@windtrade.nl",         "2014-04-01 00:00:00", 1),// factuur 16-5
array("Johan Brans",       "johan_brans@hotmail.com",   "2014-04-01 00:00:00", 1),// factuur 16-5
array("Luc Schut",         "baredluc@zonnet.nl",        "2014-04-01 00:00:00", 0),// factuur 16-5
array("Maciej Hoch",       "maciej.hoch@gmail.com",     "2014-04-01 00:00:00", 1),// factuur 16-5
array("Marc van Santen",   "m.v.santen@hotmail.com",    "2014-04-01 00:00:00", 1),// factuur 16-5
array("Pepijn van Ommeren","karendemos@planet.nl",      "2014-04-01 00:00:00", 0),// factuur 16-5
array("Peter van Velsen",  "petermartijn@xs4all.nl",    "2014-04-01 00:00:00", 1),// factuur 16-5
array("Pim de Bruin",      "pedebruin@hotmail.com",     "2014-04-01 00:00:00", 1),// factuur 16-5
array("Rick van Santen",   "m.v.santen@hotmail.com",    "2014-04-01 00:00:00", 1),// factuur 16-5
array("robert windmeijer", "R.windmeijer30@gmail.com",  "2014-04-01 00:00:00", 0),// factuur 16-5
array("Tim Vermaesen",     "timvermaesen@gmail.com",    "2014-04-01 00:00:00", 1),// factuur 16-5
array("Karen",             "Karen43@live.nl",           "2014-04-15 00:00:00", 1),// factuur 16-5
array("Merel",             "Karen43@live.nl",           "2014-04-15 00:00:00", 1),// factuur 16-5
array("Alec Hoogerwerf",   "alec.hoogerwerf@gmail.com", "2014-05-01 00:00:00", 0),// factuur 16-5
array("Iris Blonk",        "blonkg@gmail.com",    "2014-05-01 00:00:00", 1),// factuur 16-5
array("Pieter Jan Visser", "pieterjv@xs4all.nl",        "2014-05-01 00:00:00", 1),// factuur 16-5
array("Robin Kruif",       "e.bleiker@nki.nl",          "2014-05-01 00:00:00", 0),// factuur 16-5
array("Pascal Jongste",    "pascal.jongste@gmail.com",  "2014-05-01 00:00:00", 0),// factuur 16-5
array("Edwin van Leeuwen", "vanleeuwen.edwin@gmail.com","2014-05-01 00:00:00", 0),// factuur 16-5
array("Bastiaan Florijn",  "florijn85@msn.com"         ,"2014-07-01 00:00:00", 0),// factuur 24-6
array("Eveline van Beek",  "eveline.vbeek@gmail.com"   ,"2014-09-02 00:00:00", 0),// factuur 6-9
array("Ilse Disseldorp",   "ilsedisseldorp@gmail.com"  ,"2014-07-01 00:00:00", 0),// factuur 12-11
array("Karlijn van Harten","altine@casema.nl"          ,"2014-09-02 00:00:00", 0),// factuur 12-11
array("Ruben Perk",        "larsnini@ziggo.nl",         "2014-09-09 00:00:00", 1));// factuur 12-11

$text = <<<EOT
Beste <<NAAM>>,

Leuk dat je in 2014 meedoet met onze trainingen.
Met deze mail willen we je vragen om je trainingsbijdrage en,
voor zover van toepassing, de bijdrage voor de surfpool voor dit
jaar voldoen.

Trainingsbijdrage: <<GELD0>>
Bijdrage Surfpool: <<GELD1>>
Totaal: <<GELD2>>

Wil je dit bedrag binnen 2 weken overmaken rekening NL15 ABNA 0262 4083 76
t.n.v. H.C. Peters
Dat is de Moneyou spaarrekening van je surfclub.
EOT;

$labels = array_shift($deelnemers);
print("<table>\n");
print("<tr><th>".$labels[0]."</th><th>".$labels[2]."</th></tr>\n");
$subject="WV Leidschendam Surfclub: Trainingsbijdrage 2014";
$patterns = array("/<<NAAM>>/", "/<<GELD0>>/", "/<<GELD1>>/", "/<<GELD2>>/","/ /","/\n/","/\r/");
foreach ($deelnemers as $d) {
    $dt=new DateTime($d[2]);
    $month=$dt->format("m");
    switch ($month) {
    case 1:
    case 2:
    case 3:
    case 4:
	$geld[0] = 100;
	break;
    case 5:
	$geld[0] = 85;
	break;
    case 6:
	$geld[0] = 70;
	break;
    case 7:
	$geld[0] = 55;
	break;
    case 8:
	$geld[0] = 40;
    case 9:
	$geld[0] = 25;
    default:
	$geld[0] = 0;
    }
    if ($d[3] == 0) {
	$geld[1] = $geld[0];
    } else {
	$geld[1] = 0;
    }
    $geld[2] = $geld[0] + $geld[1];
    #print(nl2br('$d='.print_r($d, TRUE)));
    #print(nl2br('$geld='.print_r($geld, TRUE)));
    $replacements = array($d[0],        "$geld[0],00",   "$geld[1],00",   "$geld[2],00",  "%20","%0A", "%0D");
    $body=preg_replace(
	$patterns,
	$replacements,
	$text);
    print "<tr><td><a href='mailto:".$d[1]."?subject=$subject&body=$body'>".
	$d[0]."</a></td><td>".$d[2]."</td></tr>\n";
}
print("</table>\n");
?>
