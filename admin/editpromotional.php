<?php
include "control.php";
include "../header.php";
$action = $_POST["action"];
$show = "";
if ($action == "add")
{
$name = $_POST["name"];
$type = $_POST["type"];
$promotionalimage = $_POST["promotionalimage"];
$promotionalsubject = $_POST["promotionalsubject"];
$promotionaladbody = $_POST["promotionaladbody"];
	if (!$name)
	{
	$error = "<div>Please return and enter a name for your promotional ad.</div>";
	}
	if ($type == "banner")
	{
		if(!$promotionalimage)
		{
		$error .= "<div>Please return and enter the image URL for your promotional ad (URL to the gif, jpg, png image).</div>";
		}
	}
	if ($type == "email")
	{
		if(!$promotionalsubject)
		{
		$error .= "<div>Please return and enter a subject for your promotional ad.</div>";
		}
		if(!$promotionaladbody)
		{
		$error .= "<div>Please return and enter a message body for your promotional ad.</div>";
		}
	}
	if(!$error == "")
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
	<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
	<tr><td colspan="2" align="center"><br><?php echo $error ?></td></tr>
	<tr><td colspan="2" align="center"><br><a href="editpromotional.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
	}
$promotionalsubject = mysql_real_escape_string($promotionalsubject);
$promotionaladbody = mysql_real_escape_string($promotionaladbody);
$q = "insert into adminpromotional (name,type,promotionalimage,promotionalsubject,promotionaladbody) values ('$name','$type','$promotionalimage','$promotionalsubject','$promotionaladbody')";
$r = mysql_query($q);
$show = "New Promotional Ad Was Added";
} # if ($action == "add")
####################################################################
if ($action == "save")
{
$pid = $_POST["pid"];
$name = $_POST["name"];
$type = $_POST["type"];
$promotionalimage = $_POST["promotionalimage"];
$promotionalsubject = $_POST["promotionalsubject"];
$promotionaladbodyvarname = "promotionaladbody" . $pid;
$promotionaladbody = $_POST[$promotionaladbodyvarname];
	if (!$name)
	{
	$error = "<div>Please return and enter a name for your promotional ad.</div>";
	}
	if ($type == "banner")
	{
		if(!$promotionalimage)
		{
		$error .= "<div>Please return and enter the image URL for your promotional ad (URL to the gif, jpg, png image).</div>";
		}
	}
	if ($type == "email")
	{
		if(!$promotionalsubject)
		{
		$error .= "<div>Please return and enter a subject for your promotional ad.</div>";
		}
		if(!$promotionaladbody)
		{
		$error .= "<div>Please return and enter a message body for your promotional ad.</div>";
		}
	}
	if(!$error == "")
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
	<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
	<tr><td colspan="2" align="center"><br><?php echo $error ?></td></tr>
	<tr><td colspan="2" align="center"><br><a href="editpromotional.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
	}
$promotionalsubject = mysql_real_escape_string($promotionalsubject);
$promotionaladbody = mysql_real_escape_string($promotionaladbody);
$q = "update adminpromotional set name='$name',promotionalimage='$promotionalimage',promotionalsubject='$promotionalsubject',promotionaladbody='$promotionaladbody' where id='$pid'";
$r = mysql_query($q);
$show = "Promotional Ad Was Saved";
} # if ($action == "save")
####################################################################
if ($action == "delete")
{
$pid = $_POST["pid"];
$q = "delete from adminpromotional where id=\"$pid\"";
$r = mysql_query($q);
$show = "Promotional Ad Was Deleted";
} # if ($action == "delete")
####################################################################
?>
<script language="JavaScript">
function setuppromotional(ans) {
if (ans != "")
{
  var littext = '';
  var litfields = '';
  if (ans == "banner") {
    littext = 'Image&nbsp;URL:';
    litfields = litfields + '<input type="text" name="promotionalimage" size="55" maxlength="255" class="typein">';
	document.getElementById('previewfield').style.visibility = 'visible';
	document.getElementById('previewfield').style.display = 'block';
	document.getElementById('promotionaloptionstext').style.visibility = 'visible';
	document.getElementById('promotionaloptionsfields').style.visibility = 'visible';
	document.getElementById('promotionaloptionstext').innerHTML=littext;
	document.getElementById('promotionaloptionsfields').innerHTML=litfields;
	tinyMCE.execCommand('mceFocus', false, 'promotionaladbody');                    
	tinyMCE.execCommand('mceRemoveControl', false, 'promotionaladbody');
  }
  if (ans == "email") {
    littext = 'Subject&nbsp;and&nbsp;Message:';
    litfields = litfields + '<input type="text" name="promotionalsubject" size="55" maxlength="255" class="typein"><br><textarea name="promotionaladbody" id="promotionaladbody" rows="20" cols="80"></textarea>';
	document.getElementById('previewfield').style.visibility = 'hidden';
	document.getElementById('previewfield').style.display = 'none';
	document.getElementById('promotionaloptionstext').style.visibility = 'visible';
	document.getElementById('promotionaloptionsfields').style.visibility = 'visible';
	document.getElementById('promotionaloptionstext').innerHTML=littext;
	document.getElementById('promotionaloptionsfields').innerHTML=litfields;
	tinyMCE.execCommand('mceAddControl', false, 'promotionaladbody');
  }
}
if (ans == "")
{
document.getElementById('previewfield').style.visibility = 'hidden';
document.getElementById('previewfield').style.display = 'none';
tinyMCE.execCommand('mceFocus', false, 'promotionaladbody');                    
tinyMCE.execCommand('mceRemoveControl', false, 'promotionaladbody');
document.getElementById('promotionaloptionstext').style.visibility = 'hidden';
document.getElementById('promotionaloptionsfields').style.visibility = 'hidden';
document.getElementById('promotionaloptionstext').innerHTML='';
document.getElementById('promotionaloptionsfields').innerHTML='';
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
<tr><td align="center" colspan="2"><div class="heading">Promotional&nbsp;Material</div></td></tr>
<?php
if ($show != "")
{
?>
<tr><td align="center" colspan="2"><br><?php echo $show ?></td></tr>
<?php
}
?>
<tr><td align="center" colspan="2"><br>
<form action="editpromotional.php" method="post" name="theform" id="theform">
<table width="80%" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrdark"><td align="center" colspan="2">ADD NEW PROMOTIONAL AD</td></tr>
<tr class="sabrinatrlight"><td valign="top">Name:</td><td><input type="text" name="name" size="55" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td valign="top">Type:</td><td><select name="type" id="type" onchange="javascript:setuppromotional(document.theform.type.value)"><option value=""> - Select - </option><option value="banner">Banner</option><option value="email">Email</option></select></td></tr>
<tr class="sabrinatrlight">
<td valign="top"><span name="promotionaloptionstext" id="promotionaloptionstext" style="visibility: hidden;"></span></td>
<td><span name="promotionaloptionsfields" id="promotionaloptionsfields" style="visibility: hidden;"></span></td>
</tr>
<tr class="sabrinatrdark"><td align="center" colspan="2">
<span name="previewfield" id="previewfield" style="visibility: hidden; display: none;">
<script language="JavaScript">
function previewbannerad(bannerurl,targeturl)
{
var win
win = window.open("", "win", "height=68,width=500,toolbar=no,directories=no,menubar=no,scrollbars=yes,resizable=yes,dependent=yes'");
win.document.clear();
win.document.write('<a href="'+targeturl+'"><img src="'+bannerurl+'" border="0"></a>');
win.focus();
win.document.close();
}
</script>
<input type="button" class="sendit" value="PREVIEW" onclick="previewbannerad(promotionalimage.value,'<?php echo $domain ?>')">
</span></td>
</tr>
<tr class="sabrinatrdark"><td align="center" colspan="2">
<input type="hidden" name="action" value="add">
<input type="submit" value="ADD" class="sendit">
</form></td></tr>
</table>
</td></tr>
<?php
$query = "select * from adminpromotional order by type,id";
$result = mysql_query($query);
$rows = mysql_num_rows($result);
if ($rows > 0)
{
?>
<tr><td align="center" colspan="2"><br>
<table width="80%" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<?
while ($line = mysql_fetch_array($result))
{
$pid = $line["id"];
$name = $line["name"];
$type = $line["type"];
$promotionalimage = $line["promotionalimage"];
$promotionalsubject = $line["promotionalsubject"];
$promotionalsubject = stripslashes($promotionalsubject);
$promotionalsubject = str_replace('\\', '', $promotionalsubject); 
$promotionaladbody = $line["promotionaladbody"];
$promotionaladbody = stripslashes($promotionaladbody);
$promotionaladbody = str_replace('\\', '', $promotionaladbody); 
if ($type == "banner")
	{
?>
<form action="editpromotional.php" method="post" name="form<?php echo $pid ?>" value="form<?php echo $pid ?>">
<tr class="sabrinatrdark"><td align="center" colspan="2">BANNER</td></tr>
<tr class="sabrinatrlight"><td align="center" colspan="2"><a href="<?php echo $domain ?>" target="_blank"><img src="<?php echo $promotionalimage ?>" border="0"></a></td></tr>
<tr class="sabrinatrlight"><td valign="top">Name:</td><td><input type="text" name="name" value="<?php echo $name ?>" size="55" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td valign="top">Banner:</td><td><input type="text" name="promotionalimage" value="<?php echo $promotionalimage ?>" size="55" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrdark"><td align="center" colspan="2">
<table cellpadding="2" cellspacing="2" border="0" align="center">
<tr>
<td align="right">
<script language="JavaScript">
function previewad(bannerurl,targeturl)
{
var win
win = window.open("", "win", "height=68,width=500,toolbar=no,directories=no,menubar=no,scrollbars=yes,resizable=yes,dependent=yes'");
win.document.clear();
win.document.write('<a href="'+targeturl+'"><img src="'+bannerurl+'" border="0"></a>');
win.focus();
win.document.close();
}
</script>
<input type="button" class="sendit" value="PREVIEW" onclick="previewad(promotionalimage.value,'<?php echo $domain ?>')">
</td>
<td align="center">
<input type="hidden" name="pid" value="<?php echo $pid ?>">
<input type="hidden" name="type" value="<?php echo $type ?>">
<input type="hidden" name="action" value="save">
<input type="submit" value="SAVE" class="sendit">
</form>
</td>
<form action="editpromotional.php" method="post">
<td>
<input type="hidden" name="pid" value="<?php echo $pid ?>">
<input type="hidden" name="action" value="delete">
<input type="submit" value="DELETE" class="sendit">
</form>
</td></tr>
</table>
</td></tr>
<tr><td align="center" colspan="2"></td></tr>
<?php
	} # if ($type == "banner")
if ($type == "email")
	{
?>
<form action="editpromotional.php" method="post" name="form<?php echo $pid ?>" value="form<?php echo $pid ?>">
<tr class="sabrinatrdark"><td align="center" colspan="2">EMAIL</td></tr>
<tr class="sabrinatrlight"><td valign="top">Name:</td><td><input type="text" name="name" value="<?php echo $name ?>" size="58" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td valign="top">Subject:</td><td><input type="text" name="promotionalsubject" value="<?php echo $promotionalsubject ?>" size="58" maxlength="255" class="typein"></td></tr>
<tr class="sabrinatrlight"><td valign="top">Message:</td><td>
<textarea name="promotionaladbody<?php echo $pid ?>" id="promotionaladbody<?php echo $pid ?>" rows="20" cols="52"><?php echo $promotionaladbody ?></textarea>
</td></tr>
<tr class="sabrinatrdark"><td align="center" colspan="2">
<table cellpadding="2" cellspacing="2" border="0" align="center">
<tr>
<td align="right">
<input type="hidden" name="pid" value="<?php echo $pid ?>">
<input type="hidden" name="type" value="<?php echo $type ?>">
<input type="hidden" name="action" value="save">
<input type="submit" value="SAVE" class="sendit">
</form>
</td>
<form action="editpromotional.php" method="post">
<td>
<input type="hidden" name="pid" value="<?php echo $pid ?>">
<input type="hidden" name="action" value="delete">
<input type="submit" value="DELETE" class="sendit">
</form>
</td></tr>
</table>
</td></tr>
<tr><td align="center" colspan="2"></td></tr>
<?php
	} # if ($type == "email")
}
?>
</td></tr>
</table>
<?php
}
?>
</table>
<br><br>
<?php
include "../footer.php";
exit;
?>