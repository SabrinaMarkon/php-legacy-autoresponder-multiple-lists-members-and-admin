<?php
include "control.php";
include "header.php";
$action = $_POST["action"];
if ($action == "confirm")
{
mysql_query("delete from cashoutrequests where userid='$userid'");
mysql_query("delete from payouts where userid='$userid'");
mysql_query("delete from adminemails_viewed where userid='$userid'");
mysql_query("delete from transactions where userid='$userid'");
mysql_query("delete from members where userid='$userid'");
?>
<table cellpadding="4" cellspacing="0" border="0" width="75%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">YOUR ADDRESS AND ACCOUNT WAS REMOVED COMPLETELY FROM OUR SYSTEM</div></td></tr>
</table>
<!-- END CONTENT //-->
<?php
include "footer.php";
exit;
} # if ($action == "confirm")
?>
<table cellpadding="4" cellspacing="0" border="0" width="75%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">Are you sure you want to be removed?</div></td></tr>
<tr><td align="center" colspan="2"><br>This action is irreversible!</td></tr>
<tr><td align="center" colspan="2"><br><br>
<form action="delete.php" method="post">
<input type="hidden" name="action" value="confirm"><input type="submit" value="DELETE ACCOUNT" class="sendit">
</form>
</td></tr>
<tr><td align="center" colspan="2"><br><a href="members.php">CANCEL</a></td></tr>
</table>
<?php
include "footer.php";
exit;
?>
