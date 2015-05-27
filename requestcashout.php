<?php
include "control.php";
include "header.php";
function formatDate($val) {
	$arr = explode("-", $val);
	return date("M d Y", mktime(0,0,0, $arr[1], $arr[2], $arr[0]));
}
$commission = sprintf("%.2f", $commission);
###############################################################################
if ($_POST["action"] == "cashout")
{
$cashoutamount = $_POST["cashoutamount"];
$message = $_POST["message"];
$preferredpaymentprocessor = $_POST["preferredpaymentprocessor"];
$error = "";
if ($cashoutamount < $minimumpayout)
	{
	$error .= "<div>Sorry, you cannot withdraw less than the minimum cash payout, which is \$" . $minimumpayout . ".</div>";
	}
if ($cashoutamount > $commission)
	{
	$error .= "<div>You do not have \$" . $cashoutamount . " in earnings to withdraw.</div>";
	}
	if(!$error == "")
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
	<tr><td align="center" colspan="2"><div class="heading">Cash Out Error</div></td></tr>
	<tr><td colspan="2" align="center"><br><?php echo $error ?></td></tr>
	<tr><td colspan="2" align="center"><br><a href="requestcashout.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "footer.php";
	exit;
	}

$totalcashadminneedstopay = $cashoutamount;
$totalcashadminneedstopay = sprintf("%.2f", $totalcashadminneedstopay);
########################################################
if ($paypal == "")
	{
	$paypal = "Not Entered";
	}
if ($payza == "")
	{
	$payza = "Not Entered";
	}
if ($egopay == "")
	{
	$egopay = "Not Entered";
	}
if ($solidtrustpay == "")
	{
	$solidtrustpay = "Not Entered";
	}
if ($perfectmoney == "")
	{
	$perfectmoney = "Not Entered";
	}
if ($okpay == "")
	{
	$okpay = "Not Entered";
	}
$q = "insert into cashoutrequests (userid,preferredpaymentprocessor,egopay,payza,perfectmoney,okpay,solidtrustpay,paypal,amountrequested,daterequested,message) values (\"$userid\",\"$preferredpaymentprocessor\",\"$egopay\",\"$payza\",\"$perfectmoney\",\"$okpay\",\"$solidtrustpay\",\"$paypal\",\"$totalcashadminneedstopay\",NOW(),\"$message\")";
$r = mysql_query($q);
########################################################
$headers = "From: $sitename<$adminemail>\n";
$headers .= "Reply-To: <$adminemail>\n";
$headers .= "X-Sender: <$adminemail>\n";
$headers .= "X-Mailer: PHP4\n";
$headers .= "X-Priority: 3\n";
$headers .= "Return-Path: <$adminemail>\n";
$to = $adminemail;
$subject = $sitename . " Cash Out Request for UserID $userid";
$body = "UserID: $userid\nPreferred Payment Processor: $preferredpaymentprocessor\nEgoPay: $egopay\nPayza: $payza\nPerfect Money: $perfectmoney\nOKPay: $okpay\nSolid Trust Pay: $solidtrustpay\nPayPal: $paypal\nRequested:\n\n";
$body .= "Requested Withdrawal Amount: \$$cashoutamount\n";
$body .= "Message:\n$message\n\n";
$body .= "Total Commission Balance: \$$commission\n";
$body .= "\n";
$body .= "TOTAL CASH ADMIN PAYS FROM THIS CASHOUT REQUEST: \$$cashoutamount\n";
$body .= "\n";
@mail($to, $subject, wordwrap(stripslashes($body)),$headers, "-f $adminemail");
echo "<p align=\"center\"><font face=\"Tahoma\" size=\"2\">Your cash out request for \$" . $cashoutamount . " was submitted to the admin. <br><a href=\"requestcashout.php\">Click here</a> to go back.</font></p>";
include "footer.php";
exit;
} # if ($_POST["action"] == "cashout")
###############################################################################
?>
<table align="center" border="0" width="100%">
<tr><td colspan="2">
<div style="text-align: center;">
<?php
$query = "select * from pages where name='Request Cash Out Page'";
$result = mysql_query ($query)
or die ("Query failed");
while ($line = mysql_fetch_array($result))
{
$htmlcode = $line["htmlcode"];
echo $htmlcode;
?>
<tr><td colspan="2" align="center"><br>&nbsp;</td></tr>
<?php
}
#############################
?>
</div> 
</td></tr>

<tr><td align="center" colspan="2">
<table cellpadding="2" cellspacing="2" border="0" align="center" class="sabrinatable" width="90%">
<tr><td align="center" colspan="2">Cash Out Earnings From Commissions</td></tr>
<?php
if ($minimumpayout > 0)
	{
?>
<tr class="sabrinatrdark"><td align="center" colspan="2">Minimum Payout: $<?php echo $minimumpayout ?></td></tr>
<?php
	}
?>
<form method="post" action="requestcashout.php">
<tr class="sabrinatrlight"><td>Withdraw Earnings:</td><td>$<input type="text" name="cashoutamount" maxlength="12" size="6"></td></tr>
<tr class="sabrinatrlight"><td>Message:</td><td><input type="text" name="message" maxlength="255" size="95"></td></tr>
<tr class="sabrinatrlight"><td>Preferred Payment Processor:</td><td><select name="preferredpaymentprocessor">
<?php
		if ($payoutpaypal == "yes")
		{
		?>
		<option value="PayPal">PayPal</option>
		<?php
		}
		if ($payoutegopay == "yes")
		{
		?>
		<option value="EgoPay">EgoPay</option>
		<?php
		}
		if ($payoutpayza == "yes")
		{
		?>
		<option value="Payza">Payza</option>
		<?php
		}
		if ($payoutperfectmoney == "yes")
		{
		?>
		<option value="Perfect Money">Perfect Money</option>
		<?php
		}
		if ($payoutokpay == "yes")
		{
		?>
		<option value="OKPay">OKPay</option>
		<?php
		}
		if ($payoutsolidtrustpay == "yes")
		{
		?>
		<option value="Solid Trust Pay">Solid Trust Pay</option>
		<?php
		}
?>
</select></td></tr>
<tr class="sabrinatrdark"><td align="center" colspan="2"><input type="hidden" name="action" value="cashout">
<input type="submit" value="Submit"></form></td></tr>
</table>
</td></tr>

<tr><td colspan="2" align="center"><br>&nbsp;</td></tr>
</table>
<?php
include "footer.php";
?>