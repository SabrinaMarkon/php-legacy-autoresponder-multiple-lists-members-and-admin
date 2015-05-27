<?php
include "control.php";
include "header.php";
?>
<script language="JavaScript" type="text/javascript">
var copytoclip=1
function HighlightAll(theField) {
var tempval=eval("document."+theField)
tempval.focus()
tempval.select()
if (document.all&&copytoclip==1){
therange=tempval.createTextRange()
therange.execCommand("Copy")
window.status="Contents highlighted and copied to clipboard!"
setTimeout("window.status=''",1800)
}
}
</script>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">
<tr><td align="center" colspan="2"><div class="heading">Promote</div></td></tr>

<tr><td align="center" colspan="2">
<table cellpadding="2" cellspacing="2" border="0" align="center" width="100%">
<tr><td>
<div style="text-align: center;">
<?php
$q = "select * from pages where name='Members Area Promotion Page'";
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
<table cellpadding="4" cellspacing="2" border="0" align="center" width="600" class="sabrinatable">
<tr class="sabrinatrlight"><td valign="top">Affiliate URL:</td><td><a href="<?php echo $domain ?>/index.php?referid=<?php echo $userid ?>" target="_blank"><?php echo $domain ?>/index.php?referid=<?php echo $userid ?></a></td></tr>

<tr class="sabrinatrlight"><td valign="top">Your Referrals:</td><td>
<?php
$rq = "select * from members where referid=\"$userid\" order by userid";
$rr = mysql_query($rq);
$rrows = mysql_num_rows($rr);
if ($rrows < 1)
{
?>
You don't have any referrals yet
<?php
}
if ($rrows > 0)
{
?>
<table cellpadding="2" cellspacing="2" border="0" align="center" width="100%" class="sabrinatable">
<tr class="sabrinatrdark"><td align="center">UserID</td><td align="center">Name</td><td align="center">Verified</td></tr>
<?php
	while ($rrowz = mysql_fetch_array($rr))
	{
	$ruserid = $rrowz["userid"];
	$rfirstname = $rrowz["firstname"];
	$rlastname = $rrowz["lastname"];
	$rfullname = $rfirstname . " " . $rlastname;
	$rverified = $rrowz["verified"];
	?>
	<tr class="sabrinatrlight"><td align="center"><?php echo $ruserid ?></td><td align="center"><?php echo $rfullname ?></td><td align="center"><?php echo $rverified ?></td></tr>
	<?php
	}
?>
</table>
<?php
}
?>
</td></tr>

<?php
$bq = "select * from adminpromotional where type=\"banner\" order by id desc";
$br = mysql_query($bq);
$brows = mysql_num_rows($br);
if ($brows > 0)
{
?>
<tr class="sabrinatrdark"><td align="center" colspan="2">BANNER ADS</td></tr>
<?php
while ($browz = mysql_fetch_array($br))
	{
	$bannerid = $browz["id"];
	$bannername = $browz["name"];
	$bannerpromotionalimage = $browz["promotionalimage"];
?>
<tr class="sabrinatrlight"><td valign="top"><br><?php echo $bannername ?></td><td align="center"><br><a href="<?php echo $domain ?>/index.php?referid=<?php echo $userid ?>" target="_blank"><img src="<?php echo $bannerpromotionalimage ?>" border="0"></a>
<br><br>Banner Code:<br><br>
<form name="banner<?php echo $bannerid ?>"><textarea rows="5" cols="60" name="bannercode"><a href="<?php echo $domain ?>/index.php?referid=<?php echo $userid ?>"><img src="<?php echo $bannerpromotionalimage ?>" border="0" alt="<?php echo $sitename ?>"></a></textarea><br><br><a href="javascript: HighlightAll('banner<?php echo $bannerid ?>.bannercode')">select all banner code</a></form>
</td></tr>
<?php
	}
}
$eq = "select * from adminpromotional where type=\"email\" order by id desc";
$er = mysql_query($eq);
$erows = mysql_num_rows($er);
if ($erows > 0)
{
?>
<tr class="sabrinatrdark"><td align="center" colspan="2">EMAIL AD COPY</td></tr>
<?php
while ($erowz = mysql_fetch_array($er))
	{
	$emailname = $erowz["name"];
	$emailpromotionalsubject = $erowz["promotionalsubject"];
	$emailpromotionalsubject = stripslashes($emailpromotionalsubject);
	$emailpromotionalsubject = str_replace('\\', '', $emailpromotionalsubject); 
	$emailpromotionaladbody = $erowz["promotionaladbody"];
	$emailpromotionaladbody = stripslashes($emailpromotionaladbody);
	$emailpromotionaladbody = str_replace('\\', '', $emailpromotionaladbody); 
?>
<tr class="sabrinatrlight"><td valign="top"><?php echo $emailname ?></td><td align="center"><center>
<div style="width: 600px; height: 20px; padding: 4px; overflow:auto; border-style: solid; border-size: 1px; border-color: #999999; background: #ffffff;"><?php echo $emailpromotionalsubject ?></div>
<div style="width: 600px; height: 200px; padding: 4px; overflow:auto; border-style: solid; border-size: 1px; border-color: #999999; background: #ffffff; border-top: 0px;"><?php echo $emailpromotionaladbody ?></div>
</center>
</td></tr>
<?php
	}
}
?>

</table>
</td></tr>

</table>
<br><br>
<?php
include "footer.php";
exit;
?>