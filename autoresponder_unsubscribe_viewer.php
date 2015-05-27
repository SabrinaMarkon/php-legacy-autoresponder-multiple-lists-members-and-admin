<?php
include "control.php";
include "header.php";
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
<tr><td align="center" colspan="2"><br><a href="autoresponder_unsubscribe_viewer.php">BACK TO UNSUBSCRIBED PROSPECTS VIEWER</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "footer.php";
exit;
} # if ($action == "delete")
####################################################################
if ($action == "deleteall")
{
$deleteallq = "delete from autoresponders_prospects where userid=\"$userid\" and unsubscribed=\"yes\"";
$deleteallr = mysql_query($deleteallq);
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">Your Mailing Lists Were All Cleaned!</div></td></tr>
<tr><td align="center" colspan="2"><br>ALL Unsubscribed Prospects have been deleted from all of your AutoResponder Mailing Lists.</td></tr>
<tr><td align="center" colspan="2"><br><a href="autoresponder_unsubscribe_viewer.php">BACK TO UNSUBSCRIBED PROSPECTS VIEWER</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "footer.php";
exit;
} # if ($action == "deleteall")
####################################################################
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">AUTORESPONDER UNSUBSCRIBED PROSPECTS</div></td></tr>

<tr><td align="center" colspan="2">
<?php
include "autoresponder_menu.php";
?>
</td></tr>

<tr><td align="center" colspan="2">
<table cellpadding="2" cellspacing="2" border="0" align="center" width="100%">
<tr><td>
<div style="text-align: center;">
<?php
$q = "select * from pages where name='Members Area - Autoresponder Unsubscribed Propects Page'";
$r = mysql_query($q);
$rowz = mysql_fetch_array($r);
$htmlcode = $rowz["htmlcode"];
echo $htmlcode;
?>
</div>
</td></tr>
</table>
</td></tr>

<tr><td align="center" colspan="2"><br>
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
$q = "select * from autoresponders_prospects where userid=\"$userid\" and unsubscribed=\"yes\" order by email,listname desc";
$r = mysql_query($q);
$rows = mysql_num_rows($r);
if ($rows < 1)
{
echo "None of your prospects have unsubscribed from the AutoResponder lists.";
}
if ($rows > 0)
{
?>
<table cellpadding="2" cellspacing="2" border="0" align="center">
<form action="autoresponder_unsubscribe_viewer.php" method="post">
<tr><td align="center"><input type="hidden" name="action" value="deleteall"><input type="submit" value="CLEAN YOUR MAILING LISTS - Delete ALL Unsubscribed Prospects">
</form></td></tr>
</table>
<br><br>
<?php
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
	$pagetext = "<center><br>Total Unsubscribed Prospects: " . $rows . "<br>";

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

<tr class="sabrinatrlight"><td colspan="5" align="center"><div style="width:800px;overflow:auto;" align="center"><?php echo $pagetext ?></div></td></tr>
<tr class="sabrinatrdark">
<td align="center">Email</td>
<td align="center">Name</td>
<td align="center">Mailing&nbsp;List</td>
<td align="center">Unsubscribe Date</td>
<td align="center">Delete Completely</td>
</tr>

<?php
while ($rowz = mysql_fetch_array($resultexclude))
	{
$lid = $rowz["id"];
$llistname = $rowz["listname"];
$lfirstname = $rowz["firstname"];
$llastname = $rowz["lastname"];
$lfullname = $lfirstname . " " . $llastname;
$lemail = $rowz["email"];
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
<td align="center"><?php echo $lemail ?></td>
<td align="center"><?php echo $lfullname ?></td>
<td align="center"><?php echo $llistname ?></td>
<td align="center"><?php echo $showunsubscribedate ?></td>
<form action="autoresponder_unsubscribe_viewer.php" method="post">
<td align="center"><input type="hidden" name="action" value="delete">
<input type="hidden" name="deleteid" value="<?php echo $lid ?>">
<input type="hidden" name="deleteemail" value="<?php echo $lemail ?>">
<input type="hidden" name="deletefirstname" value="<?php echo $lfirstname ?>">
<input type="hidden" name="deletelastname" value="<?php echo $llastname ?>">
<input type="submit" value="DELETE">
</form>
</td>
</tr>
<tr class="sabrinatrdark"><td colspan="5"></td></tr>
<?php
	}
?>
</table>
<?php
}
?>
</td></tr>
</table>
<br><br>
<!-- END PAGE CONTENT //-->
<?php
include "footer.php";
exit;
?>