<?php
class htmlforms
{
    private $fieldID = 0;

    private function stringField($name, $pd)
    {
        if ($pd["protected"])
        {
            return $this->otherField($name, $pd);
        }
        $result = "<!-- " . __line__ . "--><td>" . $pd["label"] . "</td>";
        $result .= "<td>";
        if ($pd["protected"])
        {
            return $result . $pd["value"] . "</td>";
        }
        $result .= "<input type=\"" . $pd["type"] . "\"";
        if (array_key_exists("size", $pd))
        {
            $result .= ' size="' . $pd["size"] . '"';
        } else
        {
            $result .= ' size="50"';
        }
        if (array_key_exists("placeholder", $pd))
        {
            $result .= " placeholder=\"" . $pd["placeholder"] . "\"";
        }

        $result .= " name=\"" . $name . "\" value=\"" . $pd["value"] . "\" /></td>";

        return $result;
    }

    private function textareaField($name, $pd)
    {
        if ($pd["protected"])
        {
            return $this->otherField($name, $pd);
        }
        $result = "<td>" . $pd["label"] . "</td>";
        $result .= "<td>";
        $cols = 60;
        $rows = 4 + strlen($pd["value"]) / $cols;
        $result .= "<textarea rows=\"$rows\" " . "name=\"" . $name . "\">";
        if (array_key_exists("value", $pd))
        {
            $result .= $pd["value"];
        }
        $result .= "</textarea></td>";
        return $result;
    }

    private function datetimeLocalField($name, $pd)
    {
        if ($pd["protected"])
        {
            return $this->otherField($name, $pd);
        }
        $pd["value"] = preg_replace("/ /", "T", $pd["value"]);
        return $this->stringField($name, $pd);
    }

    private function checkboxField($name, $pd)
    {
        $result = "<td>" . $pd["label"] . "</td>";
        $result .= "<td>";
        if ($pd["protected"] && $pd["value"] != "")
        {
            $result .= "<input name=\"$name\" type=\"hidden\" value=\"" . $pd["value"] . "\" />";
        }
        $result .= "<input name=\"$name\" type=\"checkbox\" ";
        if ($pd["protected"])
        {
            $result .= "disabled ";
        }
        if ($pd["checked"] == $pd["value"])
        {
            $result .= "checked ";
        }
        $result .= "value=\" " . $pd["checked"] . "\" />";
        $result .= "</td>";
        return $result;
    }

    private function selectField($name, $pd)
    {
        $result = "<td>" . $pd["label"] . "</td><td>";
        $result .= "<select name=\"$name\">";
        foreach ($pd["options"] as $val => $text)
        {
            $sld = ($val == $pd["value"] ? "selected" : "");
            $result .= "<option value=\"$val\" $sld>$text</option>";
        }
        $result .= "</select>";
        $result .= "</td>";
        return $result;
    }

    private function imageField($name, $pd)
    {
        $name = preg_replace('/[\[\]]+/', '__', $name);
        $name = preg_replace('/__$/', '', $name);
        return "<td>" . $pd["label"] . "</td><td>" . "<input name=\"$name\" type=\"file\" value=\"" .
            $pd["value"] . "\" />";
    }

    private function otherField($name, $pd)
    {
        return "<td>" . $pd["label"] . "</td><td>" . "<!-- unsupported input type: " . $pd["type"] .
            " -->" . "<input name=\"$name\" type=\"hidden\" value=\"" . $pd["value"] . "\" />" .
            $pd["value"] . "</td>";
    }

    public function HFlabeledField($params, &$smarty)
    {
        $pd = $params["data"];
        if (!array_key_exists("protected", $pd))
        {
            $pd["protected"] = 0;
        }
        $name = $params["prefix"] . "[" . $pd["name"] . "]";
        if (strlen($pd["name"]) == 0)
        {
            $pd["name"] = sprintf("%s__%3d", $pd["type"], $this->fieldID++);
        }
        if ($pd["type"] == "date" || $pd["type"] == "email" || $pd["type"] == "number" ||
            $pd["type"] == "password" || $pd["type"] == "tel" || $pd["type"] == "text" || $pd["type"] ==
            "url")
        {
            $result = $this->stringField($name, $pd);
        } else
            if ($pd["type"] == "datetime-local")
            {
                $result = $this->datetimeLocalField($name, $pd);
            } else
                if ($pd["type"] == "checkbox")
                {
                    $result = $this->checkboxField($name, $pd);
                } else
                    if ($pd["type"] == "textarea")
                    {
                        $result = $this->textareaField($name, $pd);
                    } else
                        if ($pd["type"] == "select")
                        {
                            $result = $this->selectField($name, $pd);
                        } else
                            if ($pd["type"] == "image")
                            {
                                $result = $this->imageField($name, $pd);
                            } else
                            {
                                $result = $this->otherField($name, $pd);
                            }
                            return $result;
    }

    public function HFrecaptcha($params, &$smarty)
    {
        if (!defined("RECAPTCHA_SITE"))
        {
            return "<!-- RECAPTCHA_SITE not defined -->";
        }
        return '<td colspan="2">' . '<div class="g-recaptcha" data-sitekey="' .
            RECAPTCHA_SITE . '"></div>' . '</td>';
    }

    public function HFform($params, &$smarty)
    {
        $form = array(
            "action" => $_SERVER["PHP_SELF"],
            "id" => "",
            "method" => "GET");

        $args = array();
        $uriArr = split("\?", $_SERVER["REQUEST_URI"]);
        if (count($uriArr) > 1)
        {
            $args = split("&", $uriArr[1]);
        }
        $argsToKeep = array();
        foreach ($args as $arg)
        {
            if (preg_match("/^tab=/", $arg))
            {
                array_push($argsToKeep, $arg);
            }
        }
        $form["action"] = $uriArr[0];
        if (count($argsToKeep))
        {
            $from["action"] .= "?" . join("&", $argsToKeep);
        }
        foreach (array_keys($form) as $key)
        {
            if (array_key_exists($key, $params))
            {
                $form[$key] = $params[$key];
            }
        }
        $result = "<form";
        foreach ($form as $key => $val)
        {
            $result .= ' ' . $key . '="' . $val . '"';
        }

        $result .= ">";
        return $result;
    }

    function HFsubmit($params, &$smarty)
    {
        $result = "";
        $myParams = array("value" => "VERSTUUR");
        $mustLogin = genGetMustLogin($_SERVER["REQUEST_URI"]);
        genLogVar(__FUNCTION__." mustLogin", ($mustLogin?"true":"false"));
        if ($mustLogin)
        {
            $myParams['onclick'] = "submitIfAuthorized(this, event)";
        }
        foreach ($params as $key => $val)
        {
            $myParams[strtolower($key)] = $val;
        }
        $result .= "<input type='submit' ";
        genLogVAr(__FUNCTION__." myParams", $myParams);
        foreach ($myParams as $key => $val)
        {
            $result .= $key . "='" . $val . "' ";
        }
        $result .= "/>";
        return $result;
    }

    function HFreset($params, &$smarty)
    {
        $result = "";
        $myParams = array("value" => "HERSTEL");
        foreach ($params as $key => $val)
        {
            $myParams[strtolower($key)] = $val;
        }
        $result .= "<input type='reset' ";
        $result .= "value='" . $myParams["value"] . "' ";
        $result .= "/>";
        return $result;
    }
}
?>
