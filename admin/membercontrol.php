<?php
include "control.php";
include "../header.php";
function formatDate($val) {
	$arr = explode("-", $val);
	return date("M d Y", mktime(0,0,0, $arr[1], $arr[2], $arr[0]));
}
$today = date('Y-m-d',strtotime("now"));
$unixtimestamp = time();
$action = $_POST["action"];
$orderedby = $_REQUEST["orderedby"];
$searchfor = $_REQUEST["searchfor"];
$searchby = $_REQUEST["searchby"];
if ($orderedby == "userid")
{
$orderedbyq = "userid";
}
elseif ($orderedby == "password")
{
$orderedbyq = "password";
}
elseif ($orderedby == "firstname")
{
$orderedbyq = "firstname";
}
elseif ($orderedby == "lastname")
{
$orderedbyq = "lastname";
}
elseif ($orderedby == "email")
{
$orderedbyq = "email";
}
elseif ($orderedby == "accounttype")
{
$orderedbyq = "accounttype desc";
}
elseif ($orderedby == "egopay")
{
$orderedbyq = "egopay";
}
elseif ($orderedby == "payza")
{
$orderedbyq = "payza";
}
elseif ($orderedby == "perfectmoney")
{
$orderedbyq = "perfectmoney";
}
elseif ($orderedby == "okpay")
{
$orderedbyq = "okpay";
}
elseif ($orderedby == "solidtrustpay")
{
$orderedbyq = "solidtrustpay";
}
elseif ($orderedby == "paypal")
{
$orderedbyq = "paypal";
}
elseif ($orderedby == "commission")
{
$orderedbyq = "commission desc";
}
elseif ($orderedby == "country")
{
$orderedbyq = "country";
}
elseif ($orderedby == "referid")
{
$orderedbyq = "referid";
}
elseif ($orderedby == "signupip")
{
$orderedbyq = "signupip";
}
elseif ($orderedby == "signupdate")
{
$orderedbyq = "signupdate desc";
}
elseif ($orderedby == "lastlogin")
{
$orderedbyq = "lastlogin desc";
}
elseif ($orderedby == "verified")
{
$orderedbyq = "verified desc";
}
elseif ($orderedby == "id")
{
$orderedbyq = "id";
}
elseif ($orderedby == "membershiplastpaid")
{
$orderedbyq = "membershiplastpaid desc";
}
elseif ($orderedby == "membershipnextpaid")
{
$orderedbyq = "membershipnextpaid desc";
}
else
{
$orderedbyq = "userid";
}

$error = "";
$show = "";
#################################################
if ($action == "add")
{
$new_userid = $_POST["new_userid"];
$new_password = $_POST["new_password"];
$new_firstname = $_POST["new_firstname"];
$new_lastname = $_POST["new_lastname"];
$new_email = $_POST["new_email"];
$new_email = strtolower($new_email);
$new_accounttype = $_POST["new_accounttype"];
$new_egopay = $_POST["new_egopay"];
$new_egopay = strtolower($new_egopay);
$new_payza = $_POST["new_payza"];
$new_payza = strtolower($new_payza);
$new_perfectmoney = $_POST["new_perfectmoney"];
$new_perfectmoney = strtolower($new_perfectmoney);
$new_okpay = $_POST["new_okpay"];
$new_okpay = strtolower($new_okpay);
$new_solidtrustpay = $_POST["new_solidtrustpay"];
$new_solidtrustpay = strtolower($new_solidtrustpay);
$new_paypal = $_POST["new_paypal"];
$new_paypal = strtolower($new_paypal);
$new_country = $_POST["new_country"];
$new_referid = $_POST["new_referid"];
if ($new_referid == "")
{
	if ($adminmemberuserid == "")
	{
		$new_referid = "admin";
	}
	if ($adminmemberuserid != "")
	{
	$new_referid = $adminmemberuserid;
	}
}
if (!$new_userid)
{
$error .= "<div>Please return and enter a userid.</div>";
}
if(!$new_firstname)
{
$error .= "<div>Please return and enter a first name.</div>";
}
if(!$new_lastname)
{
$error .= "<div>Please return and type in a last name.</div>";
}
if(!$new_email)
{
$error .= "<div>Please return and enter an email address.</div>";
}
$q1 = "select * from members where userid='$userid'";
$r1 = mysql_query($q1);
$rows1 = mysql_num_rows($r1);
if ($rows1 > 0)
{
$error .="<div>UserID already taken.</div>";
}
$new_email_array= explode ("@", $new_email);
$new_email_domain = $new_email_array[1];
if ($emailsignupmethod == "denyallexcept")
{
$q2 = "select * from emailsignupcontrol where emaildomain='$new_email' or emaildomain='$new_email_domain'";
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
		$error .="<br><div style=\"width: 250px; padding-left: 250px;\">Email address is not in the list of allowed domains:<br>".$allalloweddomains."</div>";
		} # if ($rows3 > 0)
	} # if ($rows2 < 1)
} # if ($emailsignupmethod == "denyallexcept")
if ($emailsignupmethod != "denyallexcept")
{
$q2 = "select * from emailsignupcontrol where emaildomain='$new_email' or emaildomain='$new_email_domain'";
$r2 = mysql_query($q2);
$rows2 = mysql_num_rows($r2);
if ($rows2 > 0)
	{
	$error .="<div>Email address is in the list of banned domains. Please use a different one.</div>";
	} # if ($rows2 < 1)
} # if ($emailsignupmethod != "denyallexcept")
if(!$error == "")
{
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="80%">
<tr><td align="center" colspan="2"><div class="heading">Signup Error</div></td></tr>
<tr><td colspan="2" align="center"><br><?php echo $error ?></td></tr>
<tr><td colspan="2" align="center"><br><a href="membercontrol.php?orderedby=<?php echo $orderedby ?>&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">RETURN</a></td></tr>
</table>
<br><br>
<?php
include "../footer.php";
exit;
}
$new_signupip = $_SERVER["REMOTE_ADDR"];
$rq = "select * from members where userid='$new_referid'";
$rr = mysql_query($rq);
$rrows = mysql_num_rows($rr);
if ($rrows < 1)
	{
	$newref = $adminmemberuserid;
	}
if ($rrows > 0)
	{
	$newref = $new_referid;
	}
			if ($new_accounttype == "PAID")
			{
				if ($joinpriceinterval == "Annually")
				{
				$nextdue = @date('Y-m-d', strtotime("+1 years", strtotime($today)));
				}
				elseif ($joinpriceinterval == "Monthly")
				{
				$nextdue = @date('Y-m-d', strtotime("+1 months", strtotime($today)));
				}
				else
				{
				$nextdue = "";
				}
			$newmemberq = "insert into members (userid,password,accounttype,membershiplastpaid,membershipnextpaid,firstname,lastname,country,email,egopay,payza,perfectmoney,okpay,solidtrustpay,paypal,signupdate,signupip,referid,verifycode) values (\"$new_userid\",\"$new_password\",\"$new_accounttype\",\"$today\",\"$nextdue\",\"$new_firstname\",\"$new_lastname\",\"$new_country\",\"$new_email\",\"$new_egopay\",\"$new_payza\",\"$new_perfectmoney\",\"$new_okpay\",\"$new_solidtrustpay\",\"$new_paypal\",NOW(),\"$new_signupip\",\"$newref\",\"$unixtimestamp\")";
			$newmemberr = mysql_query($newmemberq) or die(mysql_error());
			$paychoice = "ADMIN ADDED";
			$transaction = "ADMIN ADDED";
			$userid = $new_userid;
			$referid = $new_referid;
			$egopayaccount = $new_egopay;
			$payzaaccount = $new_payza;
			$perfectmoneyaccount = $new_perfectmoney;
			$okpayaccount = $new_okpay;
			$solidtrustpayaccount = $new_solidtrustpay;
			$paypalaccount = $new_paypal;
			$tomember = $new_email;
			$headersmember .= "From: $sitename <$adminemail>\n";
			$headersmember .= "Reply-To: <$adminemail>\n";
			$headersmember .= "X-Sender: <$adminemail>\n";
			$headersmember .= "X-Mailer: PHP5\n";
			$headersmember .= "X-Priority: 3\n";
			$headersmember .= "Return-Path: <$adminemail>\n";
			$subjectmember = "Welcome to " . $sitename;
			$messagemember = "Dear ".$new_firstname." ".$new_lastname.",\n\nThe admin has signed you up for ".$sitename.".\nYour account details are below:\n\n"
			."Userid: ".$new_userid."\nPassword: ".$new_password."\n\n"
			."Please verify your email address by clicking this link ".$domain."/verify.php?userid=".$new_userid."&code=".$unixtimestamp."\n\n"
			."Your unique affiliate URL is: ".$domain."/index.php?referid=".$new_userid ."\n\n"
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
			$subjectadmin = "New " . $level2name . " Member In " . $sitename;
			$messageadmin = "This is a notification that a new PAID member has joined $sitename:\n\n
			Member was added via the Admin Area\n
			UserID: $new_userid\n
			Sponsor: $new_referid\n
			Email: $new_email\n
			IP: $new_signupip\n\n
			$sitename\n
			$domain
			";
			@mail($toadmin, $subjectadmin, wordwrap(stripslashes($messageadmin)),$headersadmin, "-f$adminemail");
			} # if ($new_accounttype == "PAID")

			if ($new_accounttype != "PAID")
			{
			$newmemberq = "insert into members (userid,password,accounttype,membershiplastpaid,membershipnextpaid,firstname,lastname,country,email,egopay,payza,perfectmoney,okpay,solidtrustpay,paypal,signupdate,signupip,referid,verifycode) values (\"$new_userid\",\"$new_password\",\"$new_accounttype\",\"\",\"\",\"$new_firstname\",\"$new_lastname\",\"$new_country\",\"$new_email\",\"$new_egopay\",\"$new_payza\",\"$new_perfectmoney\",\"$new_okpay\",\"$new_solidtrustpay\",\"$new_paypal\",NOW(),\"$new_signupip\",\"$newref\",\"$unixtimestamp\")";
			$newmemberr = mysql_query($newmemberq) or die(mysql_error());
			$tomember = $new_email;
			$headersmember .= "From: $sitename <$adminemail>\n";
			$headersmember .= "Reply-To: <$adminemail>\n";
			$headersmember .= "X-Sender: <$adminemail>\n";
			$headersmember .= "X-Mailer: PHP5\n";
			$headersmember .= "X-Priority: 3\n";
			$headersmember .= "Return-Path: <$adminemail>\n";
			$subjectmember = "Welcome to " . $sitename;
			$messagemember = "Dear ".$new_firstname." ".$new_lastname.",\n\nThe admin has signed you up for ".$sitename.".\nYour account details are below:\n\n"
			."Userid: ".$new_userid."\nPassword: ".$new_password."\n\n"
			."Please verify your email address by clicking this link ".$domain."/verify.php?userid=".$new_userid."&code=".$unixtimestamp."\n\n"
			."Your unique affiliate URL is: ".$domain."/index.php?referid=".$new_userid ."\n\n"
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
			$subjectadmin = "New FREE Member In " . $sitename;
			$messageadmin = "This is a notification that a new " . $level1name . " member has joined $sitename:\n\n
			Member was added via the Admin Area\n
			UserID: $new_userid\n
			Sponsor: $newref\n
			Email: $new_email\n
			IP: $new_signupip\n\n
			$sitename\n
			$domain
			";
			@mail($toadmin, $subjectadmin, wordwrap(stripslashes($messageadmin)),$headersadmin, "-f$adminemail");
			} # if ($new_accounttype != "PAID")
$show = "New " . $new_accounttype . " member was signed up successfully!<br><br>New UserID: " . $new_userid . "<br>New Password: " . $new_password;
} # if ($action == "add")
##############################################################################################
if ($action == "delete")
{
$delete_userid = $_POST["delete_userid"];
$q = "select * from members where userid='$delete_userid'";
$r = mysql_query($q);
$rows = mysql_num_rows($r);
if ($rows < 1)
{
$show = "UserID " . $delete_userid . " was not found in the system.";
}
if ($rows > 0)
{
mysql_query("delete from cashoutrequests where userid='$delete_userid'");
mysql_query("delete from payouts where userid='$delete_userid'");
mysql_query("delete from adminemails_viewed where userid='$delete_userid'");
mysql_query("delete from transactions where userid='$delete_userid'");
mysql_query("delete from members where userid='$delete_userid'");
$show = "UserID " . $delete_userid . " was deleted.";
}
} # if ($action == "delete")
##############################################################################################
if ($action == "save")
{
$userid = $_POST["userid"];
$q = "select * from members where userid='$userid'";
$r = mysql_query($q);
$rows = mysql_num_rows($r);
if ($rows < 1)
{
$show = "UserID " . $userid . " was not found in the system.";
}
if ($rows > 0)
{
$saveid = $_POST["saveid"];
$password = $_POST["password"];
$accounttype = $_POST["accounttype"];
$oldaccounttype = $_POST["oldaccounttype"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$email = $_POST["email"];
$egopay = $_POST["egopay"];
$payza = $_POST["payza"];
$perfectmoney = $_POST["perfectmoney"];
$okpay = $_POST["okpay"];
$solidtrustpay = $_POST["solidtrustpay"];
$paypal = $_POST["paypal"];
$country = $_POST["country"];
$referid = $_POST["referid"];
$signupip = $_POST["signupip"];
$verified = $_POST["verified"];
$oldverified = $_POST["oldverified"];
$commission = $_POST["commission"];
$givecommissions = $_POST["commission"];
$membershiplastpaid = $_POST["membershiplastpaid"];
if (!$userid)
{
$error .= "<div>Please return and enter a userid.</div>";
}
if (!$password)
{
$error .= "<div>Please return and enter a password.</div>";
}
if(!$firstname)
{
$error .= "<div>Please return and enter a first name.</div>";
}
if(!$lastname)
{
$error .= "<div>Please return and type in a last name.</div>";
}
if(!$email)
{
$error .= "<div>Please return and enter an email address.</div>";
}
if ($accounttype == "PAID")
	{
		if ((!$membershiplastpaid) or ($membershiplastpaid == "N/A") or (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$membershiplastpaid)))
		{
		$error .= "<div>Please return and enter the date the member last paid for their membership in the format YYYY-MM-DD.</div>";
		}
	}
$q1 = "select * from members where userid='$userid' and id!='$saveid'";
$r1 = mysql_query($q1);
$rows1 = mysql_num_rows($r1);
if ($rows1 > 0)
{
$error .="<div>UserID already taken.</div>";
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
	$error .="<div>Email address is in the list of banned domains. Please use a different one.</div>";
	} # if ($rows2 < 1)
} # if ($emailsignupmethod != "denyallexcept")
if(!$error == "")
{
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="80%">
<tr><td align="center" colspan="2"><div class="heading">Update Error</div></td></tr>
<tr><td colspan="2" align="center"><br><?php echo $error ?></td></tr>
<tr><td colspan="2" align="center"><br><a href="membercontrol.php?orderedby=<?php echo $orderedby ?>&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">RETURN</a></td></tr>
</table>
<br><br>
<?php
include "../footer.php";
exit;
}

if ($accounttype == "PAID")
	{
		if ($joinpriceinterval == "Annually")
		{
		$nextdue = @date('Y-m-d', strtotime("+1 years", strtotime($membershiplastpaid)));
		}
		elseif ($joinpriceinterval == "Monthly")
		{
		$nextdue = @date('Y-m-d', strtotime("+1 months", strtotime($membershiplastpaid)));
		}
		else
		{
		$nextdue = "";
		}
	$savememberq = "update members set password='$password',accounttype='$accounttype',membershiplastpaid='$membershiplastpaid',membershipnextpaid='$nextdue',firstname='$firstname',lastname='$lastname',country='$country',email='$email',egopay='$egopay',payza='$payza',perfectmoney='$perfectmoney',okpay='$okpay',solidtrustpay='$solidtrustpay',paypal='$paypal',signupip='$signupip',referid='$referid',commission='$commission',verified='$verified' where id='$saveid'";
	$savememberr = mysql_query($savememberq);
	}
if ($accounttype != "PAID")
	{
	$savememberq = "update members set password='$password',accounttype='$accounttype',firstname='$firstname',lastname='$lastname',country='$country',email='$email',egopay='$egopay',payza='$payza',perfectmoney='$perfectmoney',okpay='$okpay',solidtrustpay='$solidtrustpay',paypal='$paypal',signupip='$signupip',referid='$referid',commission='$commission',verified='$verified' where id='$saveid'";
	$savememberr = mysql_query($savememberq);
	}

if (($accounttype == "PAID") and ($oldaccounttype == "FREE"))
	{
	if ($givecommissions == "yes")
		{
		# sponsor commission
			$refq = "select * from members where userid=\"$saveref\"";
			$refr = mysql_query($refq);
			$refrows = mysql_num_rows($refr);
			if ($refrows > 0)
				{
				$refaccounttype = mysql_result($refr,0,"accounttype");
				if ($refaccounttype == "PAID")
					{
					$commission = $upgradecommissionpaid;
					}
				if ($refaccounttype != "PAID")
					{
					$commission = $upgradecommissionfree;
					}
				$commissionq = "update members set commission=commission+" . $commission . " where userid=\"$saveref\"";
				$commissionr = mysql_query($commissionq);
				$refq3 = "insert into payouts (userid,paid,datepaid,description) values (\"$saveref\",\"$commission\",NOW(),\"Commission Sponsor Payment - Referral $userid Upgraded by Admin\")";
				$refr3 = mysql_query($refq3);
				}
		} # if ($givecommissions == "yes")
	} # if (($accounttype == "PAID") and ($oldaccounttype == "FREE"))
if (($verified == "yes") and ($oldverified == "no"))
	{
	$vq = "update members set verified=\"yes\",verifieddate=NOW() where userid=\"$userid\"";
	$vr = mysql_query($vq);
	}
if (($verified == "no") and ($oldverified == "yes"))
	{
	$vq = "update members set verified=\"no\",verifieddate=\"0\",verifycode=\"$unixtimestamp\" where userid=\"$userid\"";
	$vr = mysql_query($vq);

	$tomember = $email;
	$headersmember .= "From: $sitename <$adminemail>\n";
	$headersmember .= "Reply-To: <$adminemail>\n";
	$headersmember .= "X-Sender: <$adminemail>\n";
	$headersmember .= "X-Mailer: PHP5\n";
	$headersmember .= "X-Priority: 3\n";
	$headersmember .= "Return-Path: <$adminemail>\n";
	$subjectmember = "Welcome to " . $sitename;
	$messagemember = "Dear ".$firstname." ".$lastname.",\n\nPlease verify your email address in ".$sitename." by clicking this link ".$domain."/verify.php?userid=".$userid."&code=".$unixtimestamp."\n\n"
	   ."Userid: ".$userid."\nPassword: ".$password."\n\n"
	   ."Your unique affiliate URL is: ".$domain."/index.php?ref=".$userid ."\n\n"
	   ."Your login URL is: ".$domain."\n\n"
	   ."Thank you!\n\n\n"
	   .$sitename." Admin\n"
	   .$adminemail."\n\n\n\n";
	@mail($tomember, $subjectmember, wordwrap(stripslashes($messagemember)),$headersmember, "-f$adminemail");

	} # if (($verified == "no") and ($oldverified == "yes"))

$show = "UserID " . $userid . " was saved.";
}
} # if ($action == "save")
##############################################################################################
if ($action == "resend")
{
$resend_userid = $_POST["resend_userid"];
$q = "select * from members where userid='$resend_userid'";
$r = mysql_query($q);
$rows = mysql_num_rows($r);
if ($rows < 1)
{
$show = "UserID " . $resend_userid . " was not found in the system.";
}
if ($rows > 0)
{
$password = mysql_result($r,0,"password");
$firstname = mysql_result($r,0,"firstname");
$lastname = mysql_result($r,0,"lastname");
$email = mysql_result($r,0,"email");
$vq = "update members set verified=\"no\",verifieddate=\"0\",verifycode=\"$unixtimestamp\" where userid=\"$resend_userid\"";
$vr = mysql_query($vq);

	$tomember = $email;
	$headersmember .= "From: $sitename <$adminemail>\n";
	$headersmember .= "Reply-To: <$adminemail>\n";
	$headersmember .= "X-Sender: <$adminemail>\n";
	$headersmember .= "X-Mailer: PHP5\n";
	$headersmember .= "X-Priority: 3\n";
	$headersmember .= "Return-Path: <$adminemail>\n";
	$subjectmember = $sitename . " Validation";
	$messagemember = "Before you can advertise on the site, please verify your email address by clicking this link ".$domain."/verify.php?userid=".$resend_userid."&code=".$unixtimestamp."\n\n"
	   ."Your unique affiliate URL is: ".$domain."/index.php?referid=".$resend_userid ."\n\n"
	   ."Your login URL is: ".$domain."\n\n"
	   ."Thank you!\n\n\n"
	   .$sitename." Admin\n"
	   .$adminemail."\n\n\n\n";

	@mail($tomember, $subjectmember, wordwrap(stripslashes($messagemember)),$headersmember, "-f$adminemail");

$show = "Validation email resent to UserID " . $resend_userid;
}
} # if ($action == "resend")
##############################################################################################
?>
<script language="Javascript">
<!--
/***********************************************
* Switch Content script II- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use. Last updated April 2nd, 2005.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

var enablepersist="off" //Enable saving state of content structure using session cookies? (on/off)
var memoryduration="1" //persistence in # of days

var contractsymbol="<?php echo $domain ?>/images/close.png" //Path to image to represent contract state.
var expandsymbol="<?php echo $domain ?>/images/open.png" //Path to image to represent expand state.

/////No need to edit beyond here //////////////////////////

function getElementbyClass(rootobj, classname){
var temparray=new Array()
var inc=0
var rootlength=rootobj.length
for (i=0; i<rootlength; i++){
if (rootobj[i].className==classname)
temparray[inc++]=rootobj[i]
}
return temparray
}

function sweeptoggle(ec){
var inc=0
while (ccollect[inc]){
ccollect[inc].style.display=(ec=="contract")? "none" : ""
inc++
}
revivestatus()
}


function expandcontent(curobj, cid){
if (ccollect.length>0){
document.getElementById(cid).style.display=(document.getElementById(cid).style.display!="none")? "none" : ""
curobj.src=(document.getElementById(cid).style.display=="none")? expandsymbol : contractsymbol
}
}

function revivecontent(){
selectedItem=getselectedItem()
selectedComponents=selectedItem.split("|")
for (i=0; i<selectedComponents.length-1; i++)
document.getElementById(selectedComponents[i]).style.display="none"
}

function revivestatus(){
var inc=0
while (statecollect[inc]){
if (ccollect[inc].style.display=="none")
statecollect[inc].src=expandsymbol
else
statecollect[inc].src=contractsymbol
inc++
}
}

function get_cookie(Name) { 
var search = Name + "="
var returnvalue = "";
if (document.cookie.length > 0) {
offset = document.cookie.indexOf(search)
if (offset != -1) { 
offset += search.length
end = document.cookie.indexOf(";", offset);
if (end == -1) end = document.cookie.length;
returnvalue=unescape(document.cookie.substring(offset, end))
}
}
return returnvalue;
}

function getselectedItem(){
if (get_cookie(window.location.pathname) != ""){
selectedItem=get_cookie(window.location.pathname)
return selectedItem
}
else
return ""
}

function saveswitchstate(){
var inc=0, selectedItem=""
while (ccollect[inc]){
if (ccollect[inc].style.display=="none")
selectedItem+=ccollect[inc].id+"|"
inc++
}
if (get_cookie(window.location.pathname)!=selectedItem){ //only update cookie if current states differ from cookie's
var expireDate = new Date()
expireDate.setDate(expireDate.getDate()+parseInt(memoryduration))
document.cookie = window.location.pathname+"="+selectedItem+";path=/;expires=" + expireDate.toGMTString()
}
}

function do_onload(){
uniqueidn=window.location.pathname+"firsttimeload"
var alltags=document.all? document.all : document.getElementsByTagName("*")
ccollect=getElementbyClass(alltags, "switchcontent")
statecollect=getElementbyClass(alltags, "showstate")
if (enablepersist=="on" && get_cookie(window.location.pathname)!="" && ccollect.length>0)
revivecontent()
if (ccollect.length>0 && statecollect.length>0)
revivestatus()
}

if (window.addEventListener)
window.addEventListener("load", do_onload, false)
else if (window.attachEvent)
window.attachEvent("onload", do_onload)
else if (document.getElementById)
window.onload=do_onload

if (enablepersist=="on" && document.getElementById)
window.onunload=saveswitchstate

/***********************************************
* END SWITCH CONTENT SCRIPT
***********************************************/
-->
</script>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
<tr><td align="center" colspan="2"><div class="heading">Member Administration</div></td></tr>
<?php
if ($show != "")
{
?>
<tr><td align="center" colspan="2"><br><?php echo $show ?></td></tr>
<?php
}
?>

<tr><td align="center" colspan="2"><br>
<form action="membercontrol.php" method="post">
<table width="600" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrdark"><td align="center" colspan="2">ADD A NEW MEMBER</td></tr>
<tr class="sabrinatrlight"><td>UserID:</td><td><input type="text" name="new_userid" size="25" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td>Password:</td><td><input type="text" name="new_password" size="25" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td>Membership Level:</td>
<td>
<select name="new_accounttype">
<option value="FREE"><?php echo $level1name ?></option>
<option value="PAID"><?php echo $level2name ?></option>
</select>
</td></tr>
<tr class="sabrinatrlight"><td>First&nbsp;Name:</td><td><input type="text" name="new_firstname" size="25" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td>Last&nbsp;Name:</td><td><input type="text" name="new_lastname" size="25" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td>Email:</td><td><input type="text" name="new_email" size="25" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td>EgoPay:</td><td><input type="text" name="new_egopay" size="25" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td>Payza:</td><td><input type="text" name="new_alertpay" size="25" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td>Perfect Money:</td><td><input type="text" name="new_perfectmoney" size="25" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td>OKPay:</td><td><input type="text" name="new_okpay" size="25" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td>Solid Trust Pay:</td><td><input type="text" name="new_solidtrustpay" size="25" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td>PayPal:</td><td><input type="text" name="new_paypal" size="25" maxlength="255" class="typein"></td></tr>
<?php
$cq = "select * from countries order by country_id";
$cr = mysql_query($cq);
$crows = mysql_num_rows($cr);
if ($crows > 0)
{
?>
<tr class="sabrinatrlight"><td>Country:</td><td><select name="new_country" style="width: 140px;" class="pickone">
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
$refq = "select * from members order by userid";
$refr = mysql_query($refq);
$refrows = mysql_num_rows($refr);
if ($refrows > 0)
{
?>
<tr class="sabrinatrlight"><td>Sponsor:</td><td><select name="new_referid" class="pickone">
<?php
while ($refrowz = mysql_fetch_array($refr))
	{
	$refuserid = $refrowz["userid"];
	?>
	<option value="<?php echo $refuserid ?>"><?php echo $refuserid ?></option>
	<?php
	}
?>
</select></td></tr>
<?php
}
?>
<tr class="sabrinatrdark"><td colspan="2" align="center">
<input type="hidden" name="orderedby" value="<?php echo $orderedby ?>">
<input type="hidden" name="searchfor" value="<?php echo $searchfor ?>">
<input type="hidden" name="searchby" value="<?php echo $searchby ?>">
<input type="hidden" name="action" value="add">
<input type="submit" name="submit" value="ADD"></form>
</td></tr>
</table>
</td></tr>

<tr><td align="center" colspan="2"></td></tr>

<tr><td align="center" colspan="2"><br>
<table width="600" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrdark"><td align="center" colspan="2">YOUR MEMBERS</td></tr>
<?php
if ($searchfor != "")
{
$q = "select * from members where $searchby like \"%$searchfor%\" order by $orderedbyq";
}
if ($searchfor == "")
{
$q = "select * from members order by $orderedbyq";
}
$r = mysql_query($q);
$rows = mysql_num_rows($r);
if ($rows < 1)
{
	if ($searchfor != "")
	{
	?>
	<tr class="sabrinatrlight"><td align="center" colspan="2">No search results were found.</td></tr>
	<?php
	}
	if ($searchfor == "")
	{
	?>
	<tr class="sabrinatrlight"><td align="center" colspan="2">There are no members in the system yet.</td></tr>
	<?php
	}
}
if ($rows > 0)
{
################################################################
$pagesize = 50;
	$page = (empty($_GET['p']) || !isset($_GET['p']) || !is_numeric($_GET['p'])) ? 1 : $_GET['p'];
	$s = ($page-1) * $pagesize;
	$queryexclude1 = $q ." LIMIT $s, $pagesize";
	$resultexclude=mysql_query($queryexclude1);
	$numrows = @mysql_num_rows($resultexclude);
	if($numrows == 0){
		$queryexclude1 = $q ." LIMIT $pagesize";
		$resultexclude=mysql_query($queryexclude1);
	}
	$count = 0;
	$pagetext = "<center>Total Members: <b>" . $rows . "</b>";

	if($rows > $pagesize){ // show the page bar
		$pagetext .= "<br>";
		$pagecount = ceil($rows/$pagesize);
		$pagetext .= "<div class='pagination'> ";
		if($page>1){ //show previoust link
			$pagetext .= "<a href='?p=".($page-1)."&orderedby=$orderedbyq&searchfor=$searchfor&searchby=$searchby' title='previous page'>previous</a>";
		}
		for($i=1;$i<=$pagecount;$i++){
			if($page == $i){
				$pagetext .= "<span class='current'>".$i."</span>";
			}else{
				$pagetext .= "<a href='?p=".$i."&orderedby=$orderedbyq&searchfor=$searchfor&searchby=$searchby'>".$i."</a>";
			}
		}
		if($page<$pagecount){ //show previoust link
			$pagetext .= "<a href='?p=".($page+1)."&orderedby=$orderedbyq&searchfor=$searchfor&searchby=$searchby' title='next page'>next</a>";
		}			
		$pagetext .= " </div>";
	}
################################################################
?>
<tr class="sabrinatrlight"><td align="center" colspan="2"><div style="width:550px;overflow:auto;"><?php echo $pagetext ?></div></td></tr>

<form action="membercontrol.php" method="post">
<tr class="sabrinatrdark"><td align="center" colspan="2">Search For:&nbsp;<input type="text" name="searchfor" size="15" maxlength="255">&nbsp;&nbsp;In:&nbsp;
<select name="searchby">
<option value="userid">UserID</option>
<option value="password">Password</option>
<option value="accounttype">Membership</option>
<option value="membershiplastpaid">Last Paid for Membership</option>
<option value="firstname">First Name</option>
<option value="lastname">Last Name</option>
<option value="email">Email</option>
<option value="egopay">EgoPay</option>
<option value="payza">Payza</option>
<option value="perfectmoney">Perfect Money</option>
<option value="okpay">OKPay</option>
<option value="solidtrustpay">Solid Trust Pay</option>
<option value="paypal">PayPal</option>
<option value="country">Country</option>
<option value="referid">Sponsor</option>
<option value="signupip">IP Address</option>
<option value="signupdate">Signup Date</option>
<option value="lastlogin">Last Login</option>
<option value="verified">Verified</option>
<option value="verifieddate">Verify Date</option>
<option value="commission">Commission Balance</option>
</select>
&nbsp;&nbsp;
<input type="submit" value="SEARCH"></form>
</td></tr>

<tr class="sabrinatrlight"><td align="center" colspan="2">
<table cellpadding="0" cellspacing="1" border="0" align="center" class="sabrinatable" width="600">
<?php
while ($rowz = mysql_fetch_array($resultexclude))
	{
$id = $rowz["id"];
$userid = $rowz["userid"];
$password = $rowz["password"];
$accounttype = $rowz["accounttype"];
$firstname = $rowz["firstname"];
$lastname = $rowz["lastname"];
$country = $rowz["country"];
$email = $rowz["email"];
$egopay = $rowz["egopay"];
$payza = $rowz["payza"];
$perfectmoney = $rowz["perfectmoney"];
$okpay = $rowz["okpay"];
$solidtrustpay = $rowz["solidtrustpay"];
$paypal = $rowz["paypal"];
$signupdate = $rowz["signupdate"];
$signupdate = formatDate($signupdate);
$signupip = $rowz["signupip"];
$verified = $rowz["verified"];
$verifieddate = $rowz["verifieddate"];
if ($verified == "yes")
{
$bgverified = "#99cc99";
$verifieddate = formatDate($verifieddate);
$showverified = $verifieddate;
}
if ($verified != "yes")
{
$bgverified = "#ff9999";
$verifieddate = "N/A";
$showverified = "NO";
}
$referid = $rowz["referid"];
$lastlogin = $rowz["lastlogin"];
$lastlogin = formatDate($lastlogin);
$commission = $rowz["commission"];
$membershiplastpaid = $rowz["membershiplastpaid"];
$membershipnextpaid = $rowz["membershipnextpaid"];
if (($verified != "yes") or ($vacation == "yes"))
{
$bg = "#ff9999";
}
else
{
$bg = "#99cc99";
}
?>
<tr class="sabrinatrdark">
<td align="center" style="background-color:<?php echo $bg ?>"></td>
<td align="center"><a href="membercontrol.php?orderedby=id&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">ID</a></td>
<td align="center"><a href="membercontrol.php?orderedby=userid&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">UserID</a></td>
<td align="center"><a href="membercontrol.php?orderedby=password&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Password</a></td>
<td align="center"><a href="membercontrol.php?orderedby=accounttype&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Membership</a></td>
<td align="center"><a href="membercontrol.php?orderedby=membershiplastpaid&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Last Paid</a></td>
<td align="center"><a href="membercontrol.php?orderedby=firstname&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">First&nbsp;Name</a></td>
<td align="center"><a href="membercontrol.php?orderedby=lastname&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Last&nbsp;Name</a></td>
<td align="center"><a href="membercontrol.php?orderedby=email&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Email</a></td>
<td align="center"><a href="membercontrol.php?orderedby=signupdate&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Signed&nbsp;Up</a></td>
<td align="center"><a href="membercontrol.php?orderedby=verified&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Verified</a></td>
<td align="center"><a href="membercontrol.php?orderedby=referid&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Sponsor</a></td>
</tr>
<form action="membercontrol.php" method="post">
<tr class="sabrinatrlight">
<td align="center"><img src="<?php echo $domain ?>/images/open.png" class="showstate" onclick="expandcontent(this, 'sc<?php echo $id ?>')" width="20"></td>
<td align="center"><?php echo $id ?></td>
<td align="center"><?php echo $userid ?></td>
<td align="center"><input type="text" name="password" value="<?php echo $password ?>" size="10" maxlength="255" class="typein"></td>
<td>
<select name="accounttype">
<option value="PAID" <?php if ($accounttype == "PAID") { echo "selected"; } ?>><?php echo $level2name ?></option>
<option value="FREE" <?php if ($accounttype != "PAID") { echo "selected"; } ?>><?php echo $level1name ?></option>
</select>
</td>
<?php
if ($accounttype != "PAID")
{
?>
<td align="center">N/A</td>
<?php
}
if ($accounttype == "PAID")
{
if ($membershipnextpaid < $today)
	{
	?>
	<td align="center"><br><input type="text" name="membershiplastpaid" value="<?php echo $membershiplastpaid ?>" size="10" maxlength="255" class="typein"><font color="#ff0000" style="background:#ffff00;">OVERDUE</font></td>
	<?php
	}
	else
	{
	?>
	<td align="center"><input type="text" name="membershiplastpaid" value="<?php echo $membershiplastpaid ?>" size="10" maxlength="255" class="typein"></td>
	<?php
	}
}
?>
<td align="center"><input type="text" name="firstname" value="<?php echo $firstname ?>" size="10" maxlength="255" class="typein"></td>
<td align="center"><input type="text" name="lastname" value="<?php echo $lastname ?>" size="10" maxlength="255" class="typein"></td>
<td align="center"><input type="text" name="email" value="<?php echo $email ?>" size="14" maxlength="255" class="typein"></td>
<td align="center"><?php echo $signupdate ?></td>
<td align="center">
<select name="verified" style="background-color:<?php echo $bgverified ?>">
<option value="yes" <?php if ($verified == "yes") { echo "selected"; } ?>>YES</option>
<option value="no" <?php if ($verified != "yes") { echo "selected"; } ?>>NO</option>
</select>
</td>
<td align="center"><?php echo $referid ?></td>
</tr>

<tr class="sabrinatrlight"><td id="sc<?php echo $id ?>" class="switchcontent" style="display: none; width: 100%; padding: 0px;" colspan="12" style="border:0px;" align="center">
<table cellpadding="2" cellspacing="2" border="0" align="center" class="sabrinatable" width="100%">
<tr class="sabrinatrlight"><td><a href="membercontrol.php?orderedby=country&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Country</a>:</td>
<td style="width: 440px;">
<?php
$cq = "select * from countries order by country_id";
$cr = mysql_query($cq);
$crows = mysql_num_rows($cr);
if ($crows > 0)
{
?>
<select name="country" class="pickone" style="width: 227px;">
<?php
	while ($crowz = mysql_fetch_array($cr))
	{
	$country_name = $crowz["country_name"];
?>
<option value="<?php echo $country_name ?>" <?php if ($country_name == $country) { echo "selected"; } ?>><?php echo $country_name ?></option>
<?php
	}
?>
</select>
<?php
}
?>
</td></tr>
<tr class="sabrinatrlight"><td><a href="membercontrol.php?orderedby=signupip&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">IP Address</a>:</td><td><input type="text" name="signupip" value="<?php echo $signupip ?>" size="35" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td><a href="membercontrol.php?orderedby=paypal&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">PayPal</a>:</td><td><input type="text" name="paypal" value="<?php echo $paypal ?>" size="35" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td><a href="membercontrol.php?orderedby=egopay&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">EgoPay</a>:</td><td><input type="text" name="egopay" value="<?php echo $egopay ?>" size="35" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td><a href="membercontrol.php?orderedby=payza&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Payza</a>:</td><td><input type="text" name="payza" value="<?php echo $payza ?>" size="35" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td><a href="membercontrol.php?orderedby=perfectmoney&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Perfect Money</a>:</td><td><input type="text" name="perfectmoney" value="<?php echo $perfectmoney ?>" size="35" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td><a href="membercontrol.php?orderedby=okpay&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">OKPay</a>:</td><td><input type="text" name="okpay" value="<?php echo $okpay ?>" size="35" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td><a href="membercontrol.php?orderedby=solidtrustpay&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Solid Trust Pay</a>:</td><td><input type="text" name="solidtrustpay" value="<?php echo $solidtrustpay ?>" size="35" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td><a href="membercontrol.php?orderedby=lastlogin&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Last&nbsp;Login</a>:</td><td><?php echo $lastlogin ?></td></tr>
<tr class="sabrinatrlight"><td><a href="membercontrol.php?orderedby=verifieddate&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Verify&nbsp;Date</a>:</td><td><?php echo $showverified ?></td></tr>
<tr class="sabrinatrlight"><td><a href="membercontrol.php?orderedby=commission&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">Commission Balance</a>:</td><td><input type="text" name="commission" value="<?php echo $commission ?>" size="6" maxlength="12" class="typein"></td></tr>
<tr class="sabrinatrlight"><td>Give sponsor commissions if upgrading from <?php echo $level1name ?> to <?php echo $level2name ?> membership:</td><td valign="top"><input type="checkbox" name="givecommissions" value="yes" checked></td></tr>
<tr class="sabrinatrdark"><td colspan="2" align="center">
<table cellpadding="0" cellspacing="1" border="0" align="center" width="100%">
<tr class="sabrinatrdark">
<td align="center"><input type="button" value="CONTACT MEMBER" onclick="location.href='contactmembers.php?userid=<?php echo $userid ?>'" style="font-size:10px;width:170px;"></td>
<td align="center">
<input type="hidden" name="orderedby" value="<?php echo $orderedby ?>">
<input type="hidden" name="searchfor" value="<?php echo $searchfor ?>">
<input type="hidden" name="searchby" value="<?php echo $searchby ?>">
<input type="hidden" name="oldverified" value="<?php echo $verified ?>">
<input type="hidden" name="oldaccounttype" value="<?php echo $accounttype ?>">
<input type="hidden" name="referid" value="<?php echo $referid ?>">
<input type="hidden" name="userid" value="<?php echo $userid ?>">
<input type="hidden" name="saveid" value="<?php echo $id ?>">
<input type="hidden" name="action" value="save">
<input type="submit" value="SAVE" style="font-size:10px;width:170px;">
</form>
</td>
<form action="<?php echo $domain ?>/members.php" method="post" target="_blank">
<td align="center">
<input type="hidden" name="loginusername" value="<?php echo $userid ?>">
<input type="hidden" name="loginpassword" value="<?php echo $password ?>">
<input type="submit" value="LOGIN" style="font-size:10px;width:170px;">
</form>
</td>
<form action="membercontrol.php" method="post">
<td align="center">
<input type="hidden" name="orderedby" value="<?php echo $orderedby ?>">
<input type="hidden" name="searchfor" value="<?php echo $searchfor ?>">
<input type="hidden" name="searchby" value="<?php echo $searchby ?>">
<input type="hidden" name="resend_userid" value="<?php echo $userid ?>">
<input type="hidden" name="action" value="resend">
<input type="submit" value="RESEND VERIFICATION EMAIL" style="font-size:10px;width:170px;">
</form>
</td>
<form action="membercontrol.php" method="post">
<td align="center">
<input type="hidden" name="orderedby" value="<?php echo $orderedby ?>">
<input type="hidden" name="searchfor" value="<?php echo $searchfor ?>">
<input type="hidden" name="searchby" value="<?php echo $searchby ?>">
<input type="hidden" name="delete_userid" value="<?php echo $userid ?>">
<input type="hidden" name="action" value="delete">
<input type="submit" value="DELETE" style="font-size:10px;width:170px;">
</form>
</td>
</tr>
</table>
</td></tr>
<tr style="background:#ffffff;"><td align="center" colspan="2" style="height:10px;background-color:#ffffff;"></td></tr>
</table>
</td></tr>
<?php
	} # while ($rowz = mysql_fetch_array($resultexclude))
?>
</table>
</td></tr>

<tr class="sabrinatrdark"><td align="center" colspan="2"><div style="width:550px;overflow:auto;"><?php echo $pagetext ?></div></td></tr>
<?php
} # if ($rows > 0)
?>
</table><br><br>
</td></tr>
</table>
<br><br>
<?php
include "../footer.php";
exit;
?>