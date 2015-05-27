<?php
include "../db.php";
###########################
#          SEND REMINDER MAIL           #
###########################
# run every minute.
$rq = "select * from autoresponder_reminders where remindertime<NOW() and remindernextsent<NOW() and totalmailed<=reminderhowmanytimes and reminderenabled=\"yes\"";
$rr = mysql_query($rq);
$rrows = mysql_num_rows($rr);
if ($rrows > 0)
{
	while ($rrowz = mysql_fetch_array($rr))
	{
	$id = $rrowz["id"];
	$userid = $rrowz["userid"];
	$reminderenabled = $rrowz["reminderenabled"];
	$remindertitle = $rrowz["remindertitle"];
	$remindermessage = $rrowz["remindermessage"];
	$remindermessage = stripslashes($remindermessage);
	$remindermessage = str_replace('\\', '', $remindermessage);
	$remindersubject = $rrowz["remindersubject"];
	$remindersubject = stripslashes($remindersubject);
	$remindersubject = str_replace('\\', '', $remindersubject);
	$reminderfromfield = $rrowz["reminderfromfield"];
	$reminderurl = $rrowz["reminderurl"];
	$remindereventstart = $rrowz["remindereventstart"];
	$remindereventend = $rrowz["remindereventend"];
	$remindertime = $rrowz["remindertime"];
	$reminderhowmanytimes = $rrowz["reminderhowmanytimes"];
	$reminderhowmanytimesinterval = $rrowz["reminderhowmanytimesinterval"];
	$reminderlastsent = $rrowz["reminderlastsent"];
	$remindernextsent = $rrowz["remindernextsent"];
	$totalmailed = $rrowz["totalmailed"];
	
	  $uq = "select * from members where userid=\"$userid\"";
	  $ur = mysql_query($uq);
	  $urows = mysql_num_rows($ur);
	  if ($urows > 0)
		{
		$email = mysql_result($ur,0,"email");
		$email_array = explode("@",$email);
		$email_domain = $email_array[1];
		if ($email_domain == "")
			{
			$sendto_email = $email . "@gmail.com";
			}
		if ($email_domain != "")
			{
			$sendto_email = $email;
			}

		$remindermessage .= "<br><br>===================================================================<br><br>";
		$remindermessage .= "<a href=\"" . $reminderurl . "\" target=\"_blank\">Click Here to go to your Reminder's URL: " . $reminderurl . "</a>";
		$remindermessage .= "<br><br>===================================================================<br><br>";

		$to = $sendto_email;
		$headers = "From: $reminderfromfield<$adminemail>\n";
		$headers .= "Reply-To: <$adminemail>\n";
		$headers .= "X-Sender: <$adminemail>\n";
		$headers .= "X-Mailer: PHP - $sitename Reminder\n";
		$headers .= "Return-Path: <$adminemail>\nContent-type: text/html; charset=iso-8859-1\n";

		@mail ($to, $remindersubject, $remindermessage, $headers, "-f" . $adminemail);
		
	if ($reminderhowmanytimes < 2)
			{
			$rq2 = "update autoresponder_reminders set totalmailed=totalmailed+1,reminderlastsent=NOW(),remindernextsent=NOW() where id=\"$id\"";
			$rr2 = mysql_query($rq2);
			}
	if ($reminderhowmanytimes > 1)
			{
			$rq2 = "update autoresponder_reminders set totalmailed=totalmailed+1,reminderlastsent=NOW(),remindernextsent=DATE_ADD(NOW(),INTERVAL $reminderhowmanytimesinterval HOUR) where id=\"$id\"";
			$rr2 = mysql_query($rq2);
			}
		} # if ($urows > 0)
	} # while ($rrowz = mysql_fetch_array($rr))
} # if ($rrows > 0)

###################################
#  SEND DIRECT MAIL SENT TO PROSPECT LISTS  #
###################################
$drq = "select * from autoresponder_directmail where sent=0 and sendtoprospectlists!=\"\" order by id";
$drr = mysql_query($drq);
$drrows = mysql_num_rows($drr);
if ($drrows > 0)
{
	while ($drrowz = mysql_fetch_array($drr))
	{
 	$id = $drrowz["id"];
	$userid = $drrowz["userid"];

	$limitsq = "select * from members where userid=\"$userid\"";
	$limitsr = mysql_query($limitsq);
	$limitsrows = mysql_num_rows($limitsr);
	if ($limitsrows > 0)
		{
		$accounttype = mysql_result($limitsr,0,"accounttype");
			if ($accounttype == "PAID")
			{
			$ar_howmanylists = $ar_howmanylistspaid;
			$ar_howmanyprospectsperlist = $ar_howmanyprospectsperlistpaid;
			$ar_maxprospectsmailedperlist = $ar_maxprospectsmailedperlistpaid;
			$ar_maxautoresponderemails = $ar_maxautoresponderemailspaid;
			$ar_bouncestoautounsubscribe = $ar_bouncestoautounsubscribepaid;
			}
			if ($accounttype != "PAID")
			{
			$ar_howmanylists = $ar_howmanylistsfree;
			$ar_howmanyprospectsperlist = $ar_howmanyprospectsperlistfree;
			$ar_maxprospectsmailedperlist = $ar_maxprospectsmailedperlistfree;
			$ar_maxautoresponderemails = $ar_maxautoresponderemailsfree;
			$ar_bouncestoautounsubscribe = $ar_bouncestoautounsubscribefree;
			}	
		} # if ($limitsrows > 0)

	$fromemail = $drrowz["fromemail"];
	$fromfield = $drrowz["fromfield"];
	$fromfield = stripslashes($fromfield);
	$fromfield = str_replace('\\', '', $fromfield);
	$subject  = $drrowz["subject"];
	$subject = stripslashes($subject);
	$subject = str_replace('\\', '', $subject);
	$url = $drrowz["url"];
	$headerbodyhtml = $drrowz["headerbodyhtml"];
	$headerbodyhtml = stripslashes($headerbodyhtml);
	$headerbodyhtml = str_replace('\\', '', $headerbodyhtml);
	$adbodyhtml = $drrowz["adbodyhtml"];
	$adbodyhtml = stripslashes($adbodyhtml);
	$adbodyhtml = str_replace('\\', '', $adbodyhtml);
	$disclaimerbodyhtml = $drrowz["disclaimerbodyhtml"];
	$disclaimerbodyhtml = stripslashes($disclaimerbodyhtml);
	$disclaimerbodyhtml = str_replace('\\', '', $disclaimerbodyhtml);
	$headerbodytext = $drrowz["headerbodytext"];
	$headerbodytext = stripslashes($headerbodytext);
	$headerbodytext = str_replace('\\', '', $headerbodytext);
	$adbodytext = $drrowz["adbodytext"];
	$adbodytext = stripslashes($adbodytext);
	$adbodytext = str_replace('\\', '', $adbodytext);
	$disclaimerbodytext = $drrowz["disclaimerbodytext"];
	$disclaimerbodytext = stripslashes($disclaimerbodytext);
	$disclaimerbodytext = str_replace('\\', '', $disclaimerbodytext);
	$sendtoprospectlists = $drrowz["sendtoprospectlists"];
	$sendtoprospectlists_array = explode("~",$sendtoprospectlists);
	$dbuildquery = "and (";
	foreach ($sendtoprospectlists_array as $dthelist)
		{
		if ($dthelist != "")
			{
			$dbuildquery .= "listname=\"$dthelist\" or ";
			}
		}
	$dbuildquery = substr($dbuildquery, 0, -4); 
	$dbuildquery = $dbuildquery . ")";
	if ($ar_maxprospectsmailedperlist != "Infinite")
		{
		$dbuildquery = $dbuildquery . " limit $ar_maxprospectsmailedperlist";
		}

	$dq = "select * from autoresponders_prospects where verified=\"yes\" and unsubscribed!=\"yes\" and vacation!=\"yes\" and userid=\"$userid\" ".$dbuildquery."";
	$dr = mysql_query($dq);
	$drows = mysql_num_rows($dr);
	if ($drows > 0)
		{
		while ($drowz = mysql_fetch_array($dr))
			{
			$prospectid = $drowz["id"];
			$firstname = $drowz["firstname"];
			$lastname = $drowz["lastname"];
			$email = $drowz["email"];
			$howfound = $drowz["howfound"];
			$referringpage = $drowz["referringpage"];
			$howmanydays = $drowz["howmanydays"];
			$signupip = $drowz["signupip"];
			$signupdate = $drowz["signupdate"];
			$listname = $drowz["listname"];
			$bounces = $drowz["bounces"];
			$bouncelastdate = $drowz["bouncelastdate"];
			$bouncelasterror = $drowz["bouncelasterror"];

			###### SUBSTITUTION ######
			$varq = "select * from autoresponder_substitution_variables where userid=\"$userid\" or variabletype=\"system\" order by variabletype";
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
					$subject = ereg_replace ($variablename, $$variablevalue, $subject);
					$headerbodyhtml = ereg_replace ($variablename, $$variablevalue, $headerbodyhtml);
					$adbodyhtml = ereg_replace ($variablename, $$variablevalue, $adbodyhtml);
					$disclaimerbodyhtml = ereg_replace ($variablename, $$variablevalue, $disclaimerbodyhtml);
					$headerbodytext = ereg_replace ($variablename, $$variablevalue, $headerbodytext);
					$adbodytext = ereg_replace ($variablename, $$variablevalue, $adbodytext);
					$disclaimerbodytext = ereg_replace ($variablename, $$variablevalue, $disclaimerbodytext);
					}
				if ($variabletype != "system")
					{
					$subject = ereg_replace ($variablename, $variablevalue, $subject);
					$headerbodyhtml = ereg_replace ($variablename, $variablevalue, $headerbodyhtml);
					$adbodyhtml = ereg_replace ($variablename, $variablevalue, $adbodyhtml);
					$disclaimerbodyhtml = ereg_replace ($variablename, $variablevalue, $disclaimerbodyhtml);
					$headerbodytext = ereg_replace ($variablename, $variablevalue, $headerbodytext);
					$adbodytext = ereg_replace ($variablename, $variablevalue, $adbodytext);
					$disclaimerbodytext = ereg_replace ($variablename, $variablevalue, $disclaimerbodytext);
					}
				}
			} # if ($varrows > 0)
			#### END SUBSTITUTION ####

			if ($adbodyhtml != "")
				{
				$clicklinkhtml = "<br><a href=\"".$domain."/autoresponder_click.php?arid=".$id."&type=dm\">Click Here to View!</a><br>";
				$removelinkhtml = $disclaimerbodyhtml . "<br>" . "<a href=" . $domain . "/remove.php?r=" . $email . ">" . $domain . "/remove.php?r=" . $email . "</a><br><br>";
					if ($headerbodyhtml != "")
					{
					$messagehtml .= $headerbodyhtml;
					$messagehtml .= "===================================================================<br><br>";
					}
				$messagehtml .= $adbodyhtml;
				$messagehtml .= "<br><br>===================================================================<br><br>";
				$messagehtml .= $clicklinkhtml;
				$messagehtml .= "<br><br>===================================================================<br><br>";
				$messagehtml .= $removelinkhtml;
				}
			if ($adbodytext != "")
				{
				$clicklinktext = "\nClick Here to View! ".$domain."/autoresponder_click.php?arid=".$id."&type=dm\n";
				$removelinktext = $disclaimerbodytext . "\n\n" . $domain . "/remove.php?r=" . $email . "\n\n";
					if ($headerbodytext != "")
					{
					$messagetext .= $headerbodytext;
					$messagetext .= "===================================================================<br><br>";
					}
				$messagetext .= $adbodytext;
				$messagetext .= "\n\n===================================================================\n\n";
				$messagetext .= $clicklinktext;
				$messagetext .= "\n\n===================================================================\n\n";
				$messagetext .= $removelinktext;
				}

			$to = $email;
			$return_path = "user-" . $prospectid . "-" . $ar_bounceemail;
			$boundary = md5(date('U'));
			$headers = "MIME-Version: 1.0\n";
			$headers .= "From: $fromfield <$fromemail>\n";
			$headers .= "X-Mailer: PHP - $sitename Auto Response\n";
			$headers .= "Return-Path: $return_path\n";
			$headers .= "Reply-To: <$fromemail>\n";
			$headers .= "Content-Type: multipart/alternative;boundary=" . $boundary . "\n";

			# Plain Text
			$message .= $messagetext;
			$message .= "\n\n--" . $boundary . "\n";
			$message .= "Content-type: text/html;charset=utf-8\n\n";

			# HTML
			$message .= $messagehtml;
			$message .= "\n\n--" . $boundary . "--";			   
	
			@mail ($to, $subject, $message, $headers, "-f" . $return_path);

			} # while ($prowz = mysql_fetch_array($pr))
		} # if ($drows > 0)

			$countq = "update autoresponder_directmail set sent=1,datesent=NOW() where id=\"$id\"";
			$countr = mysql_query($countq);

	} # while ($drrowz = mysql_fetch_array($drr))
} # if ($drrows > 0)

####################################
#  SEND SIGNUP AUTORESPONDER MAIL - DAY 0 ONLY   #
####################################
$arq = "select * from autoresponders where autoresponderdays=0 and autoresponderenabled=\"yes\" and sendtoprospectlists!=\"\" order by autoresponderdays";
$arr = mysql_query($arq);
$arrows = mysql_num_rows($arr);
if ($arrows > 0)
{
	while ($arrowz = mysql_fetch_array($arr))
	{
 	$id = $arrowz["id"];
	$userid = $arrowz["userid"];
	$autoresponderfromemail = $arrowz["autoresponderfromemail"];
	$autoresponderfromfield = $arrowz["autoresponderfromfield"];
	$autoresponderfromfield = stripslashes($autoresponderfromfield);
	$autoresponderfromfield = str_replace('\\', '', $autoresponderfromfield);
	$autorespondertitle = $arrowz["autorespondertitle"];
	$autorespondersubject  = $arrowz["autorespondersubject"];
	$autorespondersubject = stripslashes($autorespondersubject);
	$autorespondersubject = str_replace('\\', '', $autorespondersubject);
	$emailclick_redirecturl = $arrowz["emailclick_redirecturl"];
	$headerbodyhtml = $arrowz["headerbodyhtml"];
	$headerbodyhtml = stripslashes($headerbodyhtml);
	$headerbodyhtml = str_replace('\\', '', $headerbodyhtml);
	$autorespondermessagehtml = $arrowz["autorespondermessagehtml"];
	$autorespondermessagehtml = stripslashes($autorespondermessagehtml);
	$autorespondermessagehtml = str_replace('\\', '', $autorespondermessagehtml);
	$disclaimerbodyhtml = $arrowz["disclaimerbodyhtml"];
	$disclaimerbodyhtml = stripslashes($disclaimerbodyhtml);
	$disclaimerbodyhtml = str_replace('\\', '', $disclaimerbodyhtml);
	$headerbodytext = $arrowz["headerbodytext"];
	$headerbodytext = stripslashes($headerbodytext);
	$headerbodytext = str_replace('\\', '', $headerbodytext);
	$autorespondermessagetext = $arrowz["autorespondermessagetext"];
	$autorespondermessagetext = stripslashes($autorespondermessagetext);
	$autorespondermessagetext = str_replace('\\', '', $autorespondermessagetext);
	$disclaimerbodytext = $arrowz["disclaimerbodytext"];
	$disclaimerbodytext = stripslashes($disclaimerbodytext);
	$disclaimerbodytext = str_replace('\\', '', $disclaimerbodytext);
	$autoresponderdays = $arrowz["autoresponderdays"];
	$liststosubscribetoaftersendingthismessage  = $arrowz["liststosubscribetoaftersendingthismessage"];
	$autorespondersendtoprospectlists = $arrowz["sendtoprospectlists"];
	$autorespondersendtoprospectlists_array = explode("~",$autorespondersendtoprospectlists);
	$buildquery = "and (";
	foreach ($autorespondersendtoprospectlists_array as $thelist)
		{
		if ($thelist != "")
			{
			$buildquery .= "listname=\"$thelist\" or ";
			}
		}
	$buildquery = substr($buildquery, 0, -4); 
	$buildquery = $buildquery . ")";

	$pq = "select * from autoresponders_prospects where howmanydays=\"$autoresponderdays\" and verified=\"yes\" and unsubscribed!=\"yes\" and vacation!=\"yes\" and userid=\"$userid\" ".$buildquery."";
	$pr = mysql_query($pq);
	$prows = mysql_num_rows($pr);
	if ($prows > 0)
		{
		while ($prowz = mysql_fetch_array($pr))
			{
			$prospectid = $prowz["id"];
			$firstname = $prowz["firstname"];
			$lastname = $prowz["lastname"];
			$email = $prowz["email"];
			$howfound = $prowz["howfound"];
			$referringpage = $prowz["referringpage"];
			$howmanydays = $prowz["howmanydays"];
			$signupip = $prowz["signupip"];
			$signupdate = $prowz["signupdate"];
			$listname = $prowz["listname"];
			$bounces = $prowz["bounces"];
			$bouncelastdate = $prowz["bouncelastdate"];
			$bouncelasterror = $prowz["bouncelasterror"];
			$verified = $prowz["verified"];
			$verifieddate = $prowz["verifieddate"];
			$verifiedip = $prowz["verifiedip"];
			$vacation = $prowz["vacation"];
			$vacationdate = $prowz["vacationdate"];
			$unsubscribed = $prowz["unsubscribed"];
			$unsubscribed = $prowz["unsubscribed"];

			$countq = "update autoresponders set totalmailed=totalmailed+1 where id=\"$id\"";
			$countr = mysql_query($countq);

			###### SUBSTITUTION ######
			$varq = "select * from autoresponder_substitution_variables where userid=\"$userid\" or variabletype=\"system\" order by variabletype";
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
					$autorespondersubject = ereg_replace ($variablename, $$variablevalue, $autorespondersubject);
					$headerbodyhtml = ereg_replace ($variablename, $$variablevalue, $headerbodyhtml);
					$autorespondermessagehtml = ereg_replace ($variablename, $$variablevalue, $autorespondermessagehtml);
					$disclaimerbodyhtml = ereg_replace ($variablename, $$variablevalue, $disclaimerbodyhtml);
					$headerbodytext = ereg_replace ($variablename, $$variablevalue, $headerbodytext);
					$autorespondermessagetext = ereg_replace ($variablename, $$variablevalue, $autorespondermessagetext);
					$disclaimerbodytext = ereg_replace ($variablename, $$variablevalue, $disclaimerbodytext);
					}
				if ($variabletype != "system")
					{
					$autorespondersubject = ereg_replace ($variablename, $variablevalue, $autorespondersubject);
					$headerbodyhtml = ereg_replace ($variablename, $variablevalue, $headerbodyhtml);
					$autorespondermessagehtml = ereg_replace ($variablename, $variablevalue, $autorespondermessagehtml);
					$disclaimerbodyhtml = ereg_replace ($variablename, $variablevalue, $disclaimerbodyhtml);
					$headerbodytext = ereg_replace ($variablename, $variablevalue, $headerbodytext);
					$autorespondermessagetext = ereg_replace ($variablename, $variablevalue, $autorespondermessagetext);
					$disclaimerbodytext = ereg_replace ($variablename, $$variablevalue, $disclaimerbodytext);
					}
				}
			} # if ($varrows > 0)
			#### END SUBSTITUTION ####

			if ($autorespondermessagehtml != "")
				{
				$clicklinkhtml = "<br><a href=\"".$domain."/autoresponder_click.php?arid=".$id."&type=ar\">Click Here to View!</a><br>";
				$removelinkhtml = $disclaimerbodyhtml . "<br>" . "<a href=" . $domain . "/remove.php?r=" . $email . ">" . $domain . "/remove.php?r=" . $email . "</a><br><br>";
					if ($headerbodyhtml != "")
					{
					$messagehtml .= $headerbodyhtml;
					$messagehtml .= "===================================================================<br><br>";
					}
				$messagehtml .= $autorespondermessagehtml;
				$messagehtml .= "<br><br>===================================================================<br><br>";
				$messagehtml .= $clicklinkhtml;
				$messagehtml .= "<br><br>===================================================================<br><br>";
				$messagehtml .= $removelinkhtml;
				}
			if ($autorespondermessagetext != "")
				{
				$clicklinktext = "\nClick Here to View! ".$domain."/autoresponder_click.php?arid=".$id."&type=ar\n";
				$removelinktext = $disclaimerbodytext . "\n\n" . $domain . "/remove.php?r=" . $email . "\n\n";
					if ($headerbodytext != "")
					{
					$messagetext .= $headerbodytext;
					$messagetext .= "===================================================================<br><br>";
					}
				$messagetext .= $autorespondermessagetext;
				$messagetext .= "\n\n===================================================================\n\n";
				$messagetext .= $clicklinktext;
				$messagetext .= "\n\n===================================================================\n\n";
				$messagetext .= $removelinktext;
				}

			$to = $email;
			$return_path = "user-" . $prospectid . "-" . $ar_bounceemail;
			$boundary = md5(date('U'));
			$headers = "MIME-Version: 1.0\n";
			$headers .= "From: " . $autoresponderfromfield . " <" . $autoresponderfromemail . ">\n";
			$headers .= "X-Mailer: PHP - $sitename Auto Response\n";
			$headers .= "Return-Path: $return_path\n";
			$headers .= "Reply-To: " . "<" . $autoresponderfromemail . ">\n";
			$headers .= "Content-Type: multipart/alternative;boundary=" . $boundary . "\n";

			# Plain Text
			$message .= $messagetext;
			$message .= "\n\n--" . $boundary . "\n";
			$message .= "Content-type: text/html;charset=utf-8\n\n";

			# HTML
			$message .= $messagehtml;
			$message .= "\n\n--" . $boundary . "--";			   
	
			@mail ($to, $autorespondersubject, $message, $headers, "-f" . $return_path);

				########################################
				# see if there are lists to auto-subscribe to after sending this autoresponder email
				if ($liststosubscribetoaftersendingthismessage != "")
				{
					$autosubscribe_array = explode("~",$liststosubscribetoaftersendingthismessage);
					foreach ($autosubscribe_array as $nextlist)
					{
						if ($nextlist != "")
						{
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
						$prospectq = "insert into autoresponders_prospects (id,userid,firstname,lastname,email,howfound,referringpage,howmanydays,signupdate,signupip,listname,verifiedcode,verified,verifiedip,verifieddate,bounces,bouncelastdate,bouncelasterror,vacation,vacationdate,unsubscribed,unsubscribedate) values (\"$id\",\"$userid\",\"$firstname\",\"$lastname\",\"$email\",\"$howfound\",\"$referringpage\",\"0\",NOW(),\"$signupip\",\"$nextlist\",\"$verifiedcode\",\"$verified\",\"$verifiedip\",\"$verifieddate\",\"$bounces\",\"$bouncelastdate\",\"$bouncelasterror\",\"$vacation\",\"$vacationdate\",\"$unsubscribed\",\"$unsubscribedate\")";
						$prospectr = mysql_query($prospectq) or die(mysql_error());

						## SAVE CUSTOM USER FIELD DATA
						$listidq = "select * from autoresponders_lists where userid=\"$userid\" and listname=\"$nextlist\"";
						$listidr = mysql_query($listidq);
						$listidrows = mysql_num_rows($listidr);
						if ($listidrows > 0)
							{
							$nextlistid = mysql_result($listidr,0,"id");
								$cq2 = "select * from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$nextlistid\" order by fieldname";
								$cr2 = mysql_query($cq2);
								$crows2 = mysql_num_rows($cr2);
								if ($crows2 > 0)
								{
									while ($crowz2 = mysql_fetch_array($cr2))
									{
										$cfieldname = $crowz2["fieldname"];
										$ctype = $crowz2["type"];
										$cq3 = "select * from autoresponder_userfields_data where userid=\"$userid\" and prospectid=\"$prospectid\" and fieldname=\"$cfieldname\"";
										$cr3 = mysql_query($cq3);
										$crrows3 = mysql_num_rows($cr3);
										if ($crrows3 > 0)
										{
											$cfieldnamevalue = mysql_result($cr3,0,"fieldvalue");
											if (($cfieldnamevalue != "") and ($ctype != "system"))
											{
												$cq3 = "insert into autoresponder_userfields_data (userid,prospectid,fieldname,fieldvalue) values (\"$userid\",\"$id\",\"$cfieldname\",\"$cfieldnamevalue\")";
												$cr3 = mysql_query($cq3);
											} # if (($cfieldnamevalue != "") and ($ctype != "system"))
										}
									} # while ($crowz2 = mysql_fetch_array($cr2))
								} # if ($crows2 > 0)
							} # if ($listidrows > 0)			
						} # if ($nextlist != "")
					} # foreach ($autosubscribe_array as $nextlist)
				} # if ($liststosubscribetoaftersendingthismessage != "")
				########################################

			$adddayq = "update autoresponders_prospects set howmanydays=1 where id=\"$prospectid\"";
			$adddayr = mysql_query($adddayq);

			} # while ($prowz = mysql_fetch_array($pr))
		} # if ($prows > 0)
	} # while ($arrowz = mysql_fetch_array($arr))
} # if ($arrows > 0)
exit;
?>
