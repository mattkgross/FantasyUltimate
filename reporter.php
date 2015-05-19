<?php
session_start();

require_once("headers/mysql.php");

$value = stripslashes($_POST['value']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Score Reporter</title>
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script src="SpryAssets/SpryAccordion.js" type="text/javascript"></script>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryAccordion.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
if($value == "out")
{
	unset($_SESSION['report']);
	session_destroy();
	header('Location: reporter.php');
	exit();
}

if($_SESSION['report'] == "footlong")
{
?>
<form action="reporter.php" method="post">
<input type="hidden" name="value" id="value" value="out" />
<input type="submit" value="Logout" />
</form><br /><br />
<div id="TabbedPanels1" class="TabbedPanels">
  <ul class="TabbedPanelsTabGroup">
    <li class="TabbedPanelsTab" tabindex="0">Start Game</li>
    <li class="TabbedPanelsTab" tabindex="0">Manage Game</li>
  </ul>
  <div class="TabbedPanelsContentGroup">
    <div class="TabbedPanelsContent">
    <br />
    <form action="handle2.php" method="post">
    <input type="hidden" name="handle" id="handle" value="start" />
    <select name="game" id="game">
	<?php
	$sql = mysql_query("SELECT * FROM games WHERE active='0'");
	while($temp = mysql_fetch_array($sql))
	{
		echo "<option value=\"" . $temp['ID'] . "\">" . $temp['name'] . "</option>";
	}
	?>
    </select><br /><br />
    <input type="submit" value="Start Game" />
    </form>
    </div>
    <div class="TabbedPanelsContent">
    <br />
    <form action="handle2.php" method="post">
    <input type="hidden" name="handle" id="handle" value="edit" />
    <select name="game" id="game">
    <?php
	$sql = mysql_query("SELECT * FROM games WHERE active='1'");
	while($temp = mysql_fetch_array($sql))
	{
		echo "<option value=\"" . $temp['ID'] . "\">" . $temp['name'] . "</option>";
	}
	?>
    </select><br /><br />
    <input type="submit" value="Manage Game" />
    </form>
    </div>
  </div>
</div>
<?php
}
else
{
	if($value == "login")
	{
		$user = stripslashes($_POST['user']);
		$pword = stripslashes($_POST['pword']);
		
		$sql = mysql_query("SELECT * FROM report WHERE uname='" . $user . "' and password='" . $pword . "'");
		$result = mysql_num_rows($sql);
		
		if($result == 1)
		{
			$_SESSION['report'] = "footlong";
			header('Location: reporter.php');
			exit();
		}
		
		else
		{
			// wrong username or password or account is not yet activated
			header('Location: reporter.php');
			exit();
		}
	}
	else
	{
	?>
    <center>
    <form action="reporter.php" method="post" name="login">
    <input type="hidden" name="value" id="value" value="login" />
    Username:<br /><input type="text" name="user" id="user" /><br /><br />
    Password:<br /><input type="password" name="pword" id="pword" /><br /><br />
    <input type="submit" value="Login" />
    </form>
    </center>
    <?php
	}
}
?>
    <script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
//-->
    </script>
</body>
</html>
<?php require_once("headers/close.php"); ?>