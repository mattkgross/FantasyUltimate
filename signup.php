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
		$value = stripslashes($_POST['value']);
		if($value == "new")
		{			
			$uname = stripslashes($_POST['uname']);
			$fname = stripslashes($_POST['fname']);
			$lname = stripslashes($_POST['lname']);
			$email = stripslashes($_POST['email']);
			$econfirm = stripslashes($_POST['econfirm']);
			$pword = stripslashes($_POST['pword']);
			$pconfirm = stripslashes($_POST['pconfirm']);
			
			// prevent injection
			if(!get_magic_quotes_gpc())
			{
				$uname = mysql_real_escape_string($uname);	
				$fname = mysql_real_escape_string($fname);
				$lname = mysql_real_escape_string($lname);
				$email = mysql_real_escape_string($email);
				$econfirm = mysql_real_escape_string($econfirm);	
				$pword = mysql_real_escape_string($pword);
				$pconfirm = mysql_real_escape_string($pconfirm);
			}
			
			// search for username in datatbase, to make sure it doesn't already exist
			$sql = mysql_query("SELECT * FROM users WHERE uname='" . $uname . "'");
			$result = mysql_num_rows($sql);
			$sql = mysql_query("SELECT * FROM users WHERE email='" . $email . "'");
			$result2 = mysql_num_rows($sql);
			
			if(empty($uname) || empty($fname) || empty($lname) || empty($email) || empty($econfirm) || empty($pword) || empty($pconfirm))
			{
			?>
            	<h2>Error!</h2>
				<p class="color1">We require that you enter information into every field - they are all required!</p><br />
                <form action="signup.php" method="post">
                <input type="hidden" name="value" id="value" value="noinfo" />
                <input type="hidden" name="uname" id="uname" value="<?php echo $uname; ?>" />
                <input type="hidden" name="fname" id="fname" value="<?php echo $fname; ?>" />
                <input type="hidden" name="lname" id="lname" value="<?php echo $lname; ?>" />
                <input type="hidden" name="email" id="email" value="<?php echo $email; ?>" />
                <input type="hidden" name="econfirm" id="econfirm" value="<?php echo $econfirm; ?>" />
                <input type="submit" value="Try Again" style="border:solid;border-color:#CCCCCC;border-width:1px;">
                </form>
            <?php
			}
			
			else if(preg_match('/[^A-Za-z0-9]/', $uname))
			{
			?>
				<h2>Error!</h2>
				<p class="color1">The username you entered is invalid! Please enter a different username using only letters and numbers.</p><br />
                <form action="signup.php" method="post">
                <input type="hidden" name="value" id="value" value="new" />
                Username:<br />
                <input type="text" name="uname" id="uname" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                <input type="hidden" name="fname" id="fname" value="<?php echo $fname; ?>" />
                <input type="hidden" name="lname" id="lname" value="<?php echo $lname; ?>" />
                <input type="hidden" name="email" id="email" value="<?php echo $email; ?>" />
                <input type="hidden" name="econfirm" id="econfirm" value="<?php echo $econfirm; ?>" />
                Account Password:<br />
                <input type="password" name="pword" id="pword" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                Confirm Password:<br />
                <input type="password" name="pconfirm" id="pconfirm" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                <input type="submit" value="Try Again" style="border:solid;border-color:#CCCCCC;border-width:1px;">
                </form>
			<?php
            }
			
			else if($email != $econfirm)
			{
			?>
				<h2>Error!</h2>
				<p class="color1">Your emails don't match! Please provide a pair of matching emails.</p><br />
                <form action="signup.php" method="post">
                <input type="hidden" name="value" id="value" value="new" />
                <input type="hidden" name="uname" id="uname" value="<?php echo $uname; ?>" />
                <input type="hidden" name="fname" id="fname" value="<?php echo $fname; ?>" />
                <input type="hidden" name="lname" id="lname" value="<?php echo $lname; ?>" />
                Email Address:<br />
                <input type="text" name="email" id="email" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                Confirm Email:<br />
                <input type="text" name="econfirm" id="econfirm" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                Account Password:<br />
                <input type="password" name="pword" id="pword" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                Confirm Password:<br />
                <input type="password" name="pconfirm" id="pconfirm" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                <input type="submit" value="Try Again" style="border:solid;border-color:#CCCCCC;border-width:1px;">
                </form>
            <?php
			}
			
			else if(!preg_match("/^[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i", $email))
 			{
			?>
				<h2>Error!</h2>
				<p class="color1">Your email doesn't appear to be valid. Please enter a valid email address.</p><br />
                <form action="signup.php" method="post">
                <input type="hidden" name="value" id="value" value="new" />
                <input type="hidden" name="uname" id="uname" value="<?php echo $uname; ?>" />
                <input type="hidden" name="fname" id="fname" value="<?php echo $fname; ?>" />
                <input type="hidden" name="lname" id="lname" value="<?php echo $lname; ?>" />
                Email Address:<br />
                <input type="text" name="email" id="email" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                Confirm Email:<br />
                <input type="text" name="econfirm" id="econfirm" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                Account Password:<br />
                <input type="password" name="pword" id="pword" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                Confirm Password:<br />
                <input type="password" name="pconfirm" id="pconfirm" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                <input type="submit" value="Try Again" style="border:solid;border-color:#CCCCCC;border-width:1px;">
                </form>
            <?php
			}
			
			else if($pword != $pconfirm)
			{
			?>
				<h2>Error!</h2>
				<p class="color1">Your passwords don't match! Please provide a pair of matching passwords.</p><br />
                <form action="signup.php" method="post">
                <input type="hidden" name="value" id="value" value="new" />
                <input type="hidden" name="uname" id="uname" value="<?php echo $uname; ?>" />
                <input type="hidden" name="fname" id="fname" value="<?php echo $fname; ?>" />
                <input type="hidden" name="lname" id="lname" value="<?php echo $lname; ?>" />
                <input type="hidden" name="email" id="email" value="<?php echo $email; ?>" />
                <input type="hidden" name="econfirm" id="econfirm" value="<?php echo $econfirm; ?>" />
                Account Password:<br />
                <input type="password" name="pword" id="pword" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                Confirm Password:<br />
                <input type="password" name="pconfirm" id="pconfirm" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                <input type="submit" value="Try Again" style="border:solid;border-color:#CCCCCC;border-width:1px;">
                </form>
			<?php
            }
			
			else if(strlen($pword) < 7)
			{
			?>
				<h2>Error!</h2>
				<p class="color1">The password you entered is too short! Please enter a password of at least 7 characters in length.</p><br />
                <form action="signup.php" method="post">
                <input type="hidden" name="value" id="value" value="new" />
                <input type="hidden" name="uname" id="uname" value="<?php echo $uname; ?>" />
                <input type="hidden" name="fname" id="fname" value="<?php echo $fname; ?>" />
                <input type="hidden" name="lname" id="lname" value="<?php echo $lname; ?>" />
                <input type="hidden" name="email" id="email" value="<?php echo $email; ?>" />
                <input type="hidden" name="econfirm" id="econfirm" value="<?php echo $econfirm; ?>" />
                Account Password:<br />
                <input type="password" name="pword" id="pword" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                Confirm Password:<br />
                <input type="password" name="pconfirm" id="pconfirm" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                <input type="submit" value="Try Again" style="border:solid;border-color:#CCCCCC;border-width:1px;">
                </form>
            <?php
			}
			
			else if($result != 0)
			{
			?>
				<h2>Error!</h2>
				<p class="color1">The username you entered is already registered! Please enter a different username.</p><br />
                <form action="signup.php" method="post">
                <input type="hidden" name="value" id="value" value="new" />
                Username:<br />
                <input type="text" name="uname" id="uname" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                <input type="hidden" name="fname" id="fname" value="<?php echo $fname; ?>" />
                <input type="hidden" name="lname" id="lname" value="<?php echo $lname; ?>" />
                <input type="hidden" name="email" id="email" value="<?php echo $email; ?>" />
                <input type="hidden" name="econfirm" id="econfirm" value="<?php echo $econfirm; ?>" />
                Account Password:<br />
                <input type="password" name="pword" id="pword" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                Confirm Password:<br />
                <input type="password" name="pconfirm" id="pconfirm" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                <input type="submit" value="Try Again" style="border:solid;border-color:#CCCCCC;border-width:1px;">
                </form>
			<?php
            }
			
			else if($result2 != 0)
			{
			?>
				<h2>Error!</h2>
				<p class="color1">The email you entered is already registered! Please use a different email.</p><br />
                <form action="signup.php" method="post">
                <input type="hidden" name="value" id="value" value="new" />
                <input type="hidden" name="uname" id="uname" value="<?php echo $uname; ?>" />
                <input type="hidden" name="fname" id="fname" value="<?php echo $fname; ?>" />
                <input type="hidden" name="lname" id="lname" value="<?php echo $lname; ?>" />
                Email Address:<br />
                <input type="text" name="email" id="email" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                Confirm Email:<br />
                <input type="text" name="econfirm" id="econfirm" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                Account Password:<br />
                <input type="password" name="pword" id="pword" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                Confirm Password:<br />
                <input type="password" name="pconfirm" id="pconfirm" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                <input type="submit" value="Try Again" style="border:solid;border-color:#CCCCCC;border-width:1px;">
                </form>
			<?php
            }
			
			else
			{
				// fill the basic table
				$pword = md5($pword);
				mysql_query("INSERT INTO users (uname, fname, lname, password, email) VALUES ('$uname', '$fname', '$lname', '$pword', '$email')");
				$result = mysql_insert_id();
				
				mysql_query("INSERT INTO user_data (ID, profpic, favteam, favplayer, about) VALUES ('$result', '', '', '', '')");
				mysql_query("INSERT INTO friends (ID) VALUES ('$result')");
				
				$message = "Thank you for signing up for Fantasy Ultimate! You are one step away from having an account with us! To confirm your account, simply click on the link below:\n\nhttp://www.mattkgross.com/ulti/validate.php?uname=". $uname . " \n\nIf you have received this email through error, please let us know!\n\nWelcome to the team,\nFantasy Ultimate Team";
				
				$headers = 'From: ' . "ulti@mattkgross.com" . "\r\n".
				'Reply-To: '. "ulti@mattkgross.com" ."\r\n" .
				'X-Mailer: PHP/' . phpversion();
				mail($email, "Fantasy Ultimate - Confirm Your Account", $message, $headers);
				
				?>
                <h2>Success!</h2>
				<p class="color1">You have successfully registered yourself into our system! A confirmation email will be sent to you shortly. Use that to finish activating your account. To log in, use the bar to your left.</p>
                <?php
			}
		}
		
		else if($value == "noinfo")
			{
			?>
            	<h2>Create An Account</h2>
			<p class="color1">Let's try again! Please fill in all of the fields below.</p>
			<div class="marker">
				<div class="wrapper">
					<p class="pad_bot2"><strong>Registration</strong></p><br />
                    <form action="signup.php" method="post">
                    <input type="hidden" name="value" id="value" value="new" />
                    Username:<br />
                    <input type="text" name="uname" id="uname" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" value="<?php echo $uname; ?>" /><br /><br />
                    First Name:<br />
                    <input type="text" name="fname" id="fname" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" value="<?php echo $fname; ?>" /><br /><br />
                    Last Name:<br />
                    <input type="text" name="lname" id="lname" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" value="<?php echo $lname; ?>" /><br /><br />
                    Email Address:<br />
                    <input type="text" name="email" id="email" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" value="<?php echo $email; ?>" /><br /><br />
                    Confirm Email:<br />
                    <input type="text" name="econfirm" id="econfirm" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" value="<?php echo $econfirm; ?>" /><br /><br />
                    Account Password:<br />
                    <input type="password" name="pword" id="pword" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                    Confirm Password:<br />
                    <input type="password" name="pconfirm" id="pconfirm" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                    <input type="submit" value="All Done" style="border:solid;border-color:#CCCCCC;border-width:1px;">                   
                    </form>
				</div>
			</div>
            <?php
			}
		
		else
		{
		?>
			<h2>Create An Account</h2>
			<p class="color1">You're almost there! We just need a few pieces of information from you before your account is active. Your personal information will be kept private and not be shared with any third party.</p>
			<div class="marker">
				<div class="wrapper">
					<p class="pad_bot2"><strong>Registration</strong></p><br />
                    <form action="signup.php" method="post">
                    <input type="hidden" name="value" id="value" value="new" />
                    Username:<br />
                    <input type="text" name="uname" id="uname" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                    First Name:<br />
                    <input type="text" name="fname" id="fname" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                    Last Name:<br />
                    <input type="text" name="lname" id="lname" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                    Email Address:<br />
                    <input type="text" name="email" id="email" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                    Confirm Email:<br />
                    <input type="text" name="econfirm" id="econfirm" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                    Account Password:<br />
                    <input type="password" name="pword" id="pword" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                    Confirm Password:<br />
                    <input type="password" name="pconfirm" id="pconfirm" size="30" style="border:solid;border-color:#CCCCCC;border-width:1px;" /><br /><br />
                    <input type="submit" value="All Done" style="border:solid;border-color:#CCCCCC;border-width:1px;">                   
                    </form>
				</div>
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