<?php
include "control.php";
include "header.php";
?>
<script type="text/javascript">
function changeHiddenInput(objDropDown)
{
	var solodata=objDropDown.value.split("||");
	var soloid=solodata[0];
	if (soloid)
	{
		var solosendtoprospectlists=solodata[1];
		var solofromfield=solodata[2];
		var solofromemail=solodata[3];
		var solourl=solodata[4];
		var solosubject=solodata[5];
		var soloadbodyhtml=solodata[6];
		var solodisclaimerbodyhtml=solodata[7];
		var soloadbodytext=solodata[8];
		var solodisclaimerbodytext=solodata[9];
		var soloheaderbodyhtml=solodata[10];
		var soloheaderbodytext=solodata[11];
		var newlists_array=solosendtoprospectlists.split("~");
		for (var i=0;i<newlists_array.length;i++)
		{
			if (newlists_array[i] != "")
			{
			var thelistname = "list-"+newlists_array[i];
			document.getElementById(thelistname).checked = true;
			}
		}
		var objdeleteid = document.getElementById("deleteid");
		var objsaveid = document.getElementById("saveid");	
		var objsavefromemail = document.getElementById("fromemail");
		var objsavefromfield = document.getElementById("fromfield");
		var objsaveurl = document.getElementById("url");
		var objsavesubject = document.getElementById("subject");
		var objsaveheaderbodytext = document.getElementById("headerbodytext");
		var objsaveadbodytext = document.getElementById("adbodytext");
		var objsavedisclaimerbodytext = document.getElementById("disclaimerbodytext");
		objdeleteid.value = soloid;
		objsaveid.value = soloid;
		objsaveurl.value = solourl;
		objsavefromemail.value = solofromemail;
		objsavefromfield.value = solofromfield;
		objsaveurl.value = solourl;
		objsavesubject.value = solosubject;
		objsaveheaderbodytext.value = soloheaderbodytext;
		objsaveadbodytext.value = soloadbodytext;
		objsavedisclaimerbodytext.value = solodisclaimerbodytext;
		document.getElementById('save').checked = true;
		CKEDITOR.instances.headerbodyhtml.setData(soloheaderbodyhtml);
		CKEDITOR.instances.adbodyhtml.setData(soloadbodyhtml);
		CKEDITOR.instances.disclaimerbodyhtml.setData(solodisclaimerbodyhtml);
	}
	else
	{
		var cbs = document.getElementsByTagName('input');
		for (var i = 0; i < cbs.length; i++) {
			if (cbs[i].type == 'checkbox') {
				if (cbs[i].name == 'newlists[]') {
					cbs[i].checked = false;
				}
			}
		}
		var objdeleteid = document.getElementById("deleteid");
		var objsaveid = document.getElementById("saveid");
		var objsavefromemail = document.getElementById("fromemail");
		var objsavefromfield = document.getElementById("fromfield");
		var objsaveurl = document.getElementById("url");
		var objsavesubject = document.getElementById("subject");
		var objsaveheaderbodytext = document.getElementById("headerbodytext");
		var objsaveadbodytext = document.getElementById("adbodytext");
		var objsavedisclaimerbodytext = document.getElementById("disclaimerbodytext");
		objsaveurl.value = "";
		objsavefromemail.value = "";
		objsavefromfield.value = "";
		objsaveurl.value = "";
		objsavesubject.value = "";
		objsaveheaderbodytext.value = "";
		objsaveadbodytext.value = "";
		objsavedisclaimerbodytext.value = "";
		document.getElementById('save').checked = false;
		CKEDITOR.instances.headerbodyhtml.setData('');
		CKEDITOR.instances.adbodyhtml.setData('');
		CKEDITOR.instances.disclaimerbodyhtml.setData('');
	}
}
</script> 
<?php
$action = $_POST["action"];
$error = "";
$show = "";
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
##############################################
if ($action == "send")
{
	$fromemail = $_POST["fromemail"];
	$fromfield = $_POST["fromfield"];
	$url = $_POST["url"];
	$subject = $_POST["subject"];
	$headerbodyhtml = $_POST["headerbodyhtml"];
	$adbodyhtml = $_POST["adbodyhtml"];
	$disclaimerbodyhtml = $_POST["disclaimerbodyhtml"];
	$headerbodytext = $_POST["headerbodytext"];
	$adbodytext = $_POST["adbodytext"];
	$disclaimerbodytext = $_POST["disclaimerbodytext"];
	$newlists = $_POST["newlists"];
	$saveid = $_POST["saveid"];
	$save = $_POST["save"];
	if (!$fromfield)
	{
	$error .= "<div>No from field name was entered.</div>";
	}
	if (!$url)
	{
	$error .= "<div>No URL was entered.</div>";
	}
	if (!$subject)
	{
	$error .= "<div>No subject was entered.</div>";
	}
	if (($adbodyhtml == "") and ($adbodytext == ""))
	{
	$error .= "<div>No message body was entered.</div>";
	}
	if (($adbodyhtml != "") and ($disclaimerbodyhtml == ""))
	{
	$error .= "<div>You entered an HTML message body, but did not add an HTML disclaimer.</div>";
	}
	if (($adbodytext != "") and ($disclaimerbodytext == ""))
	{
	$error .= "<div>You entered a Plain Text message body, but did not add a Plain Text disclaimer.</div>";
	}
	if (empty($newlists))
	{
	$error .= "<div>You didn't check any of your Mailing Lists to send to.</div>";
	}
	if(!empty($newlists))
	{
		$buildquery = "and (";
		foreach ($newlists as $checked)
		{
		$buildquery = $buildquery . "listname=\"$checked\" or ";
		}
		$buildquery = substr($buildquery, 0, -4); 
		$buildquery = $buildquery . ")";
		$q = "select * from autoresponders_prospects where unsubscribed!=\"yes\" and verified=\"yes\" and vacation!=\"yes\" and userid=\"$userid\"" . $buildquery . " order by email";
		$r = mysql_query($q);
		$rows = mysql_num_rows($r);
		if ($rows < 1)
			{
			$error .= "<div>Sorry there are currently no subscribed email addresses to send to in the prospect groups specified!</div>";
			}
	} # if(empty($newlists))
	if(!$error == "")
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="80%">
	<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
	<tr><td align="center" colspan="2"><br><?php echo $error ?></td></tr>
	<tr><td colspan="2" align="center"><br><a href="autoresponder_directmailout.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "footer.php";
	exit;
	}

if(!$fromemail)
{
$fromemail = $ar_bounceemail;
}
$headerbodyhtml = stripslashes($adbodyhtml);
$headerbodyhtml = str_replace('\\', '', $headerbodyhtml);
$headerbodyhtml = mysql_real_escape_string($headerbodyhtml);
$adbodyhtml = stripslashes($adbodyhtml);
$adbodyhtml = str_replace('\\', '', $adbodyhtml);
$adbodyhtml = mysql_real_escape_string($adbodyhtml);
$disclaimerbodyhtml = stripslashes($disclaimerbodyhtml);
$disclaimerbodyhtml = str_replace('\\', '', $disclaimerbodyhtml);
$disclaimerbodyhtml = mysql_real_escape_string($disclaimerbodyhtml);
$headerbodytext = stripslashes($headerbodytext);
$headerbodytext = str_replace('\\', '', $headerbodytext);
$headerbodytext = mysql_real_escape_string($headerbodytext);
$adbodytext = stripslashes($adbodytext);
$adbodytext = str_replace('\\', '', $adbodytext);
$adbodytext = mysql_real_escape_string($adbodytext);
$disclaimerbodytext = stripslashes($disclaimerbodytext);
$disclaimerbodytext = str_replace('\\', '', $disclaimerbodytext);
$disclaimerbodytext = mysql_real_escape_string($disclaimerbodytext);
$subject = stripslashes($subject);
$subject = str_replace('\\', '', $subject); 
$subject = mysql_real_escape_string($subject);
$fromfield = stripslashes($fromfield);
$fromfield = str_replace('\\', '', $fromfield); 
$fromfield = mysql_real_escape_string($fromfield);
$sendtoprospectlists = "";
foreach ($newlists as $thislist)
{
$sendtoprospectlists = $sendtoprospectlists . "~" . $thislist;	
}
$q = "insert into autoresponder_directmail (userid,fromfield,fromemail,subject,adbodyhtml,adbodytext,url,disclaimerbodyhtml,disclaimerbodytext,headerbodyhtml,headerbodytext,sendtoprospectlists) values ('$userid','$fromfield','$fromemail','$subject','$adbodyhtml','$adbodytext','$url','$disclaimerbodyhtml','$disclaimerbodytext','$headerbodyhtml','$headerbodytext','$sendtoprospectlists')";
$r = mysql_query($q) or die(mysql_error());

		if($save)
		{
			if ($saveid != "")
			{
				$saveq = "select * from autoresponder_directmail_saved where id='$saveid'";
				$saver = mysql_query($saveq);
				$saverows = mysql_num_rows($saver);
				if ($saverows < 1)
				{
				mysql_query("insert into autoresponder_directmail_saved (userid,fromfield,fromemail,subject,adbodyhtml,adbodytext,url,disclaimerbodyhtml,disclaimerbodytext,headerbodyhtml,headerbodytext,sendtoprospectlists) values('$userid','$fromfield','$fromemail','$subject','$adbodyhtml','$adbodytext','$url','$disclaimerbodyhtml','$disclaimerbodytext','$headerbodyhtml','$headerbodytext','$sendtoprospectlists')") or die(mysql_error());
				}
				if ($saverows > 0)
				{
				mysql_query("update autoresponder_directmail_saved set fromfield='$fromfield',fromemail='$fromemail',subject='$subject',adbodyhtml='$adbodyhtml',adbodytext='$adbodytext',url='$url',disclaimerbodyhtml='$disclaimerbodyhtml',disclaimerbodytext='$disclaimerbodytext',headerbodyhtml='$headerbodyhtml',headerbodytext='$headerbodytext',sendtoprospectlists='$sendtoprospectlists' where userid='$userid' and id='$saveid'") or die(mysql_error());
				}
			}
			if ($saveid == "")
			{
			mysql_query("insert into autoresponder_directmail_saved (userid,fromfield,fromemail,subject,adbodyhtml,adbodytext,url,disclaimerbodyhtml,disclaimerbodytext,headerbodyhtml,headerbodytext,sendtoprospectlists) values('$userid','$fromfield','$fromemail','$subject','$adbodyhtml','$adbodytext','$url','$disclaimerbodyhtml','$disclaimerbodytext','$headerbodyhtml','$headerbodytext','$sendtoprospectlists')") or die(mysql_error());
			}
		} # if($save)
$show = "Your Direct Mail was queued successfully! For your membership level, your message will be sent to " . $ar_maxprospectsmailedperlist . " subscribers.";
} # if ($action == "send")
##############################################
if ($action == "delete")
{
$delq = "delete from autoresponder_directmail_saved where userid=\"$userid\" and id='".$_POST['deleteid']."'";
$delr = mysql_query($delq);
$show = "The saved email was deleted.";
}
########################################################################## SABRINA MARKON 2012 PearlsOfWealth.com
?>
<script type="text/javascript" src="<?php echo $domain ?>/jscripts/jquery.js"></script>
<script type="text/javascript" src="<?php echo $domain ?>/jscripts/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo $domain ?>/jscripts/ckeditor4/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo $domain ?>/jscripts/ckeditor4/adapters/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $domain ?>/jscripts/jquery-ui.css"/>
<div id="previewdlg" title="Preview">
<div id="pvw">
</div>
</div>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">
<?php
if ($show != "")
{
?>
<tr><td align="center" colspan="2"><br><?php echo $show ?></td></tr>
<?php
}
?>
<tr><td align="center" colspan="2"><br><div class="heading">SEND EMAIL TO YOUR PROSPECTS</div></td></tr>

<tr><td align="center" colspan="2">
<?php
include "autoresponder_menu.php";
?>
</td></tr>

<tr><td align="center" colspan="2">
<table cellpadding="2" cellspacing="2" border="0" align="center" width="100%">
<tr><td>
<div style="text-align: center;">
<?php
$q = "select * from pages where name='Members Area - Autoresponder Direct Mailout Page'";
$r = mysql_query($q);
$rowz = mysql_fetch_array($r);
$htmlcode = $rowz["htmlcode"];
echo $htmlcode;
?>
</div>
</td></tr>
</table>
</td></tr>
<?php
$savedq = "select * from autoresponder_directmail_saved where userid=\"$userid\"";
$savedr = mysql_query($savedq);
$savedrows = mysql_num_rows($savedr);
if ($savedrows > 0)
{
?>
<tr><td align="center" colspan="2"><br>
<table width="600" cellpadding="4" cellspacing="2" border="0" align="center" class="sabrinatable">
<tr class="sabrinatrdark"><td align="center" colspan="2">YOUR SAVED EMAILS</td></tr>
<tr class="sabrinatrlight"><td align="center" colspan="2">Select an email from the ones you've saved below, or enter a new one.</td></tr>
<form action="autoresponder_directmailout.php" method="post">
<tr class="sabrinatrdark"><td colspan="2" align="center"><select name="solosavedchoice" id="solosavedchoice" onchange="changeHiddenInput(this)">
<option value=""> - Select Saved Ad - </option>
<?php
while ($savedrowz = mysql_fetch_array($savedr))
	{
	$savedfromfield = $savedrowz["fromfield"];
	$savedfromfield = stripslashes($savedfromfield);
	$savedfromfield = str_replace('\\', '', $savedfromfield); 
	$savedfromfield = stripslashes($savedfromfield);
	$savedfromfield = str_replace('\\', '', $savedfromfield); 
	$savedfromemail = $savedrowz["fromemail"];
	$savedsubject = $savedrowz["subject"];
	$savedsubject = stripslashes($savedsubject);
	$savedsubject = str_replace('\\', '', $savedsubject); 
	$savedheaderbodyhtml = $savedrowz["headerbodyhtml"];
	$savedheaderbodyhtml = stripslashes($savedheaderbodyhtml);
	$savedheaderbodyhtml = str_replace('\\', '', $savedheaderbodyhtml);
	$savedheaderbodyhtml = htmlentities($savedheaderbodyhtml, ENT_COMPAT, "ISO-8859-1");
	$savedadbodyhtml = $savedrowz["adbodyhtml"];
	$savedadbodyhtml = stripslashes($savedadbodyhtml);
	$savedadbodyhtml = str_replace('\\', '', $savedadbodyhtml);
	$savedadbodyhtml = htmlentities($savedadbodyhtml, ENT_COMPAT, "ISO-8859-1");
	$saveddisclaimerbodyhtml = $savedrowz["disclaimerbodyhtml"];
	$saveddisclaimerbodyhtml = stripslashes($saveddisclaimerbodyhtml);
	$saveddisclaimerbodyhtml = str_replace('\\', '', $saveddisclaimerbodyhtml);
	$saveddisclaimerbodyhtml = htmlentities($saveddisclaimerbodyhtml, ENT_COMPAT, "ISO-8859-1");
	$savedheaderbodytext = $savedrowz["headerbodytext"];
	$savedheaderbodytext = stripslashes($savedheaderbodytext);
	$savedheaderbodytext = str_replace('\\', '', $savedheaderbodytext);
	$savedadbodytext = $savedrowz["adbodytext"];
	$savedadbodytext = stripslashes($savedadbodytext);
	$savedadbodytext = str_replace('\\', '', $savedadbodytext);
	$saveddisclaimerbodytext = $savedrowz["disclaimerbodytext"];
	$saveddisclaimerbodytext = stripslashes($saveddisclaimerbodytext);
	$saveddisclaimerbodytext = str_replace('\\', '', $saveddisclaimerbodytext);
	$savedurl = $savedrowz["url"];
	$savedid = $savedrowz["id"];
	$savedsendtoprospectlists = $savedrowz["sendtoprospectlists"];
?>
<option value="<?php echo $savedid ?>||<?php echo $savedsendtoprospectlists ?>||<?php echo $savedfromfield ?>||<?php echo $savedfromemail ?>||<?php echo $savedurl ?>||<?php echo $savedsubject ?>||<?php echo $savedadbodyhtml ?>||<?php echo $saveddisclaimerbodyhtml ?>||<?php echo $savedadbodytext ?>||<?php echo $saveddisclaimerbodytext ?>||<?php echo $savedheaderbodyhtml ?>||<?php echo $savedheaderbodytext ?>"><?php echo $savedsubject ?></option>
<?php
	}
?>
</select>&nbsp;&nbsp;<input type="hidden" name="deleteid" id="deleteid" value=""><input type="hidden" name="action" value="delete"><input type="submit" value="Delete Saved"></td></tr></form>
</table>
</td></tr>
<?php		
} # if ($savedrows > 0)
?>
<tr><td align="center" colspan="2"><br>
<table width="600" cellpadding="4" cellspacing="2" border="0" align="center" class="sabrinatable">
<tr class="sabrinatrlight"><td align="center" colspan="2">SEND DIRECT MAILOUT TO YOUR PROSPECTS</td></tr>
<tr class="sabrinatrdark"><td align="center" colspan="2">For your membership level, you are permitted to send direct mail to <?php echo $ar_maxprospectsmailedperlist ?> recipients per send.</td></tr>
<?php
$listsq = "select * from autoresponders_lists where userid=\"$userid\" order by listname";
$listsr = mysql_query($listsq);
$listsrows = mysql_num_rows($listsr);
if ($listsrows < 1)
{
?>
<tr class="sabrinatrlight"><td align="center" colspan="2">You haven't created any mailing lists to send to yet.</td></tr>
<?php
}
if ($listsrows > 0)
{
$varq = "select * from autoresponder_substitution_variables where userid=\"$userid\" or variabletype=\"system\" order by variabletype";
$varr = mysql_query($varq);
$varrows = mysql_num_rows($varr);
if ($varrows > 0)
{
?>
<tr class="sabrinatrlight"><td valign="top">Your Substitution Variables:</td><td>
<table border="0" cellpadding="2" cellspacing="2" align="center" class="sabrinatable" width="100%">
<tr class="sabrinatrdark"><td align="center">Type Exactly as Shown</td><td align="center">Substitutes</td><td align="center">Type</td></tr>
<?php
	while ($varrowz = mysql_fetch_array($varr))
	{
	$variabletype = $varrowz["variabletype"];
	$variablename = $varrowz["variablename"];
	$variablevalue = $varrowz["variablevalue"];
	$variabledescription = $varrowz["variabledescription"];
	$variabledescription = stripslashes($variabledescription);
	$variabledescription = str_replace('\\', '', $variabledescription);
	if ($variabletype == "system")
		{
		$showvariablevalue = $variabledescription;
		$showtype = "System";
		}
	if ($variabletype != "system")
		{
		$showvariablevalue = $variablevalue;
		$showtype = "Created by You";
		}
	?>
	<tr class="sabrinatrlight"><td><?php echo $variablename ?></td><td><?php echo $showvariablevalue ?></td><td><?php echo $showtype ?></td></td>
	<?php
	}
?>
</table>
</td>
</tr>
<?php
}
?>
<form method="post" name="theform" id="theform" action="autoresponder_directmailout.php">
<tr class="sabrinatrlight"><td>Your Email Address (leave blank to send from the system email):</td><td><input type="text" name="fromemail" id="fromemail" maxlength="255" size="95"></td></tr>
<tr class="sabrinatrlight"><td>Your Name that shows in the From Field:</td><td><input type="text" name="fromfield" id="fromfield" maxlength="255" size="95"></td></tr>
<tr class="sabrinatrlight"><td>Your URL:</td><td><input type="text" name="url" id="url" maxlength="255" size="95"></td></tr>
<tr class="sabrinatrlight"><td>Your Subject:</td><td><input type="text" name="subject" id="subject" maxlength="255" size="95"></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your HTML Header:</td><td><textarea class="ckeditor" rows="10" cols="95" name="headerbodyhtml" id="headerbodyhtml"></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your HTML Message Body (CAREFUL not to mix up the HTML and Plain Text message body fields!):</td><td><textarea class="ckeditor" name="adbodyhtml" id="adbodyhtml" rows="15" cols="95"></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your HTML Disclaimer (do NOT include a remove link because this is added automatically to the end of all the email):</td><td><textarea class="ckeditor" rows="10" cols="95" name="disclaimerbodyhtml" id="disclaimerbodyhtml"></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your Plain Text Header:</td><td><textarea rows="10" cols="95" name="headerbodytext" id="headerbodytext"></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your Plain Text Message Body:</td><td><textarea name="adbodytext" id="adbodytext" rows="15" cols="95"></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your Plain Text Disclaimer (do NOT include a remove link because this is added automatically to the end of all the email):</td><td><textarea rows="10" cols="95" name="disclaimerbodytext" id="disclaimerbodytext"></textarea></td></tr>
<tr class="sabrinatrlight"><td>Mailing Lists To Send To:</td></td><td>
<?php
	while ($listsrowz = mysql_fetch_array($listsr))
	{
	$newid = $listsrowz["id"];
	$newlistname = $listsrowz["listname"];
	?>
	<input type="checkbox" name="newlists[]" id="list-<?php echo $newlistname ?>" value="<?php echo $newlistname ?>">&nbsp;<?php echo $newlistname ?><br>
	<?php
	}
?>
</td></tr>
<tr class="sabrinatrlight"><td align="center" valign="top">Save&nbsp;Email</td><td><input type="checkbox" name="save" id="save" value="1"></td></tr>
<tr class="sabrinatrdark">
<td align="center" colspan="2">
<input type="hidden" name="saveid" id="saveid" value="">
<input type="hidden" name="action" value="send">
<input type="submit" value="SEND" class="sendit">
</form>
</td>
</tr>
<?php
} # if ($listsrows > 0)
?>
</table>
</td></tr>

</table>
<br><br>
<?php
include "footer.php";
exit;
?>
