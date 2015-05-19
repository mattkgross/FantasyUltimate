<?php
session_start();

require_once("headers/mysql.php");

if(!isset($_SESSION['ID']))
{
	header('Location: login.php');
	exit();
}
$ID = $_SESSION['ID'];

$sql = mysql_query("SELECT * FROM users WHERE ID='" . $ID . "'");
$user = mysql_fetch_array($sql);
$sql = mysql_query("SELECT * FROM user_data WHERE ID='" . $ID . "'");
$userd = mysql_fetch_array($sql);

$cid = stripslashes($_GET['cid']);
$sql = mysql_query("SELECT * FROM challenges WHERE ID='" . $cid . "'");
$chal = mysql_fetch_array($sql);

$temp = explode(",", $chal['noplayers']);
$valid = false;

foreach($temp as $t)
{
	if(intval($t) == intval($ID))
		$valid = true;
}

if(intval($chal['active']) == 1)
	$valid = false;

// boot if weren't invited or already in challenge and challenge hasn't started
//if(!$valid || !empty($userd['ppID']) || !empty($userd['npID']))
if(!$valid)
{
	header('Location: account.php');
	exit();
}

$handle = stripslashes($_POST['handle']);

$sql = mysql_query("SELECT * FROM games WHERE ID='" . $chal['gID'] . "'");
$game = mysql_fetch_array($sql);

$sql = mysql_query("SELECT * FROM teams WHERE ID='" . $game['ID1'] . "'");
$t1 = mysql_fetch_array($sql);

$sql = mysql_query("SELECT * FROM teams WHERE ID='" . $game['ID2'] . "'");
$t2 = mysql_fetch_array($sql);

$p1 = array();
$p2 = array();

$pl1 = explode(",", $t1['players']);
$pl2 = explode(",", $t2['players']);

foreach($pl1 as $p)
{
	$sql = mysql_query("SELECT * FROM players WHERE ID='" . $p . "'");
	$p1[] = mysql_fetch_array($sql);
}
foreach($pl2 as $p)
{
	$sql = mysql_query("SELECT * FROM players WHERE ID='" . $p . "'");
	$p2[] = mysql_fetch_array($sql);
}

if(count(explode(",", $chal['participants'])) == 7)
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
			<h2>Too Late!</h2>
            Unfortunately, the maximum of seven particpants for this challenge has already been reached. Create your own challenge <a href="challenge.php">here</a>.
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

else if($handle == "select")
{
	// check for repeats and then record into cid, np and pp (in draft) and move from noplay to participant
	$pp = $_POST['pp'];
	$np = $_POST['np'];
	
	// No duplicates, I say!
	if(count(array_unique($pp)) < 7 || count(array_unique($np)) < 7)
	{
		header('Location: choose.php?cid=' . $cid . '&error=dup');
		exit();
	}
	
	$pps = "";
	foreach($pp as $p)
	{
		$pps .= $p . ",";
	}
	$pps = substr($pps, 0, -1);
	
	$nps = "";
	foreach($np as $n)
	{
		$nps .= $n . ",";
	}
	$nps = substr($nps, 0, -1);
	
	$sql = mysql_query("SELECT * FROM draft WHERE pid='" . $ID . "'");
	if(mysql_num_rows($sql) > 0)
	{
		mysql_query("UPDATE draft SET ppID='" . $pps . "' WHERE pid='" . $ID . "'");
		mysql_query("UPDATE draft SET npID='" . $nps . "' WHERE pid='" . $ID . "'");
	}
	else
	{
		mysql_query("INSERT INTO draft (pid, ppID, npID) VALUES ('" . $ID . "', '" . $pps . "', '" . $nps . "')");
		$sql = mysql_query("SELECT * FROM challenges WHERE ID='" . $cid . "'");
		$temp = mysql_fetch_array($sql);
		$yes = $temp['participants'];
		if(strlen($yes) > 0)
			$yes .= "," . $ID;
		else
			$yes = $ID;
		mysql_query("UPDATE challenges SET participants='" . $yes . "' WHERE ID='" . $cid . "'");
		$sql = mysql_query("SELECT * FROM challenges WHERE ID='" . $cid . "'");
		$temp = mysql_fetch_array($sql);
		$no = explode(",", $temp['noplayers']);
		$non = "";
		foreach($no as $n)
		{
			if(intval($n) != intval($ID))
				$non .= $n . ",";
		}
		$non = substr($non, 0, -1);
		mysql_query("UPDATE challenges SET noplayers='" . $non . "' WHERE ID='" . $cid . "'");
	}
	
	header('Location: account.php?error=success');
	exit();
}

else if($handle == "step2")
{
	$pp = $_POST['pp'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
require("headers/header.php");

if(stripslashes($_GET['error']) == "dup")
	echo "<script>alert('Duplicate picks found! Try again.');</script>";
?>
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
			<h2>Make Your Picks</h2>
            <p class="color1">It's time to draft your players. Make sure not to have any duplicates. Let's see what you've got.</p>
            <form action="choose.php?cid=<?php echo $cid; ?>" method="post">
            <input type="hidden" name="handle" id="handle" value="select" />
            <?php
			foreach($pp as $p)
			{
				echo "<input type=\"hidden\" name=\"pp[]\" id=\"pp[]\" value=\"" . $p . "\" />";
			}
			?>
            <center>
            <table>
            <tr>
            <td>
            <center>&nbsp;&nbsp;&nbsp;&nbsp;<strong>Negative Picks</strong></center>
            </td>
            </tr>
            <?php			
			for($i = 1; $i < 8; $i++)
			{
				echo "<tr>";
				$temp2 = "<select name=\"np[]\" id=\"np[]\"><option disabled><strong>" . $t1['name'] ."</strong></option>";
				foreach($p1 as $p)
				{
					if(!in_array($p['ID'], $pp))
						$temp2 .= "<option value=\"" . $p['ID'] . "\">" . $p['fname'] . " " . $p['lname'] . "</option>";	
				}
				$temp2 .= "<option disabled><strong>" . $t2['name'] ."</strong></option>";
				foreach($p2 as $p)
				{
					if(!in_array($p['ID'], $pp))
						$temp2 .= "<option value=\"" . $p['ID'] . "\">" . $p['fname'] . " " . $p['lname'] . "</option>";	
				}
				$temp2 .= "</select>";
				echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;" . $temp2 . "</td></tr>";
			}
			?>
            <tr>
            <td colspan="2">
            <br /><center><input type="submit" style="border:solid;border-color:#CCCCCC;border-width:1px;" value="Draft 'Em" /></center>
            </td>
            </tr>
            </table>
            </center>
            </form>
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
	mysql_query("UPDATE user_data SET cID='" . $cid . "' WHERE ID='" . $ID . "'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
require("headers/header.php");

if(stripslashes($_GET['error']) == "dup")
	echo "<script>alert('Duplicate picks found! Try again.');</script>";
?>
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
			<h2>Make Your Picks</h2>
            <p class="color1">It's time to draft your players. Make sure not to have any duplicates. Let's see what you've got.</p>
            <form action="choose.php?cid=<?php echo $cid; ?>" method="post">
            <input type="hidden" name="handle" id="handle" value="step2" />
            <center>
            <table>
            <tr>
            <td>
            <center><strong>Positive Picks</strong>&nbsp;&nbsp;&nbsp;&nbsp;</center>
            </td>
            </tr>
            <?php			
			for($i = 1; $i < 8; $i++)
			{
				echo "<tr>";
				$temp1 = $i . ") <select name=\"pp[]\" id=\"pp[]\"><option disabled><strong>" . $t1['name'] ."</strong></option>";
				foreach($p1 as $p)
				{
					$temp1 .= "<option value=\"" . $p['ID'] . "\">" . $p['fname'] . " " . $p['lname'] . "</option>";	
				}
				$temp1 .= "<option disabled><strong>" . $t2['name'] ."</strong></option>";
				foreach($p2 as $p)
				{
					$temp1 .= "<option value=\"" . $p['ID'] . "\">" . $p['fname'] . " " . $p['lname'] . "</option>";	
				}
				$temp1 .= "</select>";
				echo "<td>" . $temp1 . "&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>";
			}
			?>
            <tr>
            <td colspan="2">
            <br /><center><input type="submit" style="border:solid;border-color:#CCCCCC;border-width:1px;" value="Draft 'Em" /></center>
            </td>
            </tr>
            </table>
            </center>
            </form>
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