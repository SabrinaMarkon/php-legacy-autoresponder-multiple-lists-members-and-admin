<?php
include "db.php";
include "header.php";
$referid = $_REQUEST["referid"];
$userid = $_REQUEST["userid"];
$unixtimestamp = time();
$q = "select * from members where userid=\"$userid\"";
$r = mysql_query($q);
$rows = mysql_num_rows($r);
if ($rows < 1)
{
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
<tr><td colspan="2" align="center"><br>UserID was not found in the system!</td></tr>
<tr><td colspan="2" align="center"><br><a href="index.php?referid=<?php echo $referid ?>">MAIN PAGE</a></td></tr>
</table>
<br><br>
<?php
include "footer.php";
exit;
}
if ($rows > 0)
{
$email = mysql_result($r,0,"email");
$firstname = mysql_result($r,0,"firstname");
$lastname = mysql_result($r,0,"lastname");
$password = mysql_result($r,0,"password");
$verifyq = "update member set verified=\"no\",verifieddate=\"0\",verifycode=\"$unixtimestamp\" where userid=\"$userid\"";
$verifyr = mysql_query($verifyq);

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
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
<tr><td align="center" colspan="2"><div class="heading">Verification Email Resent!</div></td></tr>
<tr><td colspan="2" align="center"><br><a href="index.php?referid=<?php echo $referid ?>">MAIN PAGE</a></td></tr>
</table>
<br><br>
<?php
include "footer.php";
exit;
}
?>