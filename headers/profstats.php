<?php
if(isset($_SESSION['ID']))
{
	$sql = mysql_query("SELECT * FROM user_data WHERE ID='" . $_SESSION['ID'] . "'");
	$stats = mysql_fetch_array($sql);
?>
	<h2>Quick Stats</h2>
	<div class="wrapper">
	Fantasy EXP: <?php echo $stats['exp']; ?><br /><br />
	Games Played: <?php echo $stats['games']; ?><br /><br />
	Total Points Earned: <?php echo $stats['totalpoints']; ?><br /><br />
	Rank: <?php $sql = mysql_query("SELECT * FROM user_data WHERE exp>" . $stats['exp']); echo mysql_num_rows($sql) + 1; ?> of <?php $sql = mysql_query("SELECT * FROM user_data"); echo mysql_num_rows($sql); ?><br /><br />
	</div>
<?php
}

else
{
?>
	<h2>Quick Login</h2>
	<form id="form_1" action="check.php" method="post">
		<div class="wrapper">
		<p>Username:</p>
		<div class="wrapper"><input type="text" name="user" id="user" class="input input1" style="border:solid;border-color:#CCCCCC;border-width:1px;"></div>
		</div>
		<br />
		<div class="wrapper">
		<p>Password:</p>
		<div class="wrapper"><input type="password" name="pword" id="pword" class="input input1" style="border:solid;border-color:#CCCCCC;border-width:1px;"></div>
		</div>
		<br />
		<div class="wrapper">
		<input type="submit" name="action" id="action" value="Login" style="border:solid;border-color:#CCCCCC;border-width:1px;">&nbsp;&nbsp;<input type="submit" name="action" id="action" value="Sign Up" style="border:solid;border-color:#CCCCCC;border-width:1px;">
		</div>
	</form>
    <?php require("headers/news.php"); ?>
<?php
}
?>