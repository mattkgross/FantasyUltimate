<?php
session_start();

require_once("headers/mysql.php");

$ID = $_SESSION['ID'];

$cid = stripslashes($_GET['cid']);
if(empty($cid))
{
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
}

$stats = mysql_fetch_array(mysql_query("SELECT * FROM user_data WHERE ID='" . $ID . "'"));

$sql = mysql_query("SELECT * FROM challenges WHERE ID='" . $cid . "'");
$count = mysql_num_rows($sql);
$chal = mysql_fetch_array($sql);

if($count == 0 || intval($chal['active']) == 0)
{
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
}

$sql = mysql_query("SELECT * FROM games WHERE ID='" . $chal['gID'] . "'");
$game = mysql_fetch_array($sql);

$pids = explode(",", $chal['participants']);

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
			<h2><?php echo $game['name']; ?></h2>
            <?php
			$ps = array();
			foreach($pids as $p)
			  {
					$sql = mysql_query("SELECT * FROM user_data WHERE ID='" . $p . "'");
					$temp = mysql_fetch_array($sql);
					$pp = mysql_fetch_array(mysql_query("SELECT * FROM players WHERE ID='" . $temp['ppID'] . "'"));
					$np = mysql_fetch_array(mysql_query("SELECT * FROM players WHERE ID='" . $temp['npID'] . "'"));
					$ps[] = (intval($pp['goals']) + intval($pp['assists']) + intval($pp['ds']) - intval($pp['turns'])) + (intval($np['turns']) - intval($np['goals']) - intval($np['assists']) - intval($np['ds']));
			  }
			  
			  $keep = 0;
			  $big = $ps[0];
			  for($i = 1; $i < count($ps); $i++)
			  {
				  if($ps[$i] > $big)
				  {
				  	$big = $ps[$i];
					$keep = $i;
				  }
			  }
			  
			  $lose = 0;
			  $small = $ps[0];
			  for($i = 1; $i < count($ps); $i++)
			  {
				  if($ps[$i] < $small)
				  {
				  	$small = $ps[$i];
					$lose = $i;
				  }
			  }
			?>
			<span style="font-style:italic;">Organized by:</span> <?php $org = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE ID='" . $chal['organizer'] . "'")); echo $org['fname'] . " " . $org['lname']; ?><br /><br />
            <span style="font-style:italic;">Current Leader:</span> <?php $temp = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE ID='" . $pids[$keep] . "'")); echo $temp['fname'] . " " . $temp['lname']; ?><br /><br />
            <span style="font-style:italic;">Current Last:</span> <?php $temp = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE ID='" . $pids[$lose] . "'")); echo $temp['fname'] . " " . $temp['lname']; ?><br /><br />
 			 <div id="TabbedPanels1" class="TabbedPanels">
              <ul class="TabbedPanelsTabGroup">
              <?php
			  $i = 0;
			  foreach($pids as $p)
			  {
					$sql = mysql_query("SELECT * FROM users WHERE ID='" . $p . "'");
					$temp = mysql_fetch_array($sql);
					echo "<li class=\"TabbedPanelsTab\" tabindex=\"0\">" . $temp['fname'] . " (" . $ps[$i++] . ")</li>";
			  }
              ?>
              </ul>
              <div class="TabbedPanelsContentGroup">
              <?php
			  foreach($pids as $p)
			  {
					$sql = mysql_query("SELECT * FROM user_data WHERE ID='" . $p . "'");
					$temp = mysql_fetch_array($sql);
					$pp = mysql_fetch_array(mysql_query("SELECT * FROM players WHERE ID='" . $temp['ppID'] . "'"));
					$np = mysql_fetch_array(mysql_query("SELECT * FROM players WHERE ID='" . $temp['npID'] . "'"));
					echo "<div class=\"TabbedPanelsContent\"><br />";
					?>
                      <table style="border-style:solid; border-color:#f4f4f4; border-width:medium;">
                      <tr>
                      <td></td>
                      <td style="border-style:dashed; border-color:#999; border-width:thin;">
                      <strong>&nbsp;&nbsp;Goals&nbsp;&nbsp;</strong>
                      </td>
                      <td style="border-style:dashed; border-color:#999; border-width:thin;">
                      <strong>&nbsp;&nbsp;Assists&nbsp;&nbsp;</strong>
                      </td>
                      <td style="border-style:dashed; border-color:#999; border-width:thin;">
                      <strong>&nbsp;&nbsp;Ds&nbsp;&nbsp;</strong>
                      </td>
                      <td style="border-style:dashed; border-color:#999; border-width:thin;">
                      <strong>&nbsp;&nbsp;Turns&nbsp;&nbsp;</strong>
                      </td>
                      <td style="border-style:dashed; border-color:#999; border-width:thin;">
                      <strong>&nbsp;&nbsp;Points&nbsp;&nbsp;</strong>
                      </td>
                      </tr>
                      <tr>
                      <td style="border-style:dashed; border-color:#999; border-width:thin;">
                      <strong>Positive:</strong> <?php echo $pp['fname'] . " " . $pp['lname'] . "&nbsp;&nbsp;"; ?>
                      </td>
                      <td style="border-style:dashed; border-color:#999; border-width:thin;">
                      <center><?php echo $pp['goals']; ?></center>
                      </td>
                      <td style="border-style:dashed; border-color:#999; border-width:thin;">
                      <center><?php echo $pp['assists']; ?></center>
                      </td>
                      <td style="border-style:dashed; border-color:#999; border-width:thin;">
                      <center><?php echo $pp['ds']; ?></center>
                      </td>
                      <td style="border-style:dashed; border-color:#999; border-width:thin;">
                      <center><?php echo $pp['turns']; ?></center>
                      </td>
                      <td style="border-style:dashed; border-color:#999; border-width:thin;">
                      <center><?php echo (intval($pp['goals']) + intval($pp['assists']) + intval($pp['ds']) - intval($pp['turns'])); ?></center>
                      </td>
                      </tr>
                      <tr>
                      <td style="border-style:dashed; border-color:#999; border-width:thin;">
                      <strong>Negative:</strong> <?php echo $np['fname'] . " " . $np['lname'] . "&nbsp;&nbsp;"; ?>
                      </td>
                      <td style="border-style:dashed; border-color:#999; border-width:thin;">
                      <center><?php echo $np['goals']; ?></center>
                      </td>
                      <td style="border-style:dashed; border-color:#999; border-width:thin;">
                      <center><?php echo $np['assists']; ?></center>
                      </td>
                      <td style="border-style:dashed; border-color:#999; border-width:thin;">
                      <center><?php echo $np['ds']; ?></center>
                      </td>
                      <td style="border-style:dashed; border-color:#999; border-width:thin;">
                      <center><?php echo $np['turns']; ?></center>
                      </td>
                      <td style="border-style:dashed; border-color:#999; border-width:thin;">
                      <center><?php echo (intval($np['turns']) - intval($np['goals']) - intval($np['assists']) - intval($np['ds'])); ?></center>
                      </td>
                      </tr>
                      </table>
                    <?php
					echo "</div>";
			  }
			  ?>
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
<script type="text/javascript">
Cufon.now();
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
</script>
</body>
</html>
<?php
require_once("headers/close.php");
?>