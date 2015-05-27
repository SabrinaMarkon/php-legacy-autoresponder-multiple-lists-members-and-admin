<?php
include "../db.php";
function unique_id($l = 8)
{
$better_token = md5(uniqid(rand(), true));
$rem = strlen($better_token)-$l;
$unique_code = substr($better_token, 0, -$rem);
$uniqueid = $unique_code;
return $uniqueid;
}
###########################
#      SEND AUTORESPONDER MAIL      #
###########################
# run once every 24 hours only.
$adddayq = "update autoresponders_prospects set howmanydays=howmanydays+1 where verified=\"yes\" and unsubscribed!=\"yes\" and vacation!=\"yes\"";
$adddayr = mysql_query($adddayq);

$arq = "select * from autoresponders where autoresponderdays>0 and autoresponderenabled=\"yes\" and sendtoprospectlists!=\"\" order by autoresponderdays";
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

			} # while ($prowz = mysql_fetch_array($pr))
		} # if ($prows > 0)
	} # while ($arrowz = mysql_fetch_array($arr))
} # if ($arrows > 0)
exit;
?>