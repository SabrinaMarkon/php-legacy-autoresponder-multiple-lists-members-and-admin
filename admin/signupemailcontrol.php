<?php
include "control.php";
include "../header.php";
$action = $_POST["action"];
$show = "";
$error = "";
if ($action == "savesetting")
{
$emailsignupmethod = $_POST["emailsignupmethod"];
mysql_query("update adminsettings set setting=\"$emailsignupmethod\" where name=\"emailsignupmethod\"");
$show = "Email signup filter was saved.";
} # if ($action == "savesetting")
############################################################################
if ($action == "add")
{
$newemaildomain = $_POST["newemaildomain"];
	if (!$newemaildomain)
	{
	$error .= "The email domain field was left blank.";
	}
$newemaildomain = strtolower($newemaildomain);
$dupq = "select * from emailsignupcontrol where emaildomain=\"$newemaildomain\"";
$dupr = mysql_query($dupq);
$duprows = mysql_num_rows($dupr);
if ($duprows > 0)
	{
	$error .= $newemaildomain . " is already being filtered.";
	}
	if(!$error == "")
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="400">
	<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
	<tr><td colspan="2" align="center"><br><?php echo $error ?></td></tr>
	<tr><td colspan="2" align="center"><br><a href="signupemailcontrol.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
	}
if ($emailsignupmethod == "denyallexcept")
	{
	$showfilter = "allowed";
	}
if ($emailsignupmethod != "denyallexcept")
	{
	$showfilter = "banned";
	}
$q = "insert into emailsignupcontrol (emaildomain) values (\"$newemaildomain\")";
$r = mysql_query($q);
$show = $newemaildomain . " was added to the email address signup filter and is now " . $showfilter;
} # if ($action == "add")
############################################################################
if ($action == "delete")
{
$deleteid = $_POST["deleteid"];
$deleteemaildomain = $_POST["deleteemaildomain"];
mysql_query("delete from emailsignupcontrol where id=\"$deleteid\"");
$show = $deleteemaildomain . " was deleted from the signup filter.";
} # if ($action == "delete")
############################################################################
if ($action == "save")
{
$saveid = $_POST["saveid"];
$saveemaildomain = $_POST["saveemaildomain"];
	if (!$saveemaildomain)
	{
	$error .= "The email domain field was blank.";
	}
$saveemaildomain = strtolower($saveemaildomain);
$dupq = "select * from emailsignupcontrol where emaildomain=\"$saveemaildomain\" and id!=\"$saveid\"";
$dupr = mysql_query($dupq);
$duprows = mysql_num_rows($dupr);
if ($duprows > 0)
	{
	$error .= $saveemaildomain . " is already being filtered.";
	}
	if(!$error == "")
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="400">
	<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
	<tr><td colspan="2" align="center"><br><?php echo $error ?></td></tr>
	<tr><td colspan="2" align="center"><br><a href="signupemailcontrol.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
	}
mysql_query("update emailsignupcontrol set emaildomain=\"$saveemaildomain\" where id=\"$saveid\"");
$show = "Email filter " . $saveemaildomain . " was saved.";
} # if ($action == "save")
############################################################################
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
<tr><td align="center" colspan="2"><div class="heading">Member Email Sign-up Filtering</div></td></tr>
<?php
if ($show != "")
{
?>
<tr><td align="center" colspan="2"><br><?php echo $show ?></td></tr>
<?php
}
?>
<tr><td align="center" colspan="2"><br>
<form action="signupemailcontrol.php" method="post">
<table width="600" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrlight"><td>Create&nbsp;Email&nbsp;Sign-up&nbsp;Filter&nbsp;Of:</td><td><select name="emailsignupmethod" class="pickone">
<option value="denyallexcept" <?php if($emailsignupmethod == "denyallexcept") echo " selected"; ?>>Allowed Domains and Email Addresses</option>
<option value="allowallexcept" <?php if($emailsignupmethod != "denyallexcept") echo " selected"; ?>>Banned Domains and Email Addresses</option>
</select></td></tr>
<tr class="sabrinatrdark"><td colspan="2" align="center">
<input type="hidden" name="action" value="savesetting">
<input type="submit" value="SAVE" class="sendit"></form>
</td></tr>
</table>
</td></tr>

<tr><td align="center" colspan="2"><br>
<form action="signupemailcontrol.php" method="post">
<table width="600" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrdark"><td align="center" colspan="2">ADD NEW EMAIL ADDRESS OR DOMAIN</td></tr>
<tr class="sabrinatrlight"><td>Add&nbsp;To&nbsp;Signup&nbsp;Filter:</td><td><input type="text" name="newemaildomain" size="55" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrdark"><td colspan="2" align="center">
<input type="hidden" name="action" value="add">
<input type="submit" value="ADD" class="sendit"></form>
</td></tr>
</table>
</td></tr>

<?php
$q = "select * from emailsignupcontrol order by emaildomain";
$r = mysql_query($q);
$rows = mysql_num_rows($r);
if ($rows > 0)
{
?>
<tr><td align="center" colspan="2"><br>
<table width="600" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrdark"><td align="center" colspan="3">CURRENT FILTERED EMAIL ADDRESSES AND DOMAINS</td></tr>
<tr class="sabrinatrlight"><td align="center">Email/Domain</td><td align="center">Save</td><td align="center">Delete</td></tr>
<?php
	while ($rowz = mysql_fetch_array($r))
	{
	$emaildomainid = $rowz["id"];
	$emaildomain = $rowz["emaildomain"];
	?>
	<form action="signupemailcontrol.php" method="post">
	<tr class="sabrinatrlight"><td align="center"><input type="text" name="addemaildomain" size="25" maxlength="255" class="typein" value="<?php echo $emaildomain ?>"></td>
	<td align="center">
	<input type="hidden" name="saveid" value="<?php echo $emaildomainid ?>">
	<input type="hidden" name="saveemaildomain" value="<?php echo $emaildomain ?>">
	<input type="hidden" name="action" value="save">
	<input type="submit" value="SAVE" class="sendit"></form>
	</form>
	</td>
	<form action="signupemailcontrol.php" method="post">
	<td align="center">
	<input type="hidden" name="deleteid" value="<?php echo $emaildomainid ?>">
	<input type="hidden" name="deleteemaildomain" value="<?php echo $emaildomain ?>">
	<input type="hidden" name="action" value="delete">
	<input type="submit" value="DELETE" class="sendit"></form>
	</form>
	</td></tr>
	<?php
	}
?>
</table>
</td></tr>
<?php
}
?>

</table>
<br><br>
<?php
include "../footer.php";
exit;
?>