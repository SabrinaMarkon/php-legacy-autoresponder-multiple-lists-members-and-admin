<?php
include "db.php";
include "header.php";
$r = $_REQUEST["r"];
$q1 = "select * from autoresponders_prospects where email=\"$r\"";
$r1 = mysql_query($q1);
$rows1 = mysql_num_rows($r1);
if ($rows1 < 1)
{
?>
<!-- CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="75%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold; color: #FF0000; font-family: Verdana;">ERROR</div></td></tr>
<tr><td colspan="2"><br>The email address you entered, <?php echo $r ?> was not found. Please <a href="mailto:<?php echo $adminemail ?>">Contact Us</a> for assistance if you are having difficulty opting out. If you also forward us a copy of the mail you received this helps us to find your address to delete it if you are getting this error but are sure you're still receiving mail from us.</p>
</td></tr>
<tr><td align="center" colspan="2">
<form action="ar_remove.php" method="post">
Remove Email:&nbsp;<input type="text" name="r" maxlength="255" size="25" value="<?php echo $r ?>" class="typein">&nbsp;<input type="submit" value="Remove Email" class="sendit">
</form>
</td></tr>
</table>
<!-- END CONTENT //-->
<?php
include "footer.php";
exit;
}
if ($rows1 > 0)
{
while ($rowz1 = mysql_fetch_array($r1))
	{
	$id = $rowz1["id"];
	$q2 = "update autoresponders_prospects set unsubscribed=\"yes\",unsubscribedate=NOW() where email=\"$r\" or id=\"$id\"";
	$r2 = mysql_query($q2);
	}
?>
<!-- CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="75%" align="center">
<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold; color: #FF0000; font-family: Verdana;">YOUR ADDRESS WAS REMOVED</div></td></tr>
</table>
<!-- END CONTENT //-->
<?php
include "footer.php";
exit;
}
?>