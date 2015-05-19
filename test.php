<?php
$con = mysql_connect("mattkgross.no-ip.org", "thedonald", "footlong");
if(!$con)
	die("Database connection failure! Please alert webmaster.");
mysql_select_db("thedonald_ulti");
$sql = mysql_query("SELECT * FROM users");
while($temp = mysql_fetch_array($sql))
{
    echo $temp['uname'] . "\r";
}
?>
