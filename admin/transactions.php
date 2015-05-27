<?php
include "control.php";
include "../header.php";
function formatDate($val) {
	$arr = explode("-", $val);
	return date("M d Y", mktime(0,0,0, $arr[1], $arr[2], $arr[0]));
}
$action = $_POST["action"];
$show = "";
if ($action == "delete")
{
foreach($id as $each)
{
mysql_query("delete from transactions where id=".$each);
}
$show = "Record(s) deleted";
} # if ($action == "delete")
?>
<script language="JavaScript">
 function Inverse(form)
   {
    len = form.elements.length;
    var i=0;
    for( i=0; i<len; i++)
    {
     if (form.elements[i].type=='checkbox' )
     {
      form.elements[i].checked = !form.elements[i].checked;
     }
    }
	return false;
   }		
</script>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
<tr><td align="center" colspan="2"><div class="heading">Site&nbsp;Transactions&nbsp;and&nbsp;Payouts</div></td></tr>
<?php
if ($show != "")
{
?>
<tr><td align="center" colspan="2"><br><?php echo $show ?></td></tr>
<?php
}
?>

<tr><td align="center" colspan="2">&nbsp;<br></td></tr>

<tr><td align="center" colspan="2">
<table cellpadding="2" cellspacing="2" border="0" align="center" class="sabrinatable" class="sabrinatable">
<tr class="sabrinatrdark"><td align="center" colspan="2"><div class="heading">Member Order/Purchase History</div></td></tr>

<?php
$pnquery = "select * from transactions order by id desc";
$pnresult = mysql_query($pnquery);
$pnrows = mysql_num_rows($pnresult);
if ($pnrows < 1)
{
?>
<tr class="sabrinatrlight"><td align="center" colspan="2">There is no order history yet in the system.</td></tr>
<?php
}
if ($pnrows > 0)
{
?>
<form action="transactions.php" method="post" name="transactions">
<tr><td align="center" colspan="2"><table cellpadding="2" cellspacing="2" border="0" align="center">
<tr class="sabrinatrlight">
<td align="center"></td>
<td align="center">ID</td>
<td align="center">UserID</td>
<td align="center">Description</td>
<!--<td align="center">Transaction ID</td>-->
<td align="center">Amount</td>
<td align="center">Date</td>
</tr>
<?php
	while ($pnrowz = mysql_fetch_array($pnresult))
	{
	$userid = $pnrowz["userid"];
	$transaction = $pnrowz["transaction"];
	$description = $pnrowz["description"];
	$amountreceived = $pnrowz["amountreceived"];
	$paymentdate = $pnrowz["paymentdate"];
	$paymentdate = formatDate($paymentdate);
	?>
	<tr class="sabrinatrdark">
	<td align="center"><input type="checkbox" name="id[]" value="<? echo $id; ?>"></td>
	<td align="center"><?php echo $id ?></td>
	<td align="center"><?php echo $userid ?></td>
	<td align="center"><?php echo $description ?></td>
	<!--<td align="center"><?php echo $transaction ?></td>-->
	<td align="center">$<?php echo $amountreceived ?></td>
	<td align="center"><?php echo $paymentdate ?></td>
	</tr>
	<?php
	} # while ($pnrowz = mysql_fetch_array($pnresult))
?>
</table></td></tr>
<tr class="sabrinatrdark"><td colspan="2" align="center"><input type="hidden" name="action" value="delete"><input type="button" onClick="return Inverse(document.transactions);" value="INVERSE"><input type="submit" name="submit" value="DELETE"></form></td></tr>
<?php
} # if ($pnrows > 0)
?>
</table></td></tr>

<tr><td colspan="2" align="center"><br>&nbsp;<br>&nbsp;</td></tr>


<tr><td align="center" colspan="2">
<table cellpadding="2" cellspacing="2" border="0" align="center" class="sabrinatable" class="sabrinatable">
<tr class="sabrinatrdark"><td align="center" colspan="2"><div class="heading">Member Payout History</div></td></tr>

<?php
$poquery = "select * from payouts order by id desc";
$poresult = mysql_query($poquery);
$porows = mysql_num_rows($poresult);
if ($porows < 1)
{
?>
<tr class="sabrinatrlight"><td align="center" colspan="2">There is no payout history yet in the system.</td></tr>
<?php
}
if ($porows > 0)
{
?>
<form action="transactions.php" method="post" name="payouts">
<tr><td align="center" colspan="2"><table cellpadding="2" cellspacing="2" border="0" align="center">
<tr class="sabrinatrlight">
<td align="center"></td>
<td align="center">ID</td>
<td align="center">UserID</td>
<td align="center">Description</td>
<td align="center">Amount</td>
<td align="center">Date</td>
</tr>
<?php
	while ($porowz = mysql_fetch_array($poresult))
	{
	$id = $porowz["id"];
	$userid = $porowz["userid"];
	$description = $porowz["description"];
	$paid = $porowz["paid"];
	$datepaid = $porowz["datepaid"];
	$datepaid = formatDate($datepaid);
	?>
	<tr class="sabrinatrdark">
	<td align="center"><input type="checkbox" name="id[]" value="<? echo $id; ?>"></td>
	<td align="center"><?php echo $id ?></td>
	<td align="center"><?php echo $userid ?></td>
	<td align="center"><?php echo $description ?></td>
	<td align="center">$<?php echo $paid ?></td>
	<td align="center"><?php echo $datepaid ?></td>
	</tr>
	<?php
	} # while ($porowz = mysql_fetch_array($poresult))
?>
</table></td></tr>
<tr class="sabrinatrdark"><td colspan="2" align="center"><input type="hidden" name="action" value="delete"><input type="button" onClick="return Inverse(document.payouts);" value="INVERSE"><input type="submit" name="submit" value="DELETE"></form></td></tr>
<?php
} # if ($porows > 0)
?>
</table></td></tr>

</table>
<br><br>
<?php
include "../footer.php";
exit;
?>