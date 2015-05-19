<?php
session_start();

require_once("headers/mysql.php");

$ID = $_SESSION['ID'];
$sql = mysql_query("SELECT * FROM users WHERE ID='" . $ID . "'");
$user = mysql_fetch_array($sql);

$sql = mysql_query("SELECT * FROM user_data");
$fan = array();
$points = array();
while($temp = mysql_fetch_array($sql))
{
	$fan[strval($temp['ID'])] = $temp['exp'];
	$points[] = array($temp['ID'], $temp['totalpoints']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php require("headers/header.php"); ?>
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css">
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
							<li><a href="games.php">Games</a></li>
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
			<h2>Leaderboards</h2>
              <div id="TabbedPanels1" class="TabbedPanels">
                  <ul class="TabbedPanelsTabGroup">
                    <li class="TabbedPanelsTab" tabindex="0">Fantasy Points</li>
                    <li class="TabbedPanelsTab" tabindex="0">Game Points</li>
                </ul>
                  <div class="TabbedPanelsContentGroup">
                    <div class="TabbedPanelsContent">
                    <table style="border: none;">
                    <?php
					print_r($fan);
					echo "<br /><br />";
					sort($fan);
					print_r($fan);
					?>
                    </table>
                    </div>
                    <div class="TabbedPanelsContent">
                    <table style="border: none;">
                    <?php
					
					?>
                    </table>
                    </div>
                  </div>
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
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
</script>
</body>
</html>
<?php
require_once("headers/close.php");
?>