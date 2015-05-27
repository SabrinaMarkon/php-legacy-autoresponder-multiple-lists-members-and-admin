<?php
include "control.php";
include "header.php";
$action = $_REQUEST["action"];
################################################################
if ($action == "newvariable")
{
$newvariablename = $_POST["newvariablename"];
$newvariablevalue = $_POST["newvariablevalue"];
	if(!$newvariablename)
	{
	$error .= "<li>Please return and enter a tag for your substitution variable. This is what you will write EXACTLY in your autoresponder emails. During mailing, it will be replaced by the value you specify.</li>";
	}
	if(!$newvariablevalue)
	{
	$error .= "<li>Please return and enter a value for your substitution variable. During mailing, this is the value that will appear to recipients in place of the tag field you specify.</li>";
	}
	$addq = "select * from autoresponder_substitution_variables where userid=\"$userid\" and variablename=\"$newvariablename\"";
	$addr = mysql_query($addq);
	$addrows = mysql_num_rows($addr);
	if ($addrows > 0)
		{
		$error .= "<li>You are already using the tag " . $newvariablename . ". Please choose a different one.</li>";
		}
	if(!$error == "")
		{
		?>
		<!-- PAGE CONTENT //-->
		<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
		<tr><td align="center" colspan="2"><br><div class="heading">ERROR</div></td></tr>
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
	$q = "insert into autoresponder_substitution_variables (userid,variablename,variablevalue,variabletype) values (\"$userid\",\"$newvariablename\",\"$newvariablevalue\",\"member\")";
	$r = mysql_query($q);
	?>
	<!-- PAGE CONTENT //-->
	<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
	<tr><td align="center" colspan="2"><br><div class="heading">Your New Substitution Variable Tag <?php echo $newvariablename ?> Was Created!</div></td></tr>
	<tr><td align="center" colspan="2"><br><a href="autoresponder_substitutionvariables.php">BACK TO MAIL MERGE EMAIL SUBSTITUTIONS</a></td></tr>
	</table>
	<!-- END PAGE CONTENT //-->
	<?php
	include "footer.php";
	exit;
} # if ($action == "newvariable")
################################################################
if ($action == "deletevariable")
{
$deletevariableid = $_POST["deletevariableid"];
$deletevariablename = $_POST["deletevariablename"];
$delq = "delete from autoresponder_substitution_variables where userid=\"$userid\" and id=\"$deletevariableid\"";
$delr = mysql_query($delq);
	?>
	<!-- PAGE CONTENT //-->
	<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
	<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold;">Substitution Variable <?php echo $deletevariablename ?> Was Deleted!</div></td></tr>
	<tr><td align="center" colspan="2"><br><a href="autoresponder_substitutionvariables.php">BACK TO MAIL MERGE EMAIL SUBSTITUTIONS</a></td></tr>
	</table>
	<!-- END PAGE CONTENT //-->
	<?php
	include "footer.php";
	exit;
} # if ($action == "deletevariable")
################################################################
if ($action == "savevariable")
{
$savevariableid = $_POST["savevariableid"];
$savevariablename = $_POST["savevariablename"];
$savevariablevalue = $_POST["savevariablevalue"];
	if(!$savevariablename)
	{
	$error .= "<li>Please return and enter a tag for your substitution variable. This is what you will write EXACTLY in your autoresponder emails. During mailing, it will be replaced by the value you specify.</li>";
	}
	if(!$savevariablevalue)
	{
	$error .= "<li>Please return and enter a value for your substitution variable. During mailing, this is the value that will appear to recipients in place of the tag field you specify.</li>";
	}
	$saveq = "select * from autoresponder_substitution_variables where userid=\"$userid\" and variablename=\"$savevariablename\"";
	$saver = mysql_query($saveq);
	$saverows = mysql_num_rows($saver);
	if ($saverows > 0)
		{
		$error .= "<li>You are already using the tag " . $savevariablename . ". Please choose a different one.</li>";
		}
	if(!$error == "")
		{
		?>
		<!-- PAGE CONTENT //-->
		<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
		<tr><td align="center" colspan="2"><br><div class="heading">ERROR</div></td></tr>
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
	$q1 = "update autoresponder_substitution_variables set variablename=\"$savevariablename\",variablevalue=\"$savevariablevalue\" where userid=\"$userid\" and id=\"$savevariableid\"";
	$r1 = mysql_query($q1);
	?>
	<!-- PAGE CONTENT //-->
	<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
	<tr><td align="center" colspan="2"><br><div class="heading">Substitution Variable Tag <?php echo $savevariablename ?> Was Saved!</div></td></tr>
	<tr><td align="center" colspan="2"><br><a href="autoresponder_substitutionvariables.php">BACK TO MAIL MERGE EMAIL SUBSTITUTIONS</a></td></tr>
	</table>
	<!-- END PAGE CONTENT //-->
	<?php
	include "footer.php";
	exit;
} # if ($action == "savevariable")
################################################################
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">AUTORESPONDER MAIL MERGE EMAIL SUBSTITUTIONS</div></td></tr>

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
$q = "select * from pages where name='Members Area - Autoresponder Mail Merge Substitution Page'";
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
<tr class="sabrinatrlight"><td align="center" colspan="2">CREATE EMAIL SUBSTITUTION VARIABLES</td></tr>
<tr class="sabrinatrdark"><td colspan="2">In addition to the system substitution variables that are available to you in your autoresponder emails, you may also create your own using the form below. All mail merge substitutions may be used in any email you create that is connected to the AutoResponder system.</td></tr>
<form action="autoresponder_substitutionvariables.php" method="post">
<tr class="sabrinatrlight"><td>Tag:<br>(This value must be typed in an email subject or message body EXACTLY as you type it here to work! It is also CaSe SeNsiTivE. Recommended format is like ~NAME_YOU-CHOOSE~):</td><td><input type="text" name="newvariablename" maxlength="255" size="55"></td></tr>
<tr class="sabrinatrlight"><td>Value:<br>(This is what will be substituted in the autoresponder emails to your prospects):</td><td><input type="text" name="newvariablevalue" maxlength="255" size="55"></td></tr>
<tr class="sabrinatrdark"><td align="center" colspan="2"><input type="hidden" name="action" value="newvariable"><input type="submit" value="ADD"></form></td></tr>
</table>
</td></tr>

<tr><td colspan="2"><br>&nbsp;</td></tr>

<tr><td align="center" colspan="2"><br>
<table width="800" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrlight"><td align="center" colspan="5">YOUR SUBSTITUTION VARIABLES</td></tr>
<?php
$varq = "select * from autoresponder_substitution_variables where userid=\"$userid\" or variabletype=\"system\" order by variabletype";
$varr = mysql_query($varq);
$varrows = mysql_num_rows($varr);
if ($varrows > 0)
{
?>
<tr class="sabrinatrdark"><td align="center">Tag (type exactly as shown)</td><td align="center">Substitutes</td><td align="center">Type</td><td align="center">Save</td><td align="center">Delete</td></tr>
<?php
	while ($varrowz = mysql_fetch_array($varr))
	{
	$variableid = $varrowz["id"];
	$variabletype = $varrowz["variabletype"];
	$variablename = $varrowz["variablename"];
	$variablevalue = $varrowz["variablevalue"];
	$variabledescription = $varrowz["variabledescription"];
	$variabledescription = stripslashes($variabledescription);
	$variabledescription = str_replace('\\', '', $variabledescription);
	if ($variabletype == "system")
		{
		?>
		<tr class="sabrinatrlight"><td><?php echo $variablename ?></td><td><?php echo $variabledescription ?></td><td>System</td><td>N/A</td><td>N/A</td></tr>
		<?php
		}
	if ($variabletype != "system")
		{
		?>
		<form action="autoresponder_substitutionvariables.php" method="post">
		<tr class="sabrinatrlight"><td><input type="text" name="savevariablename" size="25" maxlength="255" value="<?php echo $variablename ?>"></td><td><input type="text" name="savevariablevalue" size="25" maxlength="255" value="<?php echo $variablevalue ?>"></td><td>Created by You</td>
		<td align="center">
		<input type="hidden" name="savevariableid" value="<?php echo $variableid ?>"><input type="hidden" name="action" value="savevariable"><input type="submit" value="SAVE">
		</form>
		</td>
		<form action="autoresponder_substitutionvariables.php" method="post">
		<td align="center">
		<input type="hidden" name="deletevariablename" value="<?php echo $variablename ?>"><input type="hidden" name="deletevariableid" value="<?php echo $variableid ?>"><input type="hidden" name="action" value="deletevariable"><input type="submit" value="DELETE">
		</form>
		</td>
		</tr>
		<?php
		}
	}
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