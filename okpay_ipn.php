<?php
### Copyright 2012 SABRINA MARKON PearlsOfWealth.com Sunshinehosting.net OKPAY CALLBACK SYSTEM. Copying without license from Sabrina Markon (50.00 one time per cpanel account fully installed)
### is prohibited.
### Theft of my work will result in your host and their data center warehouse receiving a DHMC takedown notice for any content and/or a careless remote removal of stolen material (I do not need cpanel
### access to messily delete and hack my own work someone has stolen, obviously)
#######################
# HOW TO SET UP OKPAY IPN #
/*

    Log in and click on Profile under My Account.
    Click the Wallets and Currencies link under Account preferences.
    Choose a wallet for which you want to set up IPN and click Properties.
    In Wallet Properties click on the Integration tab.
    Click Enable IPN to receive notification messages in your listener.
    Specify your listener’s URL in the Payment Notification (IPN) URL field and click Save to activate it.

*/

error_reporting(E_ALL ^ E_NOTICE);
include "db.php";

	$email = $adminemail;
	$header = ""; 
	$emailtext = "OKPAY IPN EMAIL";

	// Read the post from OKPAY and add 'ok_verify' 
	$request = 'ok_verify=true'; 

	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$request .= "&$key=$value";
	}
	
	// Connection methods
	$fsocket = false;
	$curl = false;
	$result = false;
	
	// Try to connect via SSL due sucurity reason
	if ( (PHP_VERSION >= 4.3) && ($fp = @fsockopen('ssl://www.okpay.com', 443, $errno, $errstr, 30)) ) {
		$fsocket = true;
	} elseif (function_exists('curl_exec')) {
		$curl = true;
	} elseif ($fp = @fsockopen('www.okpay.com', 80, $errno, $errstr, 30)) {
		$fsocket = true;
	}
	
	if ($fsocket == true) {
		$header = 'POST /ipn-verify.html HTTP/1.0' . "\r\n" .
				  'Host: www.okpay.com\r\n' .
				  'Content-Type: application/x-www-form-urlencoded' . "\r\n" .
				  'Content-Length: ' . strlen($request) . "\r\n" .
				  'Connection: close' . "\r\n\r\n";
		
		@fputs($fp, $header . $request);
		$string = '';
		while (!@feof($fp)) {
			$res = @fgets($fp, 1024);
			$string .= $res;
			
			if ( ($res == 'VERIFIED') || ($res == 'INVALID') ) {
				$result = $res;
				break;
			}
		}
		@fclose($fp);
	} elseif ($curl == true) {
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, 'https://www.okpay.com/ipn-verify.html');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$result = curl_exec($ch);
		
		curl_close($ch);
	}
	
	if ($result == 'VERIFIED') {
		// If 'VERIFIED', send an email of IPN variables and values to the 
		// specified email address 
		//foreach ($_POST as $key => $value)
		//	{ 
			//$emailtext .= $key . " = " .$value ."\n\n";
		    //$$key = $value;
		//	}
		//mail($email, "Live-VERIFIED IPN", $emailtext . "\n\n" . $request . "\n\n" . $res);

//extract($_POST); // extracts all post variables

$payment_status = $_POST['ok_txn_status'];
$amount = $_POST['ok_txn_gross'];
$txn_id = $_POST['ok_txn_id'];
$receiver_email = $_POST['ok_receiver_email'];
$payer_email = $_POST['ok_payer_email'];
$userid = $_POST['ok_item_1_custom_1_value'];
$item = $_POST['ok_item_1_name'];

$query = "select * from members where userid='".$userid."'";
$result = mysql_query ($query) or die (mysql_error());
$numrows = @ mysql_num_rows($result);
if ($numrows == 1) 
{	
$user = mysql_fetch_array($result);
$referid = $user["referid"];
$egopay = $user["egopay"];
$payza = $user["payza"];
$perfectmoney = $user["perfectmoney"];
$okpay = $user["okpay"];
$solidtrustpay = $user["solidtrustpay"];
$paypal = $user["paypal"];
$membershiplastpaid = $user["membershiplastpaid"];
$paychoice = "OKPay";
$transaction = $txn_id;
$today = date('Y-m-d',strtotime("now"));

			if($item == $sitename." - Membership Upgrade - ".$userid)
				{
					if ($joinpriceinterval == "Annually")
					{
					$nextdue = @date('Y-m-d', strtotime("+1 years", strtotime($today)));
					}
					elseif ($joinpriceinterval == "Monthly")
					{
					$nextdue = @date('Y-m-d', strtotime("+1 months", strtotime($today)));
					}
					else
					{
					$nextdue = "";
					}
					$eq = "update members set membershiplastpaid=\"$today\",membershipnextpaid=\"$nextdue\",accounttype=\"PAID\" where userid=\"$userid\"";
					$er = mysql_query($eq);
					# sponsor commission
					$refq = "select * from members where userid=\"$referid\"";
					$refr = mysql_query($refq);
					$refrows = mysql_num_rows($refr);
					if ($refrows > 0)
						{
						$refaccounttype = mysql_result($refr,0,"accounttype");
						if ($refaccounttype == "PAID")
							{
							$upgradecommission = $upgradecommissionfree;
							}
						if ($refaccounttype != "PAID")
							{
							$upgradecommission = $upgradecommissionpaid;
							}
						$commissionq = "update members set commission=commission+" . $upgradecommission . " where userid=\"$referid\"";
						$commissionr = mysql_query($commissionq);
						$refq3 = "insert into payouts (userid,paid,datepaid,description) values (\"$referid\",\"$upgradecommission\",NOW(),\"Sponsor Payment - Referral $userid Paid For Upgraded Membership\")";
						$refr3 = mysql_query($refq3);
						}
					mysql_query("INSERT INTO transactions (userid,transaction,description,paymentdate,amountreceived) VALUES ('".$userid."','".$transaction."','$paychoice Payment - Membership Upgrade - " . $level2name . "','".time()."','".$amount."')");
				} # if($item == $sitename." - Membership Upgrade - ".$userid)

			if($item == $sitename." - Membership Renewal - ".$userid)
				{
					if ($joinpriceinterval == "Annually")
					{
					$nextdue = @date('Y-m-d', strtotime("+1 years", strtotime($membershiplastpaid)));
					}
					elseif ($joinpriceinterval == "Monthly")
					{
					$nextdue = @date('Y-m-d', strtotime("+1 months", strtotime($membershiplastpaid)));
					}
					else
					{
					$nextdue = "";
					}
					$eq = "update members set membershiplastpaid=\"$today\",membershipnextpaid=\"$nextdue\",accounttype=\"PAID\" where userid=\"$userid\"";
					$er = mysql_query($eq);
					# sponsor commission
					$refq = "select * from members where userid=\"$referid\"";
					$refr = mysql_query($refq);
					$refrows = mysql_num_rows($refr);
					if ($refrows > 0)
						{
						$refaccounttype = mysql_result($refr,0,"accounttype");
						if ($refaccounttype == "PAID")
							{
							$upgradecommission = $upgradecommissionfree;
							}
						if ($refaccounttype != "PAID")
							{
							$upgradecommission = $upgradecommissionpaid;
							}
						$commissionq = "update members set commission=commission+" . $upgradecommission . " where userid=\"$referid\"";
						$commissionr = mysql_query($commissionq);
						$refq3 = "insert into payouts (userid,paid,datepaid,description) values (\"$referid\",\"$upgradecommission\",NOW(),\"Sponsor Payment - Referral $userid Paid For Upgraded Membership Renewal\")";
						$refr3 = mysql_query($refq3);
						}
					mysql_query("INSERT INTO transactions (userid,transaction,description,paymentdate,amountreceived) VALUES ('".$userid."','".$transaction."','$paychoice Payment - " . $level2name . " Membership Renewal',NOW(),'".$amount."')");
				} # if($item == $sitename." - Membership Renewal - ".$userid)



} # if ($numrows == 1) 
		
	} elseif($result == 'INVALID') {
		// If 'INVALID', send an email. TODO: Log for manual investigation. 
		//foreach ($_POST as $key => $value) { 
		//	$emailtext .= $key . " = " .$value ."\n\n"; 
		//}
		//mail($email, "Live-INVALID IPN", $emailtext . "\n\n" . $request . "\n\n" . $res);'
		exit;
		
	} elseif($result == 'TEST') {
		//mail($email, "TEST IPN", $emailtext . "\n\n" . $request . "\n\n" . $res);
	}
?>