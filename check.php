<?php
session_start();

require_once("headers/mysql.php");

$action = stripslashes($_POST['action']);

if($_SESSION['logout'] == "doit")
{
	if(isset($_SESSION['ID']))
		unset($_SESSION['ID']);
	unset($_SESSION['logout']);
	session_destroy();
	header('Location: login.php?error=logout');
	exit();
}

else if($action == "Sign Up")
{
	header('Location: signup.php');
}

else
{
	$uname = stripslashes($_POST['user']);
	$pword = stripslashes($_POST['pword']);
	
	if(empty($uname) || empty($pword))
	{
		header('Location: login.php?error=empty');
		exit();
	}
	
	else
	{
	/*
		// prevent injection
		if(!get_magic_quotes_gpc())
		{
			$uname = mysql_real_escape_string($uname);		
			$pword = mysql_real_escape_string($pword);
		}*/
		
		$pword = md5($pword);
		
		$sql = mysql_query("SELECT * FROM users WHERE uname='" . $uname . "' and password='" . $pword . "' and valid='1'");
		$result = mysql_num_rows($sql);
		
		if($result == 1)
		{
			$row = mysql_fetch_array($sql);
			$ID = $row['ID'];
			$_SESSION['ID'] = $ID;
			header('Location: login.php');
			exit();
		}
		
		else
		{
			// wrong username or password or account is not yet activated
			header('Location: login.php?error=wrong');
			exit();
		}
	}
}

require_once("headers/close.php");
?>