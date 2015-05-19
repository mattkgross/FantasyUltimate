<?php
if(isset($_SESSION['ID']))
{
	$sql = mysql_query("SELECT * FROM users WHERE ID='" . $_SESSION['ID'] . "'");
	$user = mysql_fetch_array($sql);
?>
<div class="text1">
	<?php echo strtoupper($user['fname']); ?><span><?php echo strtoupper($user['lname']); ?></span><p>You are currently logged into Fantasy as <strong><?php echo $user['uname']; ?></strong>.</p>
</div>
<a href="account.php" class="button_top">Go to Account</a>
<?php
}
else
{
?>
<div class="text1">
	IT'S HERE<span>Sign Up</span><p>Sign up for a Fantasy Ultimate account to compete against friends and teammates. Earn bragging rights and follow your favorite players and teams.</p>
</div>
<a href="signup.php" class="button_top">Sign Up for Fantasy</a>
<?php
}
?>