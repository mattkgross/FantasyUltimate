<?php
session_start();

require_once("headers/mysql.php");

if(!isset($_SESSION['ID']))
{
	session_destroy();
	header('Location: login.php');
}
$cid = stripslashes($_GET['cid']);
$ID = $_SESSION['ID'];

$sql = mysql_query("SELECT * FROM user_data WHERE ID='" . $ID . "'");
$temp = mysql_fetch_array($sql);
$pcid = $temp['cID'];

if(intval($cid) != intval($pcid))
{
	header('Location: account.php');
	exit();	
}

$sql = mysql_query("SELECT * FROM challenges WHERE ID='" . $cid . "'");
$temp = mysql_fetch_array();
if(intval($temp['active']) == 1)
{
	header('Location: index.php');
	exit();	
}

mysql_query("DELETE FROM draft WHERE pid='" . $ID . "'");
$sql = mysql_query("SELECT * FROM challenges WHERE ID='" . $cid . "'");
$temp = mysql_fetch_array($sql);
$ps = explode(",", $temp['participants']);
$plays = array();
foreach($ps as $p)
{
	if($p != $ID)
		$plays[] = $p;
}

$peeps = "";
foreach($plays as $p)
{
	$peeps .= $p . ",";	
}
$peeps = substr($peeps, 0, -1);
mysql_query("UPDATE challenges SET participants='" . $peeps . "' WHERE ID='" . $cid . "'");

$sql = mysql_query("SELECT * FROM challenges WHERE ID='" . $cid . "'");
$temp = mysql_fetch_array($sql);
$ps = explode(",", $temp['noplayers']);
$plays = array();
foreach($ps as $p)
{
	if($p != $ID)
		$plays[] = $p;
}

$peeps = "";
foreach($plays as $p)
{
	$peeps .= $p . ",";	
}
$peeps = substr($peeps, 0, -1);
mysql_query("UPDATE challenges SET noplayers='" . $peeps . "' WHERE ID='" . $cid . "'");

mysql_query("UPDATE user_data SET cID='0' WHERE ID='" . $ID . "'");

require_once("headers/close.php");
	
header('Location: account.php?error=cancel');
exit();
?>