<?php
include "control.php";
require('EgoPaySci.php');
include "header.php";
if ($accounttype == "PAID")
{
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
<tr><td colspan="2" align="center"><br>You are already a <?php echo $level2name ?> <?php echo $sitename ?> Member!</td></tr>
<tr><td colspan="2" align="center"><br><a href="members.php">RETURN</a></td></tr>
</table>
<br><br>
<?php
include "footer.php";
exit;
}
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">

<tr><td align="center" colspan="2">
<table cellpadding="2" cellspacing="2" border="0" align="center" width="100%">
<tr><td>
<div style="text-align: center;">
<?php
$q = "select * from pages where name='Members Area Upgrade Page'";
$r = mysql_query($q);
$rowz = mysql_fetch_array($r);
$htmlcode = $rowz["htmlcode"];
echo $htmlcode;
?>
</div>
</td></tr>
</table>
</td></tr>

<tr><td align="center" colspan="2">
<table cellpadding="2" cellspacing="2" border="0" align="center" width="90%" class="sabrinatable">
<tr class="sabrinatrdark"><td align="center" colspan="2"><div class="heading">UPGRADE YOUR ACCOUNT</div></td></tr>
<tr class="sabrinatrlight"><td colspan="2" align="center">Order Upgrade $<?php echo sprintf("%.2f", $joinprice); ?> <?php echo $joinpriceinterval ?></td></tr>
<?php
##########################
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
        'description' => $sitename . ' - Membership Upgrade - ' . $userid,
	
	/*
	 * Optional fields
	 */
	'fail_url'	=> $domain. '/upgrade.php',
	'success_url'	=> $domain. '/thankyou_upgrade.php',
	
	/*
	 * 8 Custom fields, hidden from users, limited to 100 chars.
	 * You can retrieve them only from your callback file.
	 */
	'cf_1' => $userid,
	'cf_2' => $sitename . ' - Membership Upgrade - ' . $userid,
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
<tr class="sabrinatrdark"><td colspan="2" align="center"><br><br>
After you've made your payment, please be sure to click the link on EgoPay to return back to the website!<br><br>
<form action="<?php echo EgoPaySci::EGOPAY_PAYMENT_URL; ?>" method="post">
<input type="hidden" name="hash" value="<?php echo $sPaymentHash ?>">
<input type="image" src="<?php echo $domain ?>/images/egopay.png" border="0">
</form>
<br>&nbsp;</td></tr>
<?php
} # if (($egopay_store_id!="") and ($egopay_store_password!=""))

if ($adminpaypal != "")
{
?>
<tr class="sabrinatrdark"><td colspan="2" align="center"><br><br>
After you've made your payment, please be sure to click the link on Paypal to return back to the website!<br><br>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="amount" id="amount" value="<?php echo $joinprice ?>">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="<?php echo $adminpaypal ?>">
<input type="hidden" name="item_name" value="<?php echo $sitename ?> - Membership Upgrade - <?php echo $userid ?>">
<input type="hidden" name="page_style" value="PayPal">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="<?php echo $domain ?>/thankyou_upgrade.php">
<input type="hidden" name="cancel" value="<?php echo $domain ?>/upgrade.php">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="bn" value="PP-BuyNowBF">
<input type="hidden" name="on0" value="User ID">
<input type="hidden" name="os0" value="<?php echo $userid ?>">
<input type="hidden" name="notify_url" value="<?php echo $domain ?>/paypal_ipn.php">
<input type="image" src="<?php echo $domain ?>/images/paypal.jpg" border="0" name="submit">
</form>
<br>&nbsp;</td></tr>
<?php
} # if ($adminpaypal != "")

if ($adminpayza != "")
{
?>
<tr class="sabrinatrdark"><td colspan="2" align="center"><br><br>
After you've made your payment, please be sure to click the link on Payza to return back to the website!<br>
<form action="https://secure.payza.com/checkout" method="post">
<input type="hidden" name="ap_amount" value="<?php echo $joinprice ?>">
<input type="hidden" name="ap_purchasetype" value="item-goods">
<input type="hidden" name="ap_merchant" value="<?php echo $adminpayza ?>">    
<input type="hidden" name="ap_itemname" value="<?php echo $sitename ?> - Membership Upgrade - <?php echo $userid ?>">
<input type="hidden" name="ap_returnurl" value="<?php echo $domain ?>/thankyou_upgrade.php">
<input type="hidden" name="ap_cancelurl" value="<?php echo $domain ?>/upgrade.php">
<input type="hidden" name="apc_1" value="<?php echo $userid ?>">
<input type="hidden" name="ap_currency" value="USD"><br> 
<input type="image" name="ap_image" src="<?php echo $domain ?>/images/payza.gif" border="0">
</form> 
<br>&nbsp;</td></tr>
<?php
} # if ($adminpayza != "")

if ($adminperfectmoney != "")
{
?>
<tr class="sabrinatrdark"><td colspan="2" align="center"><br><br>
After you've made your payment, please be sure to click the link on Perfect Money to return back to the website!<br><br>
<form action="https://perfectmoney.com/api/step1.asp" method="POST">
<input type="hidden" name="PAYEE_ACCOUNT" value="<?php echo $adminperfectmoney ?>">
<input type="hidden" name="PAYEE_NAME" value="<?php echo $adminname ?>">
<input type="hidden" name="PAYMENT_AMOUNT" value="<?php echo $joinprice ?>">
<input type="hidden" name="PAYMENT_UNITS" value="USD">
<input type="hidden" name="STATUS_URL" value="<?php echo $domain ?>/<?php echo $domain ?>/perfectmoney_ipn.php">
<input type="hidden" name="PAYMENT_URL" value="<?php echo $domain ?>/thankyou_upgrade.php">
<input type="hidden" name="NOPAYMENT_URL" value="<?php echo $domain ?>/upgrade.php">
<input type="hidden" name="BAGGAGE_FIELDS" value="userid item">
<input type="hidden" name="userid" value="<?php echo $userid ?>">
<input type="hidden" name="item" value="<?php echo $sitename ?> - Membership Upgrade - <?php echo $userid ?>">
<!--<input type="hidden" name="V2_HASH" value="<?php echo $V2_HASH ?>">-->
<input type="image" name="PAYMENT_METHOD" value="PerfectMoney account" src="<?php echo $domain ?>/images/perfectmoney.gif" border="0">
</form>
<br>&nbsp;</td></tr>
<?php
} # if ($adminperfectmoney != "")

if ($adminokpay != "")
{
?>
<tr class="sabrinatrdark"><td colspan="2" align="center"><br><br>
After you've made your payment, please be sure to click the link on OKPay to return back to the website!<br><br>
<form  method="post" action="https://www.okpay.com/process.html">
<input type="hidden" name="ok_receiver" value="<?php echo $adminokpay ?>">
<input type="hidden" name="ok_item_1_name" value="<?php echo $sitename ?> - Membership Upgrade - <?php echo $userid ?>">
<input type="hidden" name="ok_currency" value="usd">
<input type="hidden" name="ok_item_1_type" value="service">
<input type="hidden" name="ok_item_1_price" value="<?php echo $joinprice ?>">
<input type="hidden" name="ok_item_1_custom_1_title" value="userid">
<input type="hidden" name="ok_item_1_custom_1_value" value="<?php echo $userid ?>">
<input type="hidden" name="ok_return_success" value="<?php echo $domain ?>/thankyou_upgrade.php">
<input type="hidden" name="ok_return_fail" value="<?php echo $domain ?>/upgrade.php">
<input type="hidden" name="ok_ipn" value="<?php echo $domain ?>/okpay_ipn.php">
<input type="image" name="submit" src="<?php echo $domain ?>/images/okpay.gif" border="0">
</form>
<br>&nbsp;</td></tr>
<?php
} # if ($adminokpay != "")

if ($adminsolidtrustpay != "")
		{
?>
<tr class="sabrinatrdark"><td colspan="2" align="center"><br><br>
After you've made your payment, please be sure to click the link on Solid Trust Pay to return back to the website!<br><br>
<form action="https://solidtrustpay.com/handle.php" method="post">
<input type="hidden" name="merchantAccount" value="<?php echo $adminsolidtrustpay ?>">
<input type="hidden" name="sci_name" value="your_sci_name">
<input type="hidden" name="amount" value="<?php echo $joinprice ?>">
<input type="hidden" name="currency" value="USD">
<input type="hidden" name="user1" value="<?php echo $userid ?>">
<input type="hidden" name="notify_url" value="<?php echo $domain ?>/solidtrustpay_ipn.php">
<input type="hidden" name="return_url" value="<?php echo $domain ?>/thankyou_upgrade.php">
<input type="hidden" name="cancel_url"  value="<?php echo $domain ?>/upgrade.php">
<input type="hidden" name="item_id" value="<?php echo $sitename ?> - Membership Upgrade - <?php echo $userid ?>">
<input type="image" name="cartImage" src="<?php echo $domain ?>/images/solidtrustpay.gif" alt="Solid Trust Pay" border="0">
</form>
<br>&nbsp;</td></tr>
<?php
	} # if ($adminsolidtrustpay != "")
?>
</table>
</td></tr>

</table>
<br><br>
<?php
include "footer.php";
exit;
?>