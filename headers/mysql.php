<?php
// Removed username and password for security. Add when you set up your own SQL DB.
//$con = mysql_connect("mattkgrosscom.ipagemysql.com", "username", "password");
// make sure to set the default_host in php.ini to mattkgrosscom.ipagemysql.com
$con = mysql_connect(ini_get("mysql.default_host"), "username", "password");
if(!$con)
	die("Database connection failure! Please alert webmaster.");
mysql_select_db("ulti");
?>