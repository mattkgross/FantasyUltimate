<?php
session_start();

require_once("headers/mysql.php");
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
							<li id="menu_active"><a href="#">Contact</a></li>
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
<?php
$value = stripslashes($_POST['value']);
if($value == "submit")
{
	$name = stripslashes($_POST['name']);
	$email = stripslashes($_POST['email']);
	$comment = stripslashes($_POST['comment']);
	
	if(empty($name) || empty($email) || empty($comment))
	{
	?>
			<h2>Error!</h2>
			<p class="color1">You left one of the fields blank! All of the fields are required. Please fill in any part that you left blank.</p>
			<div class="wrapper">
			<form action="contact.php" method="post" name="contact">
            <input type="hidden" name="value" id="value" value="submit" />
            Name:<br />
            <input type="text" name="name" id="name" style="border:solid;border-color:#CCCCCC;border-width:1px;" value="<?php echo $name; ?>" /><br /><br />
            Email:<br />
            <input type="text" name="email" id="email" style="border:solid;border-color:#CCCCCC;border-width:1px;" value="<?php echo $email; ?>" /><br /><br />
            Question/Comment:<br />
            <textarea style="border:solid;border-color:#CCCCCC;border-width:1px;" cols="60" rows="10" name="comment" id="comment"><?php echo $comment; ?></textarea>
            <br /><br />
            <input type="submit" value="Submit" style="border:solid;border-color:#CCCCCC;border-width:1px;" />
            </form>
			</div>            
			<div class="wrapper"><br /><br /><br />
    <?php
	}
	
	else
	{
		$message = $name . " (" . $email . ") has sent you a message:\n\n" . $comment;
				
		$headers = 'From: ' . $email . "\r\n".
		'Reply-To: '. $email ."\r\n" .
		'X-Mailer: PHP/' . phpversion();
		mail("ulti@mattkgross.com", "Fantasy Ultimate - Contact Form", $message, $headers);
	
	?>
			<h2>Success!</h2>
			<p class="color1">Thank you for getting in touch with us! We will respond to you within the next two business days.</p>            
			<div class="wrapper"><br /><br /><br />
    <?php
	}
}

else
{
	if(isset($_SESSION['ID']))
	{
		$sql = mysql_query("SELECT * FROM users WHERE ID='" . $_SESSION['ID'] . "'");
		$user = mysql_fetch_array($sql);
		
		$n = $user['fname'] . " " . $user['lname'];
		$e = $user['email'];
	}
?>
			<h2>Contact Us</h2>
			<p class="color1">Use the form below to get in touch with us to report any concerns or ask our team any questions you may have about our service. We will respond to your inquiry within two business days.</p>
			<div class="wrapper">
			<form action="contact.php" method="post" name="contact">
            <input type="hidden" name="value" id="value" value="submit" />
            Name:<br />
            <input type="text" name="name" id="name" style="border:solid;border-color:#CCCCCC;border-width:1px;" value="<?php echo $n; ?>" /><br /><br />
            Email:<br />
            <input type="text" name="email" id="email" style="border:solid;border-color:#CCCCCC;border-width:1px;" value="<?php echo $e; ?>" /><br /><br />
            Question/Comment:<br />
            <textarea style="border:solid;border-color:#CCCCCC;border-width:1px;" cols="60" rows="10" name="comment" id="comment"></textarea>
            <br /><br />
            <input type="submit" value="Submit" style="border:solid;border-color:#CCCCCC;border-width:1px;" />
            </form>
			</div>            
			<div class="wrapper"><br /><br /><br />
<?php
}
?>
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