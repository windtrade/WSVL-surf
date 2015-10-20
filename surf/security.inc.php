<?php
	if ( (!isset($PHP_AUTH_USER)) || (!isset($PHP_AUTH_PW)) )
	{
		header("WWW-Authenticate: Basic realm=\"".$config['cms']['klant_lang']." CMS\"");
		header("HTTP/1.0 401 Unauthorized");
		error("Unauthorized access...");
	}
	
	if($_SERVER['PHP_AUTH_USER'] && $_SERVER['PHP_AUTH_PW'])
	{
			$password = MD5($PHP_AUTH_PW);	
		
			$user_sql = "SELECT * FROM $dbtable[users] u, users_settings us, groeps_profielen gp, groeps_profielen_users_xref gpux WHERE u.username = '$PHP_AUTH_USER' AND u.user_password = '$password' AND gp.groeps_profiel_id = gpux.groeps_profiel_id AND gpux.user_id = u.user_id AND u.user_id = us.user_id AND gp.ranking != '0' ORDER BY gp.ranking DESC LIMIT 1";
			$result_users = mysql_query($user_sql,$dab[connect]);
			$aantal_users = mysql_num_rows($result_users);
	
			if($aantal_users == 0)
			{
//				echo "user niet gevonden";
				Header("Location: http://www.blogtalk.nl/");
			} 
			else
			{ 
				$user_data = NETFX_MYSQL_get_row_info($result_users, 0);
				
			}
		
	} 
	else 
	{
//		echo "user niet ingelogd";
		Header("Location: http://www.blogtalk.nl/");
	}
		
?>