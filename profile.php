<?php
include "control.php";
require('EgoPaySci.php');
include "header.php";
function formatDate($val) {
	$arr = explode("-", $val);
	return date("M d Y", mktime(0,0,0, $arr[1], $arr[2], $arr[0]));
}
$today = date('Y-m-d',strtotime("now"));
$unixtimestamp = time();
$action = $_POST["action"];
$show = "";
if ($action == "update")
{
$password = $_POST["password"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$email = $_POST["email"];
$oldemail = $_POST["oldemail"];
$country = $_POST["country"];
$egopay = $_POST["egopay"];
$payza = $_POST["payza"];
$perfectmoney = $_POST["perfectmoney"];
$okpay = $_POST["okpay"];
$solidtrustpay = $_POST["solidtrustpay"];
$paypal = $_POST["paypal"];
	if (!$password)
	{
	$error .= "<div>Please return and enter a valid password.</div>";
	}
	if(!$firstname)
	{
	$error .= "<div>Please return and enter your first name.</div>";
	}
	if(!$lastname)
	{
	$error .= "<div>Please return and type in your last name.</div>";
	}
	if(!$email)
	{
	$error .= "<div>Please return and enter your email address.</div>";
	}
	
	if(!$error == "")
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
	<tr><td align="center" colspan="2"><div class="heading">Update Error</div></td></tr>
	<tr><td colspan="2" align="center"><br><?php echo $error ?></td></tr>
	<tr><td colspan="2" align="center"><br><a href="profile.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "footer.php";
	exit;
	}

$q = "update members set password=\"$password\",firstname=\"$firstname\",lastname=\"$lastname\",email=\"$email\",country=\"$country\",egopay=\"$egopay\",payza=\"$payza\",perfectmoney=\"$perfectmoney\",okpay=\"$okpay\",solidtrustpay=\"$solidtrustpay\",paypal=\"$paypal\" where userid=\"$userid\"";
$r = mysql_query($q);
$_SESSION["loginusername"] = $password;

$show = "Your profile was updated!";

if ($oldemail != $email)
	{
	$verifyq = "update member set verified=\"no\",verifieddate=\"0\",verifycode=\"$unixtimestamp\" where userid=\"$userid\"";
	$verifyr = mysql_query($verifyq);
	$tomember = $email;
	$headersmember = "From: $sitename<$bounceemail>\n";
	$headersmember .= "Reply-To: <$bounceemail>\n";
	$headersmember .= "X-Sender: <$bounceemail>\n";
	$headersmember .= "X-Mailer: PHP5 - PHPSiteScripts\n";
	$headersmember .= "X-Priority: 3\n";
	$headersmember .= "Return-Path: <$bounceemail>\n";
	$subjectmember = $sitename . " Email Address Re-Verification";
	$messagemember = "Please re-verify your email address by clicking this link ".$domain."/verify.php?userid=".$userid."&code=".$unixtimestamp."\n\n"
	."Thank you!\n\n\n"
	.$sitename." Admin\n"
	.$adminemail."\n\n\n\n";
	@mail($tomember, $subjectmember, wordwrap(stripslashes($messagemember)),$headersmember, "-f$bounceemail");
	$show .= "<br>You changed your email address and need to re-verify it to be able to use the website. A verification email has been sent to your new email address.";
	}
} # if ($action == "update")
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
<tr><td align="center" colspan="2"><div class="heading">Your Account Profile</div></td></tr>
<?php
if ($show != "")
{
?>
<tr><td align="center" colspan="2"><br><?php echo $show ?></td></tr>
<?php
}
?>
<tr><td align="center" colspan="2">
<table cellpadding="2" cellspacing="2" border="0" align="center" width="100%">
<tr><td>
<div style="text-align: center;">
<?php
$q = "select * from pages where name='Members Area Profile Page'";
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
<table cellpadding="2" cellspacing="2" border="0" align="center" width="100%" class="sabrinatable">
<tr class="sabrinatrlight"><td align="right">UserID:</td><td><?php echo $userid ?></td></tr>
<tr class="sabrinatrlight"><td align="right" valign="top">Membership Level:</td><td><?php echo $accounttypename ?>
<?php
if ($accounttype != "PAID")
{
?>
<br><a href="upgrade.php">Click Here to Enjoy the Benefits of Upgraded Membership!</a>
<?php
}
?>
</td></tr>
<?php
if (($accounttype == "PAID") and ($joinpriceinterval != "One Time"))
{
if (($membershipnextpaid < $today) or ($membershipnextpaid ==""))
	{
	?>
	<tr class="sabrinatrlight"><td align="right">Next Membership Payment ($<?php echo $joinprice ?>) Due:</td><td><?php echo $membershipnextpaid ?> <font color="#ff0000" style="background:#ffff00;">OVERDUE:</font> Renew Membership Now for: $<?php echo sprintf("%.2f", $joinprice); ?> <?php echo $joinpriceinterval ?>
	</td></tr>
	<tr class="sabrinatrlight"><td align="center" colspan="2">
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
		'fail_url'	=> $domain. '/profile.php',
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
	<input type="hidden" name="cancel" value="<?php echo $domain ?>/profile.php">
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
	<input type="hidden" name="ap_cancelurl" value="<?php echo $domain ?>/profile.php">
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
	<input type="hidden" name="NOPAYMENT_URL" value="<?php echo $domain ?>/profile.php">
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
	<input type="hidden" name="ok_return_fail" value="<?php echo $domain ?>/profile.php">
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
	<input type="hidden" name="cancel_url"  value="<?php echo $domain ?>/profile.php">
	<input type="hidden" name="item_id" value="<?php echo $sitename ?> - Membership Renewal - <?php echo $userid ?>">
	<input type="image" name="cartImage" src="<?php echo $domain ?>/images/solidtrustpaysm.gif" alt="Solid Trust Pay" border="0" height="50">
	</form>
	</td></tr>
	<?php
		} # if ($adminsolidtrustpay != "")
	?>
	</table>
	</td></tr>
	<?php
	} # if (($membershipnextpaid < $today) or ($membershipnextpaid ==""))
else
	{
	?>
	<tr class="sabrinatrlight"><td align="right">Next Membership Payment ($<?php echo $joinprice ?> <?php echo $joinpriceinterval ?>) Due:</td><td><?php echo $membershipnextpaid ?></td></tr>
	<?php
	}
}
?>
<tr class="sabrinatrlight"><td align="right">Your Commission Balance:</td><td>$<?php echo $commission ?></td></tr>
<?php
if ($enablecreditssystem == "yes")
{
?>
<tr class="sabrinatrlight"><td align="right">Your Credit Balance:</td><td><?php echo $credits ?></td></tr>
<?php
}
?>
<form action="profile.php" method="post" target="_top">
<tr class="sabrinatrlight"><td align="right">Password:</td><td><input type="text" name="password" class="typein" maxlength="255" size="55" value="<?php echo $password ?>"></td></tr>
<tr class="sabrinatrlight"><td align="right">First Name:</td><td><input type="text" name="firstname" class="typein" maxlength="255" size="55" value="<?php echo $firstname ?>"></td></tr>
<tr class="sabrinatrlight"><td align="right">Last Name:</td><td><input type="text" name="lastname" class="typein" maxlength="255" size="55" value="<?php echo $lastname ?>"></td></tr>
<tr class="sabrinatrlight"><td align="right">Email:</td><td><input type="text" name="email" class="typein" maxlength="255" size="55" value="<?php echo $email ?>"></td></tr>
<?php
$cq = "select * from countries order by country_id";
$cr = mysql_query($cq);
$crows = mysql_num_rows($cr);
if ($crows > 0)
{
?>
<tr class="sabrinatrlight"><td align="right">Country:</td><td><select name="country" style="width: 140px;" class="pickone">
<?php
	while ($crowz = mysql_fetch_array($cr))
	{
	$country_name = $crowz["country_name"];
?>
<option value="<?php echo $country_name ?>" <?php if ($country == $country_name) { echo "selected"; } ?>><?php echo $country_name ?></option>
<?php
	}
?>
</select>
<?php
}
?>
</td></tr>
<tr class="sabrinatrlight"><td align="right">EgoPay:</td><td><input type="text" name="egopay" class="typein" maxlength="255" size="55" value="<?php echo $egopay ?>"></td></tr>
<tr class="sabrinatrlight"><td align="right">Payza:</td><td><input type="text" name="payza" class="typein" maxlength="255" size="55" value="<?php echo $payza ?>"></td></tr>
<tr class="sabrinatrlight"><td align="right">Perfect Money:</td><td><input type="text" name="perfectmoney" class="typein" maxlength="255" size="55" value="<?php echo $perfectmoney ?>"></td></tr>
<tr class="sabrinatrlight"><td align="right">OK Pay:</td><td><input type="text" name="okpay" class="typein" maxlength="255" size="55" value="<?php echo $okpay ?>"></td></tr>
<tr class="sabrinatrlight"><td align="right">Solid Trust Pay:</td><td><input type="text" name="solidtrustpay" class="typein" maxlength="255" size="55" value="<?php echo $solidtrustpay ?>"></td></tr>
<tr class="sabrinatrlight"><td align="right">PayPal:</td><td><input type="text" name="paypal" class="typein" maxlength="255" size="55" value="<?php echo $paypal ?>"></td></tr>
<tr class="sabrinatrdark"><td colspan="2" align="center">
<input type="hidden" name="oldemail" value="<?php echo $email ?>">
<input type="hidden" name="action" value="update">
<input type="submit" value="SAVE" class="sendit">
</td></tr></form>

</table>
</td></tr>

</table>
<br><br>
<?php
include "footer.php";
exit;
?>