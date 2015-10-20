<?php
/* **********************************************************************
   **	Lay-out library of Content Management System				   **
   **********************************************************************
   ** Created 26-7-04 Erwin Marges									   **
   ********************************************************************** */

class LayOut{
	var $main;
	function build(){
		/* builds lay_out */
		$blaat = new LayOut();
		$page = $blaat->head();
		$page .= $blaat->generate_top();
		$page .= "<div id='maindiv' style='width: 100%;'>";
		$page .= $blaat->menu();
		$page .= $blaat->login_status();
		$page .= $this->main;
		$page .= "</div>\n";
		return $page;
	}
	
	function main($head, $text, $nl2br){
	if($nl2br)
		$text = nl2br($text);
	$this->main = "<div id='middle' class='middle'>\n";
	$this->main .= "\t<!-- main -->\n";
	$this->main .= "\t<span class='kop'>$head</span><br />\n";
	$this->main .= $text;
	$this->main .= "<!-- end of main -->\n";
	$this->main .= "</div>\n";
	return $main;
	}
	
	function head(){
		/* generates header */
		$top = "<?phpxml version=\"1.0\" encoding=\"iso-8859-1\"?".">\n";
		$top .= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
		$top .= "<html xmlns=\"http://www.w3.org/1999/xhtml\">\n";
		$top .= "<head>\n";
		$top .= "<title>Content Management System wvleidchendam.nl</title>\n";
		$top .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />\n";
		$top .= "<link href='css/styles.css' rel='stylesheet' type='text/css' />\n";
		$top .= "<script language=\"javascript\" type=\"text/javascript\">\n
function addtext(newtext) {\n
	var x = \"<img src='images/blaat/\"+newtext+\".jpg' />\";
document.changeText.eventText.value += x;
}
function openChild(window) {
	var file = document.changeText.event_id.value;
	var file2 = \"viewimages.php?event_id=\"+file;
    childWindow=open(file2,window,'resizable=no,width=200,height=400,scrollbars=yes');
    if (childWindow.opener == null) childWindow.opener = self;
    }
\n
</script>\n";
		$top .= "</head>\n";
		$top .= "<body>\n";
		return $top;
		
	}	
	function menu(){
		/* generates menu */
		$menu = "<!-- start of menu -->\n";
		$menu .= "<div id='menu' class='menu'>\n";
		$menu .= "<span class='kop'>Menu</span><br /><br />\n\n";
		/* counter for no menu */
		$count = 0;
		if($_SESSION[allow_news] == 1 && $_SESSION[cms_newsAdmin] == 1){
			$menu .= "<a class='link1' href='addnews.php'>Nieuws toevoegen</a><br />\n";
			$menu .= "<a class='link1' href='changenews.php'>Nieuws wijzigen</a><br />\n";
			$menu .= "<br />\n";
			$count ++;
		}

		if($_SESSION[allow_event] == 1 && $_SESSION[cms_eventAdmin] == 1){
			$menu .= "<a class='link1' href='addevent.php'>Evenement toevoegen</a><br />\n";
			$menu .= "<a class='link1' href='changeevent.php'>Evenement wijzigen</a><br />\n";
			$menu .= "<a class='link1' href='addeventtext.php'>Verslag toevoegen</a><br />\n";
			/*if($_SESSION[allow_calendar] == 1)
				$menu .= "<a class='link1' href=''>Calender wijzigen</a><br />\n";*/
			$menu .= "<br />\n";
			$count ++;
		}
		
		if($_SESSION[allow_photo] == 1 && $_SESSION[cms_photoAdmin] == 1){
			$menu .= "<a class='link1' href='addphoto.php'>Foto's toevoegen</a><br />\n";

			/*if($_SESSION[allow_calendar] == 1)
				$menu .= "<a class='link1' href=''>Calender wijzigen</a><br />\n";*/
			$menu .= "<br />\n";
			$count ++;
		}
		
		if($_SESSION[allow_text] == 1 && $_SESSION[cms_textAdmin] == 1){
			$menu .= "<a class='link1' href='addtext.php'>Teksten toevoegen</a><br />\n";
			$menu .= "<a class='link1' href='edittext.php'>Teksten wijzigen</a><br />\n";
			$menu .= "<br />\n";
			$count ++;
		}
		
		if($_SESSION[allow_email] == 1 && $_SESSION[cms_emailAdmin] == 1){
			$menu .= "<a class='link1' href=''>E-Mail versturen</a><br />\n";
			$menu .= "<br />\n";
			$count ++;
		}
		
		if($_SESSION[allow_users] == 1 && $_SESSION[cms_userAdmin] == 1){
			$menu .= "<a class='link1' href=''>Gebruikersbeheer</a><br />\n";
			$menu .= "<br />\n";
			$count ++;
		}
		
		if($_SESSION[user_loggedIn] == 1)
			$menu .= "<a class='link1' href='logout.php'>Uitloggen</a><br />\n";
		
		if($count == 0)
			$menu .= "Log eerst even in.\n";
		$menu .= "</div\n";
		$menu .= "<!-- end of menu -->\n";
		return $menu;
	}
	
	function login_status(){
		/* Prints the current login status */
		$login_status = "<!-- start of login status -->\n";
		$login_status .= "<div id='subtop' class='subtop'>\n";
		if($_SESSION[user_loggedIn] == 1)
			$login_status .= "U bent nu ingelogd als $_SESSION[user_name] \n";
		else
			$login_status .= "U bent nu niet ingelogd.\n";
		$login_status .= "</div>\n";
		$login_status .= "<!-- end of login status -->\n";
		return $login_status;
	}
	
	function generate_top(){
		/* generates top table */
		$top = "<div id='top' class='top' >\n";
		$top .= "<table  width='100%'>\n";
		$top .= "\t<tr>\n";
		$top .= "\t\t<td align='left' style='color: #FDFFCC;' class='kop'>\n";
		$top .= "\t\t\tWelkom bij Content Management van:<br />\n\t\t\t $_SESSION[cms_name] <br />\n";
		$top .= "\t\t</td>\n";
		$top .= "\t\t<td align='right' valign='bottom' style='color: #FF0018; font-size: 10;'>\n";
		if($_SESSION[user_loggedIn] != true){
			$top .= "\t\t\t<!-- start of login form -->\n";
			$top .= "\t\t\t<form action='index.php' enctype='multipart/form-data' method='post' name='login'>\n";
			$top .= "\t\t\t\t<input type='hidden' name='checklogin' value='true' />\n";
			$top .= "\t\t\t\tUsername: <input type='text' size='10' name='user_name' class='form'/>\n";
			$top .= "\t\t\t\tPassword: <input type='password' size='10' name='user_password' class='form'/>\n";
			$top .= "\t\t\t\t<input type='submit' value='login' class='form'/>\n";
			$top .= "\t\t\t</form>\n";
			$top .= "\t\t\t<!-- end of login form -->\n";
		}
		$top .= "\t\t</td>\n";
		$top .= "\t</tr>\n";
		$top .= "</table>\n";
		$top .= "</div>\n";
		return $top;
	}
}
?>
