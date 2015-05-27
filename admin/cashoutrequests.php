<?php
include "control.php";
include "../header.php";
function formatDate($val) {
	$arr = explode("-", $val);
	return date("M d Y", mktime(0,0,0, $arr[1], $arr[2], $arr[0]));
}
if ($_POST["action"] == "delete")
{
$id = $_POST["id"];
$q = "delete from cashoutrequests where id=\"$id\"";
$r = mysql_query($q);
$show = "<p align=\"center\">Request Deleted</p>";
}
#########################################################################################
if ($action == "markpaid")
{
$payid = $_POST["payid"];
$username = $_POST["username"];
$paycommission = $_POST["paycommission"];
$q = "update members set commission=commission-" . $paycommission . ",commisisonlastpaid=NOW() where userid=\"$username\"";
$r = mysql_query($q);
$q2 = "insert into payouts (userid,paid,datepaid,description) values (\"$username\",\"$paycommission\",NOW(),\"Cash Payout\")";
$r2 = mysql_query($q2);
$q3 = "update cashoutrequests set paid=\"$paycommission\",lastpaid=NOW() where id=\"$payid\"";
$r3 = mysql_query($q3);
$show = "<p align=\"center\">Username " . $username . " was marked paid out \$" . $paycommission . " by deducted it from their commission total. You should login to the payment company now to send them these funds if you haven't already done so.</p>";
} # if ($action == "markpaid")
####################################################################################################

$q = "select * from cashoutrequests where amountrequested>0.00 order by id desc";
$r = mysql_query($q);

################################################################
	$pagesize = 20;
	$page = (empty($_GET['p']) || !isset($_GET['p']) || !is_numeric($_GET['p'])) ? 1 : $_GET['p'];
	$s = ($page-1) * $pagesize;
	$queryexclude1 = $q ." LIMIT $s, $pagesize";
	$resultexclude=mysql_query($queryexclude1);
	$numrows = @mysql_num_rows($resultexclude);
	if($numrows == 0){
		$queryexclude1 = $q ." LIMIT $pagesize";
		$resultexclude=mysql_query($queryexclude1);
	}
	$count = 0;
	$pagetext = "<center><br>Total Members: <b>" . $rows . "</b><br><br>";

	if($rows > $pagesize){ // show the page bar
		$pagecount = ceil($rows/$pagesize);
		$pagetext .= "<div class='pagination'> ";
		if($page>1){ //show previoust link
			$pagetext .= "<a href='?p=".($page-1)."' title='previous page'>previous</a>";
		}
		for($i=1;$i<=$pagecount;$i++){
			if($page == $i){
				$pagetext .= "<span class='current'>".$i."</span>";
			}else{
				$pagetext .= "<a href='?p=".$i."'>".$i."</a>";
			}
		}
		if($page<$pagecount){ //show previoust link
			$pagetext .= "<a href='?p=".($page+1)."' title='next page'>next</a>";
		}			
		$pagetext .= " </div><br>";
	}
################################################################
?>
<table cellpadding="4" cellspacing="0" border="0" align="center" width="600">
<tr><td align="center" colspan="2"><div class="heading">Member Manual Cash Out Requests</div></td></tr>
<tr><td align="center" colspan="2" style="height: 15px;"></td></tr>
<?php
$numrows = @ mysql_num_rows($pnresult);
if ($numrows < 1)
{
?>
<tr><td align="center" colspan="2">No Manual Cash Out Requests Pending.</td></tr>
<?php
}
if ($show != "")
{
echo $show;
}
if ($numrows > 0)
{
?>
<tr><td align="center" colspan="2">
<table cellpadding="4" cellspacing="2" border="0" align="center" class="sabrinatable">
<tr class="sabrinatrlight"><td align="center" colspan="16"><div style="width:550px;overflow:auto;"><?php echo $pagetext ?></div></td></tr>
<tr class="sabrinatrdark">
<td align="center">Userid</td>
<td align="center">Preferred Payment Processor</td>
<td align="center">EgoPay</td>
<td align="center">Payza</td>
<td align="center">Perfect Money</td>
<td align="center">OKPay</td>
<td align="center">Solid Trust Pay</td>
<td align="center">PayPal</td>
<td align="center">Amount Requested</td>
<td align="center"><b>Commission Balance</b></td>
<td align="center">Date Requested</td>
<td align="center">Message</td>
<td align="center">Already Paid For This Request</td>
<td align="center">Date Paid For This Request</td>
<td align="center">Mark&nbsp;Paid</td>
<td align="center">Delete</td>
</tr>
<?php
while ($line = mysql_fetch_array($resultexclude)) 
{
$requestid = $line["id"];
$userid = $line["userid"];
$preferredpaymentprocessor = $line["preferredpaymentprocessor"];
$commissionq = "select * from members where userid=\"$userid\"";
$commissionr = mysql_query($commissionq);
$commissionrows = mysql_num_rows($commissionr);
if ($commissionrows > 0)
	{
	$commission = mysql_result($commissionr,0,"commission");
	}
$memberegopay = $line["egopay"];
$memberpayza = $line["payza"];
$memberperfectmoney = $line["perfectmoney"];
$memberokpay = $line["okpay"];
$membersolidtrustpay = $line["solidtrustpay"];
$memberpaypal = $line["paypal"];
$message = $line["message"];
$message = stripslashes($message);
$amountrequested = $line["amountrequested"];
$amountrequested = sprintf("%.2f", $amountrequested);
if ($amountrequested > 0)
{
$bgcolor=" bgcolor=\"#FFCCCC\"";
}
else
{
$bgcolor = "";
}
$daterequested = $line["daterequested"];
if (($daterequested == "") or ($daterequested == 0))
	{
$daterequested = "N/A";
	}
if (($daterequested != "") and ($daterequested != 0))
	{
$daterequested = formatDate($daterequested);
	}
$paid = $line["paid"];
$lastpaid = $line["lastpaid"];
if (($lastpaid == "") or ($lastpaid == 0))
	{
$lastpaid = "N/A";
	}
if (($lastpaid != "") and ($lastpaid != 0))
	{
$lastpaid = formatDate($lastpaid);
	}
?>
<tr class="sabrinatrlight">
<td align="center"><?php echo $userid ?></td>
<td align="center"><?php echo $preferredpaymentprocessor ?></td>
<td align="center"><?php echo $memberegopay ?></td>
<td align="center"><?php echo $memberpayza ?></td>
<td align="center"><?php echo $memberperfectmoney ?></td>
<td align="center"><?php echo $memberokpay ?></td>
<td align="center"><?php echo $membersolidtrustpay ?></td>
<td align="center"><?php echo $memberpaypal ?></td>
<td align="center"<?php echo $bgcolor ?>>$<?php echo $amountrequested ?></td>
<td align="center">$<?php echo $commission ?></td>
<td align="center"><?php echo $daterequested ?></td>
<td><?php echo $message ?></td>
<td align="center">$<?php echo $paid ?></td>
<td align="center"><?php echo $lastpaid ?></td>
<?php
if ($amountrequested > 0)
{
	if ($paid <= $amountrequested)
	{
	$showamountrequested = 0.00;
	$showamountrequested = sprintf("%.2f", $showamountrequested);
	}
	else
	{
	$showamountrequested = $amountrequested-$paid;
	$showamountrequested = sprintf("%.2f", $showamountrequested);
	}
?>
<form action="cashoutrequests.php" method="post">
<td align="center">
Set&nbsp;Amount&nbsp;As&nbsp;Paid:&nbsp;<input type="text" class="typein" size="6" maxlength="12" name="paycommission" value="<?php echo $showamountrequested ?>">&nbsp;&nbsp;<input type="hidden" name="username" value="<?php echo $userid ?>"><input type="hidden" name="payid" value="<?php echo $requestid ?>"><input type="hidden" name="action" value="markpaid"><input type="submit" class="sendit" value="SET PAID" style="width: 98%;">
</form>
</td>
<?php
} # if ($amountrequested > 0)
if ($amountrequested <= 0)
{
?>
<td align="center">No Money Owed</td>
<?php
}
?>
<form method="post" action="cashoutrequests.php">
<td align="center">
<input type="hidden" name="action" value="delete">
<input type="hidden" name="id" value="<? echo $requestid; ?>">
<input type="submit" value="DELETE" style="width: 98%;">
</form>
</td>
</tr>
<?
}
?>
<tr class="sabrinatrlight"><td align="center" colspan="16"><div style="width:550px;overflow:auto;"><?php echo $pagetext ?></div></td></tr>
</table>
</td></tr>
<?php
} # if ($numrows > 0)
?>
</table>
<?php
include "../footer.php";
?>