<?php
/*
 * user_roles.lib.php
 *
 * class to access user_roles table
 *
 * 21-04-2012 : Huug	: Creation
 */
require_once "table.lib.php";

class user_roles extends table
{
	private $tbDefine="SQL_TBUSER_ROLES";

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
	    $cmd = "select user_id from ".SQL_TBUSER_ROLES." where ".
		"role = '$role'";
	    $result = mysql_query($cmd);
	    $retval = array();
	    if ($result) {
		while ($row=mysql_fetch_assoc($result))
		    array_push($retval, $row["user_id"]);
	    } else {
		$this->tbError(NULL);
	    }
	    return $retval;
	}

	public function hasRole($user_id, $role)
	{
		$result = $this->readSelect(Array(
			"user_id" => $user_id,
			"role" => $role));
		if (!$result) return false;
		return (0 < mysql_num_rows($result));
	}
		
	public function getRoles($user_id)
	{
		$result = $this->readSelect(Array(
			"user_id" => $user_id));
		if (!$result) return false;
		$retVal = Array("user_id" => $user_id);
		while ($row = mysql_fetch_assoc($result)) {
		    $retVal[$row["role"]]=$row["role"];
		}
		return $retVal;
	}

	public function deleteAll($id)
	{
	    $result = $this->readSelect(
		array( "user_id" => $id));
	    if (!$result) return;
	    $roles = array();
	    while ($role = mysql_fetch_assoc($result)) {
		array_push($roles, $role);
	    }
	    while ($role = array_shift($roles)) {
		if (!$this->delete($role)) {
		    return false;
		}
	    }
	    return true;
	}

	public function insert($new)
	{
		global $USER_ROLES;
		if (!array_key_exists($new["role"], $USER_ROLES)) {
			genSetError("De rol '".$new["role"]."' is niet gedefinieerd");
			return false;
		}
		if ($this->hasRole($new["user_id"], $new["role"])) {
			return true;
		}
		return parent::insert($new);
	}

	public function update($old, $new)
	{
		global $USER_ROLES;
		if (!array_key_exists($new["role"], $USER_ROLES)) {
			genSetError("De rol '".$new["role"]."' is niet gedefinieerd");
			return false;
		}
		if ($this->hasRole($old["user_id"], $old["role"])) {
			if (!parent::delete($old)) {
				return false;
			}
		}
		if (!$this->hasRole($new["user_id"], $new["role"])) {
			return parent::insert($new);
		}
		return true;
	}
}
?>
