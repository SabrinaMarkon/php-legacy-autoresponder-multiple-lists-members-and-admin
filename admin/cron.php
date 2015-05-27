<?php
include "../db.php";
#####################################
#          CHECK IF SUBSCRIPTIONS WERE RENEWED         #
#####################################
$today = date('Y-m-d',strtotime("now"));
$hourrightnow = date('H',strtotime("now"));
$dayrightnow = date('d',strtotime("now"));
$rightnow = date("YmdHis");
# run this section once every 24 hours only.
if (($hourrightnow == "23") and ($joinpriceinterval != "One Time"))
{
$q = "select * from members where accounttype=\"PAID\"";
$r = mysql_query($q);
$rows = mysql_num_rows($r);
if ($rows > 0)
	{
	while ($rowz = mysql_fetch_array($r))
		{
		$userid = $rowz["userid"];
		$membershiplastpaid = $rowz["membershiplastpaid"];
		$membershipnextpaid = $rowz["membershipnextpaid"];
		if ($enableautodowngrade == "yes")
			{
			if (($membershipnextpaid < $today) or ($membershipnextpaid ==""))
				{
					$autodowngradedate = date('Y-m-d', strtotime("+$autodowngradeafterhowmanydayslatepay days", strtotime($membershipnextpaid)));
					if ($autodowngradedate <= $today)
					{
						$downq = "update members set accounttype=\"FREE\" where userid=\"$userid\"";
						$downr = mysql_query($downq);
					} # if ($autodowngradedate <= $today)
				} # if (($membershipnextpaid < $today) or ($membershipnextpaid ==""))
			} # if ($enableautodowngrade == "yes")
		} # while ($rowz = mysql_fetch_array($r))
	} # if ($rows > 0)
} # if (($hourrightnow == "23") and ($joinpriceinterval != "One Time"))
###########################
#           START ADMIN EMAILS              #
###########################
$query3 = "select * from adminemails where sent=0 limit 1";
$result3 = mysql_query ($query3) or die (mysql_error());
$numrows2 = @ mysql_num_rows($result3);
if ($numrows2 > 0)
{
$line3 = mysql_fetch_array($result3);
$subject = $line3["subject"];
$subject = stripslashes($subject);
$subject = str_replace('\\', '', $subject);
$adbody = $line3["adbody"];
$adbody = stripslashes($adbody);
$adbody = str_replace('\\', '', $adbody);
$id = $line3["id"];
$sendtopaid = $line3["sendtopaid"];
$sendtofree = $line3["sendtofree"];
$query5 = "update adminemails set sent=1 where id='$id'";
$result5 = mysql_query ($query5) or die (mysql_error());   
$query6 = "update adminemails set datesent='".time()."' where id='$id'";
$result6 = mysql_query ($query6) or die (mysql_error());

$query4 = "select * from members where verified='yes' and vacation='no'";
if ($sendtopaid == "yes")
{
if ($sendtofree == "yes")
	{
	$query4 = $query4 . " and (accounttype='PAID' or accounttype='FREE')";
	}
if ($sendtofree != "yes")
	{
	$query4 = $query4 . " and accounttype='PAID'";
	}
} # if ($sendtopaid == "yes")
else
{
$query4 = $query4 . " and accounttype='FREE'";
}
$result4 = mysql_query($query4);
while ($line4 = mysql_fetch_array($result4))
{
    $email = $line4["email"];
    $accounttype = $line4["accounttype"];
    $userid = $line4["userid"];
	$firstname = $line4["firstname"];
	$lastname = $line4["lastname"];
	$fullname = $firstname . " " . $lastname;
	$affiliate_url = $domain . "/index.php?referid=" . $userid;
    $password = $line4["password"];
    $Subject = $subject;
    $Message = $adbody;
    $Message .= "<br><br>--------------------------------------------------------------<br><br>";
	$Message .= "<a href=\"".$domain."/click.php?userid=".$userid."&id=".$id."\">Click Here to Visit! ".$domain."/click.php?userid=".$userid."&id=".$id."</a>";
	$Message .= "<br><br>This " . $sitename . " message was submitted by the site admin.";
    $Message .= ".<br><br>";
    $Message .= "--------------------------------------------------------------<br><br>";
    $Message .= "This is an Admin Advertisement/Notification from the admin of ".$sitename.". You are receiving this because you are a member of " . $sitename . ".<br>";
    $Message .= "You can opt out of receiving emails by deleting your account. Click here to delete your account:<br><br><a href=\"$domain/remove.php?r=".$email."\">".$domain."/remove.php?r=".$email."</a>.<br><br>";
	$Message .= "$adminname<br>$sitename<br>$adminaddress<br>";
	
	$headers = "From: $sitename<$adminemail>\n";
	$headers .= "Reply-To: <$adminemail>\n";
	$headers .= "X-Sender: <$adminemail>\n";
	$headers .= "X-Mailer: PHP4\n";
	$headers .= "X-Priority: 3\n";
	$headers .= "Return-Path: <$adminemail>\nContent-type: text/html; charset=iso-8859-1\n";

	$Message = str_replace("~AFFILIATE_URL~",$affiliate_url,$Message);
	$Message = str_replace("~USERID~",$userid,$Message);
	$Message = str_replace("~FULLNAME~",$fullname,$Message);
	$Message = str_replace("~FIRSTNAME~",$firstname,$Message);
	$Message = str_replace("~LASTNAME~",$lastname,$Message);
	$Message = str_replace("~EMAIL~",$email,$Message);
	$Subject = str_replace("~AFFILIATE_URL~",$affiliate_url,$Subject);
	$Subject = str_replace("~USERID~",$userid,$Subject);
	$Subject = str_replace("~FULLNAME~",$fullname,$Subject);
	$Subject = str_replace("~FIRSTNAME~",$firstname,$Subject);
	$Subject = str_replace("~LASTNAME~",$lastname,$Subject);
	$Subject = str_replace("~EMAIL~",$email,$Subject);

    @mail($email, $Subject, wordwrap(stripslashes($Message)),$headers, "-f$adminemail");

    $counter=$counter+1;

#echo "Mail sent to " . $email . "<br>";
}
} # if ($numrows2 > 0)
$ssq1 = "select * from adminemails where sent=1 and datesent<='".(time()-31*24*60*60)."'";
$ssr1 = mysql_query($ssq1) or die(mysql_error());
while($ssrowz1 = mysql_fetch_array($ssr1))
{
$ssq3 = "delete from adminemails where id='".$ssrowz1['id']."'";
$ssr3 = mysql_query($ssq3);
}
exit;
?>