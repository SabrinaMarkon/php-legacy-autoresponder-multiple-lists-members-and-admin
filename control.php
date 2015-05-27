<?php 
if(!isset($_SESSION))
{
session_start();
}
include "db.php";
if ($_REQUEST["loginusername"])
{
$_SESSION["loginusername"] = $_REQUEST["loginusername"];
$_SESSION["loginpassword"] = $_REQUEST["loginpassword"];
}
$loginq = "select * from members where userid=\"".$_SESSION["loginusername"]."\" and password=\"".$_SESSION["loginpassword"]."\"";
$loginr = mysql_query($loginq);
$loginrows = mysql_num_rows($loginr);
	if ($loginrows < 1)
	{
	unset($_SESSION["loginusername"]);
	unset($_SESSION["loginpassword"]);
	$memberloggedin = "no";
	$show = "<div class=\"message\">Incorrect Login</div>";
	@header("Location: " . $domain . "/login.php?show=" . $show);
	exit;
	}
	if ($loginrows > 0)
	{
		if ($turingkeyenable == "yes")
		{
			include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';
			$securimage = new Securimage();
			if ($securimage->check($_POST['captcha_code']) == false)
			{
			unset($_SESSION["loginusername"]);
			unset($_SESSION["loginpassword"]);
			$memberloggedin = "no";
			$show = "<div class=\"message\">Captcha/Turing Code Was Entered Incorrectly</div>";
			@header("Location: " . $domain . "/login.php?show=" . $show);
			exit;
			}
		}
	$memberloggedin = "yes";
	$userid = mysql_result($loginr,0,"userid");
	$password = mysql_result($loginr,0,"password");
	$accounttype = mysql_result($loginr,0,"accounttype");
	$referid = mysql_result($loginr,0,"referid");
	$firstname = mysql_result($loginr,0,"firstname");
	$lastname = mysql_result($loginr,0,"lastname");
	$fullname = $firstname . " " . $lastname;
	$email = mysql_result($loginr,0,"email");
	$country = mysql_result($loginr,0,"country");
	$signupdate = mysql_result($loginr,0,"signupdate");
	$signupip = mysql_result($loginr,0,"signupip");
	$egopay = mysql_result($loginr,0,"egopay");
	$payza = mysql_result($loginr,0,"payza");
	$perfectmoney = mysql_result($loginr,0,"perfectmoney");
	$okpay = mysql_result($loginr,0,"okpay");
	$solidtrustpay = mysql_result($loginr,0,"solidtrustpay");
	$paypal = mysql_result($loginr,0,"paypal");
	$verified = mysql_result($loginr,0,"verified");
	$verifieddate = mysql_result($loginr,0,"verifieddate");
	$lastlogin = mysql_result($loginr,0,"lastlogin");
	$commission = mysql_result($loginr,0,"commission");
	$commissionlastpaid = mysql_result($loginr,0,"commissionlastpaid");
	$membershiplastpaid = mysql_result($loginr,0,"membershiplastpaid");
	$membershipnextpaid = mysql_result($loginr,0,"membershipnextpaid");
	if ($accounttype == "PAID")
		{
		$accounttypename = $level2name;
		}
	if ($accounttype != "PAID")
		{
		$accounttypename = $level1name;
		}
	}

	if ($verified == "no")
	{
	unset($_SESSION["loginusername"]);
	unset($_SESSION["loginpassword"]);
	#session_destroy();
	$show = "<div class=\"message\">Email Address Not Verified!<br><br><a href=resendverify.php?userid=$userid>Click Here to Resend your Verification Email</a></div>";
	@header("Location: " . $domain . "/login.php?show=" . $show);
	exit;
	}

	$currentFile = $_SERVER["PHP_SELF"];
	$parts = explode('/', $currentFile);
	$currentFilename = $parts[count($parts) - 1];
	$okpageforlevelq = "select * from membernavigation where membernavurl=\"$currentFilename\" and membernavallowedlevels!=\"ALL\" and membernavallowedlevels!=\"$accounttype\"";
	$okpageforlevelr = mysql_query($okpageforlevelq);
	$okpageforlevelrows = mysql_num_rows($okpageforlevelr);
	if ($okpageforlevelrows > 0)
	{
	unset($_SESSION["loginusername"]);
	unset($_SESSION["loginpassword"]);
	#session_destroy();
	$show = "<div class=\"message\">Page Not Allowed For Membership Level</div>";
	@header("Location: " . $domain . "/login.php?show=" . $show);
	exit;
	}
extract($_REQUEST);
?>