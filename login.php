<?php
//Start session
session_start();

$error = stripslashes($_GET['error']);

$SID = $_SESSION['ID'];

if($error == "out")
{
	$_SESSION['logout'] = "doit";
	header('Location: check.php');
}

else if($error == "logout")
{
    $message = "<h2>Logged Out</h2>
    <p class=\"color1\">You have successfully logged out of your account.</p>";
}

else if($error == "empty")
{
    $message = "<h2>Error!</h2>
	<p class=\"color1\">You left one of the fields in the login blank! Use the login bar to your left to try again.</p>";
}

else if($error == "wrong")
{
	$message = "<h2>Error!</h2>
	<p class=\"color1\">Wrong username and/or password! Also, be sure that your account is activated (via email) <strong>before</strong> logging in.</p>";
}

// Check whether the session variable ID is present or not
else if(empty($SID))
{
	$message = "<h2>Login</h2>
	<p class=\"color1\">Please log in using the bar to the left.</p>";
}

else
{
	header('Location: account.php');
	exit();
}
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
							<li><a href="about.php">About</a></li>
							<li><a href="contact.php">Contact</a></li>
							<li id="menu_active"><a href="#">Account</a></li>
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
<?php echo $message; ?>
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