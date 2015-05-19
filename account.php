<?php
session_start();

require_once("headers/mysql.php");

$SID = $_SESSION['ID'];

if(!isset($_SESSION['ID']) || empty($SID))
{
	session_destroy();
	header('Location: login.php');
}

else
{	
	$sql = mysql_query("SELECT * FROM users WHERE ID='" . $SID . "'");
	$user = mysql_fetch_array($sql);
	$sql = mysql_query("SELECT * FROM user_data WHERE ID='" . $SID . "'");
	$stats = mysql_fetch_array($sql);
	
	$type = stripslashes($_POST['type']);
	
	if($type == "basic")
	{
		$email = stripslashes($_POST['email']);
		$opword = stripslashes($_POST['opword']);
		$npword = stripslashes($_POST['npword']);
		$cpword = stripslashes($_POST['cpword']);
		
		if($email != $user['email'] && !empty($email) && preg_match("/^[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i", $email))
		{
			mysql_query("UPDATE users SET email='" . $email . "' WHERE ID='" . $SID . "'");
			mysql_query("UPDATE users SET valid='0' WHERE ID='" . $SID . "'");
			echo "<script type='text/javascript'>alert('You have successfully changed your email. You must now reactivate your account. Please check the email that you just entered for your activation link.');</script>";
			$message = "We have indications that you have changed the email address associated with your account. For this reason, we need you to confirm your account with the new address. To confirm your account, simply click on the link below:\n\nhttp://www.mattkgross.com/ulti/validate.php?uname=". $user['uname'] . " \n\nIf you have received this email through error, please let us know!\n\nWelcome to the team,\nFantasy Ultimate Team";				
			$headers = 'From: ' . "ulti@mattkgross.com" . "\r\n".
			'Reply-To: '. "ulti@mattkgross.com" ."\r\n" .
			'X-Mailer: PHP/' . phpversion();
			mail($email, "Fantasy Ultimate - Confirm Your Account", $message, $headers);
			header('Location: login.php?error=out');
		}
		
		if(strlen($npword) >= 7 && $npword == $cpword && md5($opword) == $user['password'] && md5($npword) != $user['password'])
		{
			mysql_query("UPDATE users SET password='" . md5($npword) . "' WHERE ID='" . $SID . "'");
			echo "<script type='text/javascript'>alert('You have successfully changed your password.');</script>";
			header('Location: account.php');
		}
	}
	
	else if($type == "personal")
	{
		$team = stripslashes($_POST['team']);
		$player = stripslashes($_POST['player']);
		$about = stripslashes($_POST['about']);
		
		if($team != $stats['favteam'])
		{
			mysql_query("UPDATE user_data SET favteam='" . addslashes($team) . "' WHERE ID='" . $SID . "'");
		}
		
		if($player != $stats['favplayer'])
		{
			mysql_query("UPDATE user_data SET favplayer='" . addslashes($player) . "' WHERE ID='" . $SID . "'");
		}
		
		if($about != $stats['about'])
		{
			mysql_query("UPDATE user_data SET about='" . addslashes($about) . "' WHERE ID='" . $SID . "'");
		}
		
		header('Location: account.php');
	}
	
	else if($type == "notifications")
	{
		$invitemail = stripslashes($_POST['invitemail']);
		if($invitemail == "yes")
			mysql_query("UPDATE users SET invite='1' WHERE ID='" . $SID . "'");
		else
			mysql_query("UPDATE users SET invite='0' WHERE ID='" . $SID . "'");
			
		header('Location: account.php');
	}
	
	else
	{	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php require("headers/header.php"); ?>
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script src="SpryAssets/SpryAccordion.js" type="text/javascript"></script>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<?php
if(stripslashes($_GET['error']) == "success")
	echo "<script>alert('Boom. Draft choices successfully registered. Check back once the draft closes to see who you got.');</script>";
else if(stripslashes($_GET['error']) == "cancel")
	echo "<script>alert('You have successfully unenrolled from your current challenge.');</script>";
else if(stripslashes($_GET['error']) == "already")
	echo "<script>alert('You are already enrolled in a challenge!');</script>";
?>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css">

<link href="SpryAssets/SpryAccordion.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
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
							<li><a href="search.php">Search</a></li>
							<li><a href="login.php?error=out">Logout</a></li>
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
		<h2>Account</h2>
        <div id="TabbedPanels1" class="TabbedPanels">
          <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab" tabindex="0">Information</li>
            <li class="TabbedPanelsTab" tabindex="0">Challenges</li>
            <li class="TabbedPanelsTab" tabindex="0">Friends</li>
            <li class="TabbedPanelsTab" tabindex="0">Invites <?php 
				$sql = mysql_query("SELECT * FROM challenges");
				$count = 0;
				while($chals = mysql_fetch_array($sql))
				{
					$trys = explode(",", $chals['noplayers']);
					foreach($trys as $t)
					{
						if(intval($t) == intval($SID))
							$count++;
					}
				}
				echo "(" . $count . ")";
			?></li>
            <li class="TabbedPanelsTab" tabindex="0">Edit</li>
          </ul>
          <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">
            <br />
            <p class="color1"><strong>Favorite Team:</strong> <?php echo stripslashes($stats['favteam']); ?></p>
            <p class="color1"><strong>Favorite Player:</strong> <?php echo stripslashes($stats['favplayer']); ?></p>
            <p class="color1"><strong>About:</strong> <?php echo stripslashes($stats['about']); ?></p>
            <p class="color1"><strong>Public Profile:</strong> <?php $url = "http://www.mattkgross.com/ulti/profile.php?prof=" . $user['uname'];echo "<a href=\"" . $url . "\">" . $url . "</a>";  ?></p>
            <p class="color1"><strong>Join Date:</strong> <?php echo date("F j, Y, g:i a T", strtotime($stats['joindate'])); ?></p>
            </div>
            <div class="TabbedPanelsContent">
            <br />
            <?php
			if(!empty($stats['cID']))
			{
				$cid = $stats['cID'];
				$sql = mysql_query("SELECT * FROM challenges WHERE ID='" . $cid . "'");
				$temp = mysql_fetch_array($sql);
				if(intval($temp['active']) == 0)
				{
					echo "<a href=\"cancel.php?cid=" . $cid . "\"><img src=\"images/vs.png\" style=\"border: solid; border-width: thin; border-color:#999999\" /></a><br /><br />";
				}
				$sql = mysql_query("SELECT * FROM challenges WHERE ID='" . $cid . "'");
				$chal = mysql_fetch_array($sql);
				$gid = $chal['gID'];
				$sql = mysql_query("SELECT * FROM games WHERE ID='". $gid . "'");
				$game = mysql_fetch_array($sql);
				echo "<strong>Name:</strong> " . $game['name'] . "<br /><br />";
				$sql = mysql_query("SELECT * FROM users WHERE ID='". $chal['organizer'] . "'");
				$temp = mysql_fetch_array($sql);
				echo "<strong>Organizer:</strong> " . $temp['fname'] . " " . $temp['lname'] . "<br /><br />";
				$temp = $chal['noplayers'];
				$noplay = explode(",", $temp);
				$output = "";
				foreach($noplay as $n)
				{
					$sql = mysql_query("SELECT * FROM users WHERE ID='" . $n . "'");
					$temp = mysql_fetch_array($sql);
					$output .= "<a href=\"profile.php?prof=" . $temp['uname'] . "\">" . $temp['fname'] . " " . $temp['lname'] . "</a>, ";
				}
				$output = substr($output, 0, -2);
				echo "<strong>Invited:</strong> " . $output . "<br /><br />";
				$temp = $chal['participants'];
				$partic = explode(",", $temp);
				$output = "";
				foreach($partic as $p)
				{
					$sql = mysql_query("SELECT * FROM users WHERE ID='" . $p . "'");
					$temp = mysql_fetch_array($sql);
					$output .= "<a href=\"profile.php?prof=" . $temp['uname'] . "\">" . $temp['fname'] . " " . $temp['lname'] . "</a>, ";
				}
				$output = substr($output, 0, -2);
				echo "<strong>Confirmed:</strong> " . $output . "<br /><br />";
				
				if(!empty($stats['ppID']) && !empty($stats['npID']))
				{
					$sql = mysql_query("SELECT * FROM players WHERE ID='" . $stats['ppID'] . "'");
					$temp = mysql_fetch_array($sql);
					$pp = $temp['fname'] . " " . $temp['lname'];
					$sql = mysql_query("SELECT * FROM players WHERE ID='" . $stats['npID'] . "'");
					$temp = mysql_fetch_array($sql);
					$np = $temp['fname'] . " " . $temp['lname'];
					echo "<strong>Your Positive:</strong> <a href=\"player.php?pid=" . $stats['ppID'] . "\">" . $pp . "</a><br /><br /><strong>Your Negative:</strong> <a href=\"player.php?pid=" . $stats['npID'] . "\">" . $np . "</a><br /><br />";
					echo "<a href=\"chal.php?cid=" . $chal['ID'] . "\">Go to Challenge</a>";
				}
				else
				{
					echo "Draft in progress...<br /><br /><strong>Current Draft:</strong><br />";
					$sql = mysql_query("SELECT * FROM draft WHERE pid='" . $SID . "'");
					$temp = mysql_fetch_array($sql);
					$pps = explode(",", $temp['ppID']);
					$nps = explode(",", $temp['npID']);
					if(count($pps) == 7 && count($nps) == 7)
					{
					?>
                    <center>
                    <table>
                    <tr>
                    <td>
                    <center><strong>Positive Picks</strong>&nbsp;&nbsp;&nbsp;&nbsp;</center>
                    </td>
                    <td>
                    <center>&nbsp;&nbsp;&nbsp;&nbsp;<strong>Negative Picks</strong></center>
                    </td>
                    </tr>
                    <?php		
                    for($i = 0; $i < 7; $i++)
                    {
                        echo "<tr>";
                        $temp1 = $i+1 . ") ";
                        $sql = mysql_query("SELECT * FROM players WHERE ID='" . $pps[$i] . "'");
						$temp = mysql_fetch_array($sql);
						$temp1 .= "<a href=\"player.php?pid=" . $pps[$i] . "\">" . $temp['fname'] . " " . $temp['lname'] . "</a>";
                        echo "<td>" . $temp1 . "&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                        $temp2 = "";
                        $sql = mysql_query("SELECT * FROM players WHERE ID='" . $nps[$i] . "'");
						$temp = mysql_fetch_array($sql);
						$temp2 .= "<a href=\"player.php?pid=" . $nps[$i] . "\">" . $temp['fname'] . " " . $temp['lname'] . "</a>";
                        echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;" . $temp2 . "</td>";
                        echo "</tr>";
                    }
                    ?>
                    </table>
                    </center>
                    <?php
					}
					else
					{
						$sql = mysql_fetch_array(mysql_query("SELECT * FROM user_data WHERE ID='" . $SID . "'"));
						echo "You have not yet completed your draft. To do so, go <a href=\"choose.php?cid=" . $sql['cID'] . "\">here</a>.";
					}
				}
			}
			
			else
			{
				echo "You are not currently enrolled in a challenge. <a href=\"games.php\">Challenge friends now</a>.";
			}
			?>
            </div>
            <div class="TabbedPanelsContent">
            <br />
            <?php
			$sql = mysql_query("SELECT * FROM friends WHERE ID='" . $ID . "'");
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
            <div class="TabbedPanelsContent">
            <br />
            <?php
				$cids = array();
				$gids = array();
				$oids = array();
				$sql = mysql_query("SELECT * FROM challenges");
				while($chals = mysql_fetch_array($sql))
				{
					$trys = explode(",", $chals['noplayers']);
					foreach($trys as $t)
					{
						if(intval($t) == intval($SID))
						{
							$cids[] = $chals['ID'];
							$gids[] = $chals['gID'];
							$oids[] = $chals['organizer'];
						}
					}
				}
				
				for($i = 0; $i < count($cids); $i++)
				{
					$sql = mysql_query("SELECT * FROM games WHERE ID='" . $gids[$i] . "'");
					$temp = mysql_fetch_array($sql);
					$gamen = $temp['name'];
					$sql = mysql_query("SELECT * FROM users WHERE ID='" . $oids[$i] . "'");
					$temp = mysql_fetch_array($sql);
					$playn = $temp['fname'] . " " . $temp['lname'];
					echo $i+1 . ") <a href=\"choose.php?cid=" . $cids[$i] . "\"><span style=\"font-style:italic;\">" . $gamen . "</span></a>, by " . $playn . "<br />";
				}
			?>
            </div>
            <div class="TabbedPanelsContent">
            <br />
            <div id="Accordion1" class="Accordion" tabindex="0">
              <div class="AccordionPanel">
                <div class="AccordionPanelTab"><strong>Basic</strong></div>
                <div class="AccordionPanelContent">
                <form name="basic" action="account.php" method="post">
                <input type="hidden" name="type" id="type" value="basic" />
                Username:<br />
                <input type="text" disabled value="<?php echo $user['uname']; ?>" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                Name:<br />
                <input type="text" disabled value="<?php echo $user['fname'] . " " . $user['lname']; ?>" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                Email:<br />
                <input type="text" name="email" id="email" value="<?php echo $user['email']; ?>" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                Old Password:<br />
                <input type="password" name="opword" id="opword" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                New Password:<br />
                <input type="password" name="npword" id="npword" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                Confirm Password:<br />
                <input type="password" name="cpword" id="cpword" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                <input type="submit" value="Save" style="border:solid;border-color:#CCCCCC;border-width:1px;" />
                </form>
                </div>
              </div>
              <div class="AccordionPanel">
                <div class="AccordionPanelTab"><strong>Personal</strong></div>
                <div class="AccordionPanelContent">
                <form name="personal" action="account.php" method="post">
                <input type="hidden" name="type" id="type" value="personal" />
                Favorite Team:<br />
                <input type="text" name="team" id="team" value="<?php echo stripslashes($stats['favteam']); ?>" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                Favorite Player:<br />
                <input type="text" name="player" id="player" value="<?php echo stripslashes($stats['favplayer']); ?>" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                About Me:<br />
                <textarea style="border:solid;border-color:#CCCCCC;border-width:1px;" cols="60" rows="10" name="about" id="about"><?php echo stripslashes($stats['about']); ?></textarea><br /><br />
                <input type="submit" value="Save" style="border:solid;border-color:#CCCCCC;border-width:1px;" />
                </form>
                </div>
              </div>
               <div class="AccordionPanel">
                <div class="AccordionPanelTab"><strong>Notifications</strong></div>
                <div class="AccordionPanelContent">
                <form name="notifications" action="account.php" method="post">
                <input type="hidden" name="type" id="type" value="notifications" />
                <input type="checkbox" <?php if($user['invite']) {echo "checked";} ?> name="invitemail" id="invitemail" value="yes" /> Enable Emails<br /><br />
                <input type="submit" value="Save" style="border:solid;border-color:#CCCCCC;border-width:1px;" />
                </form>
                </div>
              </div>
            </div>
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
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
var Accordion1 = new Spry.Widget.Accordion("Accordion1");
</script>
</body>
</html>
<?php
	}
}

require_once("headers/close.php");
?>