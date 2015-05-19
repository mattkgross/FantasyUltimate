<?php
session_start();

require_once("headers/mysql.php");

$pid = stripslashes($_GET['pid']);
$sql = mysql_query("SELECT * FROM players WHERE ID='" . $pid . "'");
$count = mysql_num_rows($sql);
$player = mysql_fetch_array($sql);

$handle = stripslashes($_POST['handle']);

if($handle == "search")
{
	$fname = stripslashes($_POST['fname']);
	$lname = stripslashes($_POST['lname']);
	$number = intval(stripslashes($_POST['number']));
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
							<li class="bg_none"><a href="search.php"><img src="images/img3.gif" alt=""></a></li>
						</ul>
					</nav>
					<nav>
						<ul id="menu">
							<li><a href="index.php">Home</a></li>
							<li><a href="about.php">About</a></li>
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
        <h2>Player Search</h2>
		<div class="wrapper">
        <div id="Accordion1" class="Accordion" tabindex="0">
          <?php
			  if(!empty($fname))
			  {
			  	echo "<div class=\"AccordionPanel\">
			      <div class=\"AccordionPanelTab\"><strong>First Name: " . $fname . "</strong></div><div class=\"AccordionPanelContent\">";
			  	$sql = mysql_query("SELECT * FROM players WHERE fname LIKE '" . $fname . "%" . "'");
				$count = 0;
				while($runame = mysql_fetch_array($sql))
				{
					echo "<strong><a href='player.php?pid=" . $runame['ID'] . "'>" . $runame['fname'] . " " . $runame['lname'] . "</a></strong><br />";
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
			  	$sql = mysql_query("SELECT * FROM players WHERE lname LIKE '" . $lname . "%" . "'");
				$count = 0;
				while($runame = mysql_fetch_array($sql))
				{
					echo "<strong><a href='player.php?pid=" . $runame['ID'] . "'>" . $runame['fname'] . " " . $runame['lname'] . "</a></strong><br />";
					++$count;
				}
				
				if($count == 0)
					echo "No results found...<br />";
				echo "</div></div>";
			  }
			  
			  if(!empty($number) && $number >=0 && $number < 100)
			  {
			  	echo "<div class=\"AccordionPanel\">
			      <div class=\"AccordionPanelTab\"><strong>Number: " . $number . "</strong></div><div class=\"AccordionPanelContent\">";
			  	$sql = mysql_query("SELECT * FROM players WHERE number ='" . $number . "'");
				$count = 0;
				while($runame = mysql_fetch_array($sql))
				{
					echo "<strong><a href='player.php?pid=" . $runame['ID'] . "'>" . $runame['fname'] . " " . $runame['lname'] . "</a></strong><br />";
					++$count;
				}
				
				if($count == 0)
					echo "No results found...<br />";
				echo "</div></div>";
			  }
		  ?>
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
<script type="text/javascript">
Cufon.now();
var Accordion1 = new Spry.Widget.Accordion("Accordion1");
</script>
</body>
</html>
<?php
}

else if($count == 0)
{
	// Player search
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
        <h2>Player Search</h2>
			<p class="color1">Search for players by name or number.</p><br />
            <form action="player.php" method="post" name="search">
            <input type="hidden" name="handle" id="handle" value="search" />
            First Name:<br />
            <input type="text" name="fname" id="fname" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
            Last Name:<br />
            <input type="text" name="lname" id="lname" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
            Number:<br />
            <input type="text" name="number" id="number" maxlength="2" style="border:solid;border-color:#CCCCCC;border-width:1px; width: 30px;" /><br /><br />
            <input type="submit" value="Search" style="border:solid;border-color:#CCCCCC;border-width:1px;" />
            </form>
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
        <table border="none" width="100%">
        <tr>
        <td>
        <?php if(file_exists("images/players/p_" . $pid . ".png")) {echo "<img src=\"images/players/p_" . $pid . ".png\" />";} else {echo "<img src=\"images/players/noprof.png\" />";} ?>
        </td>
        <td style="vertical-align:middle;">
        <h2><?php echo $player['fname'] . " " . $player['lname']; ?></h2>
        </td>
        </tr>
        </table><br />
			<div class="pad_1">
            <div class="wrapper">
            <strong>Lifetime Goals:</strong> <?php echo $player['tgoals']; ?><br /><br />
            <strong>Lifetime Assists:</strong> <?php echo $player['tassists']; ?><br /><br />
            <strong>Lifetime Ds:</strong> <?php echo $player['tds']; ?><br /><br />
            <strong>Lifetime Turns:</strong> <?php echo $player['tturns']; ?><br /><br />
            <strong>Avg. Fantasy Pts. per Game:</strong> <?php echo number_format((intval($player['tgoals']) + intval($player['tassists']) + intval($player['tds']) - intval($player['tturns']))/intval($player['tgames']), 2); ?><br /><br />
            <strong>Goals per Game:</strong> <?php echo number_format(intval($player['tgoals'])/intval($player['tgames']), 2); ?><br /><br />
            <strong>Assists per Game:</strong> <?php echo number_format(intval($player['tassists'])/intval($player['tgames']), 2); ?><br /><br />
            <strong>Ds per Game:</strong> <?php echo number_format(intval($player['tds'])/intval($player['tgames']), 2); ?><br /><br />
            <strong>Turns per Game:</strong> <?php echo number_format(intval($player['tturns'])/intval($player['tgames']), 2); ?><br /><br />
            </div>
			</div>
		</article>
		<article class="col2 pad_left1">
        <?php
		$sql = mysql_query("SELECT * FROM teams");
		$steams = "Free Agent";
		$temp3 = strval($pid);
		$ts = array();
		while($temp = mysql_fetch_array($sql))
		{
			$temp2 = explode(",", $temp['players']);
			if(in_array($temp3, $temp2))
			{
				$ts[] = $temp['ID'];
				if($steams == "Free Agent")
					$steams = $temp['name'];
				else
					$steams .= ", " . $temp['name'];	
			}
		}
		?>
			<h2><?php echo $steams; ?></h2>
			<p class="color1"></p>
			<div class="marker">
				<div class="wrapper">
					<p class="pad_bot2"><strong>Current Season:</strong></p>
					<p class="pad_bot2">Goals: <?php echo $player['goals']; ?></p>
                    <p class="pad_bot2">Assists: <?php echo $player['assists']; ?></p>
                    <p class="pad_bot2">Ds: <?php echo $player['ds']; ?></p>
                    <p class="pad_bot2">Turns: <?php echo $player['turns']; ?></p>
				</div>
			</div>
            <br />
            <div class="marker">
				<div class="wrapper">
					<p class="pad_bot2"><strong>Current Games:</strong></p>
					<p class="pad_bot2">
					<?php
					$sql = mysql_query("SELECT * FROM games");
					$sgames = "This player is not currently participating in any active games.";
					while($temp = mysql_fetch_array($sql))
					{
						if((in_array($temp['ID1'], $ts) || in_array($temp['ID2'], $ts)) && !intval($temp['active']))
						{
							if($sgames == "This player is not currently participating in any active games.")
								$sgames = "<a href=\"challenge.php?gid=" . $temp['ID'] . "\">" . $temp['name'] . "</a>";
							else
								$sgames .= ", <a href=\"challenge.php?gid=" . $temp['ID'] . "\">" . $temp['name'] . "</a>";
						}
					}
					echo $sgames;
					?>
                    </p>
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
<?php
}

require_once("headers/close.php");
?>