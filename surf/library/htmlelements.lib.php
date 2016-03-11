<?php
#
#  htmlelements: element processing for smarty templates
#  Huug Peters
#  06-12-2013: creation
#

require_once "image.lib.php";
require_once "userSession.lib.php";
class htmlelements
{
    private $image;
    private $userSession;

    public function __construct()
    {
        $this->image = new image();
    }

    public function HEelement($p, &$smarty)
    {
        if (!array_key_exists("tag", $p) || $p["tag"] == "") {
            return "<!-- no tag parameter -->";
        }
        if (!array_key_exists("value", $p) || $p["tag"] == "") {
            return "<!-- no value parameter -->";
        }
        $result = "<" . $p["tag"];
        foreach ($p as $attr => $val) {
            if ($attr == "tag" || $attr == "value")
                continue;
            $result .= " $attr=\"$val\"";
        }
        $result .= ">" . $p["value"] . "</" . $p["tag"] . ">";
        return $result;
    }

    public function HEimage($p, &$smarty)
    {
        $start = print_r($p, true);
        if (!array_key_exists("id", $p))
            $p["id"] = 0;
        $img = false;
        if ($p["id"] > 0) {
            $img = $this->image->get($p["id"]);
        }
        if (!array_key_exists("size", $p)) {
            $p["size"] = "small";
        }
        ;
        if ($img) {
            $src = image::getUrl($p["id"], $p["size"]);
        } else {
            $src = image::imageNotFound($p["size"]);
            $img["description"] = "geen plaatje";
        }
        $result = '<img src="' . $src . '"';
        $result .= ' class="img_' . $p["size"] . '"';
        $result .= ' alt="' . $img["description"] . '"';
        $result .= ' />';
        return $result;
    }

    public function HEanchor($p, $smarty)
    {
        $attributes = "";
        $href = "#";
        $inner = "Naar nergens";
        foreach ($p as $key => $val) {
            switch (strtolower($key)) { 
            case "href":
                $href = $val;
                break;
            case "inner":
                $inner = $val;
                break;
            default:
                $attributes .= " ".$key.'='.$val;
            }
        }
        $result = "";
        if ($href != "#" && !preg_match('/:\/\//', $href)) {
            $href = "http://" . $href;
        }
        $pattern = '/^([^?]*)[?]*(.*)/';
        $page = preg_replace($pattern, "$1", $href);
        $query = preg_replace($pattern, "$2", $href);
        $result .= "<a " . 'href="' . $page;
        if (strlen($query)) {
            $result .= '?' . $query;
        }
        $result .= '"';
        $result .= $attributes;
        $result .= '>';
        $result .= $inner;
        $result .= '</a>';
        return $result;
    }

    public function HEtext($p, $smarty)
    {
        if (!array_key_exists("textId", $p)) {
            return "<!-- " . __function__ . ": no textId param>";
        }
        if (!is_numeric($p["textId"]) || $p["textId"] <= 0) {
            return "<!-- " . __function__ . ": invalid textId: " . $p["textId"] . " -->";
        }
        $text = genGetTekst($p["textId"]);
        $result = "";
        if (!is_array($text)) {
            $result .= "<!-- " . __function__ . ": Could not get " . $p["textId"] . " -->";
        } else {
            if (array_key_exists("titel", $text)) {
                $result .= "<h1>" . $text["titel"] . "</h1>";
            }
            if (array_key_exists("tekst", $text)) {
                $result .= $text["tekst"];
            }
        }
        return $result;
    }

    private function heGetParam($p, $param, $default)
    {
        if (array_key_exists($param, $p) and $p[$param] != "") {
            return $p[$param];
        }
        return $default;
    }

    public function heCssMenuElement($p, $class, $elt)
    {
        if ($elt['mustLogin'] && !$this->userSession->isLoggedIn())
            return "";
        $hasSub = 0;
        $result = "";
        $class = "";
        if (array_key_exists("subMenu", $elt) && count($elt["subMenu"]) > 0) {
            $hasSub = 1;
            $class = $p["has-sub"];
        }
        $classAttr = ($class == "" ? "" : "class='$class'");
        $result .= "<li $classAttr>";
        /**
         * On-click functionality is added in document.ready function
         */
        if (array_key_exists("onclick", $elt) && $elt["onclick"] != "") {
            $result .= "<a id='" . $elt["onclick"] . "'" . " href='#'" . ">" . "<span>" . $elt["label"] .
                "</span>" . "</a>\n";
        } elseif (array_key_exists("url", $elt) && $elt["url"] != "") {
            $result .= "<a href='" . $elt["url"];
            if (array_key_exists("tab", $elt)) {
                $result .= "?tab=" . $elt["tab"];
            }
            $result .= "'>" . "<span>" . $elt["label"] . "</span>" . "</a>\n";
        } else {
            $result .= "<span>" . $elt["label"] . "</span>";
        }
        if ($hasSub) {
            $result .= "<ul>\n";
            $last = array_pop($elt["subMenu"]);
            foreach ($elt["subMenu"] as $subElt) {
                $result .= $this->heCssMenuElement($p, "", $subElt);
            }
            $result .= $this->heCssMenuElement($p, $p["last"], $last);
            $result .= "</ul>";
        }
        $result .= "</li>";
        return $result;
    }
    public function HEcssmenu($p, &$smarty)
    {
        $this->userSession = new UserSession();
        if (!array_key_exists("menu", $p) or !is_array($p["menu"])) {
            return "<!-- no menu available " . print_r($p, true) . "-->\n";
        }
        $p["id"] = $this->heGetParam($p, "id", "");
        $p["has-sub"] = $this->heGetParam($p, "has-sub", "has-sub");
        $p["last"] = $this->heGetParam($p, "last", "last");
        $result = "";
        if ($p["id"]) {
            $result .= "<div id='" . $p["id"] . "'>\n";
        }
        $result .= "<ul>\n";
        $last = array_pop($p["menu"]);
        foreach ($p["menu"] as $elt) {
            $result .= $this->heCssMenuElement($p, "", $elt);
        }
        $result .= $this->heCssMenuElement($p, $p["last"], $last);
        $result .= "</ul>\n";
        if ($p["id"]) {
            $result .= "</div>";
        }
        return $result;
    }

    /**
     * remove all arguments from $uri except those mentioned in $keep
     * use:
     * {HEbuildURI [uri="<uri>"] [keep=<arg1,arg2,..>] [argX=val [argY=val]]}
     */
    public function HEbuildURI($p, &$smarty)
    {
        $keep = array();
        $newargs = array();
        $uri = $_SERVER["REQUEST_URI"];
        foreach ($p as $key => $val) {
            if ($key == "keep") {
                $keep = preg_split("/\s*[,]\s*/", $p["keep"]);
            } elseif ($key == "uri") {
                $uri = $val;
            } else {
                array_push($newargs, "$key=".urlencode($val));
            }
        }
        $parts = preg_split("/[?]/", $uri);
        if (count($parts) > 1) {
            $args = preg_split("/[&]/", $parts[1]);
        } else {
            $args = array();
        }
        $uri = $parts[0];
        foreach ($args as $arg) {
            $parts = preg_split("/[=]/", $arg);
            if (in_array($parts[0], $keep)) {
                array_unshift($newargs, $arg);
            }
        }
        $newargs = join($newargs, "&");
        if (strlen($newargs)) $uri .= "?" . $newargs;
        return $_SERVER["SERVER_NAME"] . $uri;
    }

    // Add buttons to share on social media
    public function HEsocial($p, &$smarty)
    {
        $pageURL = genCurPageURL($p);
        $result = "";
        // Facebook
        $result .= "<div class=\"fb-share-button\" ";
        $result .= "data-href=\"" . $pageURL . "\" ";
        $result .= "data-layout=\"button_count\">";
        $result .= "</div>";
        // twitter
        /* leave this for later
        $result .= "<a class=\"twitter-share-button\" " ;
        $result .= "href=\"https://twitter.com/intent/tweet?text=Windsurfnieuws:%20\"?hashtags=\"WSVL,windsurf\" ";
        $result .= "data-size=\"large\">";
        $result .= "Tweet</a>";
        */
        return $result;
    }
}
?>
