<?php
session_start();

require_once("headers/mysql.php");

$target = stripslashes($_GET['prof']);
$ID = $_SESSION['ID'];

$sql = mysql_query("SELECT * FROM users WHERE uname='" . $target . "'");
$prof = mysql_fetch_array($sql);
$result = mysql_num_rows($sql);
$sql = mysql_query("SELECT * FROM user_data WHERE ID='" . $prof['ID'] . "'");
$prof2 = mysql_fetch_array($sql);

if(empty($target) || $result == 0)
	header('Location: account.php');
	
else
{
	$sql = mysql_query("SELECT * FROM users WHERE uname='" . $_GET['prof'] . "'");
	$temp = mysql_fetch_array($sql);
	$friendID = $temp['ID'];
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
            <?php
				if(substr($prof['fname'], -1) == "s")
					$s = "'";
				else
					$s = "'s";
			?>
				<h2><?php echo $prof['fname'] . $s; ?> Stats</h2>
				<div class="wrapper">
                Fantasy EXP: <?php echo $prof2['exp']; ?><br /><br />
                Games Played: <?php echo $prof2['games']; ?><br /><br />
                Total Points Earned: <?php echo $prof2['totalpoints']; ?><br /><br />
                Rank: <?php $sql = mysql_query("SELECT * FROM user_data WHERE exp>" . $prof2['exp']); echo mysql_num_rows($sql) + 1; ?> of <?php $sql = mysql_query("SELECT * FROM user_data"); echo mysql_num_rows($sql); ?><br /><br />
                </div>
            </div>
		</article>
		<article class="col2 pad_left1">
		  <h2><?php echo $prof['fname'] . " " . $prof['lname']; ?></h2>
          <?php
		  if(isset($_SESSION['ID']))
		  {
		  	$sql = mysql_query("SELECT * FROM friends WHERE ID='" . $ID . "'");
			$temp = mysql_fetch_array($sql);
			$friends = $temp['friends'];
			
			$aref = false;
			
			if(!empty($friends))
			{
				$farray = explode(",", $friends);			
				for($i = 0; $i < count($farray); ++$i)
				{
					if($farray[$i] == $friendID)
						$aref = true;
				}
			}
			
			if((empty($friends) || (!$aref)) && ($friendID != $ID))
			{
				$_SESSION['friendID'] = $friendID;
				echo "<a href=\"add.php\"><img src=\"images/add.png\" style=\"border: solid; border-width: thin; border-color:#999999\" /></a><br /><br />";
			}
			
			/*
			if($aref)
			{
				$_SESSION['friendID'] = $friendID;
				echo "<a href=\"challenge.php\"><img src=\"images/vs.png\" style=\"border: solid; border-width: thin; border-color:#999999\" /></a><br /><br />";
			}
			*/
		  }
		  ?>
		  <div id="TabbedPanels1" class="TabbedPanels">
			  <ul class="TabbedPanelsTabGroup">
			    <li class="TabbedPanelsTab" tabindex="0">Information</li>
			    <li class="TabbedPanelsTab" tabindex="0">Friends</li>
		      </ul>
			  <div class="TabbedPanelsContentGroup">
			    <div class="TabbedPanelsContent">
                <br />
                <p class="color1"><strong>Favorite Team:</strong> <?php echo stripslashes($prof2['favteam']); ?></p>
                <p class="color1"><strong>Favorite Player:</strong> <?php echo stripslashes($prof2['favplayer']); ?></p>
                <p class="color1"><strong>About:</strong> <?php echo stripslashes($prof2['about']); ?></p>
                <p class="color1"><strong>Join Date:</strong> <?php echo date("F j, Y, g:i a T", strtotime($prof2['joindate'])); ?></p>
                </div>
			    <div class="TabbedPanelsContent">
                <br />
                <?php
				$sql = mysql_query("SELECT * FROM friends WHERE ID='" . $friendID . "'");
				$temp = mysql_fetch_array($sql);
				$friends = $temp['friends'];
				
				if(!empty($friends))
				{
					$farray = explode(",", $friends);			
					for($i = 0; $i < count($farray)-1; ++$i)
					{
						$sql = mysql_query("SELECT * FROM users WHERE ID='" . $farray[$i] . "'");
						$temp = mysql_fetch_array($sql);
						
						echo "<a href=\"profile.php?prof=" . $temp['uname'] . "\">" . $temp['fname'] . " " . $temp['lname'] . "</a>, ";
					}
					$sql = mysql_query("SELECT * FROM users WHERE ID='" . $farray[count($farray)-1] . "'");
					$temp = mysql_fetch_array($sql);
					echo "<a href=\"profile.php?prof=" . $temp['uname'] . "\">" . $temp['fname'] . " " . $temp['lname'] . "</a>";
				}
				else
				{
					echo "No friends yet!";
				}
				?>
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
}

require_once("headers/close.php");
?>