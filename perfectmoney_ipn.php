<?php
### Copyright 2012 SABRINA MARKON PearlsOfWealth.com Sunshinehosting.net PERFECT MONEY CALLBACK SYSTEM. Copying without license from Sabrina Markon (50.00 one time per cpanel account fully installed)
### is prohibited.
### Theft of my work will result in your host and their data center warehouse receiving a DHMC takedown notice for any content and/or a careless remote removal of stolen material (I do not need cpanel
### access to messily delete and hack my own work someone has stolen, obviously)
#######################
include "db.php";
/* Constant below contains md5-hashed alternate passhrase in upper case.
   You can generate it like this:
   strtoupper(md5('your_passphrase'));
   Where `your_passphrase' is Alternate Passphrase you entered
   in your PerfectMoney account.

   !!! WARNING !!!
   We strongly recommend NOT to include plain Alternate Passphrase in
   this script and use its pre-generated hashed version instead (just
   like we did in this scipt below).
   This is the best way to keep it secure. */
$alternate_phrase_hash = strtoupper(md5($adminperfectmoneyalternatepassphrase));
define('ALTERNATE_PHRASE_HASH', $alternate_phrase_hash);

// Path to directory to save logs. Make sure it has write permissions.
#define('PATH_TO_LOG',  '/somewhere/out/of/document_root/');

/*
$string=
      $_POST['PAYMENT_ID'].':'.$_POST['PAYEE_ACCOUNT'].':'.
      $_POST['PAYMENT_AMOUNT'].':'.$_POST['PAYMENT_UNITS'].':'.
      $_POST['PAYMENT_BATCH_NUM'].':'.
      $_POST['PAYER_ACCOUNT'].':'.ALTERNATE_PHRASE_HASH.':'.
      $_POST['TIMESTAMPGMT'];

$hash=strtoupper(md5($string));

if($hash==$_POST['V2_HASH'])
	{
	// proccessing payment if only hash is valid
*/
   /* In section below you must implement comparing of data you recieved
   with data you sent. This means to check if $_POST['PAYMENT_AMOUNT'] is
   particular amount you billed to client and so on. */

   if($_POST['PAYEE_ACCOUNT']==$adminperfectmoney && $_POST['PAYMENT_UNITS']=='USD' && ($_POST['PAYMENT_AMOUNT'] == $_POST['fundamountplusfee'])){

      /* ...insert some code to proccess valid payments here... */

$amount = $_POST['PAYMENT_AMOUNT'];
$txn_id = $_POST['PAYMENT_BATCH_NUM'];
$receiver_email = $_POST['PAYEE_ACCOUNT'];
$payer_email = $_POST['PAYER_ACCOUNT'];
$userid = $_POST['userid'];
$item = $_POST['item'];

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
$paychoice = "Perfect Money";
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

      // uncomment code below if you want to log successfull payments
      /* $f=fopen(PATH_TO_LOG."good.log", "ab+");
      fwrite($f, date("d.m.Y H:i")."; POST: ".serialize($_POST)."; STRING: $string; HASH: $hash\n");
      fclose($f); */

   }
   else
	{ // you can also save invalid payments for debug purposes

      // uncomment code below if you want to log requests with fake data
      /* $f=fopen(PATH_TO_LOG."bad.log", "ab+");
      fwrite($f, date("d.m.Y H:i")."; REASON: fake data; POST: ".serialize($_POST)."; STRING: $string; HASH: $hash\n");
      fclose($f); */

   }
#}
/*
else
{ // you can also save invalid payments for debug purposes

   // uncomment code below if you want to log requests with bad hash
   /* $f=fopen(PATH_TO_LOG."bad.log", "ab+");
   fwrite($f, date("d.m.Y H:i")."; REASON: bad hash; POST: ".serialize($_POST)."; STRING: $string; HASH: $hash\n");
   fclose($f); */

}
*/
?>