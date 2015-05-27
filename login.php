<?php
include "db.php";
include "header.php";
$show = $_GET["show"];
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
<tr><td align="center" colspan="2"><div class="heading">Member Login</div></td></tr>
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
$q = "select * from pages where name='Login Page'";
$r = mysql_query($q);
$rowz = mysql_fetch_array($r);
$htmlcode = $rowz["htmlcode"];
echo $htmlcode;
?>
</div>
</td></tr>
</table>
</td></tr>

<form action="members.php" method="post" target="_top">
<tr><td align="center" colspan="2">
<table cellpadding="2" cellspacing="2" border="0" align="center" width="50%">
<tr><td align="right">UserID:</td><td><input type="text" name="loginusername" class="typein" maxlength="255" size="25" value="demomember"></td></tr><tr><td align="right">Password:</td><td><input type="password" name="loginpassword" class="typein" maxlength="255" size="25" value="demopass"></td></tr>
<?php
if ($turingkeyenable == "yes")
{
?>
<tr><td align="center" colspan="2"><br>
<img id="captcha" src="/securimage/securimage_show.php" alt="CAPTCHA Image" style="border:1px solid #000000;" /><br><br>
<table cellpadding="4" cellspacing="2" border="0" align="center" width="220">
<tr><td align="right">Enter Code:</td><td><input type="text" name="captcha_code" size="10" maxlength="6" /></td><td><a href="#" onclick="document.getElementById('captcha').src = '/securimage/securimage_show.php?' + Math.random(); return false"><img src="<?php echo $domain ?>/securimage/images/refresh.png" border="Refresh Image" width="20" height="20"></a></td><td style="padding-left:5px;padding-top:2px;">
<object type="application/x-shockwave-flash" data="/securimage/securimage_play.swf?audio_file=/securimage/securimage_play.php&amp;bgColor1=#fff&amp;bgColor2=#fff&amp;iconColor=#777&amp;borderWidth=1&amp;borderColor=#000" width="25" height="25">
<param name="wmode" value="transparent">
<param name="movie" value="/securimage/securimage_play.swf?audio_file=/securimage/securimage_play.php&amp;bgColor1=#fff&amp;bgColor2=#fff&amp;iconColor=#777&amp;borderWidth=1&amp;borderColor=#000" />
</object></td></tr>
</table>
</td></tr>
<?php
} # if ($turingkeyenable == "yes")
?>
</table>
</td></tr>
<tr><td colspan="2" align="center"><br><input type="hidden" name="newlogin" value="1"><input type="hidden" name="referid" value="<?php echo $referid ?>"><input type="submit" value="LOGIN" class="sendit"></td></tr></form><tr><td colspan="2" align="center"><a href="lostlogin.php?referid=<?php echo $referid ?>">LOST LOGIN</a></td></tr>
</table>
<br><br>
<?php
include "footer.php";
exit;
?>