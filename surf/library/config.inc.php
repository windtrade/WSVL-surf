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
$_SESSION[cms_eventAdmin] = false;
$_SESSION[cms_textAdmin] = false;
$_SESSION[cms_emailAdmin] = false;

/* db configuration */

$mysql_user = "wvleid01_surf";
$mysql_password = "uAzMZ4kd";
$mysql_host = "localhost";
$mysql_dbName = "wvleid01_surfclub";

/* module settings */

/* news module */
$news_imgDir = "../surf/images/news";
$news_imgSizeSmall = "200";
$news_imgSizeMax = "615";

/*	Configuratie voor de Trainingspagina's */
$trainers = array('arjanus24@hotmail.com','e.marges@gmail.com','robbert-jan@technotalents.nl','iele@hotmail.com','erik127@hotmail.com','dhrbart@hotmail.com','marky_power@hotmail.com');
$trainingsdata = array('2010-03-30','2010-04-06','2010-04-13','2010-04-20','2010-04-27','2010-05-04','2010-05-11','2010-05-18','2010-05-25','2010-06-01','2010-06-08','2010-06-15','2010-06-22','2010-06-29','2010-07-06','2010-07-13','2010-07-20','2010-07-27','2010-08-03','2010-08-10','2010-08-17','2010-08-24','2010-08-31','2010-09-07','2010-09-14','2010-09-21','2010-09-28');


?>
