<?php
session_start();

require_once("headers/mysql.php");
	
if(isset($_SESSION['friendID']) && isset($_SESSION['ID']))
{
	$ID = $_SESSION['ID'];
	$friendID = $_SESSION['friendID'];
	unset($_SESSION['friendID']);

	$sql = mysql_query("SELECT * FROM friends WHERE ID='" . $ID . "'");
	$temp = mysql_fetch_array($sql);
	$friends = $temp['friends'];
	
	if(empty($friends))
		$friends = $friendID;
	else
		$friends .= "," . $friendID;
		
	mysql_query("UPDATE friends SET friends='" . $friends . "' WHERE ID='" . $ID . "'");
}

require_once("headers/close.php");

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>