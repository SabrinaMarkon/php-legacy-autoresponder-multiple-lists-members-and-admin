<?php
include "control.php";
include "header.php";
$action = $_REQUEST["action"];
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
$howmanyq = "select * from autoresponders where userid=\"$userid\"";
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
################################################################
if ($action == "newautoresponder")
{
	if (($howmanyrows >= $ar_maxautoresponderemails) and ($ar_maxautoresponderemails != "Infinite"))
	{
	?>
	<!-- PAGE CONTENT //-->
	<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
	<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold; color: #ff0000;">ERROR</div></td></tr>
	<tr><td align="center" colspan="2"><br>You already have the maximum <?php echo $ar_maxautoresponderemails ?> AutoResponders set up for your membership level.</td></tr>
	<tr><td align="center" colspan="2"><br>
	<input type="button" value="Return To Form" onclick="javascript:history.back();" class="sendit">
	</td></tr>
	</table>
	<!-- END PAGE CONTENT //-->
	<?php
	include "footer.php";
	exit;
	}
$newautorespondertitle = $_POST["newautorespondertitle"];
$newautorespondertitle = addslashes($newautorespondertitle);
$newautoresponderfromemail = $_POST["newautoresponderfromemail"];
$newautoresponderfromfield = $_POST["newautoresponderfromfield"];
$newautoresponderfromfield = addslashes($newautoresponderfromfield);
$newemailclick_redirecturl = $_POST["newemailclick_redirecturl"];
$newautorespondersubject = $_POST["newautorespondersubject"];
$newautorespondersubject = addslashes($newautorespondersubject);
$newheaderbodyhtml = $_POST["newheaderbodyhtml"];
$newheaderbodyhtml = addslashes($newheaderbodyhtml);
$newautorespondermessagehtml = $_POST["newautorespondermessagehtml"];
$newautorespondermessagehtml = addslashes($newautorespondermessagehtml);
$newdisclaimerbodyhtml = $_POST["newdisclaimerbodyhtml"];
$newdisclaimerbodyhtml = addslashes($newdisclaimerbodyhtml);
$newheaderbodytext = $_POST["newheaderbodytext"];
$newheaderbodytext = addslashes($newheaderbodytext);
$newautorespondermessagetext = $_POST["newautorespondermessagetext"];
$newautorespondermessagetext = addslashes($newautorespondermessagetext);
$newdisclaimerbodytext = $_POST["newdisclaimerbodytext"];
$newdisclaimerbodytext = addslashes($newdisclaimerbodytext);
$newlists = $_POST["newlists"];
$newautoresponderdays = $_POST["newautoresponderdays"];
$newnextlists  = $_POST["newnextlists"];
$newautoresponderenabled = $_POST["newautoresponderenabled"];
if (!$newautorespondertitle)
{
$error .= "<li>Please return and enter a name for your autoresponder email or campaign.</li>";
}
if (!$newautoresponderfromemail)
{
$error .= "<li>Please return and enter an email address that your autoresponder message will be sent from.</li>";
}
if (!$newautoresponderfromfield)
{
$error .= "<li>Please return and enter your name or company name for the from field of your autoresponder email.</li>";
}
if (!$newemailclick_redirecturl)
{
$error .= "<li>Please return and enter the click redirect URL for your autoresponder email. This is the website people will visit after clicking the tracking link at the bottom of your emails (you may include other urls in the message body too).</li>";
}
if (!$newautorespondersubject)
{
$error .= "<li>Please return and enter the subject for your autoresponder email.</li>";
}
if (($newautorespondermessagehtml == "") and ($newautorespondermessagetext == ""))
{
$error .= "<li>Please return and enter a message body for your autoresponder email. You need at least ONE of either the HTML or Plain Text versions, but both are recommended for maximum compatibility with recipient email programs.</li>";
}
if (($newautorespondermessagehtml == "") and ($newdisclaimerbodyhtml == ""))
{
$error .= "<li>You entered an HTML message body for your autoresponder, but left the HTML disclaimer blank.</li>";
}
if (($newautorespondermessagetext == "") and ($newdisclaimerbodytext == ""))
{
$error .= "<li>You entered a Plain Text message body for your autoresponder, but left the Plain Text disclaimer blank.</li>";
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
if ($newlists != "")
	{
	$sendtolists = "";
	foreach ($newlists as $thislist)
		{
		$sendtolists = $sendtolists . "~" . $thislist;	
		}
	}

if ($newnextlists != "")
	{
	$nextliststosubscribeto = "";
	foreach ($newnextlists as $nextlist)
		{
		$nextliststosubscribeto = $nextliststosubscribeto . "~" . $nextlist;
		}
	}
$newautorespondermessagehtml = str_replace("&Acirc;&#160;","",$newautorespondermessagehtml);
$newdisclaimerbodyhtml = str_replace("&Acirc;&#160;","",$newdisclaimerbodyhtml);
$q = "insert into autoresponders (userid,autoresponderfromemail,autorespondertitle,autorespondermessagehtml,autorespondermessagetext,autorespondersubject,autoresponderfromfield,autoresponderdays,sendtoprospectlists,liststosubscribetoaftersendingthismessage,emailclick_redirecturl,disclaimerbodyhtml,disclaimerbodytext,headerbodyhtml,headerbodytext,autoresponderenabled) values (\"$userid\",\"$newautoresponderfromemail\",\"$newautorespondertitle\",\"$newautorespondermessagehtml\",\"$newautorespondermessagetext\",\"$newautorespondersubject\",\"$newautoresponderfromfield\",\"$newautoresponderdays\",\"$sendtolists\",\"$nextliststosubscribeto\",\"$newemailclick_redirecturl\",\"$newdisclaimerbodyhtml\",\"$newdisclaimerbodytext\",\"$newheaderbodyhtml\",\"$newheaderbodytext\",\"$newautoresponderenabled\")";
$r = mysql_query($q);
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">YOUR NEW AUTORESPONDER MESSAGE WAS CREATED!</div></td></tr>
<tr><td align="center" colspan="2"><br><a href="autoresponder_create_campaigns.php">BACK TO CREATE AUTORESPONDER CAMPAIGNS</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "footer.php";
exit;
} # if ($action == "newautoresponder")
################################################################
?>
<!-- PAGE CONTENT //-->
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
<tr><td align="center" colspan="2"><br><div class="heading">CREATE YOUR AUTORESPONDER CAMPAIGNS</div></td></tr>

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
$q = "select * from pages where name='Members Area - Create Autoresponder Campaigns Page'";
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
<form action="autoresponder_create_campaigns.php" method="post">
<tr><td colspan="2" align="center">
<table width="800" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrlight"><td colspan="2" align="center">CREATE NEW AUTORESPONDER EMAIL MESSAGE</td></tr>
<?php
if (($howmanyrows < $ar_maxautoresponderemails) or ($ar_maxautoresponderemails == "Infinite"))
{
$listsq = "select * from autoresponders_lists where userid=\"$userid\" order by listname";
$listsr = mysql_query($listsq);
$listsrows = mysql_num_rows($listsr);
if ($listsrows < 1)
{
?>
<tr class="sabrinatrdark"><td align="center" colspan="2">You haven't created any mailing lists for prospects to join and receive AutoResponder emails.</td></tr>
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
<form action="autoresponder_create_campaigns.php" method="post" name="addform">
<tr class="sabrinatrlight"><td>AutoResponder Campaign:</td><td><input type="text" name="newautorespondertitle" maxlength="255" size="95"></td></tr>
<tr class="sabrinatrlight"><td>Enable:</td><td><select name="newautoresponderenabled"><option value="yes">YES</option><option value="no">NO</option></select></td></tr>
<tr class="sabrinatrlight"><td>Email Address This AutoResponder is Sent From:</td><td><input type="text" name="newautoresponderfromemail" maxlength="255" size="95"></td></tr>
<tr class="sabrinatrlight"><td>Your Name that shows in the From Field:</td><td><input type="text" name="newautoresponderfromfield" maxlength="255" size="95"></td></tr>
<tr class="sabrinatrlight"><td>URL Prospects are Redirected to When Clicking the Bottom Tracking Link in your AutoResponder Email (you may include additional links in your message body too):</td><td><input type="text" name="newemailclick_redirecturl" maxlength="255" size="95"></td></tr>
<tr class="sabrinatrlight"><td>Your AutoResponder Subject:</td><td><input type="text" name="newautorespondersubject" maxlength="255" size="95"></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your HTML Header:</td><td><textarea class="ckeditor" rows="10" cols="95" name="newheaderbodyhtml"></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your AutoResponder HTML Message Body (CAREFUL not to mix up the HTML and Plain Text message body fields!):</td><td><textarea class="ckeditor" name="newautorespondermessagehtml" rows="15" cols="95"></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your HTML Disclaimer (do NOT include a remove link because this is added automatically to the end of all the email):</td><td><textarea class="ckeditor" rows="10" cols="95" name="newdisclaimerbodyhtml"></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your Plain Text Header:</td><td><textarea rows="10" cols="95" name="newheaderbodytext"></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your AutoResponder Plain Text Message Body:</td><td><textarea name="newautorespondermessagetext" rows="15" cols="95"></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your Plain Text Disclaimer (do NOT include a remove link because this is added automatically to the end of all the email):</td><td><textarea rows="10" cols="95" name="newdisclaimerbodytext"></textarea></td></tr>
<tr class="sabrinatrlight"><td>Mailing Lists To Send To:</td></td><td>
<?php
while ($listsrowz = mysql_fetch_array($listsr))
{
$newid = $listsrowz["id"];
$newlistname = $listsrowz["listname"];
?>
<input type="checkbox" name="newlists[]" value="<?php echo $newlistname ?>">&nbsp;<?php echo $newlistname ?><br>
<?php
}
?>
</td></tr>
<tr class="sabrinatrlight"><td>Send After How Many Days? (select 0 for immediately after signup!):</td><td>
<select name="newautoresponderdays" class="pickone">
<?php
for($i=0;$i<=100;$i++)
{
?>
<option value="<?php echo $i ?>"><?php echo $i ?></option>
<?php
}
?>
</select>
</td></tr>
<?php
$listsq2 = "select * from autoresponders_lists where userid=\"$userid\" order by listname";
$listsr2 = mysql_query($listsq2);
$listsrows2 = mysql_num_rows($listsr2);
if ($listsrows2 > 0)
	{
	?>
	<tr class="sabrinatrlight"><td>After being sent this AutoResponder email, auto-subscribe prospects in mailing lists that receive this message to mailing list(s):</td></td><td>
	<?php
		while ($listsrowz2 = mysql_fetch_array($listsr2))
		{
		$newid2 = $listsrowz2["id"];
		$newlistname2 = $listsrowz2["listname"];
		?>
		<input type="checkbox" name="newnextlists[]" value="<?php echo $newlistname2 ?>">&nbsp;<?php echo $newlistname2 ?><br>
		<?php
		}
	?>
	</td></tr>
	<?php
	} # if ($listsrows2 > 0)
?>
<tr class="sabrinatrdark"><td colspan="2" align="center"><input type="hidden" name="action" value="newautoresponder"><input type="submit" value="ADD"></form></td></tr>
<?php
} # if ($listsrows > 0)
} # if (($howmanyrows < $ar_maxautoresponderemails) or ($ar_maxautoresponderemails == "Infinite"))
else
{
?>
<tr class="sabrinatrlight"><td align="center" colspan="2">You already have the maximum <?php echo $ar_maxautoresponderemails ?> AutoResponders set up for your membership level.</td></tr>
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