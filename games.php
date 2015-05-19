<?php
session_start();

require_once("headers/mysql.php");

$ID = $_SESSION['ID'];
if(!isset($_SESSION['ID']))
{
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
			<h2>Page Inaccessible</h2>
            <p class="color1">You must be logged in to access this page. Use the sidebar to the left to login to your account.</p>
            <!--
			<p class="color1">Fantasy Ultimate is a new service that enables users to connect to their favorite players and teams, view season and game statistics, and play friendly "fantasy" games against other players. The service is free; all you have to do is sign up!</p>
			<div class="marker">
				<div class="wrapper">
					<p class="pad_bot2"><strong>Registration</strong></p>
					<p class="pad_bot2">All we need are a few details from you and then you will be ready to compete against friends and root your teams on!</p>
				</div>
			</div>
			<div class="wrapper pad_bot2"><a href="signup.php" class="button1">Register</a></div>
			<div class="marker">
				<div class="wrapper">
					<p class="pad_bot2"><strong>Questions?</strong></p>
					<p class="pad_bot2">We are available to answer any questions you may have about how our system works. Feel free to contact us with any questions or concerns you may have!</p>
				</div>
			</div>
			<div class="wrapper pad_bot2">
				<a href="contact.php" class="button1">Contact Us</a>-->
				<!--<a href="#" class="button2">Fleet</a>-->
			</div>
            
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
else
{
	$sql = mysql_query("SELECT * FROM users WHERE ID='" . $ID . "'");
	$user = mysql_fetch_array($sql);
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
							<li id="menu_active"><a href="games.php">Games</a></li>
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
			<h2>Current Games</h2>
            <table style="border-style:solid; border-color:#f4f4f4; border-width:medium;">
            <tr>
            <td style="border-style:dashed; border-color:#999; border-width:thin;">
            <strong><center>&nbsp;Name&nbsp;</center></strong>
            </td>
            <td style="border-style:dashed; border-color:#999; border-width:thin;">
            <strong><center>&nbsp;Team 1&nbsp;</center></strong>
            </td>
            <td style="border-style:dashed; border-color:#999; border-width:thin;">
            <strong><center>&nbsp;Team 2&nbsp;</center></strong>
            </td>
            <td style="border-style:dashed; border-color:#999; border-width:thin;">
            <strong><center>&nbsp;Start Time&nbsp;</center></strong>
            </td>
            <td style="border-style:dashed; border-color:#999; border-width:thin;">
            <strong><center>&nbsp;Active&nbsp;</center></strong>
            </td>
            </tr>
            <?php
			$sql = mysql_query("SELECT * FROM games");
			
			while($game = mysql_fetch_array($sql))
			{
				$sql2 = mysql_query("SELECT * FROM teams WHERE ID='" . $game['ID1'] . "'");
				$temp = mysql_fetch_array($sql2);
				$t1 = $temp['name'];
				$sql2 = mysql_query("SELECT * FROM teams WHERE ID='" . $game['ID2'] . "'");
				$temp = mysql_fetch_array($sql2);
				$t2 = $temp['name'];
				$output = "<tr><td style=\"border-style:dashed; border-color:#999; border-width:thin;\" nowrap=\"nowrap\">&nbsp;" . $game['name'] . "&nbsp;</td><td style=\"border-style:dashed; border-color:#999; border-width:thin;\" nowrap=\"nowrap\">&nbsp;" . $t1 . "&nbsp;</td><td style=\"border-style:dashed; border-color:#999; border-width:thin;\" nowrap=\"nowrap\">&nbsp;" . $t2 . "&nbsp;</td><td style=\"border-style:dashed; border-color:#999; border-width:thin;\" nowrap=\"nowrap\">&nbsp;" . date("F j, g:i a", strtotime($game['start'])) . "&nbsp;</td>";
				if(intval($game['active']) == 0)
					$output .= "<td style=\"border-style:dashed; border-color:#999; border-width:thin;\" nowrap=\"nowrap\">&nbsp;<a href=\"challenge.php?gid=" . $game['ID'] . "\">Challenge</a>&nbsp;</td></tr>";
				else
					$output .= "<td style=\"border-style:dashed; border-color:#999; border-width:thin;\" nowrap=\"nowrap\">&nbsp;In Progress&nbsp;</td></tr>";
				
				echo $output;
			}
			?>
            </table>
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