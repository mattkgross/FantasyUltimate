<?php
session_start();

require_once("headers/mysql.php");

$value = stripslashes($_POST['value']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin</title>
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script src="SpryAssets/SpryAccordion.js" type="text/javascript"></script>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryAccordion.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
if($value == "out")
{
	unset($_SESSION['admin']);
	session_destroy();
	header('Location: admin.php');
	exit();
}

if($_SESSION['admin'] == "footlong")
{
?>
<form action="admin.php" method="post">
<input type="hidden" name="value" id="value" value="out" />
<input type="submit" value="Logout" />
</form><br /><br />
<div id="TabbedPanels1" class="TabbedPanels">
  <ul class="TabbedPanelsTabGroup">
    <li class="TabbedPanelsTab" tabindex="0">Add Game</li>
    <li class="TabbedPanelsTab" tabindex="0">Add Player</li>
    <li class="TabbedPanelsTab" tabindex="0">Add Team</li>
    <li class="TabbedPanelsTab" tabindex="0">Edit Game</li>
    <li class="TabbedPanelsTab" tabindex="0">Edit Player</li>
    <li class="TabbedPanelsTab" tabindex="0">Edit Team</li>
    <li class="TabbedPanelsTab" tabindex="0">Delete Game</li>
    <li class="TabbedPanelsTab" tabindex="0">Team Info</li>
  </ul>
  <div class="TabbedPanelsContentGroup">
    <div class="TabbedPanelsContent">
    <br />
    <form action="handle.php" method="post">
    <input type="hidden" name="handle" id="handle" value="newgame" />
    Name:<br />
    <input type="text" name="name" id="name" /> (<span style="font-style:italic;">leave blank for default of Team 1 v. Team 2</span>)<br /><br />
    Team 1:<br />
    <select name="team1" id="team1">
    <?php
		$sql = mysql_query("SELECT * FROM teams");
		while($temp = mysql_fetch_array($sql))
		{
    		echo "<option value=\"" . $temp['ID'] . "\">" . $temp['name'] . "</option>";
		}
	?>
    </select><br /><br />
    Team 2:<br />
    <select name="team2" id="team2">
    <?php
		$sql = mysql_query("SELECT * FROM teams");
		while($temp = mysql_fetch_array($sql))
		{
    		echo "<option value=\"" . $temp['ID'] . "\">" . $temp['name'] . "</option>";
		}
	?>
    </select><br /><br />
    <input type="checkbox" name="open" id="open" value="true" checked="checked" /> Open<br /><br />
    <input type="submit" value="Add Game" />
    </form>
    </div>
    <div class="TabbedPanelsContent">
    <br />
    <form action="handle.php" method="post">
    <input type="hidden" name="handle" id="handle" value="newplayer" />
    First Name:<br />
    <input type="text" name="fname" id="fname" /><br /><br />
    Last Name:<br />
    <input type="text" name="lname" id="lname" /><br /><br />
    Number:<br />
    <input type="text" name="number" id="number" maxlength="2" /><br /><br />
    Team:<br />
    <select name="team[]" id="team[]" multiple="multiple">
    <?php
		$sql = mysql_query("SELECT * FROM teams");

		while($temp = mysql_fetch_array($sql))
		{
			echo "<option value=\"" . $temp['name'] . "\">" . $temp['name'] . "</option>";
		}
	?>
    </select><br /><br />
    <input type="submit" value="Add Player" />
    </form>
    </div>
    <div class="TabbedPanelsContent">
    <br />
    <form action="handle.php" method="post">
    <input type="hidden" name="handle" id="handle" value="newteam" />
    Team Name:<br />
    <input type="text" name="tname" id="tname" /><br /><br />
    <input type="submit" value="Add Team" />
    </form>
    </div>
    <div class="TabbedPanelsContent">
    <br />
    <form action="handle.php" method="post">
    <input type="hidden" name="handle" id="handle" value="editgame" />
    Team 1:<br />
    <select name="team1" id="team1">
    <?php
		$sql = mysql_query("SELECT * FROM teams");

		while($temp = mysql_fetch_array($sql))
		{
			echo "<option value=\"" . $temp['ID'] . "\">" . $temp['name'] . "</option>";
		}
	?>
    </select><br /><br />
    Team 2:<br />
    <select name="team2" id="team2">
    <?php
		$sql = mysql_query("SELECT * FROM teams");

		while($temp = mysql_fetch_array($sql))
		{
			echo "<option value=\"" . $temp['ID'] . "\">" . $temp['name'] . "</option>";
		}
	?>
    </select><br /><br />
    <input type="submit" value="Find" />
    </form>
    </div>
    <div class="TabbedPanelsContent">
    <br />
    <form action="handle.php" method="post">
    <input type="hidden" name="handle" id="handle" value="editplayer" />
    First Name:<br />
    <input type="text" name="fname" id="fname" /><br /><br />
    Last Name:<br />
    <input type="text" name="lname" id="lname" /><br /><br />
    <input type="submit" value="Find" />
    </form>
    </div>
    <div class="TabbedPanelsContent">
    <br />
    <form action="handle.php" method="post">
    <input type="hidden" name="handle" id="handle" value="editteam" />
    Team Name:<br />
    <input type="text" name="name" id="name" /><br /><br />
    <input type="submit" value="Find" />
    </form>
    </div>
    <div class="TabbedPanelsContent">
    <br />
    <form action="handle.php" method="post">
    <input type="hidden" name="handle" id="handle" value="delgame" />
    <?php
	$sql = mysql_query("SELECT * FROM games");
	while($game = mysql_fetch_array($sql))
	{
		echo "<input type=\"checkbox\" name=\"game[]\" id=\"game[]\" value=\"" . $game['ID'] . "\"> " . $game['name'] . "<br />";	
	}
	?>
    <br /><input type="submit" value="Delete" />
    </form>
    </div>
    <div class="TabbedPanelsContent">
    <br />
    <div id="Accordion1" class="Accordion" tabindex="0">
    <?php
	$sql = mysql_query("SELECT * FROM teams");
	
	while($ti = mysql_fetch_array($sql))
	{
	?>
      <div class="AccordionPanel">
        <div class="AccordionPanelTab"><?php echo $ti['name']; ?></div>
        <div class="AccordionPanelContent">
        <?php
		$parray = explode(",", $ti['players']);
		if(!empty($parray))
		{
			for($i = 0; $i < count($parray); $i++)
			{
				$sql2 = mysql_query("SELECT * FROM players WHERE ID='" . $parray[$i] . "'");
				$player = mysql_fetch_array($sql2);
				if(intval($player['number']) >= 0)
					echo "#" . $player['number'] . " " . $player['fname'] . " " . $player['lname'] . "<br />";
				else
					echo $player['fname'] . " " . $player['lname'] . "<br />";
			}
		}
		?>
        </div>
      </div>
    <?php
	}
	?>
    </div>
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
		
		$sql = mysql_query("SELECT * FROM admin WHERE uname='" . $user . "' and password='" . $pword . "'");
		$result = mysql_num_rows($sql);
		
		if($result == 1)
		{
			$_SESSION['admin'] = "footlong";
			header('Location: admin.php');
			exit();
		}
		
		else
		{
			// wrong username or password or account is not yet activated
			header('Location: admin.php');
			exit();
		}
	}
	else
	{
	?>
    <center>
    <form action="admin.php" method="post" name="login">
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
var Accordion1 = new Spry.Widget.Accordion("Accordion1");
//-->
    </script>
</body>
</html>
<?php require_once("headers/close.php"); ?>