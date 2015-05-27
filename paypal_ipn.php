<?php
include "db.php";
### Copyright 2013 SABRINA MARKON PearlsOfWealth.com Sunshinehosting.net sabrina@sunshinehosting.net UPDATED PAYPAL CALLBACK SYSTEM. Copying without license from Sabrina Markon (50.00 one time per cpanel website fully installed)
### is prohibited.
### Theft of my work will result in your host and their data center warehouse receiving a DHMC takedown notice for any content and/or a careless remote removal of stolen material (I do not need cpanel
### access to messily delete and hack my own work someone has stolen, obviously)

// STEP 1: Read POST data

// reading posted data from directly from $_POST causes serialization 
// issues with array data in POST
// reading raw POST data from input stream instead. 
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
  $keyval = explode ('=', $keyval);
  if (count($keyval) == 2)
     $myPost[$keyval[0]] = urldecode($keyval[1]);
}
// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) {
   $get_magic_quotes_exists = true;
} 
foreach ($myPost as $key => $value) {        
   if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
        $value = urlencode(stripslashes($value)); 
   } else {
        $value = urlencode($value);
   }
   $req .= "&$key=$value";
}

// STEP 2: Post IPN data back to paypal to validate
 
$ch = curl_init('https://www.paypal.com/cgi-bin/webscr');
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
// In wamp like environments that do not come bundled with root authority certificates,
// please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path 
// of the certificate as shown below.
// curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');

if( !($res = curl_exec($ch)) ) {
    error_log("Got " . curl_error($ch) . " when processing IPN data");
    curl_close($ch);
    exit;
}
curl_close($ch);

// STEP 3: Inspect IPN validation result and act accordingly
 
if (strcmp ($res, "VERIFIED") == 0) {
echo "VERIFIED";

$payment_status = $_POST['payment_status'];
$amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$paypal = $_POST['payer_email'];
$quantity = $_POST['quantity'];
$userid = $_POST['option_selection1'];
$item = $_POST['item_name'];

if ($payment_status == "Completed")
{
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
$paychoice = "Paypal";
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
} # if ($payment_status == "Completed")

} else if (strcmp ($res, "INVALID") == 0) {
echo "INVALID";
}
?>