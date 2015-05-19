<?php
session_start();

$type = stripslashes($_GET['t']);
$handle = stripslashes($_POST['handle']);
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
<?php
if($handle == "v1")
{
	
?>
			<h2>Cover Letter Upload</h2>
			<form action="employ.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="handle" id="handle" value="v2" />
            <input type="hidden" name="fname" id="fname" value="<?php echo stripslashes($_POST['fname']); ?>" />
            <input type="hidden" name="lname" id="lname" value="<?php echo stripslashes($_POST['lname']); ?>" />
            <input type="hidden" name="email" id="email" value="<?php echo stripslashes($_POST['email']); ?>" />
            <input type="hidden" name="skills" id="skills" value="<?php echo stripslashes($_POST['skills']); ?>" />
            <input type="hidden" name="more" id="more" value="<?php echo stripslashes($_POST['more']); ?>" />
			If you like, you may upload a r&eacute;sum&eacute; or cover letter now (*.pdf only please, under 5 MB):<br />
            <input type="file" name="resume" id="resume" /><br /><br />
            <input type="submit" value="Continue" style="border:solid;border-color:#CCCCCC;border-width:1px;" />
            </form>
<?php
}

else if($handle == "v2")
{
	$fname = stripslashes($_POST['fname']);
	$lname = stripslashes($_POST['lname']);
	$email = stripslashes($_POST['email']);
	$skills = stripslashes($_POST['skills']);
	$more = stripslashes($_POST['more']);
	$loc = "None";
	$error = false;
	
	$allowedExts = array("pdf");
	$extension = end(explode(".", $_FILES["resume"]["name"]));
	if (($_FILES["resume"]["size"] <= 5120000) && in_array($extension, $allowedExts))
    {
    	if ($_FILES["resume"]["error"] > 0)
			$error = true;
		else
		{
			$temp = mysql_fetch_array(mysql_query("SELECT * FROM resume WHERE ID='1'"));
	
			if (file_exists("resume/resume_" . strval(intval($temp['resume'])) . ".pdf"))
				$error = true;
			else
			{
				move_uploaded_file($_FILES["resume"]["tmp_name"],	"resume/resume_" . strval(intval($temp['resume'])) . ".pdf");
				mysql_query("UPDATE resume SET resume='" . (intval($temp['resume'])+1) . "' WHERE ID='1'");
				$loc = "resume/resume_" . strval(intval($temp['resume'])) . ".pdf";
			}
		}
    }
	else
		$error = true;
		
	if($error)
	{
	?>
    <h2>Upload Error</h2>
    <p>Your submission could not be successfully processed. Please try again. If you continue to have this problem, then submit without attaching a cover letter and we will request it later via email. Thank you for your understanding.</p>
    <?php
	}
	else
	{
		$headers = "From: ulti@mattkgross.com\r\n";
		$headers .= "Reply-To: ulti@mattkgross.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		$message = "Name: $fname $lname<br />Email: $email<br />Listed Skills: $skills<br />Additional Info: $more<br />Cover Letter? $loc<br /><br /><span style=\"font-style:italic;\">Sent via automated web application system.</span>";
		 mail("ulti@mattkgross.com", "Volunteer Application", $message, $headers);
	?>
    <h2>Submission Successful</h2>
    <p>Thank you for your submission! We will contact you shortly if we feel that you qualify as a potential fit within our organization.</p>
    <?php
	}
}

else if($handle == "p1")
{
?>
	<h2>Cover Letter Upload</h2>
    <form action="employ.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="handle" id="handle" value="p2" />
    <input type="hidden" name="fname" id="fname" value="<?php echo stripslashes($_POST['fname']); ?>" />
    <input type="hidden" name="lname" id="lname" value="<?php echo stripslashes($_POST['lname']); ?>" />
    <input type="hidden" name="email" id="email" value="<?php echo stripslashes($_POST['email']); ?>" />
    <input type="hidden" name="skills" id="skills" value="<?php echo stripslashes($_POST['skills']); ?>" />
    <input type="hidden" name="more" id="more" value="<?php echo stripslashes($_POST['more']); ?>" />
    If you like, you may upload a r&eacute;sum&eacute; or cover letter now (*.pdf only please, under 5 MB):<br />
    <input type="file" name="resume" id="resume" /><br /><br />
    <input type="submit" value="Continue" style="border:solid;border-color:#CCCCCC;border-width:1px;" />
    </form>
<?php
}

else if($handle == "p2")
{
	$fname = stripslashes($_POST['fname']);
	$lname = stripslashes($_POST['lname']);
	$email = stripslashes($_POST['email']);
	$skills = stripslashes($_POST['skills']);
	$more = stripslashes($_POST['more']);
	$loc = "None";
	$error = false;
	
	$allowedExts = array("pdf");
	$extension = end(explode(".", $_FILES["resume"]["name"]));
	if (($_FILES["resume"]["size"] <= 5120000) && in_array($extension, $allowedExts))
    {
    	if ($_FILES["resume"]["error"] > 0)
			$error = true;
		else
		{
			$temp = mysql_fetch_array(mysql_query("SELECT * FROM resume WHERE ID='1'"));
	
			if (file_exists("resume/resume_" . strval(intval($temp['resume'])) . ".pdf"))
				$error = true;
			else
			{
				move_uploaded_file($_FILES["resume"]["tmp_name"],	"resume/resume_" . strval(intval($temp['resume'])) . ".pdf");
				mysql_query("UPDATE resume SET resume='" . (intval($temp['resume'])+1) . "' WHERE ID='1'");
				$loc = "resume/resume_" . strval(intval($temp['resume'])) . ".pdf";
			}
		}
    }
	else
		$error = true;
		
	if($error)
	{
	?>
    <h2>Upload Error</h2>
    <p>Your submission could not be successfully processed. Please try again. If you continue to have this problem, then submit without attaching a cover letter and we will request it later via email. Thank you for your understanding.</p>
    <?php
	}
	else
	{
		$headers = "From: ulti@mattkgross.com\r\n";
		$headers .= "Reply-To: ulti@mattkgross.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		$message = "Name: $fname $lname<br />Email: $email<br />Listed Skills: $skills<br />Additional Info: $more<br />Cover Letter? $loc<br /><br /><span style=\"font-style:italic;\">Sent via automated web application system.</span>";
		 mail("ulti@mattkgross.com", "Partnership Application", $message, $headers);
	?>
    <h2>Submission Successful</h2>
    <p>Thank you for your submission! We will contact you shortly if we feel that you qualify as a potential fit within our organization.</p>
    <?php
	}
}

else if($type == "v")
{
?>
			<h2>Volunteer Application</h2>
			<p class="color1">Fantasy Ultimate would like to thank you for your interest in volunteering. Please fill out the form below and we will contact you within the next week regarding this position.</p><br />
            <form action="employ.php" method="post" name="v">
            <input type="hidden" name="handle" id="handle" value="v1" />
            First Name:<br />
            <input type="text" name="fname" id="fname" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
            Last Name:<br />
            <input type="text" name="lname" id="lname" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
            Email:<br />
            <input type="text" name="email" id="email" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
            Please list any languages or skills that you have experience with that you feel may be pertinent to this position.<br />
            <textarea name="skills" id="skills" cols="40" rows="5" style="border:solid;border-color:#CCCCCC;border-width:1px;"></textarea><br /><br />
            Anything else we should know?<br />
            <textarea name="more" id="more" cols="40" rows="5" style="border:solid;border-color:#CCCCCC;border-width:1px;"></textarea><br /><br />
            <input type="submit" value="Submit Application" style="border:solid;border-color:#CCCCCC;border-width:1px;" />
            </form>
<?php
}

else if($type == "p")
{
?>
			<h2>Partnership Application</h2>
			<p class="color1">Fantasy Ultimate would like to thank you for your interest in becoming a partner. Please fill out the form below and we will contact you within the next week regarding this position.</p><br />
            <form action="employ.php" method="post" name="p">
            <input type="hidden" name="handle" id="handle" value="p1" />
            First Name:<br />
            <input type="text" name="fname" id="fname" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
            Last Name:<br />
            <input type="text" name="lname" id="lname" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
            Email:<br />
            <input type="text" name="email" id="email" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
            Please list any languages or skills that you have experience with that you feel may be pertinent to this position.<br />
            <textarea name="skills" id="skills" cols="40" rows="5" style="border:solid;border-color:#CCCCCC;border-width:1px;"></textarea><br /><br />
            Please list leadership skills as well as past experiences in design and production roles:<br />
            <textarea name="more" id="more" cols="40" rows="5" style="border:solid;border-color:#CCCCCC;border-width:1px;"></textarea><br /><br />
            <input type="submit" value="Submit Application" style="border:solid;border-color:#CCCCCC;border-width:1px;" />
            </form>
<?php
}
else
{
?>
			<h2>Employment</h2>
			<p class="color1">Fantasy Ultimate is a free service that enables users to connect to their favorite players and teams, view season and game statistics, and play friendly "fantasy" games against other players.</p>
			<div class="marker">
				<div class="wrapper">
					<p class="pad_bot2"><strong>Volunteering</strong></p>
					<p class="pad_bot2">Seeing as we are a free service without advertising, we encompass a non-profit setting. If you are interested in volunteering your efforts to help us improve and build upon our services, please let us know. We are always in need of more developers with knowledge in PHP, MySQL, C#, Ubuntu LTS, CSS, HTML, Javascript, and more.</p>
				</div>
			</div>
			<div class="wrapper pad_bot2"><a href="employ.php?t=v" class="button1">Volunteer</a></div>
			<div class="marker">
				<div class="wrapper">
					<p class="pad_bot2"><strong>Partnership</strong></p>
					<p class="pad_bot2">If you are interested in joining our small team as a fellow partner, please select this option. Responsibilities here include financial and business modeling, API and administrative development, desktop and mobile planning and implementation, as well as other administrative duties.</p>
				</div>
			</div>
			<div class="wrapper pad_bot2">
				<a href="employ.php?t=p" class="button1">Apply</a>
				<!--<a href="#" class="button2">Fleet</a>-->
			</div>
<?php
}
?>
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