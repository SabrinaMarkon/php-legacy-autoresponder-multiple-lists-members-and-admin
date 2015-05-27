<?php
include "db.php";
function unique_id($l = 8)
{
$better_token = md5(uniqid(rand(), true));
$rem = strlen($better_token)-$l;
$unique_code = substr($better_token, 0, -$rem);
$uniqueid = $unique_code;
return $uniqueid;
}
//echo unique_id();
$listid = $_REQUEST["listid"];
$referringpage = $_SERVER["HTTP_REFERER"];
$signupip = $_SERVER["REMOTE_ADDR"];
$error = "";
$add_to_message = "";

$listq = "select * from autoresponders_lists where id=\"$listid\"";
$listr = mysql_query($listq);
$listrows = mysql_num_rows($listr);
if ($listrows < 1)
{
include "header.php";
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">Error</div></td></tr>
<tr><td align="center" colspan="2"><br>This list is no longer in the system!</td></tr>
<tr><td align="center" colspan="2"><br><a href="<?php echo $ar_defaultredirecturlaftersubscribeformsubmission ?>">Please click here to continue</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "footer.php";
exit;
}
if ($listrows > 0)
{
$sponsor_userid = mysql_result($listr,0,"userid");
$listname = mysql_result($listr,0,"listname");
$submitform_redirecturl = mysql_result($listr,0,"submitform_redirecturl");
$verificationheaderbodyhtml = mysql_result($listr,0,"verificationheaderbodyhtml");
$verificationheaderbodyhtml = stripslashes($verificationheaderbodyhtml);
$verificationheaderbodyhtml = str_replace('\\', '', $verificationheaderbodyhtml); 
$verificationheaderbodytext = mysql_result($listr,0,"verificationheaderbodytext");
$verificationheaderbodytext = stripslashes($verificationheaderbodytext);
$verificationheaderbodytext = str_replace('\\', '', $verificationheaderbodytext); 
$verificationmessagehtml = mysql_result($listr,0,"verificationmessagehtml");
$verificationmessagehtml = stripslashes($verificationmessagehtml);
$verificationmessagehtml = str_replace('\\', '', $verificationmessagehtml); 
$verificationmessagetext = mysql_result($listr,0,"verificationmessagetext");
$verificationmessagetext = stripslashes($verificationmessagetext);
$verificationmessagetext = str_replace('\\', '', $verificationmessagetext); 
$verificationsubject = mysql_result($listr,0,"verificationsubject");
$verificationsubject = stripslashes($verificationsubject);
$verificationsubject = str_replace('\\', '', $verificationsubject); 
$verificationfromfield = mysql_result($listr,0,"verificationfromfield");
$verificationfromfield = stripslashes($verificationfromfield);
$verificationfromfield = str_replace('\\', '', $verificationfromfield); 
$verificationdisclaimerbodyhtml = mysql_result($listr,0,"verificationdisclaimerbodyhtml");
$verificationdisclaimerbodyhtml = stripslashes($verificationdisclaimerbodyhtml);
$verificationdisclaimerbodyhtml = str_replace('\\', '', $verificationdisclaimerbodyhtml); 
$verificationdisclaimerbodytext = mysql_result($listr,0,"verificationdisclaimerbodytext");
$verificationdisclaimerbodytext = stripslashes($verificationdisclaimerbodytext);
$verificationdisclaimerbodytext = str_replace('\\', '', $verificationdisclaimerbodytext); 

$limitsq = "select * from members where userid=\"$sponsor_userid\"";
$limitsr = mysql_query($limitsq);
$limitsrows = mysql_num_rows($limitsr);
if ($limitsrows > 0)
	{
	$sponsor_accounttype = mysql_result($limitsr,0,"accounttype");
		if ($sponsor_accounttype == "PAID")
		{
		$ar_howmanylists = $ar_howmanylistspaid;
		$ar_howmanyprospectsperlist = $ar_howmanyprospectsperlistpaid;
		$ar_maxprospectsmailedperlist = $ar_maxprospectsmailedperlistpaid;
		$ar_maxautoresponderemails = $ar_maxautoresponderemailspaid;
		$ar_bouncestoautounsubscribe = $ar_bouncestoautounsubscribepaid;
		}
		if ($sponsor_accounttype != "PAID")
		{
		$ar_howmanylists = $ar_howmanylistsfree;
		$ar_howmanyprospectsperlist = $ar_howmanyprospectsperlistfree;
		$ar_maxprospectsmailedperlist = $ar_maxprospectsmailedperlistfree;
		$ar_maxautoresponderemails = $ar_maxautoresponderemailsfree;
		$ar_bouncestoautounsubscribe = $ar_bouncestoautounsubscribefree;
		}
		$howmanyq = "select * from autoresponders_prospects where userid=\"$sponsor_userid\" and listname=\"$listname\"";
		$howmanyr = mysql_query($howmanyq);
		$howmanyrows = mysql_num_rows($howmanyr);
		if ($howmanyrows < 1)
		{
		$has = 0;
		}
		if ($howmanyrows > 0)
		{
		$has = $howmanyrows;
		}	
		if (($howmanyrows >= $ar_howmanyprospectsperlist) and ($ar_howmanyprospectsperlist != "Infinite"))
		{
		include "header.php";
		?>
		<!-- PAGE CONTENT //-->
		<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
		<tr><td align="center" colspan="2"><br><div class="heading">Error</div></td></tr>
		<tr><td align="center" colspan="2"><br>Sorry, this Mailing List has already reached the maximum number of <?php echo $ar_howmanyprospectsperlist ?> subscribers!</td></tr>
		<tr><td align="center" colspan="2"><br><a href="<?php echo $submitform_redirecturl ?>">Please click here to continue</a></td></tr>
		</table>
		<!-- END PAGE CONTENT //-->
		<?php
		include "footer.php";
		exit;
		}
	} # if ($limitsrows > 0)

	$q2 = "select * from autoresponder_userfields_forms where userid=\"$sponsor_userid\" and listnameid=\"$listid\" order by fieldname";
	$r2 = mysql_query($q2);
	$rows2 = mysql_num_rows($r2);
	if ($rows2 < 1)
	{
	include "header.php";
	?>
	<!-- PAGE CONTENT //-->
	<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
	<tr><td align="center" colspan="2"><br><div class="heading">Error</div></td></tr>
	<tr><td align="center" colspan="2"><br>This List still needs to be configured!</td></tr>
	<tr><td align="center" colspan="2"><br><a href="<?php echo $submitform_redirecturl ?>">Please click here to continue</a></td></tr>
	</table>
	<!-- END PAGE CONTENT //-->
	<?php
	include "footer.php";
	exit;
	}
	if ($rows2 > 0)
	{
		while ($rowz2 = mysql_fetch_array($r2))
		{
			$fieldname = $rowz2["fieldname"];
			eval("\$fieldnamevalue = \$_POST[\"$fieldname\"];");
			$type = $rowz2["type"];
			if ($fieldnamevalue == "")
			{
				if ($type == "system")
				{
					if ($fieldname == "firstname")
					{
					$error .= "<li>Please return and enter your first name field.</li>";
					}
					if ($fieldname == "lastname")
					{
					$error .= "<li>Please return and enter your last name field.</li>";
					}
					if ($fieldname == "email")
					{
					$error .= "<li>Please return and enter your email address field.</li>";
					}
					if ($fieldname == "howfound")
					{
					$error .= "<li>Please return and tell us how you found our website.</li>";
					}
				} # if ($type == "system")
				if ($type != "system")
				{
					$q3 = "select * from autoresponder_userfields where userid=\"$sponsor_userid\" and fieldname=\"$fieldname\"";
					$r3 = mysql_query($q3);
					$rows3 = mysql_num_rows($r3);
					if ($rows3 > 0)
					{
						$fieldtitle = mysql_result($r3,0,"fieldtitle");
						$error .= "<li>Please return and enter the " . $fieldtitle . " field.</li>";
					}
				} # if ($type != "system")
			} # if ($fieldnamevalue == "")
			if ($fieldnamevalue != "")
			{
				if ($type == "system")
				{
					if ($fieldname == "firstname")
					{
					$add_to_message .= "First Name: " . $fieldnamevalue . "\n";
					}
					if ($fieldname == "lastname")
					{
					$add_to_message .= "Last Name: " . $fieldnamevalue . "\n";
					}
					if ($fieldname == "email")
					{
					$add_to_message .= "Email: " . $fieldnamevalue . "\n";
					}
					if ($fieldname == "howfound")
					{
					$add_to_message .= "How They Found Your Website: " . $fieldnamevalue . "\n";
					}
				} # if ($type == "system")
				if ($type != "system")
				{
					$q3 = "select * from autoresponder_userfields where userid=\"$sponsor_userid\" and fieldname=\"$fieldname\"";
					$r3 = mysql_query($q3);
					$rows3 = mysql_num_rows($r3);
					if ($rows3 > 0)
					{
						$fieldtitle = mysql_result($r3,0,"fieldtitle");
						$add_to_message .= $fieldtitle . ": " . $fieldnamevalue . "\n";
					}
				} # if ($type != "system")
			} # if ($fieldnamevalue != "")
		} # while ($rowz2 = mysql_fetch_array($r2))

		if(!$error == "")
		{
		include "header.php";
		?>
		<!-- CONTENT //-->
		<table cellpadding="4" cellspacing="0" border="0" width="75%" align="center">
		<tr><td align="center" colspan="2"><br><div class="heading">ERROR</div></td></tr>
		<tr><td  colspan="2"><br>Please return to the form and correct the following problems:<br>
		<ul><?php echo $error ?></ul>
		</td></tr>
		<tr><td align="center" colspan="2">
		<input type="button" value="Return To Form" onclick="javascript:history.back();" class="sendit">
		</td></tr>
		</table>
		<!-- END CONTENT //-->
		<?php
		include "footer.php";
		exit;
		}

		$alreadyq = "select * from autoresponders_prospects where userid=\"$sponsor_userid\" and listname=\"$listname\" and email=\"$email\"";
		$alreadyr = mysql_query($alreadyq);
		$alreadyrows = mysql_num_rows($alreadyr);
		if ($alreadyrows > 0)
		{
		include "header.php";
		?>
		<!-- CONTENT //-->
		<table cellpadding="4" cellspacing="0" border="0" width="75%" align="center">
		<tr><td align="center" colspan="2"><br><div class="heading">ERROR</div></td></tr>
		<tr><td  align="center" colspan="2"><br>You are already subscribed to this mailing list!</td></tr>
		<tr><td align="center" colspan="2"><br><a href="<?php echo $submitform_redirecturl ?>">Please click here to continue</a></td></tr>
		</table>
		<!-- END CONTENT //-->
		<?php
		include "footer.php";
		exit;
		}

		$verifiedcode = unique_id();
		$pidq = "select * from autoresponders_prospects order by id desc limit 1";
		$pidr = mysql_query($pidq);
		$pidrows = mysql_num_rows($pidr);
		if ($pidrows > 0)
		{
		$lastid = mysql_result($pidr,0,"id");
		$id = $lastid+1;
		}
		if ($pidrows < 1)
		{
		$id = 1;
		}
		$prospectq = "insert into autoresponders_prospects (id,userid,firstname,lastname,email,howfound,referringpage,howmanydays,signupdate,signupip,listname,verifiedcode) values (\"$id\",\"$sponsor_userid\",\"$firstname\",\"$lastname\",\"$email\",\"$howfound\",\"$referringpage\",\"0\",NOW(),\"$signupip\",\"$listname\",\"$verifiedcode\")";
		$prospectr = mysql_query($prospectq) or die(mysql_error());

		## SAVE CUSTOM USER FIELD DATA
		$cq2 = "select * from autoresponder_userfields_forms where userid=\"$sponsor_userid\" and listnameid=\"$listid\" order by fieldname";
		$cr2 = mysql_query($cq2);
		$crows2 = mysql_num_rows($cr2);
		if ($crows2 > 0)
		{
			while ($crowz2 = mysql_fetch_array($cr2))
			{
				$cfieldname = $crowz2["fieldname"];
				eval("\$cfieldnamevalue = \$_POST[\"$cfieldname\"];");
				$ctype = $crowz2["type"];
				if (($cfieldnamevalue != "") and ($ctype != "system"))
				{
					$cq3 = "insert into autoresponder_userfields_data (userid,prospectid,fieldname,fieldvalue) values (\"$sponsor_userid\",\"$id\",\"$cfieldname\",\"$cfieldnamevalue\")";
					$cr3 = mysql_query($cq3);
				} # if (($cfieldnamevalue != "") and ($ctype != "system"))
			} # while ($crowz2 = mysql_fetch_array($cr2))
		} # if ($crows2 > 0)

		## SEND VERIFICATION EMAIL ##

		###### SUBSTITUTION ######
		$varq = "select * from autoresponder_substitution_variables where userid=\"$sponsor_userid\" or variabletype=\"system\" order by variabletype";
		$varr = mysql_query($varq);
		$varrows = mysql_num_rows($varr);
		if ($varrows > 0)
		{
			while ($varrowz = mysql_fetch_array($varr))
			{
			$variablename = $varrowz["variablename"];
			$variablevalue = $varrowz["variablevalue"];
			$variabletype = $varrowz["variabletype"];
			if ($variabletype == "system")
				{
				$verificationsubject = ereg_replace ($variablename, $$variablevalue, $verificationsubject);
				$verificationheaderbodyhtml = ereg_replace ($variablename, $$variablevalue, $verificationheaderbodyhtml);
				$verificationmessagehtml = ereg_replace ($variablename, $$variablevalue, $verificationmessagehtml);
				$verificationdisclaimerbodyhtml = ereg_replace ($variablename, $$variablevalue, $verificationdisclaimerbodyhtml);
				$verificationheaderbodytext = ereg_replace ($variablename, $$variablevalue, $verificationheaderbodytext);
				$verificationmessagetext = ereg_replace ($variablename, $$variablevalue, $verificationmessagetext);
				$verificationdisclaimerbodytext = ereg_replace ($variablename, $$variablevalue, $verificationdisclaimerbodytext);
				}
			if ($variabletype != "system")
				{
				$verificationsubject = ereg_replace ($variablename, $variablevalue, $verificationsubject);
				$verificationheaderbodyhtml = ereg_replace ($variablename, $variablevalue, $verificationheaderbodyhtml);
				$verificationmessagehtml = ereg_replace ($variablename, $variablevalue, $verificationmessagehtml);
				$verificationdisclaimerbodyhtml = ereg_replace ($variablename, $variablevalue, $verificationdisclaimerbodyhtml);
				$verificationheaderbodytext = ereg_replace ($variablename, $variablevalue, $verificationheaderbodytext);
				$verificationmessagetext = ereg_replace ($variablename, $variablevalue, $verificationmessagetext);
				$verificationdisclaimerbodytext = ereg_replace ($variablename, $$variablevalue, $verificationdisclaimerbodytext);
				}
			}
		} # if ($varrows > 0)
		#### END SUBSTITUTION ####

		if ($verificationmessagehtml != "")
			{
			$clicklinkhtml = "<br><a href=\"".$domain."/ar_verify.php?id=".$id."&code=".$verifiedcode."&list=" . $listid . "\">Click Here to Verify your Subscription!</a><br>";
			$removelinkhtml = $verificationdisclaimerbodyhtml . "<br>" . "<a href=" . $domain . "/remove.php?r=" . $email . ">" . $domain . "/remove.php?r=" . $email . "</a><br><br>";
				if ($verificationheaderbodyhtml != "")
				{
				$messagehtml .= $verificationheaderbodyhtml;
				$messagehtml .= "===================================================================<br><br>";
				}
			$messagehtml .= $verificationmessagehtml;
			$messagehtml .= "<br><br>===================================================================<br><br>";
			$messagehtml .= $clicklinkhtml;
			$messagehtml .= "<br><br>===================================================================<br><br>";
			$messagehtml .= $removelinkhtml;
			}
		if ($verificationmessagetext != "")
			{
			$clicklinktext = "\nClick Here to View! ".$domain."/ar_verify.php?id=".$id."&code=".$verifiedcode."&list=".$listid."\n";
			$removelinktext = $verificationdisclaimerbodytext . "\n\n" . $domain . "/remove.php?r=" . $email . "\n\n";
				if ($verificationheaderbodytext != "")
				{
				$messagetext .= $verificationheaderbodytext;
				$messagetext .= "===================================================================\n\n";
				}
			$messagetext .= $verificationmessagetext;
			$messagetext .= "\n\n===================================================================\n\n";
			$messagetext .= $clicklinktext;
			$messagetext .= "\n\n===================================================================\n\n";
			$messagetext .= $removelinktext;
			}

			$return_path = $ar_bounceemail;
			$boundary = md5(date('U'));

			$verificationheaders = "MIME-Version: 1.0\n";
			$verificationheaders .= "From: " . $verificationfromfield . " <" . $ar_bounceemail . ">\n";
			$verificationheaders .= "X-Mailer: PHP - $sitename Double-Opt-In Verification\n";
			$verificationheaders .= "Return-Path: $return_path\n";
			$verificationheaders .= "Reply-To: " . "<" . $ar_bounceemail . ">\n";
			$verificationheaders .= "Content-Type: multipart/alternative;boundary=" . $boundary . "\n";

			# Plain Text
			$verificationmessage .= $messagetext;
			$verificationmessage .= "\n\n--" . $boundary . "\n";
			$verificationmessage .= "Content-type: text/html;charset=utf-8\n\n";

			# HTML
			$verificationmessage .= $messagehtml;
			$verificationmessage .= "\n\n--" . $boundary . "--";			   

			@mail ($email, $verificationsubject, $verificationmessage, $verificationheaders, "-f" . $return_path);

			############ email the sponsor who referrerd this prospect to their autoresponder.
			$sq = "select * from members where userid=\"$sponsor_userid\"";
			$sr = mysql_query($sq);
			$srows = mysql_num_rows($sr);
			if ($srows > 0)
			{
			$sponsor_email = mysql_result($sr,0,"email");
			$sponsor_email_array = explode("@",$sponsor_email);
			$sponsor_email_domain = $sponsor_email_array[1];
			if ($sponsor_email_domain == "")
				{
				$sendto_sponsor_email = $sponsor_email . "@gmail.com";
				}
			if ($sponsor_email_domain != "")
				{
				$sendto_sponsor_email = $sponsor_email;
				}
			$headers = "From: " . $sitename . " <$adminemail>";
			$subject = "A New Prospect has Signed Up for one of your AutoResponder Mailing Lists!";
			$message = "";
			$message .= "Before they begin to receive the AutoResponder messages, they will need to verify their email address.\n\n";
			$message .= "Mailing List: ";
			$message .= $listname . "\n\n";
			$message .= $add_to_message;
			$message .= "\n\n";
			$message .= "You may login to your " . $sitename . " members area at any time to view your Prospects or to
			configure your AutoResponder messages and system.\n\n";
			$message .= "Thank you!\n" . $sitename . " Admin\n" . $domain . "\n\n";
			@mail ($sendto_sponsor_email, $subject, $message, $headers, "-f" . $adminemail);
			} # if ($srows > 0)
			############

			include "header.php";
			?>
			<!-- CONTENT //-->
			<table cellpadding="4" cellspacing="0" border="0" width="75%" align="center">
			<tr><td align="center" colspan="2"><br><div class="heading">Thank You for Registering!</div></td></tr>
			<tr><td align="center" colspan="2"><br>Please check the inbox of the email address you used to signup with for a verification email to confirm your subscription.<br>
			If you can't find the email with this link, please check your mailbox's spam or bulk folder, and whitelist emails from our site so future messages aren't lost or filtered.
			</td></tr>
			<?php
			if ($submitform_redirecturl != "")
			{
			?>
			<tr><td align="center" colspan="2">
			<a href="<?php echo $submitform_redirecturl ?>">Please click here to continue</a>
			</td></tr>
			<?php
			}
			else
			{
			?>
			<tr><td align="center" colspan="2">
			<a href="<?php echo $ar_defaultredirecturlaftersubscribeformsubmission ?>">Please click here to continue</a>
			</td></tr>
			<?php
			}
			?>
			</table>
			<!-- END CONTENT //-->
			<?php
			include "footer.php";
			exit;

	} # if ($rows2 > 0)
} # if ($listrows > 0)
?>