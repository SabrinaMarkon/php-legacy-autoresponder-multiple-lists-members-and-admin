<?php
include "control.php";
include "../header.php";
function formatDate($val) {
	$arr = explode("-", $val);
	return date("M d Y", mktime(0,0,0, $arr[1], $arr[2], $arr[0]));
}
$action = $_REQUEST["action"];
####################################################################
if ($action == "delete")
{
$deleteid = $_POST["deleteid"];
$deleteemail = $_POST["deleteemail"];
$deletefirstname = $_POST["deletefirstname"];
$deletelastname = $_POST["deletelastname"];
$q = "delete from autoresponders_prospects where id=\"$deleteid\"";
$r = mysql_query($q);
$q2 = "delete from autoresponder_userfields_data where prospectid=\"$deleteid\"";
$r2 = mysql_query($q2);
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">Prospect ID <?php echo $deleteid ?> with Email <?php echo $deleteemail ?> Was Deleted!</div></td></tr>
<tr><td align="center" colspan="2"><br><a href="autoresponder_bounce_viewer.php">BACK TO ADMIN BOUNCE VIEWER</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
} # if ($action == "delete")
####################################################################
if ($action == "save")
{
$saveid = $_POST["saveid"];
$saveemail = $_POST["saveemail"];
$savefirstname = $_POST["savefirstname"];
$savelastname = $_POST["savelastname"];
$saveverified = $_POST["saveverified"];
$saveverifiedip = $_POST["saveverifiedip"];
$savebounces = $_POST["savebounces"];
$savebouncelasterror = $_POST["savebouncelasterror"];
$savebouncelasterror = addslashes($savebouncelasterror);
$savevacation = $_POST["savevacation"];
$saveunsubscribed = $_POST["saveunsubscribed"];
	if(!$saveemail)
	{
	$error .= "<li>Please return and enter the email address of the prospect.</li>";
	}
	if(!$error == "")
	{
	?>
	<!-- PAGE CONTENT //-->
	<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
	<tr><td align="center" colspan="2"><br><div style="font-size: 18px; font-weight: bold; color: #ff0000;">ERROR</div></td></tr>
	<tr><td colspan="2"><br>Please return to the form and correct the following problems:<br>
	<ul><?php echo $error ?></ul>
	</td></tr>
	<tr><td align="center" colspan="2"><br>
	<input type="button" value="Return To Form" onclick="javascript:history.back();" class="sendit">
	</td></tr>
	</table>
	<!-- END PAGE CONTENT //-->
	<?php
	include "../footer.php";
	exit;
	}
$q = "update autoresponders_prospects set email=\"$saveemail\",bounces=\"$savebounces\",bouncelasterror=\"$savebouncelasterror\",vacation=\"$savevacation\",unsubscribed=\"$saveunsubscribed\" where id=\"$saveid\"";
$r = mysql_query($q);
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">Prospect ID <?php echo $saveid ?> With Email <?php echo $saveemail ?> Was Saved</div></td></tr>
<tr><td align="center" colspan="2"><br><a href="autoresponder_bounce_viewer.php">BACK TO ADMIN BOUNCE VIEWER</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
} # if ($action == "save")
####################################################################
?>
<!-- PAGE CONTENT //-->
<tr><td align="center" colspan="2"><br><div class="heading">AUTORESPONDER BOUNCES</div></td></tr>

<tr><td align="center" colspan="2">
<style type="text/css">
<!--
div.pagination {
	padding: 3px;
	margin: 3px;
}
div.pagination a {
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #eeeeee;
	text-decoration: none;
	color: #000099;
}
div.pagination a:hover, div.pagination a:active {
	border: 1px solid #808080;
	color: #000;
}
div.pagination span.current {
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #808080;	
	font-weight: bold;
	background-color: #808080;
	color: #FFF;
	}
div.pagination span.disabled {
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #EEE;
	color: #DDD;
	}
-->
</style>
<?php
$q = "select * from autoresponders_prospects where bounces>0 order by bounces desc,bouncelastdate desc";
$r = mysql_query($q);
$rows = mysql_num_rows($r);
if ($rows < 1)
{
echo "None of the prospects' email addresses have bounced in response to AutoResponder messages yet.";
}
if ($rows > 0)
{
################################################################
$pagesize = 50;

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
	$pagetext = "<center><br>Total Prospects with Bouncing Email Addresses: " . $rows . "<br>";

	if($rows > $pagesize){ // show the page bar
		$pagecount = ceil($rows/$pagesize);
		$pagetext .= "<div class='pagination'> ";
		if($page>1){ //show previoust link
			if ($searchfor == "")
			{
			$pagetext .= "<a href='?p=".($page-1)."' title='previous page'>previous</a>";
			}
			if ($searchfor != "")
			{
			$pagetext .= "<a href='?p=".($page-1)."' title='previous page'>previous</a>";
			}
		}
		for($i=1;$i<=$pagecount;$i++){
			if($page == $i){
				$pagetext .= "<span class='current'>".$i."</span>";
			}else{
				if ($searchfor == "")
				{
				$pagetext .= "<a href='?p=".$i."'>".$i."</a>";
				}
				if ($searchfor != "")
				{
				$pagetext .= "<a href='?p=".$i."'>".$i."</a>";
				}
			}
		}
		if($page<$pagecount){ //show previoust link
			if ($searchfor == "")
			{
			$pagetext .= "<a href='?p=".($page+1)."' title='next page'>next</a>";
			}
			if ($searchfor != "")
			{
			$pagetext .= "<a href='?p=".($page+1)."' title='next page'>next</a>";
			}
		}			
		$pagetext .= " </div><br>";
	}
################################################################
?>
<table cellpadding="2" cellspacing="2" border="0" align="center" class="sabrinatable">

<tr class="sabrinatrlight"><td colspan="15" align="center"><div style="width:800px;overflow:auto;" align="center"><?php echo $pagetext ?></div></td></tr>
<tr class="sabrinatrdark">
<td align="center"><a href="autoresponder_bounce_viewer.php">Sponsor</a></td>
<td align="center"><a href="autoresponder_bounce_viewer.php">Mailing&nbsp;List</a></td>
<td align="center"><a href="autoresponder_bounce_viewer.php">Email</a></td>
<td align="center"><a href="autoresponder_bounce_viewer.php">First&nbsp;Name</a></td>
<td align="center"><a href="autoresponder_bounce_viewer.php">Last&nbsp;Name</a></td>
<td align="center"><a href="autoresponder_bounce_viewer.php">Bounces</a></td>
<td align="center"><a href="autoresponder_bounce_viewer.php">Last Bounce</a></td>
<td align="center"><a href="autoresponder_bounce_viewer.php">Last Bounce Error</a></td>
<td align="center"><a href="autoresponder_bounce_viewer.php">Vacation (from bouncing)</a></td>
<td align="center"><a href="autoresponder_bounce_viewer.php">Vacation Date</a></td>
<td align="center"><a href="autoresponder_bounce_viewer.php">Unsubscribed</a></td>
<td align="center"><a href="autoresponder_bounce_viewer.php">Unsubscribe Date</a></td>
<td align="center">Save</td>
<td align="center">Contact</td>
<td align="center">Delete Completely</td>
</tr>

<?php
while ($rowz = mysql_fetch_array($resultexclude))
	{
$lid = $rowz["id"];
$luserid = $rowz["userid"];
$llistname = $rowz["listname"];
$lfirstname = $rowz["firstname"];
$llastname = $rowz["lastname"];
$lemail = $rowz["email"];
$lhowfound = $rowz["howfound"];
$lreferringpage = $rowz["referringpage"];
$lhowmanydays = $rowz["howmanydays"];
$lsignupdate = $rowz["signupdate"];
	if (($lsignupdate == 0) or ($lsignupdate == "0000-00-00 00:00:00") or ($lsignupdate == ""))
	{
	$showsignupdate = "Not Recorded";
	}
	else
	{
	$showsignupdate = formatDate($lsignupdate);
	}
$lsignupip = $rowz["signupip"];
$lverified = $rowz["verified"];
	if ($lverified == "yes")
	{
	$lverifiedbg = "#ff9999";
	}
	if ($lverified != "yes")
	{
	$lverifiedbg = "#99cc99";
	}
$lverifieddate = $rowz["verifieddate"];
	if (($lverifieddate == 0) or ($lverifieddate == "0000-00-00 00:00:00") or ($lverifieddate == ""))
	{
	$showverifieddate = "N/A";
	}
	else
	{
	$showverifieddate = formatDate($lverifieddate);
	}
$lverifiedip = $rowz["verifiedip"];
$lbounces = $rowz["bounces"];
$lbouncelastdate = $rowz["bouncelastdate"];
	if (($lbouncelastdate == 0) or ($lbouncelastdate == "0000-00-00 00:00:00") or ($lbouncelastdate == ""))
	{
	$showbouncelastdate = "N/A";
	}
	else
	{
	$showbouncelastdate = formatDate($lbouncelastdate);
	}
$lbouncelasterror = $rowz["bouncelasterror"];
$lbouncelasterror = stripslashes($lbouncelasterror);
$lbouncelasterror = str_replace('\\', '', $lbouncelasterror);
$lvacation = $rowz["vacation"];
	if ($lvacation == "yes")
	{
	$lvacationbg = "#ff9999";
	}
	if ($lvacation != "yes")
	{
	$lvacationbg = "#99cc99";
	}
$lvacationdate = $rowz["vacationdate"];
	if (($lvacationdate == 0) or ($lvacationdate == "0000-00-00 00:00:00") or ($lvacationdate == ""))
	{
	$showvacationdate = "N/A";
	}
	else
	{
	$showvacationdate = formatDate($lvacationdate);
	}
$lunsubscribed = $rowz["unsubscribed"];
	if ($lunsubscribed == "yes")
	{
	$lunsubscribedbg = "#ff9999";
	}
	if ($lunsubscribed != "yes")
	{
	$lunsubscribedbg = "#99cc99";
	}
$lunsubscribedate = $rowz["unsubscribedate"];
	if (($lunsubscribedate == 0) or ($lunsubscribedate == "0000-00-00 00:00:00") or ($lunsubscribedate == ""))
	{
	$showunsubscribedate = "N/A";
	}
	else
	{
	$showunsubscribedate = formatDate($lunsubscribedate);
	}
?>
<tr class="sabrinatrlight">
<form action="autoresponder_bounce_viewer.php" method="post">
<td align="center"><?php echo $luserid ?></td>
<td align="center"><?php echo $llistname ?></td>
<td align="center"><input type="text" name="saveemail" class="typein" size="15" maxlength="255" value="<?php echo $lemail ?>"></td>
<td align="center"><?php echo $lfirstname ?></td>
<td align="center"><?php echo $llastname ?></td>
<td align="center">
<select name="savebounces" class="pickone">
<?php
for($j=0;$j<=100;$j++)
{
?>
<option value="<?php echo $j ?>" <?php if ($j == $lbounces) { echo "selected"; } ?>><?php echo $j ?></option>
<?php
}
?>
</select>
</td>
<td align="center"><?php echo $showbouncelastdate ?></td>
<td align="center"><textarea name="savebouncelasterror" cols="15" rows="5"><?php echo $lbouncelasterror ?></textarea></td>
<td align="center" bgcolor="<?php echo $lvacationbg ?>">
<select name="savevacation" class="pickone">
<option value="yes" <?php if ($lvacation == "yes") { echo "selected"; } ?>>YES</option>
<option value="no" <?php if ($lvacation != "yes") { echo "selected"; } ?>>NO</option>
</select>
</td>
<td align="center"><?php echo $showvacationdate ?></td>
<td align="center" bgcolor="<?php echo $lunsubscribedbg ?>">
<select name="saveunsubscribed" class="pickone">
<option value="yes" <?php if ($lunsubscribed == "yes") { echo "selected"; } ?>>YES</option>
<option value="no" <?php if ($lunsubscribed != "yes") { echo "selected"; } ?>>NO</option>
</select>
</td>
<td align="center"><?php echo $showunsubscribedate ?></td>
<td align="center">
<input type="hidden" name="action" value="save">
<input type="hidden" name="saveid" value="<?php echo $lid ?>">
<input type="submit" value="SAVE">
</form>
</td>
<form method="post" action="mailto:<?php echo $lemail ?>">
<td align="center">
<input type="submit" value="EMAIL">
</form>
</td>
<form action="autoresponder_bounce_viewer.php" method="post">
<td align="center"><input type="hidden" name="action" value="delete">
<input type="hidden" name="deleteid" value="<?php echo $lid ?>">
<input type="hidden" name="deleteemail" value="<?php echo $lemail ?>">
<input type="hidden" name="deletefirstname" value="<?php echo $lfirstname ?>">
<input type="hidden" name="deletelastname" value="<?php echo $llastname ?>">
<input type="submit" value="DELETE">
</form>
</td>
</tr>
<tr class="sabrinatrdark"><td colspan="15"></td></tr>
<?php
	}
?>
</table>
<?php
}
?>
</td></tr>
<tr><td align="center" colspan="2"><br><a href="controlpanel.php">Return To Main Control Panel</a></td></tr>
</table>
<br><br>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
?>