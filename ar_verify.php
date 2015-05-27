<?php
include "db.php";
function formatDate($val) {
	$arr = explode("-", $val);
	return date("M d Y", mktime(0,0,0, $arr[1], $arr[2], $arr[0]));
}
$id = $_GET["id"];
$list = $_GET["list"];
$code = $_GET["code"];
$verifiedip = $_SERVER["REMOTE_ADDR"];
$add_to_message = "";
if ((empty($id)) or (empty($code)) or (empty($list)))
{
include "header.php";
include "mainnav.php";
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">
<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
<tr><td align="center" colspan="2">
Invalid Link
</td></tr>
</table>
<br><br>
<?php
include "footer.php";
exit;
}
$q = "select * from autoresponders_prospects where id=\"$id\" and verifiedcode=\"$code\"";
$r = mysql_query($q);
$rows = mysql_num_rows($r);
if ($rows < 1)
{
include "header.php";
include "mainnav.php";
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">
<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
<tr><td align="center" colspan="2">
Invalid Link
</td></tr>
</table>
<br><br>
<?php
include "footer.php";
exit;
}
if ($rows > 0)
{
$firstname = mysql_result($r,0,"firstname");
$lastname = mysql_result($r,0,"lastname");
$email = mysql_result($r,0,"email");
$howfound = mysql_result($r,0,"howfound");
$referringpage = mysql_result($r,0,"referringpage");
$howmanydays = mysql_result($r,0,"howmanydays");
$signupip = mysql_result($r,0,"signupip");
$signupdate = mysql_result($r,0,"signupdate");
	if (($signupdate == 0) or ($signupdate == "0000-00-00 00:00:00") or ($signupdate == ""))
	{
	$showsignupdate = "Not Recorded";
	}
	else
	{
	$showsignupdate = formatDate($signupdate);
	}
$listname = mysql_result($r,0,"listname");
$bounces = mysql_result($r,0,"bounces");
$bouncelastdate = mysql_result($r,0,"bouncelastdate");
$bouncelasterror = mysql_result($r,0,"bouncelasterror");
}
# get the prospect's list info they are subscribing to.
$q3 = "select * from autoresponders_lists where id=\"$list\"";
$r3 = mysql_query($q3);
$rows3 = mysql_num_rows($r3);
if ($rows3 < 1)
{
	include "header.php";
	include "mainnav.php";
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">
	<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
	<tr><td align="center" colspan="2">The list you were trying to subscribe to was not found in the system!</td></tr>
	</table>
	<br><br>
	<?php
	include "footer.php";
	exit;
} # if ($rows3 < 1)
if ($rows3 > 0)
{
	$sponsor_userid = mysql_result($r3,0,"userid");
	$listname = mysql_result($r3,0,"listname");
	$verification_redirecturl = mysql_result($r3,0,"verification_redirecturl");
	if ($verification_redirecturl == "")
		{
		$redirecturl = $ar_defaultredirecturlafterverification;
		}
	if ($verification_redirecturl != "")
		{
		$redirecturl = $verification_redirecturl;
		}

	$vq = "select * from autoresponder_userfields_forms where userid=\"$sponsor_userid\" and listnameid=\"$list\" order by fieldname";
	$vr = mysql_query($vq);
	$vrows = mysql_num_rows($vr);
	if ($vrows > 0)
	{
		while ($vrowz = mysql_fetch_array($vr))
		{
		$vfieldname = $vrowz["fieldname"];
		$vtype = $vrowz["type"];
		if ($vtype == "system")
			{
				if ($vfieldname == "firstname")
				{
				$add_to_message .= "First Name: " . $firstname . "\n";
				}
				if ($vfieldname == "lastname")
				{
				$add_to_message .= "Last Name: " . $lastname . "\n";
				}
				if ($vfieldname == "email")
				{
				$add_to_message .= "Email Address: " . $email . "\n";
				}
				if ($vfieldname == "howfound")
				{
				$add_to_message .= "How They Found Your Website: " . $howfound . "\n";
				}		
			} # if ($vtype == "system")
		if ($vtype != "system")
			{
			$vq2 = "select * from autoresponder_userfields where userid=\"$sponsor_userid\" and fieldname=\"$fieldname\"";
			$vr2 = mysql_query($vq2);
			$vrows2 = mysql_num_rows($vr2);
			if ($vrows2 > 0)
				{
					$vfieldtitle = mysql_result($vr2,0,"fieldtitle");
					$vq3 = "select * from autoresponder_userfields_data where userid=\"$sponsor_userid\" and prospectid=\"$id\" and fieldname=\"$vfieldname\"";
					$vr3 = mysql_query($vq2);
					$vrows3 = mysql_num_rows($vr3);
					if ($vrows3 > 0)
					{
					$vfieldvalue = mysql_result($vr3,0,"fieldvalue");
					$add_to_message .= $vfieldtitle . ": " . $vfieldvalue . "\n";
					}
				}
			} # if ($vtype != "system")
		} # while ($rowz2 = mysql_fetch_array($r2))
	} # if ($vrows > 0)

	$q2 = "update autoresponders_prospects set listname=\"$listname\",verified=\"yes\",verifiedip=\"$verifiedip\",verifieddate=NOW(),vacation=\"no\",vacationdate=\"0000-00-00 00:00:00\",unsubscribed=\"no\",unsubscribedate=\"0000-00-00 00:00:00\" where id=\"$id\" and verifiedcode=\"$code\"";
	$r2 = mysql_query($q2);

	?>
	<frameset ROWS="25,*" BORDER=0 FRAMEBORDER=1 FRAMESPACING=0>
	<frame name="header" scrolling="no" noresize marginheight="1" marginwidth="1" target="main" src="ar_verify_top.php">
	<frame name="main" src="<?php echo $redirecturl ?>">
	</frameset>
	<?php
	exit;
} # if ($rows3 > 0)
?>