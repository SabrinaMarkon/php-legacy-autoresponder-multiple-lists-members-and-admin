<?php
include "control.php";
include "../header.php";
$action = $_POST["action"];
$show = "";
if ($action == "savesettings")
{
$adminuserid = $_POST["adminuseridp"];
$adminpassword = $_POST["adminpasswordp"];
$adminmemberuserid = $_POST["adminmemberuseridp"];
$adminname = $_POST["adminnamep"];
$domain = $_POST["domainp"];
$sitename = $_POST["sitenamep"];
$adminemail = $_POST["adminemailp"];
$turingkeyenable = $_POST["turingkeyenablep"];
$level1name = $_POST["level1namep"];
$level2name = $_POST["level2namep"];
$egopay_store_id = $_POST["egopay_store_idp"];
$egopay_store_password = $_POST["egopay_store_passwordp"];
$adminpayza = $_POST["adminpayzap"];
$adminpayzaseccode = $_POST["adminpayzaseccodep"];
$adminperfectmoney = $_POST["adminperfectmoneyp"];
$adminokpay = $_POST["adminokpayp"];
$adminsolidtrustpay = $_POST["adminsolidtrustpayp"];
$adminpaypal = $_POST["adminpaypalp"];
$joinprice = $_POST["joinpricep"];
$joinpriceinterval = $_POST["joinpriceintervalp"];
$upgradecommissionfree = $_POST["upgradecommissionfreep"];
$upgradecommissionpaid = $_POST["upgradecommissionpaidp"];
$minimumpayout = $_POST["minimumpayoutp"];
$enableautodowngrade = $_POST["enableautodowngradep"];
$autodowngradeafterhowmanydayslatepay = $_POST["autodowngradeafterhowmanydayslatepayp"];

$update = mysql_query("update adminsettings set setting='$adminuserid' where name='adminuserid'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$adminpassword' where name='adminpassword'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$adminmemberuserid' where name='adminmemberuserid'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$adminname' where name='adminname'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$domain' where name='domain'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting=\"$sitename\" where name='sitename'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$adminemail' where name='adminemail'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$turingkeyenable' where name='turingkeyenable'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$level1name' where name='level1name'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$level2name' where name='level2name'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$egopay_store_id' where name='egopay_store_id'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$egopay_store_password' where name='egopay_store_password'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$adminpayza' where name='adminpayza'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$adminpayzaseccode' where name='adminpayzaseccode'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$adminperfectmoney' where name='adminperfectmoney'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$adminokpay' where name='adminokpay'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$adminsolidtrustpay' where name='adminsolidtrustpay'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$adminpaypal' where name='adminpaypal'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$joinprice' where name='joinprice'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$joinpriceinterval' where name='joinpriceinterval'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$upgradecommissionfree' where name='upgradecommissionfree'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$upgradecommissionpaid' where name='upgradecommissionpaid'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$minimumpayout' where name='minimumpayout'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$enableautodowngrade' where name='enableautodowngrade'") or die(mysql_error());
$update = mysql_query("update adminsettings set setting='$autodowngradeafterhowmanydayslatepay' where name='autodowngradeafterhowmanydayslatepay'") or die(mysql_error());

$_SESSION["loginusernameadmin"] = $adminuserid;
$_SESSION["loginpasswordadmin"] = $adminpassword;

$adminuserid = $adminuseridp;
$adminpassword = $adminpasswordp;

$show = "Your settings were updated!";
} # if ($action == "savesettings")
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
<tr><td align="center" colspan="2"><div class="heading">Website&nbsp;Settings</div></td></tr>

<?php
if ($show != "")
{
?>
<tr><td align="center" colspan="2"><br><?php echo $show ?></td></tr>
<?php
}
?>
<tr><td align="center" colspan="2"><br>
<form action="sitecontrol.php" method="post">
<table width="600" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrdark"><td colspan="2" align="center"><div class="heading">MAIN SETTINGS</div></td></tr>
<tr class="sabrinatrlight"><td>Admin Login ID:</td><td><input type="text" class="typein" name="adminuseridp" value="<?php echo $adminuserid ?>" class="typein" size="25" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td>Admin Login Password:</td><td><input type="text" class="typein" name="adminpasswordp" value="<?php echo $adminpassword ?>" class="typein" size="25" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td>Admin Site Member UserID:</td><td><input type="text" class="typein" name="adminmemberuseridp" value="<?php echo $adminmemberuserid ?>" class="typein" size="25" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td>Admin Name:</td><td><input type="text" class="typein" name="adminnamep" value="<?php echo $adminname ?>" class="typein" size="25" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td>Website Main Domain URL (with http:// and NO trailing slash):</td><td><input type="text" class="typein" name="domainp" value="<?php echo $domain ?>" class="typein" size="25" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td>Website Name:</td><td><input type="text" class="typein" name="sitenamep" value="<?php echo $sitename ?>" class="typein" size="25" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td>First Membership Level (free membership) Name:</td><td><input type="text" class="typein" name="level1namep" value="<?php echo $level1name ?>" class="typein" size="25" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td>Second Membership Level Name:</td><td><input type="text" class="typein" name="level2namep" value="<?php echo $level2name ?>" class="typein" size="25" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td>Admin Support Email:</td><td><input type="text" class="typein" name="adminemailp" value="<?php echo $adminemail ?>" class="typein" size="25" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td>Enable Captcha/Turing Key for Login and Signup Forms:</td><td>
<select name="turingkeyenablep">
<option value="no" <?php if ($turingkeyenable != "yes") { echo "selected"; } ?>>NO</option>
<option value="yes" <?php if ($turingkeyenable == "yes") { echo "selected"; } ?>>YES</option>
</select>
</td></tr>
<tr class="sabrinatrlight"><td>Admin EgoPay Store ID (leave blank if you don't want to sell using EgoPay):</td><td><input type="text" class="typein" name="egopay_store_idp" value="<?php echo $egopay_store_id ?>" class="typein" size="25" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td>Admin EgoPay Store Password (leave blank if you don't want to sell using EgoPay):</td><td><input type="text" class="typein" name="egopay_store_passwordp" value="<?php echo $egopay_store_password ?>" class="typein" size="25" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td>Admin Payza Account (leave blank if you don't want to sell using Payza):</td><td><input type="text" class="typein" name="adminpayzap" value="<?php echo $adminpayza ?>" class="typein" size="25" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td>Admin Payza IPN Security Code (leave blank if you don't want to sell using Payza):</td><td><input type="text" class="typein" name="adminpayzaseccodep" value="<?php echo $adminpayzaseccode ?>" class="typein" size="25" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td>Admin Perfect Money Account (leave blank if you don't want to sell using Perfect Money):</td><td><input type="text" class="typein" name="adminperfectmoneyp" value="<?php echo $adminperfectmoney ?>" class="typein" size="25" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td>Admin OKPay Account (leave blank if you don't want to sell using OKPay):</td><td><input type="text" class="typein" name="adminokpayp" value="<?php echo $adminokpay ?>" class="typein" size="25" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td>Admin Solid Trust Pay Account (leave blank if you don't want to sell using Solid Trust Pay):</td><td><input type="text" class="typein" name="adminsolidtrustpayp" value="<?php echo $adminsolidtrustpay ?>" class="typein" size="25" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td>Admin PayPal Account (leave blank if you don't want to sell using PayPal):</td><td><input type="text" class="typein" name="adminpaypalp" value="<?php echo $adminpaypal ?>" class="typein" size="25" maxlength="255"></td></tr>
<tr class="sabrinatrlight"><td>Price To Upgrade To <?php echo $level2name ?> Membership:</td><td><input type="text" class="typein" name="joinpricep" value="<?php echo $joinprice ?>" class="typein" size="6" maxlength="12"></td></tr>
<tr class="sabrinatrlight"><td>Bill How Often? (attempts to withdraw automatically from <?php echo $ewalletname ?> when due):</td><td>
<select name="joinpriceintervalp">
<option value="One Time" <?php if ($joinpriceinterval == "One Time") { echo "selected"; } ?>>One Time</option>
<option value="Monthly" <?php if ($joinpriceinterval == "Monthly") { echo "selected"; } ?>>Monthly</option>
<option value="Annually" <?php if ($joinpriceinterval == "Annually") { echo "selected"; } ?>>Annually</option>
</select>
</td></tr>
<tr class="sabrinatrlight"><td>Commission for <?php echo $level1name ?> Member Sponsors when a referral purchases a membership upgrade:</td><td><input type="text" class="typein" name="upgradecommissionfreep" value="<?php echo $upgradecommissionfree ?>" class="typein" size="6" maxlength="12"></td></tr>
<tr class="sabrinatrlight"><td>Commission for <?php echo $level2name ?> Member Sponsors when a referral purchases a membership upgrade:</td><td><input type="text" class="typein" name="upgradecommissionpaidp" value="<?php echo $upgradecommissionpaid ?>" class="typein" size="6" maxlength="12"></td></tr>
<tr class="sabrinatrlight"><td>Member Minimum Payout:</td><td><input type="text" class="typein" name="minimumpayoutp" value="<?php echo $minimumpayout ?>" class="typein" size="6" maxlength="12"></td></tr>
<tr class="sabrinatrlight"><td>Automatically Downgrade Overdue <?php echo $level2name ?> Member Accounts:</td><td><select name="enableautodowngradep"><option value="yes" <?php if ($enableautodowngrade == "yes") { echo "selected"; } ?>>YES</option><option value="no" <?php if ($enableautodowngrade != "yes") { echo "selected"; } ?>>NO</option></select></td></tr>
<tr class="sabrinatrlight"><td>How many days late with payment should a <?php echo $level2name ?> member be before being Automatically Downgraded to <?php echo $level1name ?>?</td><td>
<select name="autodowngradeafterhowmanydayslatepayp">
<?php
for ($z=1;$z<=100;$z++)
{
?>
<option value="<?php echo $z ?>" <?php if ($z == $autodowngradeafterhowmanydayslatepay) { echo "selected"; } ?>><?php echo $z ?></option>
<?php
}
?>
</select></td></tr>
<tr class="sabrinatrdark"><td colspan="2" align="center">
<input type="hidden" name="action" value="savesettings">
<input type="submit" name="submit" value="SAVE" class="sendit"></form>
</td></tr>
</table>

</td></tr>
</table>
<br><br>
<?php
include "../footer.php";
exit;
?>