<?php
session_start();

require_once("headers/mysql.php");

$handle = stripslashes($_POST['handle']);

if($handle == "newgame" || $handle == "newplayer" || $handle == "newteam")
{
	if($handle == "newgame")
	{
		$team1 = stripslashes($_POST['team1']);
		$team2 = stripslashes($_POST['team2']);
		$name = stripslashes($_POST['name']);
		$open = stripslashes($_POST['open']);
		
		if(empty($name))
		{
			$sql = mysql_query("SELECT * FROM teams WHERE ID='" . $team1 . "'");
			$temp = mysql_fetch_array($sql);
			$t1 = $temp['name'];
			$sql = mysql_query("SELECT * FROM teams WHERE ID='" . $team2 . "'");
			$temp = mysql_fetch_array($sql);
			$t2 = $temp['name'];
			$name = $t1 . " v. " . $t2;
		}
		
		if($team1 == $team2)
		{
			header('Location: admin.php');
			exit();
		}
			
		// Already exists?
		$sql = mysql_query("SELECT * FROM games WHERE ID1='" . $team1 . "' AND ID2='" . $team2 . "'");
		$count = mysql_num_rows($sql);
		if($count != 0)
		{
			header('Location: admin.php');
			exit();
		}
		$sql = mysql_query("SELECT * FROM games WHERE ID1='" . $team2 . "' AND ID2='" . $team1 . "'");
		$count = mysql_num_rows($sql);
		if($count != 0)
		{
			header('Location: admin.php');
			exit();
		}
			
		if($open == "true")
			$open = 0;
		else
			$open = 1;	
			
		mysql_query("INSERT INTO games (name, ID1, ID2, active) VALUES ('". $name . "', '" . $team1 . "', '" . $team2 . "', '" . $open . "')");
	}
	
	else if($handle == "newplayer")
	{
		$fname = stripslashes($_POST['fname']);
		$lname = stripslashes($_POST['lname']);
		$number = stripslashes($_POST['number']);
		if(empty($number) && $number != 0)
			$number = -1;
		foreach($_POST['team[]'] as $t)
		{
			array_push($team, $t);
		}
		
		$sql = mysql_query("SELECT * FROM players WHERE fname='" . $fname . "' AND lname='" . $lname . "'");
		$count = mysql_num_rows($sql);
		
		if($count == 0)
		{
			mysql_query("INSERT INTO players (fname, lname, number) VALUES ('" . $fname . "', '" . $lname . "', '" . $number . "')");
			$iID = mysql_insert_id();
			for($i = 0; $i < count($team); $i++)
			{
				$sql = mysql_query("SELECT * FROM teams WHERE name='" . $team[$i] . "'");
				$temp = mysql_fetch_array($sql);
				$players = $temp['players'];
				if(empty($players))
					$players = $iID;
				else
					$players .= "," . $iID;
				mysql_query("UPDATE teams SET players='" . $players . "' WHERE name='" . $team[$i] . "'");
			}
		}
	}
	
	else if($handle == "newteam")
	{
		$tname = stripslashes($_POST['tname']);
		$sql = mysql_query("SELECT * FROM teams WHERE name='" . $tname . "'");
		$count = mysql_num_rows($sql);
		
		if($count == 0)
		{
			mysql_query("INSERT INTO teams (name) VALUES ('" . $tname . "')");
		}
	}
	
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}

else if($handle == "editgame" || $handle == "editplayer" || $handle == "editteam" || $handle == "delgame")
{
	if($handle == "editgame")
	{
		$team1 = stripslashes($_POST['team1']);
		$team2 = stripslashes($_POST['team2']);
		
		if($team1 == $team2)
		{
			header('Location: admin.php');
			exit();	
		}
		
		$sql = mysql_query("SELECT * FROM games WHERE ID1='" . $team1 . "' AND ID2='" . $team2 . "'");
		$count = mysql_num_rows($sql);
		$sql2 = mysql_query("SELECT * FROM games WHERE ID1='" . $team2 . "' AND ID2='" . $team1 . "'");
		$count2 = mysql_num_rows($sql2);
		
		if($count != 0)
		{
			$sql = mysql_query("SELECT * FROM games WHERE ID1='" . $team1 . "' AND ID2='" . $team2 . "'");
		}
		
		else if($count2 != 0)
		{
			$sql = mysql_query("SELECT * FROM games WHERE ID1='" . $team2 . "' AND ID2='" . $team1 . "'");
		}
		
		else
		{
			header('Location: admin.php');
			exit();
		}
		
		$game = mysql_fetch_array($sql);
	?>
    <html>
    <title>Admin</title>
    <body>
    <form action="handle.php" method="post">
    <input type="hidden" name="handle" id="handle" value="egame" />
    <input type="hidden" name="gID" id="gID" value="<?php echo $game['ID']; ?>" />
    Name:<br />
    <input type="text" name="name" id="name" value="<?php echo $game['name']; ?>" /><br /><br />
    Team 1:<br />
    <select name="team1" id="team1">
    <?php
		$sql = mysql_query("SELECT * FROM teams");

		while($temp = mysql_fetch_array($sql))
		{
			if($temp['ID'] == $team1)
			{
				echo "<option value=\"" . $temp['ID'] . "\" selected>" . $temp['name'] . "</option>";
				$oldie1 = $temp['ID'];
			}
			else
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
			if($temp['ID'] == $team2)
			{
				echo "<option value=\"" . $temp['ID'] . "\" selected>" . $temp['name'] . "</option>";
				$oldie2 = $temp['ID'];
			}
			else
				echo "<option value=\"" . $temp['ID'] . "\">" . $temp['name'] . "</option>";
		}
	?>
    </select><br /><br />
    Start Time: <span style="font-style:italic;"><?php echo date("F j, Y, g:i a T", strtotime($game['start'])); ?></span><br /><br />
    <input type="checkbox" name="open" id="open" value="true" <?php if(intval($game['active']) == 0) {echo "checked";} ?> /> Open<br /><br />
    <input type="hidden" name="old1" id="old1" value="<?php echo $oldie1; ?>" />
    <input type="hidden" name="old2" id="old2" value="<?php echo $oldie2; ?>" />
    <input type="submit" value="Commit" />
    </form>
    </body>
    </html>
    <?php		
	}
	
	else if($handle == "editplayer")
	{
		$fname = stripslashes($_POST['fname']);
		$lname = stripslashes($_POST['lname']);
		
		$sql = mysql_query("SELECT * FROM players WHERE fname='" . $fname . "' AND lname='" . $lname . "'");
		$count = mysql_num_rows($sql);
		
		if($count == 1)
		{
			$sql = mysql_query("SELECT * FROM players WHERE fname='" . $fname . "' AND lname='" . $lname . "'");
			$player = mysql_fetch_array($sql);
		
	?>
    <html>
    <title>Admin</title>
    <body>
    <form action="handle.php" method="post">
    <input type="hidden" name="handle" id="handle" value="eplayer" />
    <input type="hidden" name="pID" id="pID" value="<?php echo $player['ID']; ?>" />
    First Name:<br />
    <input type="text" name="fname" id="fname" value="<?php echo $player['fname']; ?>" /><br /><br />
    Last Name:<br />
    <input type="text" name="lname" id="lname" value="<?php echo $player['lname']; ?>" /><br /><br />
    Number:<br />
    <input type="text" name="number" id="number" maxlength="2" value="<?php echo $player['number']; ?>" /><br /><br />
    Teams:<br />
    <select name="team[]" id="team[]" multiple="multiple">
    	<?php
		$sql = mysql_query("SELECT * FROM teams");
		$output = "";

		while($temp = mysql_fetch_array($sql))
		{
			$farray = explode(",", $temp['players']);
			$check = false;
			for($i = 0; $i < count($farray); $i++)
			{
				if($player['ID'] == $farray[$i])
				{											
					echo "<option value=\"" . $temp['name'] . "\" selected>" . $temp['name'] . "</option>";
					$output .= "<input type=\"hidden\" name=\"old[]\" id=\"old[]\" value=\"" . $temp['name'] . "\">";
					$check = true;
				}
			}
			
			if(!$check)
			{
				echo "<option value=\"" . $temp['name'] . "\">" . $temp['name'] . "</option>";
			}
		}
	?>
    </select>
    <?php echo $output; ?>
    <br />
    <input type="submit" value="Commit" />
    </form>
    </body>
    </html>
    <?php
		}
		
		else
			echo "Player not found.";
	}
	
	else if($handle == "editteam")
	{
		$name = stripslashes($_POST['name']);
		
		$sql = mysql_query("SELECT * FROM teams WHERE name='" . $name . "'");
		$count = mysql_num_rows($sql);

		if($count == 1)
		{
			$sql = mysql_query("SELECT * FROM teams WHERE name='" . $name . "'");
			$team = mysql_fetch_array($sql);
			$players = $team['players'];
			$farray = explode(",", $players);
		?>
		<html>
		<head>
		<title>Admin</title>
		</head>
		<body>
		<form method="post" action="handle.php">
		<input type="hidden" name="handle" id="handle" value="eteam" />
        <input type="hidden" name="tID" id="tID" value="<?php echo $team['ID']; ?>" />
		Team Name:<br />
		<input type="text" name="name" id="name" value="<?php echo $team['name']; ?>" /><br /><br />
		Players:<br />
		<?php
		if(!empty($farray))
		{
			for($i = 0; $i < count($farray); $i++)
			{
				$sql = mysql_query("SELECT * FROM players WHERE ID='" . $farray[$i] . "'");
				$player = mysql_fetch_array($sql);
				echo "<input name=\"players[]\" id=\"players[]\" type=\"checkbox\" value=\"" . $player['ID'] . "\" checked>" . $player['fname'] . " " . $player['lname'] . "<br />";
			}
		}
		?><br /><br />
		<input type="submit" value="Commit" />
		</form>
		</body>
		</html>
		<?php
		}
	}
	
	else if($handle == "delgame")
	{
		foreach($_POST['game'] as $g)
		{	
			// delete all associated challenges
			// delete all drafts associated w/ challenges
			// delete all ppid npid and cid associated w/ challenges
			// set all player temp stats to 0
			$sql = mysql_query("SELECT * FROM challenges WHERE gID='" . $g . "'");
			while($temp = mysql_fetch_array($sql))
			{
				$confirm = explode(",", $temp['participants']);
				foreach($confirm as $c)
				{
					mysql_query("DELETE FROM draft WHERE pid='" . $c . "'");
					mysql_query("UPDATE user_data SET cid='0' WHERE ID='" . $c . "'");
					mysql_query("UPDATE user_data SET ppID='0' WHERE ID='" . $c . "'");
					mysql_query("UPDATE user_data SET npID='0' WHERE ID='" . $c . "'");
				}
				mysql_query("DELETE FROM challenges WHERE ID='" . $temp['ID'] . "'");
			}
			
			$sql = mysql_fetch_array(mysql_query("SELECT * FROM games WHERE ID='" . $g . "'"));
			$t1 = mysql_fetch_array(mysql_query("SELECT * FROM teams WHERE ID='" . $sql['ID1'] . "'"));
			$t2 = mysql_fetch_array(mysql_query("SELECT * FROM teams WHERE ID='" . $sql['ID2'] . "'"));
			$p1 = explode(",", $t1['players']);
			$p2 = explode(",", $t2['players']);
			
			foreach($p1 as $p)
			{
				mysql_query("UPDATE players SET goals='0' WHERE ID='" . $p . "'");
				mysql_query("UPDATE players SET assists='0' WHERE ID='" . $p . "'");
				mysql_query("UPDATE players SET ds='0' WHERE ID='" . $p . "'");
				mysql_query("UPDATE players SET turns='0' WHERE ID='" . $p . "'");
			}
			foreach($p2 as $p)
			{
				mysql_query("UPDATE players SET goals='0' WHERE ID='" . $p . "'");
				mysql_query("UPDATE players SET assists='0' WHERE ID='" . $p . "'");
				mysql_query("UPDATE players SET ds='0' WHERE ID='" . $p . "'");
				mysql_query("UPDATE players SET turns='0' WHERE ID='" . $p . "'");
			}
			
			mysql_query("DELETE FROM games WHERE ID='" . $g . "'");
		}
		
		header('Location: admin.php');
		exit();
	}
}

else if($handle == "egame" || $handle == "eplayer" || $handle == "eteam")
{
	if($handle == "egame")
	{
		$gid = stripslashes($_POST['gID']);
		$name = stripslashes($_POST['name']);
		$team1 = stripslashes($_POST['team1']);
		$team2 = stripslashes($_POST['team2']);
		$old1 = stripslashes($_POST['old1']);
		$old2 = stripslashes($_POST['old2']);
		$open = stripslashes($_POST['open']);
		
		// Let's not overwrite existing ones!
		if(!(($team1 == $old1 && $team2 == $old2) || ($team1 == $old2 && $team2 == $old1)))
		{
			$sql = mysql_query("SELECT * FROM games WHERE ID1='" . $team1 . "' AND ID2='" . $team2 . "'");
			$count = mysql_num_rows($sql);
			if($count != 0)
			{
				header('Location: admin.php');
				exit();	
			}
			$sql = mysql_query("SELECT * FROM games WHERE ID1='" . $team2 . "' AND ID2='" . $team1 . "'");
			$count = mysql_num_rows($sql);
			if($count != 0)
			{
				header('Location: admin.php');
				exit();	
			}
		}
		
		if($open == "true")
			$open = 0;
		else
			$open = 1;	

		mysql_query("UPDATE games SET name='" . $name . "' WHERE ID='" . $gid . "'");
		mysql_query("UPDATE games SET ID1='" . $team1 . "' WHERE ID='" . $gid . "'");
		mysql_query("UPDATE games SET ID2='" . $team2 . "' WHERE ID='" . $gid . "'");
		mysql_query("UPDATE games SET active='" . $open . "' WHERE ID='" . $gid . "'");
	}

	else if($handle == "eplayer")
	{
		$pid = stripslashes($_POST['pID']);
		$fname = stripslashes($_POST['fname']);
		$lname = stripslashes($_POST['lname']);
		$number = stripslashes($_POST['number']);
		if(empty($number) && $number != 0)
			$number = -1;
		
		foreach($_POST['team[]'] as $t)
		{
			array_push($team, $t);
		}
		foreach($_POST['old'] as $o)
		{
			array_push($old, $o);
		}
		
		// Take out of old teams
		for($i = 0; $i < count($old); $i++)
		{
			$sql = mysql_query("SELECT * FROM teams WHERE name='" . $old[$i] . "'");
			$temp = mysql_fetch_array($sql);
			$players = explode(",", $temp['players']);
			$play = "";
			for($j = 0; $j < count($players); $j++)
			{
				if($players[$j] != $pid)
				{
					$play .= $players[$j] . ",";
				}
			}
			if(!empty($play))
				$play = substr($play, 0, -1); // get rid of last ,
			mysql_query("UPDATE teams SET players='" . $play . "' WHERE name='" . $old[$i] . "'");
		}
		
		// Put into new teams
		for($i = 0; $i < count($team); $i++)
		{
			$sql = mysql_query("SELECT * FROM teams WHERE name='" . $team[$i] . "'");
			$temp = mysql_fetch_array($sql);
			$players = $temp['players'];
			if(empty($players))
				$players = $pid;
			else
				$players .= "," . $pid;
			mysql_query("UPDATE teams SET players='" . $players . "' WHERE name='" . $team[$i] . "'");
		}
		
		mysql_query("UPDATE players SET fname='" . $fname . "' WHERE ID='" . $pid . "'");
		mysql_query("UPDATE players SET lname='" . $lname . "' WHERE ID='" . $pid . "'");
		mysql_query("UPDATE players SET number='" . $number . "' WHERE ID='" . $pid . "'");
	}

	else if($handle == "eteam")
	{
		$name = stripslashes($_POST['name']);
		$tID = stripslashes($_POST['tID']);
		
		foreach($_POST['players'] as $p)
		{
			array_push($players, $p);
		}
		
		mysql_query("UPDATE teams SET name='" . $name . "' WHERE ID='" . $tID . "'");
		
		if(count($players) == 0)
		{
			$player = "";
		}
		
		else
		{
			$player = $players[0];
			for($i = 1; $i < count($players); $i++)
			{
				$player .= "," . $players[$i];
			}
		}
		
		mysql_query("UPDATE teams SET players='" . $player . "' WHERE ID='" . $tID . "'");
	}

	header('Location: admin.php');
}

else
{
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}

require_once("headers/close.php");
?>