<?php
### Copyright 2012 SABRINA MARKON PearlsOfWealth.com Sunshinehosting.net EGOPAY CALLBACK SYSTEM. Copying without license from Sabrina Markon (50.00 one time per cpanel account fully installed)
### is prohibited.
### Theft of my work will result in your host and their data center warehouse receiving a DHMC takedown notice for any content and/or a careless remote removal of stolen material (I do not need cpanel
### access to messily delete and hack my own work someone has stolen, obviously)
include "db.php";
require('EgoPaySci.php');

$oEgopay = new EgoPaySciCallback(array(
	'store_id'          => $store_id,
	'store_password'    => $store_password
));

$aResponse = $oEgopay->getResponse($_POST);  

$sId = $aResponse["sId"];
$sDate = $aResponse["sDate"];
$fAmount = $aResponse["fAmount"];
$sCurrency = $aResponse["sCurrency"];
$fFee = $aResponse["fFee"];
$sType = $aResponse["sType"];
$iTypeId = $aResponse["iTypeId"];
$sEmail = $aResponse["sEmail"];
$sDetails = $aResponse["sDetails"];
$sStatus = $aResponse["sStatus"];
$cf_1 = $aResponse["cf_1"];
$cf_2 = $aResponse["cf_2"];
$cf_3 = $aResponse["cf_3"];
$cf_4 = $aResponse["cf_4"];

	if (($sStatus == "Completed") or ($sStatus == "TEST SUCCESS"))
	{
	$userid = $cf_1;
	$item = $cf_2;
	$amount = $fAmount;
	$txn_id = $sId;

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
			$paychoice = "EgoPay";
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



		}

	} # if (($sStatus == "Completed") or ($sStatus == "TEST SUCCESS"))
?>
          