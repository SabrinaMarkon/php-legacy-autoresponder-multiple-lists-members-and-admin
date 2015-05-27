<?php
include "control.php";
include "header.php";
$action = $_POST["action"];
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
$maxlistsq = "select * from autoresponders_lists where userid=\"$userid\" order by listname";
$maxlistsr = mysql_query($maxlistsq);
$maxlistsrows = mysql_num_rows($maxlistsr);
if ($maxlistsrows < 1)
{
$has = 0;
}
if ($maxlistsrows > 0)
{
$has = $maxlistsrows;
}
################################################################
if ($action == "newmailinglist")
{
	if (($maxlistsrows >= $ar_howmanylists) and ($ar_howmanylists != "Infinite"))
	{
	?>
	<!-- PAGE CONTENT //-->
	<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
	<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold; color: #ff0000;">ERROR</div></td></tr>
	<tr><td align="center" colspan="2">You already have the maximum <?php echo $ar_howmanylists ?> mailing lists for your membership level.</td></tr>
	<tr><td align="center" colspan="2"><br>
	<input type="button" value="Return To Form" onclick="javascript:history.back();" class="sendit">
	</td></tr>
	</table>
	<!-- END PAGE CONTENT //-->
	<?php
	include "footer.php";
	exit;
	}
	$newlistname = $_POST["newlistname"];
	$newsubmitform_redirecturl = $_POST["newsubmitform_redirecturl"];
	$newverification_redirecturl = $_POST["newverification_redirecturl"];
	$newverificationheaderbodyhtml = $_POST["newverificationheaderbodyhtml"];
	$newverificationheaderbodyhtml = addslashes($newverificationheaderbodyhtml);
	$newverificationheaderbodytext = $_POST["newverificationheaderbodytext"];
	$newverificationheaderbodytext = addslashes($newverificationheaderbodytext);
	$newverificationmessagehtml = $_POST["newverificationmessagehtml"];
	$newverificationmessagehtml = addslashes($newverificationmessagehtml);
	$newverificationmessagetext = $_POST["newverificationmessagetext"];
	$newverificationmessagetext = addslashes($newverificationmessagetext);
	$newverificationsubject = $_POST["newverificationsubject"];
	$newverificationsubject = addslashes($newverificationsubject);
	$newverificationfromfield = $_POST["newverificationfromfield"];
	$newverificationfromfield = addslashes($newverificationfromfield);
	$newverificationdisclaimerbodyhtml = $_POST["newverificationdisclaimerbodyhtml"];
	$newverificationdisclaimerbodyhtml = addslashes($newverificationdisclaimerbodyhtml);
	$newverificationdisclaimerbodytext = $_POST["newverificationdisclaimerbodytext"];
	$newverificationdisclaimerbodytext = addslashes($newverificationdisclaimerbodytext);
	if(!$newlistname)
	{
	$error .= "<li>Please return and enter a name for the mailing list.</li>";
	}
	if(!$newsubmitform_redirecturl)
	{
	$error .= "<li>Please return and enter a URL to redirect prospects to after they submit your signup form.</li>";
	}
	if(!$newverification_redirecturl)
	{
	$error .= "<li>Please return and enter a URL to redirect prospects to after they verify their email addresses.</li>";
	}
	if (!$newverificationfromfield)
	{
	$error .= "<div>No from field name was entered for the verification email.</div>";
	}
	if (!$newverificationsubject)
	{
	$error .= "<div>No subject was entered for the verification email.</div>";
	}
	if (($newverificationmessagehtml == "") and ($newverificationmessagetext == ""))
	{
	$error .= "<div>No message body was entered for the verification email.</div>";
	}
	if (($newverificationmessagehtml != "") and ($newverificationdisclaimerbodyhtml == ""))
	{
	$error .= "<div>You entered an HTML message body, but did not add an HTML disclaimer for the verification email.</div>";
	}
	if (($newverificationmessagetext != "") and ($newverificationdisclaimerbodytext == ""))
	{
	$error .= "<div>You entered a Plain Text message body, but did not add a Plain Text disclaimer for the verification email.</div>";
	}
	$dupq = "select * from autoresponders_lists where userid=\"$userid\" and listname=\"$newlistname\"";
	$dupr = mysql_query($dupq);
	$duprows = mysql_num_rows($dupr);
	if ($duprows > 0)
		{
		$error .= "<li>You already have a mailing list with the name " . $newlistname . ".</li>";
		}
	if(!$error == "")
		{
		?>
		<!-- PAGE CONTENT //-->
		<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
		<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold; color: #ff0000;">ERROR</div></td></tr>
		<tr><td colspan="2"><br>Please return to the form and correct the following problems:<br>
		<ul><?php echo $error ?></ul>
		</td></tr>
		<tr><td align="center" colspan="2"><br>
		<input type="button" value="Return To Form" onclick="javascript:history.back();" class="sendit">
		</td></tr>
		</table>
		<!-- END PAGE CONTENT //-->
		<?php
		include "footer.php";
		exit;
		}
	$idq = "select * from autoresponders_lists order by id desc limit 1";
	$idr = mysql_query($idq);
	$idrows = mysql_num_rows($idr);
	if ($idrows < 1)
	{
		$newid = 1;
	}
	if ($idrows > 0)
	{
		$lastid = mysql_result($idr,0,"id");
		$newid = $lastid+1;
	}
	$q = "insert into autoresponders_lists (id,userid,listname,submitform_redirecturl,verification_redirecturl,verificationheaderbodyhtml,verificationheaderbodytext,verificationmessagehtml,verificationmessagetext,verificationsubject,verificationfromfield,verificationdisclaimerbodyhtml,verificationdisclaimerbodytext) values (\"$newid\",\"$userid\",\"$newlistname\",\"$newsubmitform_redirecturl\",\"$newverification_redirecturl\",\"$newverificationheaderbodyhtml\",\"$newverificationheaderbodytext\",\"$newverificationmessagehtml\",\"$newverificationmessagetext\",\"$newverificationsubject\",\"$newverificationfromfield\",\"$newverificationdisclaimerbodyhtml\",\"$newverificationdisclaimerbodytext\")";
	$r = mysql_query($q);
	# system form fields
	$ar_firstname = $_POST["ar_firstname"];
	if ($ar_firstname == "yes")
		{
		$q1 = "delete from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$newid\" and fieldname=\"firstname\"";
		$r1 = mysql_query($q1);
		$q2 = "insert into autoresponder_userfields_forms (userid,listnameid,fieldname,type) values (\"$userid\",\"$newid\",\"firstname\",\"system\")";
		$r2 = mysql_query($q2);
		}
	if ($ar_firstname != "yes")
		{
		$q1 = "delete from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$newid\" and fieldname=\"firstname\"";
		$r1 = mysql_query($q1);
		}
	$ar_lastname = $_POST["ar_lastname"];
	if ($ar_lastname == "yes")
		{
		$q1 = "delete from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$newid\" and fieldname=\"lastname\"";
		$r1 = mysql_query($q1);
		$q2 = "insert into autoresponder_userfields_forms (userid,listnameid,fieldname,type) values (\"$userid\",\"$newid\",\"lastname\",\"system\")";
		$r2 = mysql_query($q2);
		}
	if ($ar_lastname != "yes")
		{
		$q1 = "delete from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$newid\" and fieldname=\"lastname\"";
		$r1 = mysql_query($q1);
		}
	$ar_email = $_POST["ar_email"];
	if ($ar_email == "yes")
		{
		$q1 = "delete from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$newid\" and fieldname=\"email\"";
		$r1 = mysql_query($q1);
		$q2 = "insert into autoresponder_userfields_forms (userid,listnameid,fieldname,type) values (\"$userid\",\"$newid\",\"email\",\"system\")";
		$r2 = mysql_query($q2);
		}
	if ($ar_email != "yes")
		{
		$q1 = "delete from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$newid\" and fieldname=\"email\"";
		$r1 = mysql_query($q1);
		}
	$ar_howfound = $_POST["ar_howfound"];
	if ($ar_howfound == "yes")
		{
		$q1 = "delete from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$newid\" and fieldname=\"howfound\"";
		$r1 = mysql_query($q1);
		$q2 = "insert into autoresponder_userfields_forms (userid,listnameid,fieldname,type) values (\"$userid\",\"$newid\",\"howfound\",\"system\")";
		$r2 = mysql_query($q2);
		}
	if ($ar_howfound != "yes")
		{
		$q1 = "delete from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$newid\" and fieldname=\"howfound\"";
		$r1 = mysql_query($q1);
		}
	# user custom form fields
	$auq = "select * from autoresponder_userfields where userid=\"$userid\" order by fieldname";
	$aur = mysql_query($auq);
	$aurows = mysql_num_rows($aur);
		if ($aurows > 0)
		{
			while ($aurowz = mysql_fetch_array($aur))
			{
			$au_fieldname = $aurowz["fieldname"];
			eval("\$au_fieldnamevalue = \$_POST[\"$au_fieldname\"];");
			$q1 = "delete from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$newid\" and fieldname=\"$au_fieldname\"";
			$r1 = mysql_query($q1);
			if ($au_fieldnamevalue == "yes")
				{
				$q2 = "insert into autoresponder_userfields_forms (userid,listnameid,fieldname,type) values (\"$userid\",\"$newid\",\"$au_fieldname\",\"member\")";
				$r2 = mysql_query($q2);				
				}
			} # while ($aurowz = mysql_fetch_array($aur))
		} # if ($aurows > 0)
	?>
	<!-- PAGE CONTENT //-->
	<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
	<tr><td align="center" colspan="2"><br><div class="heading">New Mailing List <?php echo $newlistname ?> Created!</div></td></tr>
	<tr><td align="center" colspan="2"><br><a href="autoresponder_create_mailinglists.php">BACK TO CREATE AUTORESPONDER MAILING LISTS</a></td></tr>
	</table>
	<!-- END PAGE CONTENT //-->
	<?php
	include "footer.php";
	exit;
} # if ($action == "newmailinglist")
################################################################
if ($action == "newcustomfield")
{
$newfieldname = $_POST["newfieldname"];
$newfieldtitle = $_POST["newfieldtitle"];
if (!$newfieldname)
{
$error .= "<li>Please return and enter a variable name for your new form field (alphabetical A-Z or a-z ONLY!). New prospects do not see this value.</li>";
}
if (!$newfieldtitle)
{
$error .= "<li>Please return and enter a short description for your new form field. This is the label for the form field that your prospects will see.</li>";
}
if (!ctype_alnum($newfieldname)) 
{
$error .= "<li>The variable name for your new form field must be alphanumeric characters ONLY. New prospects do not see this value.</li>";
}
if (!ctype_alpha($newfieldname[0]))
{
$error .= "<li>The FIRST character of your variable name for your new form field must be a letter (A-Z or a-z). New prospects do not see this value.</li>";
}
if(!$error == "")
	{
	?>
	<!-- PAGE CONTENT //-->
	<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
	<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold; color: #ff0000;">ERROR</div></td></tr>
	<tr><td colspan="2"><br>Please return to the form and correct the following problems:<br>
	<ul><?php echo $error ?></ul>
	</td></tr>
	<tr><td align="center" colspan="2"><br>
	<input type="button" value="Return To Form" onclick="javascript:history.back();" class="sendit">
	</td></tr>
	</table>
	<!-- END PAGE CONTENT //-->
	<?php
	include "footer.php";
	exit;
	}
$q = "insert into autoresponder_userfields (userid,fieldname,fieldtitle) values (\"$userid\",\"$newfieldname\",\"$newfieldtitle\")";
$r = mysql_query($q);
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">New Custom Signup Form Field Was Created!</div></td></tr>
<tr><td align="center" colspan="2"><br><a href="autoresponder_create_mailinglists.php">BACK TO CREATE AUTORESPONDER MAILING LISTS</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "footer.php";
exit;
} # if ($action == "newcustomfield")
################################################################
if ($action == "deletecustomfield")
{
$deletefieldid = $_POST["deletefieldid"];
$deletefieldname = $_POST["deletefieldname"];
$q1 = "delete from autoresponder_userfields where userid=\"$userid\" and id=\"$deletefieldid\"";
$r1 = mysql_query($q1);
$q2 = "delete from autoresponder_userfields_data where userid=\"$userid\" and fieldname=\"$deletefieldname\"";
$r2 = mysql_query($q2);
$q3 = "delete from autoresponder_userfields_forms where userid=\"$userid\" and fieldname=\"$deletefieldname\"";
$r3 = mysql_query($q3);
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">The Custom Field was Deleted</div></td></tr>
<tr><td align="center" colspan="2"><br><a href="autoresponder_create_mailinglists.php">BACK TO CREATE AUTORESPONDER MAILING LISTS</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "footer.php";
exit;
} # if ($action == "deletecustomfield")
################################################################
if ($action == "savecustomfield")
{
$savefieldid = $_POST["savefieldid"];
$savefieldname = $_POST["savefieldname"];
$oldfieldname = $_POST["oldfieldname"];
$savefieldtitle = $_POST["savefieldtitle"];
if (!$savefieldname)
{
$error .= "<li>Please return and enter a variable name for your form field (alphabetical A-Z or a-z ONLY!). New prospects do not see this value.</li>";
}
if (!$savefieldtitle)
{
$error .= "<li>Please return and enter a short description for your form field. This is the label for the form field that your prospects will see.</li>";
}
if (!ctype_alnum($savefieldname)) 
{
$error .= "<li>The variable name for your new form field must be alphanumeric characters ONLY. New prospects do not see this value.</li>";
}
if (!ctype_alpha($savefieldname[0]))
{
$error .= "<li>The FIRST character of your variable name for your new form field must be a letter (A-Z or a-z). New prospects do not see this value.</li>";
}
if(!$error == "")
	{
	?>
	<!-- PAGE CONTENT //-->
	<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
	<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold; color: #ff0000;">ERROR</div></td></tr>
	<tr><td colspan="2"><br>Please return to the form and correct the following problems:<br>
	<ul><?php echo $error ?></ul>
	</td></tr>
	<tr><td align="center" colspan="2"><br>
	<input type="button" value="Return To Form" onclick="javascript:history.back();" class="sendit">
	</td></tr>
	</table>
	<!-- END PAGE CONTENT //-->
	<?php
	include "footer.php";
	exit;
	}
$q1 = "update autoresponder_userfields set fieldname=\"$savefieldname\",fieldtitle=\"$savefieldtitle\" where userid=\"$userid\" and id=\"$savefieldid\"";
$r1 = mysql_query($q1);
$q2 = "update autoresponder_userfields_data set fieldname=\"$savefieldname\" where userid=\"$userid\" and fieldname=\"$oldfieldname\"";
$r2 = mysql_query($q2);
$q3 = "update autoresponder_userfields_forms set fieldname=\"$savefieldname\" where userid=\"$userid\" and fieldname=\"$oldfieldname\"";
$r3 = mysql_query($q3);
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">Your Custom Signup Form Field Was Saved!</div></td></tr>
<tr><td align="center" colspan="2"><br><a href="autoresponder_create_mailinglists.php">BACK TO CREATE AUTORESPONDER MAILING LISTS</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "footer.php";
exit;
} # if ($action == "savecustomfield")
################################################################
?>
<!-- PAGE CONTENT //-->
<script language="JavaScript" type="text/javascript">
var copytoclip=1
function HighlightAll(theField) {
var tempval=eval("document."+theField)
tempval.focus()
tempval.select()
if (document.all&&copytoclip==1){
therange=tempval.createTextRange()
therange.execCommand("Copy")
window.status="Contents highlighted and copied to clipboard!"
setTimeout("window.status=''",1800)
}
}
</script>
<script type="text/javascript" src="<?php echo $domain ?>/jscripts/jquery.js"></script>
<script type="text/javascript" src="<?php echo $domain ?>/jscripts/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo $domain ?>/jscripts/ckeditor4/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo $domain ?>/jscripts/ckeditor4/adapters/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $domain ?>/jscripts/jquery-ui.css"/>
<div id="previewdlg" title="Preview">
<div id="pvw">
</div>
</div>
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">CREATE AUTORESPONDER MAILING LISTS</div></td></tr>

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
$q = "select * from pages where name='Members Area - Autoresponder Create Mailing Lists Page'";
$r = mysql_query($q);
$rowz = mysql_fetch_array($r);
$htmlcode = $rowz["htmlcode"];
echo $htmlcode;
?>
</div>
</td></tr>
</table>
</td></tr>

<tr><td colspan="2"><br>&nbsp;</td></tr>

<tr><td align="center" colspan="2"><br>
<table width="800" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrlight"><td align="center" colspan="2">CREATE CUSTOM FIELDS FOR SIGNUP FORMS</td></tr>
<tr class="sabrinatrdark"><td colspan="2">You may create your own custom fields that new prospects will  need to enter when they signup to the mailing lists for your AutoResponders.</td></tr>
<form action="autoresponder_create_mailinglists.php" method="post">
<tr class="sabrinatrlight"><td>Form Field Variable Name:<br>(alphanumeric ONLY, and FIRST character must be a LETTER! ie. phonenumber)</td><td><input type="text" name="newfieldname" maxlength="255" size="55"></td></tr>
<tr class="sabrinatrlight"><td>Form Field Description:<br>(displayed in form to new signups. ie. Your Phone Number)</td><td><input type="text" name="newfieldtitle" maxlength="255" size="55"></td></tr>
<tr class="sabrinatrdark"><td align="center" colspan="2"><input type="hidden" name="action" value="newcustomfield"><input type="submit" value="ADD"></form></td></tr>
</table>
</td></tr>

<tr><td colspan="2"><br>&nbsp;</td></tr>

<tr><td align="center" colspan="2"><br>
<table width="800" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrlight"><td align="center" colspan="4">EXISTING CUSTOM FIELDS FOR YOUR MAILING LIST SIGNUP FORMS</td></tr>
<?php
$fieldsq = "select * from autoresponder_userfields where userid=\"$userid\" order by fieldname";
$fieldsr = mysql_query($fieldsq);
$fieldsrows = mysql_num_rows($fieldsr);
if ($fieldsrows < 1)
{
?>
<tr class="sabrinatrdark"><td align="center" colspan="4">You haven't created any custom form fields yet.</td></tr>
<?php
}
if ($fieldsrows > 0)
{
?>
<tr class="sabrinatrdark"><td align="center">Form Field Variable Name (alphanumeric ONLY, and FIRST character must be a LETTER!)</td><td align="center">Form Field Description</td><td align="center">Save</td><td align="center">Delete</td></tr>
<?php
	while ($fieldsrowz = mysql_fetch_array($fieldsr))
	{
		$f_id = $fieldsrowz["id"];
		$f_fieldname = $fieldsrowz["fieldname"];
		$f_fieldtitle = $fieldsrowz["fieldtitle"];
		$f_fieldtitle = stripslashes($f_fieldtitle);
		$f_fieldtitle = str_replace('\\', '', $f_fieldtitle);
		?>
		<form action="autoresponder_create_mailinglists.php" method="post">
		<tr class="sabrinatrdark"><td align="center"><input type="text" name="savefieldname" value="<?php echo $f_fieldname ?>" size="35" maxlength="255"></td><td align="center"><input type="text" name="savefieldtitle" value="<?php echo $f_fieldtitle ?>" size="35" maxlength="255"></td>
		<td align="center">
		<input type="hidden" name="oldfieldname" value="<?php echo $f_fieldname ?>">
		<input type="hidden" name="savefieldid" value="<?php echo $f_id ?>">
		<input type="hidden" name="action" value="savecustomfield">
		<input type="submit" value="SAVE">
		</form>
		</td>
		<form action="autoresponder_create_mailinglists.php" method="post">
		<td align="center">
		<input type="hidden" name="deletefieldid" value="<?php echo $f_id ?>">
		<input type="hidden" name="deletefieldname" value="<?php echo $f_fieldname ?>">
		<input type="hidden" name="action" value="deletecustomfield">
		<input type="submit" value="DELETE">
		</form>
		</td></tr>
		<?php
	} # while ($fieldsrowz = mysql_fetch_array($fieldsr))
} # if ($fieldsrows > 0)
?>
</table>
</td></tr>

<tr><td colspan="2"><br>&nbsp;</td></tr>

<tr><td align="center" colspan="2"><br>
<table width="800" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrdark"><td align="center" colspan="2">CREATE NEW MAILING LIST</td></tr>
<?php
if (($maxlistsrows < $ar_howmanylists) or ($ar_howmanylists == "Infinite"))
{
?>
<form action="autoresponder_create_mailinglists.php" method="post">
<tr class="sabrinatrlight"><td>Mailing List Name:</td><td><input type="text" name="newlistname" maxlength="255" size="95"></td></tr>
<tr class="sabrinatrlight"><td>URL Prospects are Redirected to After Submitting your Subscribe Form:</td><td><input type="text" name="newsubmitform_redirecturl" maxlength="255" size="95"></td></tr>
<tr class="sabrinatrlight">
<td valign="top">Fields for Mailing List's AutoResponder Signup Form Code:</td>
<td align="center">HTML form code generated for this Mailing List may be copied and pasted into your HTML emails and web sites. Prospects who signup from your form code will be automatically joined to this Mailing List (and subscribed to all AutoResponders that send to it).<br>
<table cellpadding="2" cellspacing="2" border="0" class="sabrinatable" align="center" width="100%">
<tr class="sabrinatrdark"><td align="center">Field for Prospect to Enter</td><td align="center">Include in Form Code</td></tr>
<tr class="sabrinatrlight"><td>First Name:</td><td align="center"><select name="ar_firstname" id="ar_firstname"><option value="yes">YES</option><option value="no">NO</option></select></td></tr>
<tr class="sabrinatrlight"><td>Last Name:</td><td align="center"><select name="ar_lastname" id="ar_lastname"><option value="yes">YES</option><option value="no">NO</option></select></td></tr>
<tr class="sabrinatrlight"><td>Email:</td><td align="center">YES<input type="hidden" name="ar_email" id="ar_email" value="yes"></td></tr>
<tr class="sabrinatrlight"><td>How They Found Your Site:</td><td align="center"><select name="ar_howfound" id="ar_howfound"><option value="yes">YES</option><option value="no">NO</option></select></td></tr>
<?php
$auq = "select * from autoresponder_userfields where userid=\"$userid\" order by fieldname";
$aur = mysql_query($auq);
$aurows = mysql_num_rows($aur);
	if ($aurows > 0)
	{
		while ($aurowz = mysql_fetch_array($aur))
		{
		$au_fieldname = $aurowz["fieldname"];
		$au_fieldtitle = $aurowz["fieldtitle"];
		$au_fieldtitle = stripslashes($au_fieldtitle);
		$au_fieldtitle = str_replace('\\', '', $au_fieldtitle);
		?>
		<tr class="sabrinatrlight"><td><?php echo $au_fieldtitle ?>:</td><td align="center"><select name="<?php echo $au_fieldname ?>" id="<?php echo $au_fieldname ?>"><option value="yes" selected>YES</option><option value="no">NO</option></select></td></tr>
		<?php
		} # while ($aurowz = mysql_fetch_array($aur))
	} # if ($aurows > 0)
?>
</table>
</td>
</tr>
<?php
$varq = "select * from autoresponder_substitution_variables where userid=\"$userid\" or variabletype=\"system\" order by variabletype";
$varr = mysql_query($varq);
$varrows = mysql_num_rows($varr);
if ($varrows > 0)
{
?>
<tr class="sabrinatrlight"><td valign="top">Substitution Variables for your Prospects' Verification Emails:</td><td>
<table border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center" width="100%">
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
<tr class="sabrinatrlight"><td>URL Prospects are Redirected to After Verifying their Email Addresses:</td><td><input type="text" name="newverification_redirecturl" maxlength="255" size="95"></td></tr>
<tr class="sabrinatrlight"><td>Your Name that shows in the From Field of your Verification Email:</td><td><input type="text" name="newverificationfromfield" maxlength="255" size="95"></td></tr>
<tr class="sabrinatrlight"><td>Your Verification Email Subject:</td><td><input type="text" name="newverificationsubject" maxlength="255" size="95"></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your Verification Email HTML Header:</td><td><textarea class="ckeditor" rows="10" cols="95" name="newverificationheaderbodyhtml"></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your Verification Email HTML Message Body (CAREFUL not to mix up the HTML and Plain Text message body fields!):</td><td><textarea class="ckeditor" name="newverificationmessagehtml" rows="15" cols="95"></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your Verification Email HTML Disclaimer (do NOT include a remove link because this is added automatically to the end of all the email):</td><td><textarea class="ckeditor" rows="10" cols="95" name="newverificationdisclaimerbodyhtml"></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your Verification Email Plain Text Header:</td><td><textarea rows="10" cols="95" name="newverificationheaderbodytext"></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your Verification Email Plain Text Message Body:</td><td><textarea name="newverificationmessagetext" rows="15" cols="95"></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your Verification Email Plain Text Disclaimer (do NOT include a remove link because this is added automatically to the end of all the email):</td><td><textarea rows="10" cols="95" name="newverificationdisclaimerbodytext"></textarea></td></tr>
<tr class="sabrinatrdark"><td align="center" colspan="2"><input type="hidden" name="action" value="newmailinglist"><input type="submit" value="ADD"></form></td></tr>
<?php
}
else
{
?>
<tr class="sabrinatrlight"><td align="center" colspan="2">You already have the maximum <?php echo $ar_howmanylists ?> mailing lists for your membership level.</td></tr>
<?php
}
?>
</table>
</td></tr>

<tr><td colspan="2"><br>&nbsp;</td></tr>



</table><br><br>&nbsp;
<!-- END PAGE CONTENT //-->
<?php
include "footer.php";
exit;
?>