<?php
include "control.php";
require('EgoPaySci.php');
include "header.php";
$today = date('Y-m-d',strtotime("now"));
function formatDate($val) {
	$arr = explode("-", $val);
	return date("M d Y", mktime(0,0,0, $arr[1], $arr[2], $arr[0]));
}
if ($_POST["newlogin"])
{
$newloginq = "update members set lastlogin=NOW() where userid=\"$userid\"";
$newloginr = mysql_query($newloginq);
}
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">
<tr><td align="center" colspan="2"><div class="heading">Welcome <?php echo $firstname ?></div></td></tr>
<tr><td align="center" colspan="2" style="height: 15px;"></td></tr>

<?php
if (($accounttype == "PAID") and ($joinpriceinterval != "One Time"))
{
if (($membershipnextpaid < $today) or ($membershipnextpaid ==""))
	{
	?>
<tr><td align="center" colspan="2"><br>
<table cellpadding="2" cellspacing="2" border="0" align="center" class="sabrinatable" width="800">
<tr class="sabrinatrlight"><td align="center" colspan="2"><font style="color:#ff0000;background:#ffff00;">YOUR MEMBERSHIP FEE IS PAST DUE</font></td></tr>
<tr class="sabrinatrdark"><td colspan="2">Don't risk your membership being downgraded! Renew today!</td></tr>
<tr class="sabrinatrlight"><td>Due Date:</td><td><?php echo $membershipnextpaid ?></td></tr>
<tr class="sabrinatrlight"><td>Last Paid:</td><td><?php echo $membershiplastpaid ?></td></tr>
<tr class="sabrinatrlight"><td>Renew Membership Now for:</td><td>$<?php echo sprintf("%.2f", $joinprice); ?> <?php echo $joinpriceinterval ?></td></tr>
<tr class="sabrinatrdark"><td align="center" colspan="2">
<table cellpadding="2" cellspacing="2" border="0" align="center" class="sabrinatable" width="800">
<tr>
<?php
#### EGOPAY
if (($egopay_store_id!="") and ($egopay_store_password!=""))
{
try {
        
    $oEgopay = new EgoPaySci(array(
        'store_id'          => $egopay_store_id,
        'store_password'    => $egopay_store_password
    ));
    
    $sPaymentHash = $oEgopay->createHash(array(
	/*
	 * Payment amount with two decimal places 
	 */
        'amount'    => $joinprice,
	/*
	 * Payment currency, USD/EUR
	 */
        'currency'  => 'USD',
	/*
	 * Description of the payment, limited to 120 chars
	 */
        'description' => $sitename . ' - Membership Renewal - ' . $userid,
	
	/*
	 * Optional fields
	 */
	'fail_url'	=> $domain. '/members.php',
	'success_url'	=> $domain. '/thankyou_upgraderenewal.php',
	
	/*
	 * 8 Custom fields, hidden from users, limited to 100 chars.
	 * You can retrieve them only from your callback file.
	 */
	'cf_1' => $userid,
	'cf_2' => $sitename . ' - Membership Renewal - ' . $userid,
	//'cf_3' => '',
	//'cf_4' => '',
	//'cf_5' => '',
	//'cf_6' => '',
	//'cf_7' => '',
	//'cf_8' => '',
    ));
    
} catch (EgoPayException $e) {
    die($e->getMessage());
}
?>
<form action="<?php echo EgoPaySci::EGOPAY_PAYMENT_URL; ?>" method="post">
<td align="center">
<input type="hidden" name="hash" value="<?php echo $sPaymentHash ?>">
<input type="image" src="<?php echo $domain ?>/images/egopaysm.png" border="0" height="50">
</form>
</td></tr>
<?php
} # if (($egopay_store_id!="") and ($egopay_store_password!=""))
#### PAYPAL
if ($adminpaypal != "")
{
?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<td align="center">
<input type="hidden" name="amount" id="amount" value="<?php echo $joinprice ?>">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="<?php echo $adminpaypal ?>">
<input type="hidden" name="item_name" value="<?php echo $sitename ?> - Membership Renewal - <?php echo $userid ?>">
<input type="hidden" name="page_style" value="PayPal">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="<?php echo $domain ?>/thankyou_upgraderenewal.php">
<input type="hidden" name="cancel" value="<?php echo $domain ?>/members.php">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="bn" value="PP-BuyNowBF">
<input type="hidden" name="on0" value="User ID">
<input type="hidden" name="os0" value="<?php echo $userid ?>">
<input type="hidden" name="notify_url" value="<?php echo $domain ?>/paypal_ipn.php">
<input type="image" src="<?php echo $domain ?>/images/paypalsm.gif" border="0" name="submit" height="50">
</form>
</td></tr>
<?php
} # if ($adminpaypal != "")
#### PAYZA
if ($adminpayza != "")
{
?>
<form action="https://secure.payza.com/checkout" method="post">
<td align="center">
<input type="hidden" name="ap_amount" value="<?php echo $joinprice ?>">
<input type="hidden" name="ap_purchasetype" value="item-goods">
<input type="hidden" name="ap_merchant" value="<?php echo $adminpayza ?>">    
<input type="hidden" name="ap_itemname" value="<?php echo $sitename ?> - Membership Renewal - <?php echo $userid ?>">
<input type="hidden" name="ap_returnurl" value="<?php echo $domain ?>/thankyou_upgraderenewal.php">
<input type="hidden" name="ap_cancelurl" value="<?php echo $domain ?>/members.php">
<input type="hidden" name="apc_1" value="<?php echo $userid ?>">
<input type="hidden" name="ap_currency" value="USD"><br> 
<input type="image" name="ap_image" src="<?php echo $domain ?>/images/payzasm.png" border="0" height="50">
</form> 
</td></tr>
<?php
} # if ($adminpayza != "")
#### PERFECTMONEY
if ($adminperfectmoney != "")
{
?>
<form action="https://perfectmoney.com/api/step1.asp" method="POST">
<td align="center">
<input type="hidden" name="PAYEE_ACCOUNT" value="<?php echo $adminperfectmoney ?>">
<input type="hidden" name="PAYEE_NAME" value="<?php echo $adminname ?>">
<input type="hidden" name="PAYMENT_AMOUNT" value="<?php echo $joinprice ?>">
<input type="hidden" name="PAYMENT_UNITS" value="USD">
<input type="hidden" name="STATUS_URL" value="<?php echo $domain ?>/<?php echo $domain ?>/perfectmoney_ipn.php">
<input type="hidden" name="PAYMENT_URL" value="<?php echo $domain ?>/thankyou_upgraderenewal.php">
<input type="hidden" name="NOPAYMENT_URL" value="<?php echo $domain ?>/members.php">
<input type="hidden" name="BAGGAGE_FIELDS" value="userid item">
<input type="hidden" name="userid" value="<?php echo $userid ?>">
<input type="hidden" name="item" value="<?php echo $sitename ?> - Membership Renewal - <?php echo $userid ?>">
<!--<input type="hidden" name="V2_HASH" value="<?php echo $V2_HASH ?>">-->
<input type="image" name="PAYMENT_METHOD" value="PerfectMoney account" src="<?php echo $domain ?>/images/perfectmoneysm.png" border="0" height="50">
</form>
</td></tr>
<?php
} # if ($adminperfectmoney != "")
#### OKPAY
if ($adminokpay != "")
{
?>
<form  method="post" action="https://www.okpay.com/process.html">
<td align="center">
<input type="hidden" name="ok_receiver" value="<?php echo $adminokpay ?>">
<input type="hidden" name="ok_item_1_name" value="<?php echo $sitename ?> - Membership Renewal - <?php echo $userid ?>">
<input type="hidden" name="ok_currency" value="usd">
<input type="hidden" name="ok_item_1_type" value="service">
<input type="hidden" name="ok_item_1_price" value="<?php echo $joinprice ?>">
<input type="hidden" name="ok_item_1_custom_1_title" value="userid">
<input type="hidden" name="ok_item_1_custom_1_value" value="<?php echo $userid ?>">
<input type="hidden" name="ok_return_success" value="<?php echo $domain ?>/thankyou_upgraderenewal.php">
<input type="hidden" name="ok_return_fail" value="<?php echo $domain ?>/members.php">
<input type="hidden" name="ok_ipn" value="<?php echo $domain ?>/okpay_ipn.php">
<input type="image" name="submit" src="<?php echo $domain ?>/images/okpaysm.gif" border="0" height="50">
</form>
</td></tr>
<?php
} # if ($adminokpay != "")
#### SOLIDTRUSTPAY
if ($adminsolidtrustpay != "")
		{
?>
<form action="https://solidtrustpay.com/handle.php" method="post">
<td align="center">
<input type="hidden" name="merchantAccount" value="<?php echo $adminsolidtrustpay ?>">
<input type="hidden" name="sci_name" value="your_sci_name">
<input type="hidden" name="amount" value="<?php echo $joinprice ?>">
<input type="hidden" name="currency" value="USD">
<input type="hidden" name="user1" value="<?php echo $userid ?>">
<input type="hidden" name="notify_url" value="<?php echo $domain ?>/solidtrustpay_ipn.php">
<input type="hidden" name="return_url" value="<?php echo $domain ?>/thankyou_upgraderenewal.php">
<input type="hidden" name="cancel_url"  value="<?php echo $domain ?>/members.php">
<input type="hidden" name="item_id" value="<?php echo $sitename ?> - Membership Renewal - <?php echo $userid ?>">
<input type="image" name="cartImage" src="<?php echo $domain ?>/images/solidtrustpaysm.gif" alt="Solid Trust Pay" border="0" height="50">
</form>
</td></tr>
<?php
	} # if ($adminsolidtrustpay != "")
?>
</table>
</td></tr>
</table>
</td></tr>
<tr><td align="center" colspan="2"><br>&nbsp;</td></tr>
	<?php
	} # if (($membershipnextpaid < $today) or ($membershipnextpaid ==""))
} # if (($accounttype == "PAID") and ($joinpriceinterval != "One Time"))
?>

<tr><td align="center" colspan="2">
<?php
$q = "select * from pages where name='Members Area Main Page'";
$r = mysql_query($q);
$rowz = mysql_fetch_array($r);
$htmlcode = $rowz["htmlcode"];
echo $htmlcode;
?>
</td></tr>




</table>
<br><br>
<?php
include "footer.php";
exit;
?>