<?php
/* **********************************************************************
   **	dataBase library of Content Management System				   **
   **********************************************************************
   ** Created 27-7-04 Erwin Marges									   **
   ********************************************************************** */

class login{

	var $user_array;
	var $post_userName;
	var $post_userPassword;
	var $loginMessage;
	var $allow_news;
	var $allow_users;
	var $allow_calendar;
	var $allow_event;
	var $allow_foto;
	var $allow_text;
	
	function login2($post_userName, $post_userPassword)
	{
		$this->post_userName = $post_userName;
		$this->post_userPassword = $post_userPassword;
		if($this->valid() == true){
			/* login ok get en set session vars */
			$_SESSION[user_name] = $this->user_array["user_name"];
			$_SESSION[user_id] = $this->user_array["user_id"];
			$_SESSION[user_loggedIn] = true;
			$_SESSION[user_active]=time();
			$this->getPrivileges();
//			Keep getPrivileges in sync with clearPrivileges
			$_SESSION[allow_news] = $this->allow_news;
			$_SESSION[allow_users] = $this->allow_users;
//			$_SESSION[allow_calendar] = $this->allow_calendar;
			$_SESSION[allow_event] = $this->allow_event;
			$_SESSION[allow_photo] = $this->allow_foto;
			$_SESSION[allow_text] = $this->allow_text;
			return true;
		}
		else
			return false;
	}
	
	function valid()
	{
		$query = mysql_query("SELECT * FROM cms_users WHERE user_name = '$this->post_userName' AND user_password = MD5('$this->post_userPassword') LIMIT 1");
		if (!$query) {
			if(function_exists('traceThis')) traceThis(mysql_error());
			return false;
		}
		if ($this->user_array = mysql_fetch_array($query, MYSQL_ASSOC))
		{
			/* login = ok */
			return true;
		}	
		else
		{
			/* login = not ok */
			$this->loginMessage="Foute naam/wachtwoord";
			return false;
		}	
	}
	
	function getPrivileges()
	{
		/* get privileges for user */
		$user_id = $this->user_array["user_id"];
		$query = mysql_query("SELECT * FROM cms_userPrivileges WHERE user_id = '$user_id'");
		if (!$query) {
			if(function_exists('traceThis')) traceThis(mysql_error());
			return false;
		}
		while ($user_privileges = mysql_fetch_array($query, MYSQL_ASSOC))
		{
			if($user_privileges["privilege_id"] == 1)
				$this->allow_news = true;
			if($user_privileges["privilege_id"] == 2)
				$this->allow_users = true;
			if($user_privileges["privilege_id"] == 3)
				$this->allow_calendar = true;
			if($user_privileges["privilege_id"] == 4)
				$this->allow_event = true;
			if($user_privileges["privilege_id"] == 5)
				$this->allow_foto = true;
			if($user_privileges["privilege_id"] == 6)
				$this->allow_text = true;
		}
	}
	// or die(mysql_errno($link) . ": " . mysql_error($link). "<br />\n");

	function clearPrivileges() {
//			Keep getPrivileges in sync with clearPrivileges
			$_SESSION[allow_news] = false;
			$_SESSION[allow_users] = false;
//			$_SESSION[allow_calendar] = false;
			$_SESSION[allow_event] = false;
			$_SESSION[allow_photo] = false;
			$_SESSION[allow_text] = false;
	}

	function stillActive() {
		// traceThis("time=".time()." user_active=".$_SESSION['user_active'].":::");
		if ((time() - $_SESSION['user_active']) < 1800) {
			// traceThis("Still active!!!");
			$_SESSION['user_active'] = time();
			return true;
		}
		traceThis("not active!!!");
		$_SESSION[user_logged_in] = false;
		$this->loginMessage = "Te lang inactief geweest, log opnieuw in";
		return false;
	}
}
?>
