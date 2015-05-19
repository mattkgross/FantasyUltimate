<?php
session_start();

require_once("headers/mysql.php");

$type = stripslashes($_POST['type']);

if($type == "search")
{
	$uname = stripslashes($_POST['uname']);
	$fname = stripslashes($_POST['fname']);
	$lname = stripslashes($_POST['lname']);
	$email = stripslashes($_POST['email']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php require("headers/header.php"); ?>
<script src="SpryAssets/SpryAccordion.js" type="text/javascript"></script>
<link href="SpryAssets/SpryAccordion.css" rel="stylesheet" type="text/css">
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
							<li class="bg_none"><a href="#"><img src="images/img3.gif" alt=""></a></li>
						</ul>
					</nav>
					<nav>
						<ul id="menu">
							<li><a href="index.php">Home</a></li>
							<li><a href="about.php">About</a></li>
							<li><a href="contact.php">Contact</a></li>
							<li><a href="login.php">Account</a></li>
                            <li id="menu_active"><a href="search.php">Search</a></li>
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
			<h2>Search Results</h2>
			<div class="wrapper">            
			  <div id="Accordion1" class="Accordion" tabindex="0">
              <?php
			  if(!empty($uname))
			  {
			  	echo "<div class=\"AccordionPanel\">
			      <div class=\"AccordionPanelTab\"><strong>Username: " . $uname . "</strong></div><div class=\"AccordionPanelContent\">";
			  	$sql = mysql_query("SELECT * FROM users WHERE uname LIKE '" . $uname . "%" . "'");
				$count = 0;
				while($runame = mysql_fetch_array($sql))
				{
					echo "<strong><a href='profile.php?prof=" . $runame['uname'] . "'>" . $runame['uname'] . "</a></strong>, " . $runame['fname'] . " " . $runame['lname'] . "<br />";
					++$count;
				}
				
				if($count == 0)
					echo "No results found...<br />";
				echo "</div></div>";
			  }
			  
			  if(!empty($fname))
			  {
			  	echo "<div class=\"AccordionPanel\">
			      <div class=\"AccordionPanelTab\"><strong>First Name: " . $fname . "</strong></div><div class=\"AccordionPanelContent\">";
				$sql = mysql_query("SELECT * FROM users WHERE fname LIKE '" . $fname . "%" . "'");
				$count = 0;
				while($rfname = mysql_fetch_array($sql))
				{
					echo "<a href='profile.php?prof=" . $rfname['uname'] . "'>" . $rfname['uname'] . "</a>, <strong>" . $rfname['fname'] . "</strong> " . $rfname['lname'] . "<br />";
					++$count;
				}
				
				if($count == 0)
					echo "No results found...<br />";
				echo "</div></div>";
			  }
			  
			  if(!empty($lname))
			  {
			  	echo "<div class=\"AccordionPanel\">
			      <div class=\"AccordionPanelTab\"><strong>Last Name: " . $lname . "</strong></div><div class=\"AccordionPanelContent\">";
				$sql = mysql_query("SELECT * FROM users WHERE lname LIKE '" . $lname . "%" . "'");
				$count = 0;
				while($rlname = mysql_fetch_array($sql))
				{
					echo "<a href='profile.php?prof=" . $rlname['uname'] . "'>" . $rlname['uname'] . "</a>, " . $rlname['fname'] . " <strong>" . $rlname['lname'] . "</strong><br />";
					++$count;
				}
				
				if($count == 0)
					echo "No results found...<br />";
				echo "</div></div>";
			  }
			  
			  if(!empty($email))
			  {
			  	echo "<div class=\"AccordionPanel\">
			      <div class=\"AccordionPanelTab\"><strong>Email: " . $email . "</strong></div><div class=\"AccordionPanelContent\">";
				$sql = mysql_query("SELECT * FROM users WHERE email LIKE '" . $email . "%" . "'");
				$count = 0;
				while($remail = mysql_fetch_array($sql))
				{
					echo "<a href='profile.php?prof=" . $remail['uname'] . "'>" . $remail['uname'] . "</a>, " . $remail['fname'] . " " . $remail['lname'] . "</strong><br />"; //", <strong>" . $remail['email'] . "</strong><br />"; This adds emails to the end of the search results
					++$count;
				}
				
				if($count == 0)
					echo "No results found...<br />";
				echo "</div></div>";
			  }
			  
			  if(empty($uname) && empty($fname) && empty($lname) && empty($email))
			  {
			  	echo "Nothing entered into the search!<br />";
			  }
			  ?>
		      </div>
              <br /><a href="search.php">Try again?</a>
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
<script type="text/javascript">
Cufon.now();
var Accordion1 = new Spry.Widget.Accordion("Accordion1");
</script>
</body>
</html>
<?php
}

else
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
							<li class="bg_none"><a href="#"><img src="images/img3.gif" alt=""></a></li>
						</ul>
					</nav>
					<nav>
						<ul id="menu">
							<li><a href="index.php">Home</a></li>
							<li><a href="about.php">About</a></li>
							<li><a href="contact.php">Contact</a></li>
							<li><a href="login.php">Account</a></li>
                            <li id="menu_active"><a href="#">Search</a></li>
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
			<h2>Search</h2>
			<p class="color1">Search for your fellow teammates and friends on our site either by username, first or last name, or email! Get started below by filling in what information you do know.</p>
            <div class="wrapper">
                <p class="pad_bot2">
                <form action="search.php" method="post" name="search">
                <input type="hidden" name="type" id="type" value="search" />
                First Name:<br />
                <input type="text" name="fname" id="fname" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                Last Name:<br />
                <input type="text" name="lname" id="lname" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                Username:<br />
                <input type="text" name="uname" id="uname" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                Email:<br />
                <input type="text" name="email" id="email" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                <input type="submit" value="Search" style="border:solid;border-color:#CCCCCC;border-width:1px;" />
                </form>
                </p>
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

require_once("headers/close.php");
?>