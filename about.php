<?php
session_start();
?>
<?php require_once("headers/mysql.php"); ?>
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
							<li id="menu_active"><a href="#">About</a></li>
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
			<h2>About Fantasy Ultimate</h2>
			<p class="color1">As the Ultimate community expands, so does the desire to follow the top teams in the nation. With Fantasy Ultimate, not only will you be able to keep up to date with top scoring players, but you will also be able to compete against other fans. 
At Fantasy Ultimate, we are developing a way for fans to choose their favorite elite club players to challenge other players around the world. 
</p>
			<div class="marker">
				<div class="wrapper">
					<p class="pad_bot2"><strong>How to Play</strong></p>
					<p class="pad_bot2">Pick a player as a “positive” and another player as a “negative” at the start of a game. Every goal, assist, and D that your positive gets nets you a +1. A turn over counts as -1. For your negative, these values are reversed.  Challenge your friends to see who will can choose the ultimate team.</p>
				</div>
			</div>
		<!--<div class="wrapper pad_bot2"><a href="signup.php" class="button1">Register</a></div>
			<div class="marker">
				<div class="wrapper">
					<p class="pad_bot2"><strong>Questions?</strong></p>
					<p class="pad_bot2">We are available to answer any questions you may have about how our system works. Feel free to contact us with any questions or concerns you may have!</p>
				</div>
			</div>
			<div class="wrapper pad_bot2">
				<a href="contact.php" class="button1">Contact Us</a>
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
<?php require_once("headers/close.php"); ?>