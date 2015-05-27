<?php
session_start();
include "db.php";
include "header.php";
$referid = $_REQUEST["referid"];
$today = date('Y-m-d',strtotime("now"));
$unixtimestamp = time();
if ($referid == "")
{
	if ($adminmemberuserid != "")
	{
	$referid = $adminmemberuserid;
	}
	if ($adminmemberuserid == "")
	{
	$referid = "admin";
	}
}
###########
$action = $_POST["action"];
if ($action == "join")
{
	if ($turingkeyenable == "yes")
	{
		include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';
		$securimage = new Securimage();
		if ($securimage->check($_POST['captcha_code']) == false)
		{
		$error .= "<div>Captcha/Turing Code was entered incorrectly.</div>";
		}
	}

$userid = $_POST["userid"];
$password = $_POST["password"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$email = $_POST["email"];
$country = $_POST["country"];
$signupip = $_SERVER["REMOTE_ADDR"];

	if (!$userid)
	{
	$error .= "<div>Please return and enter a userid.</div>";
	}
	if(!$password)
	{
	$error .= "<div>Please return and enter a password.</div>";
	}
	if(!$firstname)
	{
	$error .= "<div>Please return and enter your first name.</div>";
	}
	if(!$lastname)
	{
	$error .= "<div>Please return and enter your last name.</div>";
	}
	if(!$email)
	{
	$error .= "<div>Please return and enter your email address.</div>";
	}
	$dupq = "select * from members where userid=\"$userid\" or email=\"$email\"";
	$dupr = mysql_query($dupq);
	$duprows = mysql_num_rows($dupr);
	if ($duprows > 0)
	{
	$error .= "<div>The userid or email address you chose is already registered.</div>";
	}
	$new_email_array= explode ("@", $email);
	$new_email_domain = $new_email_array[1];
	if ($emailsignupmethod == "denyallexcept")
	{
	$q2 = "select * from emailsignupcontrol where emaildomain='$email' or emaildomain='$new_email_domain'";
	$r2 = mysql_query($q2);
	$rows2 = mysql_num_rows($r2);
	if ($rows2 < 1)
		{
		$q3 = "select * from emailsignupcontrol order by id";
		$r3 = mysql_query($q3);
		$rows3 = mysql_num_rows($r3);
		if ($rows3 > 0)
			{
			$allalloweddomains = "<ul style=\"text-align: left;\">";
			while ($rowz3 = mysql_fetch_array($r3))
				{
				$alloweddomain = $rowz3["emaildomain"];
				$allalloweddomains = $allalloweddomains . "<li>" . $alloweddomain . "</li>";
				}
			$allalloweddomains = $allalloweddomains . "</ul>";
			$error .="<br><div>Email address is not in the list of allowed domains:<br>".$allalloweddomains."</div>";
			} # if ($rows3 > 0)
		} # if ($rows2 < 1)
	} # if ($emailsignupmethod == "denyallexcept")
	if ($emailsignupmethod != "denyallexcept")
	{
	$q2 = "select * from emailsignupcontrol where emaildomain='$email' or emaildomain='$new_email_domain'";
	$r2 = mysql_query($q2);
	$rows2 = mysql_num_rows($r2);
	if ($rows2 > 0)
		{
		$error .="<div>Email address is in the list of banned domains. Please signup using a different one.</div>";
		} # if ($rows2 < 1)
	} # if ($emailsignupmethod != "denyallexcept")
	if(!$error == "")
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="300">
	<tr><td align="center" colspan="2"><b>Signup Error</b></td></tr>
	<tr><td colspan="2"><br><?php echo $error ?></td></tr>
	<tr><td colspan="2" align="center"><br><a href="javascript: history.back()">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "footer.php";
	exit;
	}
#############################
$freeq = "insert into members (userid,password,accounttype,firstname,lastname,country,email,signupdate,signupip,referid,verifycode) values (\"$userid\",\"$password\",\"FREE\",\"$firstname\",\"$lastname\",\"$country\",\"$email\",NOW(),\"$signupip\",\"$referid\",\"$unixtimestamp\")";
$freer = mysql_query($freeq);

					$tomember = $email;
					$headersmember .= "From: $sitename <$adminemail>\n";
					$headersmember .= "Reply-To: <$adminemail>\n";
					$headersmember .= "X-Sender: <$adminemail>\n";
					$headersmember .= "X-Mailer: PHP5\n";
					$headersmember .= "X-Priority: 3\n";
					$headersmember .= "Return-Path: <$adminemail>\n";
					$subjectmember = "Welcome to " . $sitename;
					$messagemember = "Dear ".$firstname." ".$lastname.",\n\nThank you for signing up for ".$sitename.".\nYour account details are below:\n\n"
					   ."Userid: ".$userid."\nPassword: ".$password."\n\n"
					   ."Please verify your email address by clicking this link ".$domain."/verify.php?userid=".$userid."&code=".$unixtimestamp."\n\n"
					   ."Your unique affiliate URL is: ".$domain."/index.php?referid=".$userid ."\n\n"
					   ."Your login URL is: ".$domain."\n\n"
					   ."Thank you!\n\n\n"
					   .$sitename." Admin\n"
					   .$adminemail."\n\n\n\n";
					@mail($tomember, $subjectmember, wordwrap(stripslashes($messagemember)),$headersmember, "-f$adminemail");

					$toadmin = $adminemail;
					$headersadmin .= "From: $sitename <$adminemail>\n";
					$headersadmin .= "Reply-To: <$adminemail>\n";
					$headersadmin .= "X-Sender: <$adminemail>\n";
					$headersadmin .= "X-Mailer: PHP5\n";
					$headersadmin .= "X-Priority: 3\n";
					$headersadmin .= "Return-Path: <$adminemail>\n";
					$subjectadmin = "New (Free) Member In " . $sitename;
					$messageadmin = "This is a notification that a new FREE level member just joined $sitename:\n\n
					UserID: $userid\n
					Sponsor: $referid\n
					Email: $email\n
					IP: $signupip\n\n
					$sitename\n
					$domain
					";
					@mail($toadmin, $subjectadmin, wordwrap(stripslashes($messageadmin)),$headersadmin, "-f$adminemail");
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">
<tr><td align="center" colspan="2"><div class="heading">Signup Successful!</div></td></tr>

<tr><td align="center" colspan="2">
<table cellpadding="2" cellspacing="2" border="0" align="center" width="100%">
<tr><td>
<div style="text-align: center;">
<?php
$q = "select * from pages where name='Thank You Page - New Free Member Signup'";
$r = mysql_query($q);
$rowz = mysql_fetch_array($r);
$htmlcode = $rowz["htmlcode"];
echo $htmlcode;
?>
</div>
</td></tr>
</table>
</td></tr>

</table>
<br><br>
<?php
include "footer.php";
exit;
} # if ($action == "join")
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
<tr><td align="center" colspan="2"><div class="heading">Register</div></td></tr>
<tr><td align="center" colspan="2">
<table cellpadding="2" cellspacing="2" border="0" align="center" width="100%">
<tr><td>
<div style="text-align: center;">
<?php
$q = "select * from pages where name='Registration Page'";
$r = mysql_query($q);
$rowz = mysql_fetch_array($r);
$htmlcode = $rowz["htmlcode"];
echo $htmlcode;
?>
</div>
</td></tr>
</table>
</td></tr>

<tr><td align="center" colspan="2" valign="top">
<table cellpadding="2" cellspacing="2" border="0" align="center" class="sabrinatable">
<form action="register.php" method="post">
<tr class="sabrinatrlight"><td>UserID:</td><td><input type="text" name="userid" size="35" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td>Password:</td><td><input type="text" name="password" size="35" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td>First Name:</td><td><input type="text" name="firstname" size="35" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td>Last Name:</td><td><input type="text" name="lastname" size="35" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td>Email:</td><td><input type="text" name="email" size="35" maxlength="255"></td></tr>
<?php
$cq = "select * from countries order by country_id";
$cr = mysql_query($cq);
$crows = mysql_num_rows($cr);
if ($crows > 0)
{
?>
<tr class="sabrinatrlight"><td>Country:</td><td><select name="country" style="width: 232px;" class="pickone">
<?php
	while ($crowz = mysql_fetch_array($cr))
	{
	$country_name = $crowz["country_name"];
?>
<option value="<?php echo $country_name ?>" <?php if ($country_name == "United States") { echo "selected"; } ?>><?php echo $country_name ?></option>
<?php
	}
?>
</select>
</td></tr>
<?php
}
?>
<tr class="sabrinatrlight"><td>Your Sponsor:</td><td><?php echo $referid ?></td></tr>
<?php
if ($turingkeyenable == "yes")
{
?>
<tr class="sabrinatrlight"><td align="center" colspan="2">
<div style="height:15px;"></div>
<img id="captcha" src="/securimage/securimage_show.php" alt="CAPTCHA Image" style="border:1px solid #000000;" /><br><br>
<table cellpadding="4" cellspacing="2" border="0" align="center" width="220">
<tr><td align="right">Enter Code:</td><td><input type="text" name="captcha_code" size="10" maxlength="6" /></td><td><a href="#" onclick="document.getElementById('captcha').src = '/securimage/securimage_show.php?' + Math.random(); return false"><img src="<?php echo $domain ?>/securimage/images/refresh.png" border="Refresh Image" width="20" height="20"></a></td><td style="padding-left:5px;padding-top:2px;">
<object type="application/x-shockwave-flash" data="/securimage/securimage_play.swf?audio_file=/securimage/securimage_play.php&amp;bgColor1=#fff&amp;bgColor2=#fff&amp;iconColor=#777&amp;borderWidth=1&amp;borderColor=#000" width="25" height="25">
<param name="wmode" value="transparent">
<param name="movie" value="/securimage/securimage_play.swf?audio_file=/securimage/securimage_play.php&amp;bgColor1=#fff&amp;bgColor2=#fff&amp;iconColor=#777&amp;borderWidth=1&amp;borderColor=#000" />
</object></td></tr>
</table>
<div style="height:15px;"></span>
</td></tr>
<?php
} # if ($turingkeyenable == "yes")
?>
<tr class="sabrinatrdark"><td colspan="2" align="center"><input type="hidden" name="referid" value="<?php echo $referid ?>">
<input type="hidden" name="action" value="join">
<input type="submit" value="JOIN!">
</form></td></tr>
</table><center>
<br>By signing up, you agree to our <a href="terms.php?referid=<?php echo $referid ?>" target=_"blank">Terms & Conditions.</a>
<br>
</td></tr></table>
<br><br>
<?php
include "footer.php";
exit;
?>