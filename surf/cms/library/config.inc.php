<?php
/* **********************************************************************
   **	Configuration file of Content Management System				   **
   **********************************************************************
   ** Created 26-7-04 Erwin Marges									   **
   ********************************************************************** */

/* main configuration */
$_SESSION[cms_name] = "WVleidschendam.nl";
$_SESSION[real_addr] = "http://www.wvleidschendam.nl/";

/* enable modules */
$_SESSION[cms_userAdmin] = false;
$_SESSION[cms_newsAdmin] = true;
$_SESSION[cms_eventAdmin] = true;
$_SESSION[cms_textAdmin] = true;
$_SESSION[cms_emailAdmin] = false;
$_SESSION[cms_photoAdmin] = true;

/* db configuration */
$mysql_user = "wvleid01_surf";
$mysql_password = "uAzMZ4kd";
$mysql_host = "localhost";
$mysql_dbName = "wvleid01_surfclub";
/* module settings */

/* news module */
$news_imgDir = "../images/news";
$news_imgSizeSmall = "300";
$news_imgSizeMax = "615";

/* event module */
$event_imgDir = "../images/event";
$event_imgSizeSmall = "300";
$event_imgSizeMax = "615";
$event_photoDir = "../images/event/photo/";
$event_photoSizeSmall = "133";
$event_photoSizeMax = "710";

?>
