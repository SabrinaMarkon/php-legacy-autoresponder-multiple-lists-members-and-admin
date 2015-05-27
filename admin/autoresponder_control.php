<?php
include "control.php";
include "../header.php";
$action = $_POST["action"];
$show = "";
if ($action == "savesettings")
{
$ar_howmanylistspaid = $_POST["ar_howmanylistspaidp"];
$ar_howmanyprospectsperlistpaid = $_POST["ar_howmanyprospectsperlistpaidp"];
$ar_maxprospectsmailedperlistpaid = $_POST["ar_maxprospectsmailedperlistpaidp"];
$ar_maxautoresponderemailspaid = $_POST["ar_maxautoresponderemailspaidp"];
$ar_bouncestoautounsubscribepaid = $_POST["ar_bouncestoautounsubscribepaidp"];
$ar_howmanylistsfree = $_POST["ar_howmanylistsfreep"];
$ar_howmanyprospectsperlistfree = $_POST["ar_howmanyprospectsperlistfreep"];
$ar_maxprospectsmailedperlistfree = $_POST["ar_maxprospectsmailedperlistfreep"];
$ar_maxautoresponderemailsfree = $_POST["ar_maxautoresponderemailsfreep"];
$ar_bouncestoautounsubscribefree = $_POST["ar_bouncestoautounsubscribefreep"];
$ar_defaultredirecturlaftersubscribeformsubmission = $_POST["ar_defaultredirecturlaftersubscribeformsubmissionp"];
$ar_defaultredirecturlafterclickingaremaillink = $_POST["ar_defaultredirecturlafterclickingaremaillinkp"];
$ar_defaultredirecturlafterverification = $_POST["ar_defaultredirecturlafterverificationp"];
$ar_bounceemail = $_POST["ar_bounceemailp"];

$update = mysql_query("update adminsettings set setting='$ar_howmanylistspaid' where name='ar_howmanylistspaid'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$ar_howmanyprospectsperlistpaid' where name='ar_howmanyprospectsperlistpaid'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$ar_maxprospectsmailedperlistpaid' where name='ar_maxprospectsmailedperlistpaid'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$ar_maxautoresponderemailspaid' where name='ar_maxautoresponderemailspaid'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$ar_bouncestoautounsubscribepaid' where name='ar_bouncestoautounsubscribepaid'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$ar_howmanylistsfree' where name='ar_howmanylistsfree'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$ar_howmanyprospectsperlistfree' where name='ar_howmanyprospectsperlistfree'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$ar_maxprospectsmailedperlistfree' where name='ar_maxprospectsmailedperlistfree'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$ar_maxautoresponderemailsfree' where name='ar_maxautoresponderemailsfree'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$ar_bouncestoautounsubscribefree' where name='ar_bouncestoautounsubscribefree'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$ar_defaultredirecturlaftersubscribeformsubmission' where name='ar_defaultredirecturlaftersubscribeformsubmission'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$ar_defaultredirecturlafterclickingaremaillink' where name='ar_defaultredirecturlafterclickingaremaillink'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$ar_defaultredirecturlafterverification' where name='ar_defaultredirecturlafterverification'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$ar_bounceemail' where name='ar_bounceemail'") or die(mysql_error());

$show = "Your Settings were Saved!";
} # if ($action == "savesettings")
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
<tr><td align="center" colspan="2"><div class="heading">AutoResponder System Settings</div></td></tr>
<?php
if ($show != "")
{
?>
<tr><td align="center" colspan="2"><br><?php echo $show ?></td></tr>
<?php
}
?>
<tr><td align="center" colspan="2"><br>
<form action="autoresponder_control.php" method="post">
<table width="600" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrdark"><td colspan="3" align="center">AUTORESPONDER BASIC SETTINGS</td></tr>
<tr class="sabrinatrlight"><td colspan="2" align="center">Default URL AutoResponder prospects see after signing up if no other URL is available in the system:</td><td><input type="text" name="ar_defaultredirecturlaftersubscribeformsubmissionp" value="<?php echo $ar_defaultredirecturlaftersubscribeformsubmission ?>" size="25" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td colspan="2" align="center">Default URL AutoResponder prospects see after clicking a link in an AutoResponder email they've received, if no other URL is available in the system:</td><td><input type="text" name="ar_defaultredirecturlafterclickingaremaillinkp" value="<?php echo $ar_defaultredirecturlafterclickingaremaillink ?>" size="25" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td colspan="2" align="center">Default URL AutoResponder prospects see after verifiying their email address, if no other URL is available in the system:</td><td><input type="text" name="ar_defaultredirecturlafterverificationp" value="<?php echo $ar_defaultredirecturlafterverification ?>" size="25" maxlength="255"></td></tr>

<tr class="sabrinatrlight"><td colspan="2" align="center">Bounce Email address (handles bounced AutoResponder emails):</td><td><input type="text" name="ar_bounceemailp" value="<?php echo $ar_bounceemail ?>" size="25" maxlength="255"></td></tr>
<tr class="sabrinatrdark"><td align="center">Setting</td><td align="center">Free Members</td><td align="center">Paid Members</td></tr>

<tr class="sabrinatrlight">
<td>Maximum AutoResponders members may set up:</td>
<td align="center"><select name="ar_maxautoresponderemailsfreep">
<option value="Infinite" <?php if ($ar_maxautoresponderemailsfree == "Infinite") { echo "selected"; } ?>>Infinite</option>
<option value="0" <?php if ($ar_maxautoresponderemailsfree == "0") { echo "selected"; } ?>>0</option>
<?php
for($a=0;$a<=100;$a++)
{
	if ($a != 0)
	{
	?>
	<option value="<?php echo $a ?>" <?php if ($ar_maxautoresponderemailsfree == $a) { echo "selected"; } ?>><?php echo $a ?></option>
	<?php
	}
}
?>
</select></td>
<td align="center"><select name="ar_maxautoresponderemailspaidp">
<option value="Infinite" <?php if ($ar_maxautoresponderemailspaid == "Infinite") { echo "selected"; } ?>>Infinite</option>
<option value="0" <?php if ($ar_maxautoresponderemailspaid == "0") { echo "selected"; } ?>>0</option>
<?php
for($b=0;$b<=100;$b++)
{
	if ($b != 0)
	{
	?>
	<option value="<?php echo $b ?>" <?php if ($ar_maxautoresponderemailspaid == $b) { echo "selected"; } ?>><?php echo $b ?></option>
	<?php
	}
}
?>
</select></td>
</tr>

<tr class="sabrinatrlight">
<td>Maximum Mailing Lists members may create:</td>
<td align="center"><select name="ar_howmanylistsfreep">
<option value="Infinite" <?php if ($ar_howmanylistsfree == "Infinite") { echo "selected"; } ?>>Infinite</option>
<option value="0" <?php if ($ar_howmanylistsfree == "0") { echo "selected"; } ?>>0</option>
<?php
for($c=0;$c<=100;$c++)
{
	if ($c != 0)
	{
	?>
	<option value="<?php echo $c ?>" <?php if ($ar_howmanylistsfree == $c) { echo "selected"; } ?>><?php echo $c ?></option>
	<?php
	}
}
?>
</select></td>
<td align="center"><select name="ar_howmanylistspaidp">
<option value="Infinite" <?php if ($ar_howmanylistspaid == "Infinite") { echo "selected"; } ?>>Infinite</option>
<option value="0" <?php if ($ar_howmanylistspaid == "0") { echo "selected"; } ?>>0</option>
<?php
for($d=0;$d<=100;$d++)
{
	if ($d != 0)
	{
	?>
	<option value="<?php echo $d ?>" <?php if ($ar_howmanylistspaid == $d) { echo "selected"; } ?>><?php echo $d ?></option>
	<?php
	}
}
?>
</select></td>
</tr>

<tr class="sabrinatrlight">
<td>Maximum Prospects per mailing list a member creates<br>(IMPORTANT: after reaching this value, the member's subscribe form for the mailing list will no longer accept new prospect signups!):</td>
<td align="center"><select name="ar_howmanyprospectsperlistfreep">
<option value="Infinite" <?php if ($ar_howmanyprospectsperlistfree == "Infinite") { echo "selected"; } ?>>Infinite</option>
<option value="0" <?php if ($ar_howmanyprospectsperlistfree == "0") { echo "selected"; } ?>>0</option>
<?php
for($e=0;$e<=5000;$e+=50)
{
	if ($e != 0)
	{
	?>
	<option value="<?php echo $e ?>" <?php if ($ar_howmanyprospectsperlistfree == $e) { echo "selected"; } ?>><?php echo $e ?></option>
	<?php
	}
}
?>
</select></td>
<td align="center"><select name="ar_howmanyprospectsperlistpaidp">
<option value="Infinite" <?php if ($ar_howmanyprospectsperlistpaid == "Infinite") { echo "selected"; } ?>>Infinite</option>
<option value="0" <?php if ($ar_howmanyprospectsperlistpaid == "0") { echo "selected"; } ?>>0</option>
<?php
for($f=0;$f<=5000;$f+=50)
{
	if ($f != 0)
	{
	?>
	<option value="<?php echo $f ?>" <?php if ($ar_howmanyprospectsperlistpaid == $f) { echo "selected"; } ?>><?php echo $f ?></option>
	<?php
	}
}
?>
</select></td>
</tr>

<tr class="sabrinatrlight">
<td>Maximum recipients for direct mailouts to prospects:</td>
<td align="center"><select name="ar_maxprospectsmailedperlistfreep">
<option value="Infinite" <?php if ($ar_maxprospectsmailedperlistfree == "Infinite") { echo "selected"; } ?>>Infinite</option>
<option value="0" <?php if ($ar_maxprospectsmailedperlistfree == "0") { echo "selected"; } ?>>0</option>
<?php
for($g=0;$g<=5000;$g+=50)
{
	if ($g != 0)
	{
	?>
	<option value="<?php echo $g ?>" <?php if ($ar_maxprospectsmailedperlistfree == $g) { echo "selected"; } ?>><?php echo $g ?></option>
	<?php
	}
}
?>
</select></td>
<td align="center"><select name="ar_maxprospectsmailedperlistpaidp">
<option value="Infinite" <?php if ($ar_maxprospectsmailedperlistpaid == "Infinite") { echo "selected"; } ?>>Infinite</option>
<option value="0" <?php if ($ar_maxprospectsmailedperlistpaid == "0") { echo "selected"; } ?>>0</option>
<?php
for($h=0;$h<=5000;$h+=50)
{
	if ($h != 0)
	{
	?>
	<option value="<?php echo $h ?>" <?php if ($ar_maxprospectsmailedperlistpaid == $h) { echo "selected"; } ?>><?php echo $h ?></option>
	<?php
	}
}
?>
</select></td>
</tr>

<tr class="sabrinatrlight">
<td>Bounces before a prospect is automatically unsubscribed:</td>
<td align="center"><select name="ar_bouncestoautounsubscribefreep">
<?php
for($i=0;$i<=50;$i++)
{
	if ($i != 0)
	{
	?>
	<option value="<?php echo $i ?>" <?php if ($ar_bouncestoautounsubscribefree == $i) { echo "selected"; } ?>><?php echo $i ?></option>
	<?php
	}
}
?>
</select></td>
<td align="center"><select name="ar_bouncestoautounsubscribepaidp">
<?php
for($j=0;$j<=50;$j++)
{
	if ($j != 0)
	{
	?>
	<option value="<?php echo $j ?>" <?php if ($ar_bouncestoautounsubscribepaid == $j) { echo "selected"; } ?>><?php echo $j ?></option>
	<?php
	}
}
?>
</select></td>
</tr>

<tr class="sabrinatrdark">
<td colspan="3" align="center"><input type="hidden" name="action" value="savesettings"><input type="submit" name="submit" value="SAVE" class="sendit"></form></td>
</tr>
</table>
</td></tr>

</table>
<br><br>
<?php
include "../footer.php";
exit;
?>