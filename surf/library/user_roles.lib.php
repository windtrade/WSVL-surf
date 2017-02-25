<?php
/*
 * user_roles.lib.php
 *
 * class to access user_roles table
 *
 * 21-04-2012 : Huug	: Creation
 */
require_once "general.lib.php";
require_once "table.lib.php";

class user_roles extends table
{
	private $tbDefine="SQL_TBUSER_ROLES";

    protected $structure = array(
        "user_id" => array(
            "label" => "ID",
            "default" => "",
            "role" => "public",
            "mandatory" => "0",
            "type" =>  "number",
            "protected" => "1",
            "check" => ""),
        "role" => array(
            "label" => "Rol",
            "default" => "MEMBER",
            "role" => "system",
            "mandatory" => "0",
            "type" =>  "text",
            "protected" => "1",
            "check" => "")
	);

	public function __construct()
	{
		if (defined($this->tbDefine)) {
			parent::__construct(SQL_TBUSER_ROLES);
		} else {
			genSetError(" not defined");
		}
	
	}

	public function getUsersWithRoles($role)
	{
		$sth = $this->readSelect(array("role" => $role));
	    $retval = array();
	    $rows = $this->fetch_assoc_all($sth);
		while ($row=array_shift($rows)) {
		    array_push($retval, $row["user_id"]);
	    }
	    return $retval;
	}

	public function hasRole($user_id, $role)
	{
		$result = $this->readSelect(Array(
			"user_id" => $user_id,
			"role" => $role));
		return (0 < count($this->fetch_assoc_all($result)));
	}

    /**
     * @param $user_id
     * @return array(["user-id'] => user_id, ['role 1'] =>"role 1" {, ...}
     */
	public function getRoles($user_id)
	{
		$sth = $this->readSelect(Array(
			"user_id" => $user_id));
		$roles = $this->fetch_assoc_all($sth);
		$retVal = Array("user_id" => $user_id);
		while ($row = array_shift($roles)) {
		    $retVal[$row["role"]]=$row["role"];
		}
		return $retVal;
	}

	public function deleteAll($id)
    {
        $roles = $this->getSelect(
            array( "user_id" => $id));
        while ($role = array_shift($roles)) {
            if (!$this->delete($role)) {
                return false;
            }
        }
        return true;
    }

	public function insert($arr)
	{
		global $USER_ROLES;
		if (!array_key_exists($arr["role"], $USER_ROLES)) {
			genSetError("De rol '".$arr["role"]."' is niet gedefinieerd");
			return false;
		}
		if ($this->hasRole($arr["user_id"], $arr["role"])) {
			return true;
		}
		return parent::insert($arr);
	}

	public function definedRoles() {
	    global $USER_ROLES;
	    $all = array_merge($USER_ROLES);
	    $defined = array_keys($all);
	    return $defined;
    }
}
?>
