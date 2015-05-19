<div id="bar-anchor"></div>
<div class="bar" id="bar">
<div class="bar_content">
<table class="bar_tab">
<tr>
<td class="bar_left">
<?php
$b_sql = mysql_query("SELECT * FROM users WHERE ID='" . $_SESSION['ID'] . "'");
$b_count = mysql_num_rows($b_sql);
$b_user = mysql_fetch_array($b_sql);
if($b_count == 0)
{
?>
<img src="images/d_status.png" style="vertical-align: middle;" />&nbsp;<a href="signup.php">Guest</a>
<?php
}
else
{
?>
<img src="images/g_status.png" style="vertical-align: middle;" />&nbsp;
<?php
echo "<a href=\"account.php\">" . $b_user['fname'] . " " . $b_user['lname'] . "</a>";
}
?>
</td>
<td class="bar_center">
<a href="leaders.php">Leaderboard</a> | <a href="scores.php">Scores</a> | <a href="teams.php">Teams</a> | <a href="player.php">Players</a>
</td>
<td class="bar_right">
<?php
if($b_count == 0)
{
	echo "<a href=\"login.php\">Log In</a>";
}
else
{
	echo "<a href=\"login.php?error=out\">Logout</a>";
}
?>
</td>
</tr>
</table>
</div>
</div>