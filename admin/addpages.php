<?php
include "control.php";
include "../header.php";
$action = $_POST["action"];
$show = "";
if ($action == "edit")
{
$pageid = $_POST["pageid"];
$pagename = $_POST["pagename"];
$htmlcode = $_POST["htmlcode"];
$q = "update pagesdynamic set htmlcode='".$htmlcode."' where id=".$pageid;
$r = mysql_query($q);
$show = "The \"" . $pagename . "\" page was edited.";
} # if ($action == "edit")
####################################
if ($action == "deletepage")
{
$deletepageid = $_POST["deletepageid"];
$deletepagename = $_POST["deletepagename"];
$q = "delete from pagesdynamic where id=\"$deletepageid\"";
$r = mysql_query($q);
$show = "The \"" . $deletepagename . "\" page was deleted.";
} # if ($action == "deletepage")
####################################
if ($action == "newpage")
{
$newpagename = $_POST["newpagename"];
$newhtmlcode = $_POST["newhtmlcode"];
$newpagetag = $_POST["newpagetag"];
	if(!$newpagename)
	{
	$error .= "<li>Please return and enter a name for your page.</li>";
	}	
	if(!$newpagetag)
	{
	$error .= "<li>Please return and enter a tag for your page (shows in the url and should have no spaces or special characters).</li>";
	}
	$dupq = "select * from pagesdynamic where name=\"$newpagename\"";
	$dupr = mysql_query($dupq);
	$duprows = mysql_num_rows($dupr);
	if ($duprows > 0)
	{
	$error .= "<li>There is already a page in the system named " . $newpagename . ". Please return and try a different name for your page.</li>";
	}
	$dupq2 = "select * from pagesdynamic where tag=\"$newpagetag\"";
	$dupr2 = mysql_query($dupq2);
	$duprows2 = mysql_num_rows($dupr2);
	if ($duprows2 > 0)
	{
	$error .= "<li>There is already a page in the system with the tag " . $newpagetag . ". Please return and try a different tag name for your page.</li>";
	}
	if(!$error == "")
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="80%">
	<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
	<tr><td colspan="2" align="center"><br><?php echo $error ?></td></tr>
	<tr><td colspan="2" align="center"><br><a href="addpages.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
	}
####
$newpagetag = preg_replace("/[^A-Za-z0-9]/", "", $newpagetag);
$q = "insert into pagesdynamic (name,htmlcode,tag) values (\"$newpagename\",'".$newhtmlcode."',\"$newpagetag\")";
$r = mysql_query($q);
####
$show = "New Members Area \"" . $newpagename . "\" page was added.";
} # if ($action == "newpage")
?>
<script type="text/javascript">
function changeHiddenInput(objDropDown)
{
	var pagedata=objDropDown.value.split("||");
	var pageid=pagedata[0];
	if (pageid)
	{	
		var pagename=pagedata[1];
		var pagehtmlcode=pagedata[2];
		var pagetag=pagedata[3];
		var objpageid = document.getElementById("pageid");
		var objpagename = document.getElementById("pagename");
		var objshowlink = document.getElementById("showlink");
		objpageid.value = pageid;
		objpagename.value = pagename;
		objshowlink.innerHTML="<a href=<?php echo $domain ?>/dynamic.php?page="+pagetag+" target=_blank><?php echo $domain ?>/dynamic.php?page="+pagetag+"</a>";
		tinyMCE.execCommand('mceSetContent',false,pagehtmlcode);
	}
	else
	{
		var objpageid = document.getElementById("pageid");
		var objpagename = document.getElementById("pagename");
		var objshowlink = document.getElementById("showlink");
		objpageid.value = "";
		objpagename.value = "";
		objshowlink.innerHTML="";
		tinyMCE.execCommand('mceSetContent',false,'');
	}
}
</script> 
<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="../jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
theme : "advanced",
mode : "textareas",
//save_callback : "customSave",
content_css : "../jscripts/tiny_mce/advanced.css",
extended_valid_elements : "a[href|target|name],font[face|size|color|style],span[class|align|style]",
theme_advanced_toolbar_location : "top",
plugins : "table",
theme_advanced_buttons3_add_before : "tablecontrols,separator",
//invalid_elements : "a",
relative_urls : false,
theme_advanced_styles : "Header 1=header1;Header 2=header2;Header 3=header3;Table Row=tableRow1", // Theme specific setting CSS classes
debug : false,
verify_html : false
});
</script>
<!-- /tinyMCE --> 
<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
<?php
if ($show != "")
{
?>
<tr><td align="center" colspan="2"><br><?php echo $show ?></td></tr>
<?php
}
?>

<tr><td align="center" colspan="2"><br>
<form action="addpages.php" method="post">
<table width="600" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrlight"><td align="center" colspan="2"><div class="heading">Add Your Own Custom Pages</div></td></tr>
<tr class="sabrinatrdark"><td colspan="2">New pages are created with a URL like <?php echo $domain ?>/dynamic.php?page=TAG (where you enter what you want TAG to be in the form below)</td></tr>
<tr class="sabrinatrlight"><td>Page Name:</td><td><input type="text" name="newpagename" size="40" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td>Tag (no spaces or special characters!):</td><td><input type="text" name="newpagetag" size="40" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td align="center" colspan="2"><textarea name="newhtmlcode" id="newhtmlcode" rows="20" cols="70"></textarea></td></tr>
<tr class="sabrinatrdark"><td align="center" colspan="2">
<input type="hidden" name="action" value="newpage">
<input type="submit" name="ADD" class="sendit"></form>
</td></tr>
</table></td></tr>

<tr><td align="center" colspan="2"><br>&nbsp;</td></tr>

<?php
$query = "select * from pagesdynamic order by name";
$result = mysql_query($query);
$rows = mysql_num_rows($result);
if ($rows > 0)
{
?>
<tr><td align="center" colspan="2">
<form action="addpages.php" method="post">
<table width="600" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrlight"><td align="center"><div class="heading">Edit&nbsp;Page&nbsp;HTML</div></td></tr>
<tr class="sabrinatrlight"><td align="center">
<select name="pagenamechoice" id="pagenamechoice" onchange="changeHiddenInput(this)" style="width:600px;">
<option value=""> - Select Page To Edit - </option>
<?php
while ($rowz = mysql_fetch_array($result))
	{
	$pageid = $rowz["id"];
	$pagename = $rowz["name"];
	$pagetag = $rowz["tag"];
	$pagehtmlcode = $rowz["htmlcode"];
	$pagehtmlcode = stripslashes($pagehtmlcode);
	$pagehtmlcode = str_replace('\\', '', $pagehtmlcode);
	$pagehtmlcode = htmlentities($pagehtmlcode, ENT_COMPAT, "ISO-8859-1");
?>
<option value="<?php echo $pageid ?>||<?php echo $pagename ?>||<?php echo $pagehtmlcode ?>||<?php echo $pagetag ?>"><?php echo $pagename ?> - URL: <?php echo $domain ?>/dynamic.php?page=<?php echo $pagetag ?></option>
<?php
	}
?>
</select></form></td></tr>
<tr class="sabrinatrlight"><td align="center"><div id="showlink" name="showlink" style="width:600px;font-size:12px;"></div></td></tr>
<tr class="sabrinatrlight">
<td align="center"><textarea name="htmlcode" id="htmlcode" rows="20" cols="70"></textarea></td></tr>
<tr class="sabrinatrdark"><td align="center">
<table cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
<td align="right">
<input type="hidden" name="pageid" id="pageid" value="">
<input type="hidden" name="pagename" id="pagename" value="">
<input type="hidden" name="action" value="edit">
<input type="submit" value="SAVE" class="sendit"></form>
</td>

<form action="addpages.php" method="post">
<td>
<input type="hidden" name="deletepageid" id="deletepageid" value="">
<input type="hidden" name="deletepagename" id="deletepagename" value="">
<input type="hidden" name="action" value="deletepage">
<input type="submit" value="DELETE PAGE" class="sendit"></form>
</td>

</tr>
</table>
</td></tr>

</table>
</td></tr>
<?php
}
?>
<tr><td align="center" colspan="2"><br><a href="controlpanel.php">Return To Main Control Panel</a></td></tr>
</table>
<br><br>
<?php
include "../footer.php";
exit;
?>