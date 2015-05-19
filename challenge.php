<?php
session_start();

require_once("headers/mysql.php");

$ID = $_SESSION['ID'];
if(!isset($_SESSION['ID']))
{
	header('Location: login.php');
	exit();
}

$sql = mysql_query("SELECT * FROM users WHERE ID='" . $ID . "'");
$user = mysql_fetch_array($sql);
$sql = mysql_query("SELECT * FROM user_data WHERE ID='" . $ID . "'");
$userd = mysql_fetch_array($sql);

if(!empty($userd['cID']))
	header('Location: account.php?error=already');

$handle = stripslashes($_POST['handle']);

if($handle == "step1")
{
	$gid = stripslashes($_POST['gid']);
	$sql = mysql_query("SELECT * FROM games WHERE ID='" . $gid . "'");
	$game = mysql_fetch_array($sql);
	
	$friends = array(); 
	foreach($_POST['choices'] as $f)
	{
		$friends[] = $f; 
	}
	
	$noplay = $ID;
	foreach($friends as $friend)
	{
		$noplay .= "," . $friend;
	}	
	
	mysql_query("INSERT INTO challenges (organizer, noplayers, gID) VALUES ('" . $ID . "', '" . $noplay . "', '" . $gid . "')");
	$cid = mysql_insert_id();
	mysql_query("UPDATE user_data SET cID='" . $cid . "' WHERE ID='" . $ID . "'");
	
	foreach($friends as $friend)
	{
		$to = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE ID='" . $friend . "'"));

		if(intval($to['invite']))
		{		
			$subject = "Challenge Invite";
			
			$headers = "From: ulti@mattkgross.com\r\n";
			$headers .= "Reply-To: ulti@mattkgross.com\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
			$message = "<html><body><div style=\"background-color:#030303;color:#ffffff;\"><img src=\"http://www.mattkgross.com/ulti/images/email_logo.png\"><br /><center><span style=\"text-decoration:underline;\"><h1>Challenge Invite</h1></span></center><br /><br /><p>&nbsp;&nbsp;&nbsp;&nbsp;Hey, " . $to['fname'] . "! You've been invited to a challenge for " . $game['name'] . " by ". $user['fname'] . " " . $user['lname'] . "! To view the challenge details, look under your \"Invites\" tab on <a href=\"http://www.mattkgross.com/ulti/account.php\"> your account</a>. You can also directly join the challenge <a href=\"http://www.mattkgross.com/ulti/choose.php?cid=" . $cid . "\">here</a>.</p><br /><br /><span style=\"font-style:italic;\">&nbsp;&nbsp;&nbsp;&nbsp;Please do not respond to this email. This was sent via an automated service run by Fantasy Ultimate. Any replies will be ignored by the server.</span></div></body></html>";
			
			mail($to['email'], $subject, $message, $headers);
		}
	}
	
	header('Location: choose.php?cid=' . $cid);
}

else
{
	$gid = stripslashes($_GET['gid']);
	$sql = mysql_query("SELECT * FROM games WHERE ID='" . $gid . "'");
	$game = mysql_fetch_array($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php require("headers/header.php"); ?>
</head>
<body id="page1">
<?php require("headers/bar.php"); ?>
<div class="body1">
	<div class="main">
<!-- header -->
		<header>
			<div class="wrapper">
            
				<h1>
					<a href="index.php" id="logo">Fantasy Ultimate</a><!--<span id="slogan">International Travel</span>-->
				</h1>
            
				<div class="right">
					<nav>
						<ul id="top_nav">
							<li><a href="index.php"><img src="images/img1.gif" alt=""></a></li>
							<li><a href="contact.php"><img src="images/img2.gif" alt=""></a></li>
							<li class="bg_none"><a href="search.php"><img src="images/img3.gif" alt=""></a></li>
						</ul>
					</nav>
					<nav>
						<ul id="menu">
							<li><a href="index.php">Home</a></li>
							<li id="menu_active"><a href="#">Games</a></li>
							<li><a href="contact.php">Contact</a></li>
							<li><a href="login.php">Account</a></li>
                            <li><a href="search.php">Search</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</header>
	</div>
</div>
<div class="main">
	<div id="banner">
	<?php require("headers/banner.php"); ?>
	</div>
</div>
<!-- / header -->
<div class="main">
<!-- content -->
	<section id="content">
		<article class="col1">
			<div class="pad_1">
            <?php require("headers/profstats.php"); ?>
			</div>
		</article>
		<article class="col2 pad_left1">
			<h2>Create Challenge</h2>
            <strong>Selected Game:</strong> <?php echo $game['name']; ?><br /><br />
            <strong>Select Friends to Challenge:</strong><br />
            <form action="challenge.php" method="post">
            <input type="hidden" name="handle" id="handle" value="step1" />
            <input type="hidden" name="gid" id="gid" value="<?php echo $gid; ?>" />
            <?php
			$sql = mysql_query("SELECT * FROM friends WHERE ID='" . $ID . "'");
			$temp = mysql_fetch_array($sql);
			$friends = $temp['friends'];
			
			if(!empty($friends))
			{
				$farray = explode(",", $friends);			
				for($i = 0; $i < count($farray); ++$i)
				{
					$sql = mysql_query("SELECT * FROM users WHERE ID='" . $farray[$i] . "'");
					$temp = mysql_fetch_array($sql);
					
					echo "<input type=\"checkbox\" name=\"choices[]\" id=\"choices[]\" value=\"" . $farray[$i] . "\"> " . $temp['fname'] . " " . $temp['lname'] . "<br />";
				}
				
				echo "<br /><input type=\"submit\" style=\"border:solid;border-color:#CCCCCC;border-width:1px;\" value=\"Next\" />";
			}
			
			else
			{
				echo "You need friends to create a challenge!";	
			}
			?>
            </form>
            <!--<p class="color1">Fantasy Ultimate is a new service that enables users to connect to their favorite players and teams, view season and game statistics, and play friendly "fantasy" games against other players. The service is free; all you have to do is sign up!</p>-->
            
			<div class="wrapper"><br /><br /><br />
            <!--
				<article class="cols">
					<h2>Our Clients</h2>
					<p><strong>Avero eoset</strong> accusamus et iusto odio dig- nissimos ducimus qui blanditiis praesentium voluptatum deleniti.</p>
					<p>Atque corrupti quos dolores et quas moles- tias excepturi sint <a href="#">occaecati cupiditate</a> non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.</p>
				</article>
				<div class="box1">
					<div class="pad_1">
						<div class="wrapper">
							<p class="pad_bot2">Lorem ipsum dolor sit amet, consectetur adip- isicing elit, sed do eius- mod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis </p>
							<p><span class="right">Mr. Thomas Lloyd</span>&nbsp;<br></p>
						</div>
					</div>
				</div>
                -->
			</div>
		</article>
	</section>
<!-- / content -->
</div>
<div class="body2">
	<div class="main">
<!-- footer -->
<?php require("headers/footer.php"); ?>
<!-- / footer -->
	</div>
</div>
<script type="text/javascript"> Cufon.now(); </script>
</body>
</html>
<?php
}

require_once("headers/close.php");
?>