<?php
require_once("headers/mysql.php");

$gid = stripslashes($_POST['game']);

if(stripslashes($_POST['handle']) == "start")
{
	// set game active to 1
	mysql_query("UPDATE games SET active='1' WHERE ID='" . $gid . "'");
	// set all players' temp stats to 0.
	$t1 = mysql_fetch_array(mysql_query("SELECT * FROM teams WHERE ID='" . $gid['ID1'] . "'"));
	$t2 = mysql_fetch_array(mysql_query("SELECT * FROM teams WHERE ID='" . $gid['ID2'] . "'"));
	$p1 = explode(",", $t1['players']);
	$p2 = explode(",", $t2['players']);
	foreach($p1 as $p)
	{
		mysql_query("UPDATE players SET goals='0' WHERE ID='" . $p . "'");
		mysql_query("UPDATE players SET turns='0' WHERE ID='" . $p . "'");
		mysql_query("UPDATE players SET ds='0' WHERE ID='" . $p . "'");
		mysql_query("UPDATE players SET assists='0' WHERE ID='" . $p . "'");
	}
	foreach($p2 as $p)
	{
		mysql_query("UPDATE players SET goals='0' WHERE ID='" . $p . "'");
		mysql_query("UPDATE players SET turns='0' WHERE ID='" . $p . "'");
		mysql_query("UPDATE players SET ds='0' WHERE ID='" . $p . "'");
		mysql_query("UPDATE players SET assists='0' WHERE ID='" . $p . "'");
	}
	// check to make sure 2+ participants in challenges associated with game and cut if no, else change active to 1
	$sql = mysql_query("SELECT * FROM challenges WHERE gID='" . $gid . "'");
	// set all participants' ppID and npID via algorithm of death (credit to Dylan Miller)
	while($temp = mysql_fetch_array($sql))
	{
		$parts = explode(",", $temp['participants']);
		$nparts = array();
		if(count($parts) < 2)
		{
			foreach($parts as $p)
			{
				mysql_query("UPDATE user_data SET cID='0' WHERE ID='" . $p . "'");
			}
			mysql_query("DELETE FROM challenges WHERE ID='" . $temp['ID'] . "'");
		}
		else
		{
			mysql_query("UPDATE challenges SET active='1' WHERE ID='". $temp['ID'] . "'");
			
			$ppool = array();
			$npool = array();
			
			foreach($parts as $p)
			{
				$sql2 = mysql_query("SELECT * FROM draft WHERE pid='" . $p . "'");
				$temp2 = mysql_fetch_array($sql2);
				$temp3 = explode(",", $temp2['ppID']);
				foreach($temp3 as $t)
				{
					$ppool[] = $t;
				}
				
				$temp3 = explode(",", $temp2['npID']);	
				foreach($temp3 as $t)
				{
					$npool[] = $t;
				}
			}
			
			$ppool = array_values(array_unique($ppool));
			$npool = array_values(array_unique($npool));

			$num = count($parts);
			
			for($i = 0; $i < $num; $i++)
			{
				$sel = $parts[rand(0, ($num - $i - 1))];
				$count = 0;
				$finished = false;
				$sql2 = mysql_query("SELECT * FROM draft WHERE pid='" . $sel . "'");
				$temp2 = mysql_fetch_array($sql2);
				$pplay = explode(",", $temp2['ppID']);
				
				while(!$finished)
				{
					if(in_array($pplay[$count], $ppool))
					{
						mysql_query("UPDATE user_data SET ppID='" . $pplay[$count] . "' WHERE ID='" . $sel . "'");
						unset($ppool[array_search($pplay[$count], $ppool)]);
						$ppool = array_values($ppool);
						
						$nparts[] = $sel;
						unset($parts[array_search($sel, $parts)]);
						$parts = array_values($parts);
						
						$finished = true;
					}
					else
						$count++;
				}
			}
			
			$rparts = array_reverse($nparts);
			for($i = 0; $i < $num; $i++)
			{
				$sel = $rparts[$i];
				$count = 0;
				$finished = false;
				$sql2 = mysql_query("SELECT * FROM draft WHERE pid='" . $sel . "'");
				$temp2 = mysql_fetch_array($sql2);
				$nplay = explode(",", $temp2['npID']);			
				
				while(!$finished)
				{
					if(in_array($nplay[$count], $npool))
					{
						mysql_query("UPDATE user_data SET npID='" . $nplay[$count] . "' WHERE ID='" . $sel . "'");
						unset($npool[array_search($nplay[$count], $npool)]);
						$npool = array_values($npool);	
												
						unset($nparts[array_search($sel, $nparts)]);
						$nparts = array_values($nparts);

						$finished = true;
					}
					else
						$count++;
				}
			}
		}
		// delete drafts
		$elims = explode(",", $temp['participants']);
		foreach($elims as $e)
		{
			mysql_query("DELETE FROM draft WHERE pid='" . $e . "'");
		}
	}
	
	header('Location: reporter.php');
	exit();
}
if(stripslashes($_POST['handle']) == "edit")
{
?>
	<html>
    <head>
    <title>Score Reporter</title>
    </head>
    <body>
    <form action="handle2.php" method="post"><input type="hidden" name="game" id="game" value="<?php echo $gid; ?>" /><input type="hidden" name="handle" id="handle" value="end" /><input type="submit" value="End Game" /></form><br /><br />
    <form action="handle2.php" method="post"><input type="hidden" name="handle" id="handle" value="update" /><input type="hidden" name="game" id="game" value="<?php echo $gid; ?>" />
<?php
	$game = mysql_fetch_array(mysql_query("SELECT * FROM games WHERE ID='" . $gid . "'"));
	$t1 = mysql_fetch_array(mysql_query("SELECT * FROM teams WHERE ID='" . $game['ID1'] . "'"));
	$t2 = mysql_fetch_array(mysql_query("SELECT * FROM teams WHERE ID='" . $game['ID2'] . "'"));
	$p1 = explode(",", $t1['players']);
	$p2 = explode(",", $t2['players']);
	?>
    <table style="border:none;">
    <tr>
    <td style="vertical-align:top;">
    <?php echo "<h2>" . $t1['name'] . "</h2>"; ?>
    <table style="border:thin; border-style:ridge;">
    <tr>
    <td style="border:thin;">
    &nbsp;&nbsp;<strong>Player</strong>&nbsp;&nbsp;
    </td>
    <td style="border:thin;">
    &nbsp;&nbsp;<strong>Goals</strong>&nbsp;&nbsp;
    </td>
    <td style="border:thin;">
    &nbsp;&nbsp;<strong>Assists</strong>&nbsp;&nbsp;
    </td>
    <td style="border:thin;">
    &nbsp;&nbsp;<strong>Ds</strong>&nbsp;&nbsp;
    </td>
    <td style="border:thin;">
    &nbsp;&nbsp;<strong>Turns</strong>&nbsp;&nbsp;
    </td>
    </tr>
    <?php
	foreach($p1 as $p)
	{
		$play = mysql_fetch_array(mysql_query("SELECT * FROM players WHERE ID='" . $p . "'"));
		echo "<tr>";
		echo "<td style=\"border:thin;\"><center>" . $play['fname'] . " " . $play['lname'] . "</center></td>";
		echo "<td style=\"border:thin;\"><center><input type=\"text\" style=\"width:30px;text-align:center;\" name=\"goals1[]\" id=\"goals1[]\" value=\"" . $play['goals'] . "\" maxlength=\"2\"></center></td>";
		echo "<td style=\"border:thin;\"><center><input type=\"text\" style=\"width:30px;text-align:center;\" name=\"assists1[]\" id=\"assists1[]\" value=\"" . $play['assists'] . "\" maxlength=\"2\"></center></td>";
		echo "<td style=\"border:thin;\"><center><input type=\"text\" style=\"width:30px;text-align:center;\" name=\"ds1[]\" id=\"ds1[]\" value=\"" . $play['ds'] . "\" maxlength=\"2\"></center></td>";
		echo "<td style=\"border:thin;\"><center><input type=\"text\" style=\"width:30px;text-align:center;\" name=\"turns1[]\" id=\"turns1[]\" value=\"" . $play['turns'] . "\" maxlength=\"2\"></center></td>";
		echo "</tr>";
	}
	?>
    </table>
    &nbsp;&nbsp;&nbsp;
    </td>
    <td style="vertical-align:top;">
    <?php echo "<h2>" . $t2['name'] . "</h2>"; ?>
    <table style="border:thin; border-style:ridge;">
    <tr>
    <td style="border:thin;">
    &nbsp;&nbsp;<strong>Player</strong>&nbsp;&nbsp;
    </td>
    <td style="border:thin;">
    &nbsp;&nbsp;<strong>Goals</strong>&nbsp;&nbsp;
    </td>
    <td style="border:thin;">
    &nbsp;&nbsp;<strong>Assists</strong>&nbsp;&nbsp;
    </td>
    <td style="border:thin;">
    &nbsp;&nbsp;<strong>Ds</strong>&nbsp;&nbsp;
    </td>
    <td style="border:thin;">
    &nbsp;&nbsp;<strong>Turns</strong>&nbsp;&nbsp;
    </td>
    </tr>
    <?php
	foreach($p2 as $p)
	{
		$play = mysql_fetch_array(mysql_query("SELECT * FROM players WHERE ID='" . $p . "'"));
		echo "<tr>";
		echo "<td style=\"border:thin;\"><center>" . $play['fname'] . " " . $play['lname'] . "</center></td>";
		echo "<td style=\"border:thin;\"><center><input type=\"text\" style=\"width:30px;text-align:center;\" name=\"goals2[]\" id=\"goals2[]\" value=\"" . $play['goals'] . "\" maxlength=\"2\"></center></td>";
		echo "<td style=\"border:thin;\"><center><input type=\"text\" style=\"width:30px;text-align:center;\" name=\"assists2[]\" id=\"assists2[]\" value=\"" . $play['assists'] . "\" maxlength=\"2\"></center></td>";
		echo "<td style=\"border:thin;\"><center><input type=\"text\" style=\"width:30px;text-align:center;\" name=\"ds2[]\" id=\"ds2[]\" value=\"" . $play['ds'] . "\" maxlength=\"2\"></center></td>";
		echo "<td style=\"border:thin;\"><center><input type=\"text\" style=\"width:30px;text-align:center;\" name=\"turns2[]\" id=\"turns2[]\" value=\"" . $play['turns'] . "\" maxlength=\"2\"></center></td>";
		echo "</tr>";
	}
	?>
	</table>
    </td>
    </tr>
    </table><br />
	<input type="submit" value="Update Stats" />
	</form>
	</body>
    </html>
<?php
}

if(stripslashes($_POST['handle']) == "update")
{	
	$game = mysql_fetch_array(mysql_query("SELECT * FROM games WHERE ID='" . $gid . "'"));
	$t1 = mysql_fetch_array(mysql_query("SELECT * FROM teams WHERE ID='" . $game['ID1'] . "'"));
	$t2 = mysql_fetch_array(mysql_query("SELECT * FROM teams WHERE ID='" . $game['ID2'] . "'"));
	$p1 = explode(",", $t1['players']);
	$p2 = explode(",", $t2['players']);
	
	$goals1 = array();
	$assists1 = array();
	$ds1 = array();
	$turns1 = array();
	
	foreach($_POST['goals1'] as $g)
	{
		$goals1[] = $g;
	}
	foreach($_POST['assists1'] as $a)
	{
		$assists1[] = $a;
	}
	foreach($_POST['ds1'] as $d)
	{
		$ds1[] = $d;
	}
	foreach($_POST['turns1'] as $t)
	{
		$turns1[] = $t;
	}
	
	$goals2 = array();
	$assists2 = array();
	$ds2 = array();
	$turns2 = array();
	
	foreach($_POST['goals2'] as $g)
	{
		$goals2[] = $g;
	}
	foreach($_POST['assists2'] as $a)
	{
		$assists2[] = $a;
	}
	foreach($_POST['ds2'] as $d)
	{
		$ds2[] = $d;
	}
	foreach($_POST['turns2'] as $t)
	{
		$turns2[] = $t;
	}
	
	for($i = 0; $i < count($p1); $i++)
	{
		if(intval($goals1[$i]) < 0)
			$goals1[$i] = 0;
		if(intval($assists1[$i]) < 0)
			$assists1[$i] = 0;
		if(intval($ds1[$i]) < 0)
			$ds1[$i] = 0;
		if(intval($turns1[$i]) < 0)
			$turns1[$i] = 0;
		
		mysql_query("UPDATE players SET goals='" . $goals1[$i] . "' WHERE ID='" . $p1[$i] . "'");
		mysql_query("UPDATE players SET assists='" . $assists1[$i] . "' WHERE ID='" . $p1[$i] . "'");
		mysql_query("UPDATE players SET ds='" . $ds1[$i] . "' WHERE ID='" . $p1[$i] . "'");
		mysql_query("UPDATE players SET turns='" . $turns1[$i] . "' WHERE ID='" . $p1[$i] . "'");
	}
	
	for($i = 0; $i < count($p2); $i++)
	{
		if(intval($goals2[$i]) < 0)
			$goals2[$i] = 0;
		if(intval($assists2[$i]) < 0)
			$assists2[$i] = 0;
		if(intval($ds2[$i]) < 0)
			$ds2[$i] = 0;
		if(intval($turns2[$i]) < 0)
			$turns2[$i] = 0;
		
		mysql_query("UPDATE players SET goals='" . $goals2[$i] . "' WHERE ID='" . $p2[$i] . "'");
		mysql_query("UPDATE players SET assists='" . $assists2[$i] . "' WHERE ID='" . $p2[$i] . "'");
		mysql_query("UPDATE players SET ds='" . $ds2[$i] . "' WHERE ID='" . $p2[$i] . "'");
		mysql_query("UPDATE players SET turns='" . $turns2[$i] . "' WHERE ID='" . $p2[$i] . "'");
	}
	
	echo "<html><body>Successfully Updated.<br /><br /><form action=\"handle2.php\" method=\"post\"><input type=\"hidden\" name=\"handle\" value=\"edit\"><input type=\"hidden\" name=\"game\" value=\"" . $gid . "\"><input type=\"submit\" value=\"Continue\"></form></body></html>";
}

if(stripslashes($_POST['handle']) == "end")
{
	// determine winner of each challenge associated with game (award points 7,6,5,4,3,2,1)
	// distribute point earnings to players
	// distribute player temps to player totals
	// send out game summary email
	// delete challenge and game
	// clear user cid, ppID, and npID
	
	$sql = mysql_query("SELECT * FROM challenges WHERE gID='" . $gid . "'");
	while($temp = mysql_fetch_array($sql))
	{
		$mnames = array(); // participant names sorted from lowest score to highest
		
		$pids = explode(",", $temp['participants']);
		$ps = array();
		foreach($pids as $p)
		  {
				$sql2 = mysql_query("SELECT * FROM user_data WHERE ID='" . $p . "'");
				$temp3 = mysql_fetch_array($sql2);
				$pp = mysql_fetch_array(mysql_query("SELECT * FROM players WHERE ID='" . $temp3['ppID'] . "'"));
				$np = mysql_fetch_array(mysql_query("SELECT * FROM players WHERE ID='" . $temp3['npID'] . "'"));
				$ps[] = (intval($pp['goals']) + intval($pp['assists']) + intval($pp['ds']) - intval($pp['turns'])) + (intval($np['turns']) - intval($np['goals']) - intval($np['assists']) - intval($np['ds']));
		  }
		  
		  // Matt's bubble sort	  
		  $c = 0;
		  $cs = count($ps);
		  $change = true;
		  
		  while(($c < $cs) && $change)
		  {
			  $change = false;
			  for($i = 0; $i < $cs-1; $i++)
			  {
				  if(intval($ps[$i]) > intval($ps[$i+1]))
				  {
					  $temp2 = $ps[$i];
					  $ps[$i] = $ps[$i+1];
					  $ps[$i+1] = $temp2;
					  $temp2 = $pids[$i];
					  $pids[$i] = $pids[$i+1];
					  $pids[$i+1] = $temp2;

					  $change = true;
				  }
			  }
			  $c++;
		  }
		  
		  $to = "";
		  
		  $counter = 0;
		  for($i = count($pids) - 1; $i >= 0; $i--)
		  {
			  $sql2 = mysql_fetch_array(mysql_query("SELECT * FROM user_data WHERE ID='" . $pids[$i] . "'"));
			  $exp = $sql2['exp'];
			  $games = $sql2['games'];
			  $points = $sql2['totalpoints'];
			  
			  // resolve ties
			  if($counter)
			  {
				  mysql_query("UPDATE user_data SET exp='" . (intval($exp)+$counter) . "' WHERE ID='" . $pids[$i] . "'");
				  if($i != 0 && $ps[$i] != $ps[$i-1])
					  $counter = 0;
			  }
			  else
			  {
				  mysql_query("UPDATE user_data SET exp='" . (intval($exp)+$i + 1) . "' WHERE ID='" . $pids[$i] . "'");
				  if($i != 0 && $ps[$j] == $ps[$j-1])
				  	  $counter = $i + 1;
			  }
			  			  
			  mysql_query("UPDATE user_data SET games='" . (intval($games)+1) . "' WHERE ID='" . $pids[$i] . "'");
			  mysql_query("UPDATE user_data SET totalpoints='" . (intval($points)+$ps[$i]) . "' WHERE ID='" . $pids[$i] . "'");
			  
			  $sql2 = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE ID='" . $pids[$i] . "'"));
			  
			  $to .= $sql2['email'] . ", ";
			  $mnames[] = $sql2['fname'] . "  " . $sql2['lname'];	  
		  }
		  
		  $atemp = $mnames;
		  unset($mnames);
		  $mnames = array_reverse($atemp);
		  
		  $winners = 1;
		  $end = count($pids) - 1;
		  for($i = count($pids) - 2; $i >= 0; $i--)
		  {
			  if($ps[$i] == $ps[$end])
			  	$winners++;
			  else
				break;
		  }
		  
		  
		  $sql2 = mysql_fetch_array(mysql_query("SELECT * FROM games WHERE ID='" . $gid . "'"));
		  
		  $mname = $sql2['name']; // challenge name
		  
		  $to = substr($to, 0, -1);

		  $subject = "Challenge Summary";
		
		  $headers = "From: ulti@mattkgross.com\r\n";
		  $headers .= "Reply-To: ulti@mattkgross.com\r\n";
		  $headers .= "Bcc: " . $to . "\r\n";
		  $headers .= "MIME-Version: 1.0\r\n";
		  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		  
		  $winning = "This challenge's winner is <strong>" . $mnames[count($mnames)-1];
		  if($winners > 1)
		  {
			  $winning = "This challenge's winners are <strong>" . $mnames[count($mnames)-1];
			  for($i = (count($pids)-2); $i >= 0; $i--)
			  {
				  if($winners == 1)
				  	  break;
				  $winning .= ", " . $mnames[$i];
				  $winners--;
			  }
		  }
		  
		  
		  $message = "<html><body><div style=\"background-color:#030303;color:#ffffff;\">";
		  $message .= "<img src=\"http://www.mattkgross.com/ulti/images/email_logo.png\"><br /><center><span style=\"text-decoration:underline;\"><h1>$mname</h1></span></center><br /><br /><p>&nbsp;&nbsp;&nbsp;&nbsp;$mname has ended. After a hard fought game, the results are in. " . $winning . "</strong>. Let's take a look at the game's stats (positive players appear before negative players):</p><br /><p><center><table border=\"1\"><tr><td style=\"border:thin;\">&nbsp;<strong>Player</strong>&nbsp;</td><td style=\"border:thin;\">&nbsp;<strong>Pick</strong>&nbsp;</td><td style=\"border:thin;\">&nbsp;<strong>Goals</strong>&nbsp;</td><td style=\"border:thin;\">&nbsp;<strong>Assists</strong>&nbsp;</td><td style=\"border:thin;\">&nbsp;<strong>Ds</strong>&nbsp;</td><td style=\"border:thin;\">&nbsp;<strong>Turns</strong>&nbsp;</td><td style=\"border:thin;\">&nbsp;<strong>Total</strong>&nbsp;</td></tr>";
		  
		  for($i = (count($pids) - 1); $i >= 0; $i--)
		  {
			  $sql2 = mysql_fetch_array(mysql_query("SELECT * FROM user_data WHERE ID='" . $pids[$i] . "'"));
			  $man = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE ID='" . $pids[$i] . "'"));
			  $pp = mysql_fetch_array(mysql_query("SELECT * FROM players WHERE ID='" . $sql2['ppID'] . "'"));
			  $np = mysql_fetch_array(mysql_query("SELECT * FROM players WHERE ID='" . $sql2['npID'] . "'"));
			  
			  $message .= "<tr><td style=\"border:thin;\" nowrap=\"nowrap\">&nbsp;" . $man['fname'] . " " . $man['lname'] . "&nbsp;</td><td style=\"border:thin;\" nowrap=\"nowrap\">&nbsp;" . $pp['fname'] . "  " . $pp['lname'] . "&nbsp;</td><td style=\"border:thin;\" nowrap=\"nowrap\"><center>&nbsp;" . $pp['goals'] . "&nbsp;</center></td><td style=\"border:thin;\" nowrap=\"nowrap\"><center>&nbsp;" . $pp['assists'] . "&nbsp;</center></td><td style=\"border:thin;\" nowrap=\"nowrap\"><center>&nbsp;" . $pp['ds'] . "&nbsp;</center></td><td style=\"border:thin;\" nowrap=\"nowrap\"><center>&nbsp;" . $pp['turns'] . "&nbsp;</center></td><td style=\"border:thin;\" nowrap=\"nowrap\"><center>&nbsp;" . (intval($pp['goals']) + intval($pp['assists']) + intval($pp['ds']) - intval($pp['turns'])) . "&nbsp;</center></td></tr>";
			  
			  $message .= "<tr><td style=\"border:thin;\" nowrap=\"nowrap\"></td><td style=\"border:thin;\" nowrap=\"nowrap\">&nbsp;" . $np['fname'] . "  " . $np['lname'] . "&nbsp;</td><td style=\"border:thin;\" nowrap=\"nowrap\"><center>&nbsp;" . $np['goals'] . "&nbsp;</center></td><td style=\"border:thin;\" nowrap=\"nowrap\"><center>&nbsp;" . $np['assists'] . "&nbsp;</center></td><td style=\"border:thin;\" nowrap=\"nowrap\"><center>&nbsp;" . $np['ds'] . "&nbsp;</center></td><td style=\"border:thin;\" nowrap=\"nowrap\"><center>&nbsp;" . $np['turns'] . "&nbsp;</center></td><td style=\"border:thin;\" nowrap=\"nowrap\"><center>&nbsp;" . (intval($np['turns']) - intval($np['goals']) - intval($np['assists']) - intval($np['ds'])) . "&nbsp;</center></td></tr>";
			  
			  mysql_query("UPDATE user_data SET ppID='0' WHERE ID='" . $pids[$i] . "'");
			  mysql_query("UPDATE user_data SET npID='0' WHERE ID='" . $pids[$i] . "'");
			  mysql_query("UPDATE user_data SET cID='0' WHERE ID='" . $pids[$i] . "'");
		  }
		  
		  $message .= "</table></center></p><br /><br /><span style=\"font-style:italic;\">&nbsp;&nbsp;&nbsp;&nbsp;Please do not respond to this email. This was sent via an automated service run by Fantasy Ultimate. Any replies will be ignored by the server.</span>";		  
		  $message .= "</div></body></html>";
		  
		  mail("ulti@mattkgross.com", $subject, $message, $headers);
		  
		  mysql_query("DELETE FROM challenges WHERE ID='" . $temp['ID'] . "'");
	}
	
	
	$game = mysql_fetch_array(mysql_query("SELECT * FROM games WHERE ID='" . $gid . "'"));
	$t1 = mysql_fetch_array(mysql_query("SELECT * FROM teams WHERE ID='" . $game['ID1'] . "'"));
	$t2 = mysql_fetch_array(mysql_query("SELECT * FROM teams WHERE ID='" . $game['ID2'] . "'"));
	$p1 = explode(",", $t1['players']);
	$p2 = explode(",", $t2['players']);
	
	foreach($p1 as $p)
	{
		$temp = mysql_fetch_array(mysql_query("SELECT * FROM players WHERE ID='" . $p . "'"));
		$gs = intval($temp['goals']) + intval($temp['tgoals']);
		$as = intval($temp['assists']) + intval($temp['tassists']);
		$ds = intval($temp['ds']) + intval($temp['tds']);
		$ts	 = intval($temp['turns']) + intval($temp['tturns']);
		$gms = intval($temp['tgames']) + 1;
		
		mysql_query("UPDATE players SET tgoals='" . $gs . "' WHERE ID='" . $p . "'");
		mysql_query("UPDATE players SET tassists='" . $as . "' WHERE ID='" . $p . "'");
		mysql_query("UPDATE players SET tds='" . $ds . "' WHERE ID='" . $p . "'");
		mysql_query("UPDATE players SET tturns='" . $ts . "' WHERE ID='" . $p . "'");
		mysql_query("UPDATE players SET tgames='" . $gms . "' WHERE ID='" . $p . "'");
		
		mysql_query("UPDATE players SET goals='0' WHERE ID='" . $p . "'");
		mysql_query("UPDATE players SET assists='0' WHERE ID='" . $p . "'");
		mysql_query("UPDATE players SET ds='0' WHERE ID='" . $p . "'");
		mysql_query("UPDATE players SET turns='0' WHERE ID='" . $p . "'");
	}
	foreach($p2 as $p)
	{
		$temp = mysql_fetch_array(mysql_query("SELECT * FROM players WHERE ID='" . $p . "'"));
		$gs = intval($temp['goals']) + intval($temp['tgoals']);
		$as = intval($temp['assists']) + intval($temp['tassists']);
		$ds = intval($temp['ds']) + intval($temp['tds']);
		$ts	 = intval($temp['turns']) + intval($temp['tturns']);
		$gms = intval($temp['tgames']) + 1;
		
		mysql_query("UPDATE players SET tgoals='" . $gs . "' WHERE ID='" . $p . "'");
		mysql_query("UPDATE players SET tassists='" . $as . "' WHERE ID='" . $p . "'");
		mysql_query("UPDATE players SET tds='" . $ds . "' WHERE ID='" . $p . "'");
		mysql_query("UPDATE players SET tturns='" . $ts . "' WHERE ID='" . $p . "'");
		mysql_query("UPDATE players SET tgames='" . $gms . "' WHERE ID='" . $p . "'");
		
		mysql_query("UPDATE players SET goals='0' WHERE ID='" . $p . "'");
		mysql_query("UPDATE players SET assists='0' WHERE ID='" . $p . "'");
		mysql_query("UPDATE players SET ds='0' WHERE ID='" . $p . "'");
		mysql_query("UPDATE players SET turns='0' WHERE ID='" . $p . "'");
	}
	
	
	mysql_query("DELETE FROM games WHERE ID='" . $gid . "'");
	
	
	echo "Game successfully ended.<br /><br /><a href=\"reporter.php\">Go back to Score Reporter</a>.";
}

require_once("headers/close.php");
?>