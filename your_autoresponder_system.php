<?php
include "control.php";
include "header.php";
?>
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">YOUR AUTORESPONDER SYSTEM</div></td></tr>

<tr><td align="center" colspan="2">
<?php
include "autoresponder_menu.php";
?>
</td></tr>

<tr><td align="center" colspan="2"><br>
<table width="800" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrlight"><td align="center" colspan="3">AUTORESPONDER SETTINGS BY MEMBERSHIP LEVEL</td></tr>
<tr class="sabrinatrdark"><td align="center">Setting</td><td align="center">Free Members</td><td align="center">Paid Members</td></tr>
<tr class="sabrinatrlight"><td>Maximum AutoResponders:</td><td align="center"><?php echo $ar_maxautoresponderemailsfree ?></td><td align="center"><?php echo $ar_maxautoresponderemailspaid ?></td></tr>
<tr class="sabrinatrlight"><td>Maximum Mailing Lists:</td><td align="center"><?php echo $ar_howmanylistsfree ?></td><td align="center"><?php echo $ar_howmanylistspaid ?></td></tr>
<tr class="sabrinatrlight"><td>Maximum Prospects Per Mailing List:</td><td align="center"><?php echo $ar_howmanyprospectsperlistfree ?></td><td align="center"><?php echo $ar_howmanyprospectsperlistpaid ?></td></tr>
<tr class="sabrinatrlight"><td>Maximum Direct Email Recipients Per Send:</td><td align="center"><?php echo $ar_maxprospectsmailedperlistfree ?></td><td align="center"><?php echo $ar_maxprospectsmailedperlistpaid ?></td></tr>
<tr class="sabrinatrlight"><td>Bounces before a Prospect is Automatically Unsubscribed:</td><td align="center"><?php echo $ar_bouncestoautounsubscribefree ?></td><td align="center"><?php echo $ar_bouncestoautounsubscribepaid ?></td></tr>
</table>
</td></tr>

<tr><td align="center" colspan="2"><br>
<table cellpadding="2" cellspacing="2" border="0" align="center" width="100%">
<tr><td>
<div style="text-align: center;">
<?php
$q = "select * from pages where name='Members Area - Autoresponder Introductory Page'";
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

</table><br><br>&nbsp;
<!-- END PAGE CONTENT //-->
<?php
include "footer.php";
exit;
?>