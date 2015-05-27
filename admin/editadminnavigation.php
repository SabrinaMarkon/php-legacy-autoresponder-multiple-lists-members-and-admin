<?php
include "control.php";
include "../header.php";
$action = $_POST["action"];
if ($action == "newnav")
{
$newnavtitle = $_POST["newnavtitle"];
$newnavurl = $_POST["newnavurl"];
$newnavtarget = $_POST["newnavtarget"];
$newnavenabled = $_POST["newnavenabled"];

	if(!$newnavtitle)
	{
	$error .= "<li>Please return and enter the text that will appear on the new navigation button.</li>";
	}
	if(!$newnavurl)
	{
	$error .= "<li>Please return and add a URL that people will visit when they click the new navigation button.</li>";
	}
	if(!$error == "")
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="80%">
	<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
	<tr><td colspan="2" align="center"><br><?php echo $error ?></td></tr>
	<tr><td colspan="2" align="center"><br><a href="editadminnavigation.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
	}
$q1 = "select * from adminnavigation order by adminnavsequence desc limit 1";
$r1 = mysql_query($q1);
$row1 = mysql_num_rows($r1);
if ($row1 < 1)
	{
	$newnavorder = 1;
	}
if ($row1 > 0)
	{
	$lastnavorder = mysql_result($r1,0,"adminnavsequence");
	$newnavorder = $lastnavorder+1;
	}
$q2 = "insert into adminnavigation (adminnavsequence,adminnavtitle,adminnavurl,adminnavwindow,adminnavenabled) values (\"$newnavorder\",\"$newnavtitle\",\"$newnavurl\",\"$newnavtarget\",\"$newnavenabled\")";
$r2 = mysql_query($q2);
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="80%">
<tr><td align="center" colspan="2"><div class="heading">New Navigation Button Created!</div></td></tr>
<tr><td colspan="2"><br>By default, new buttons are created to show LAST, that is at the bottom of the menu after the other buttons. If you would like to have your new button show in a different position, please return again to the Navigation Admin area (where you just created this button) and you can use the drag and drop interface to change where your new button appears in relation to the other buttons.</td></tr>
<tr><td colspan="2" align="center"><br><a href="editadminnavigation.php">RETURN</a></td></tr>
</table>
<br><br>
<?php
include "../footer.php";
exit;
} # if ($action == "newnav")

if ($action == "deletenav")
{
$q1 = "select * from adminnavigation where id=\"$deleteid\"";
$r1 = mysql_query($q1);
$rows1 = mysql_num_rows($r1);
if ($rows1 > 0)
	{
	$deletenavorder = mysql_result($r1,0,"adminnavsequence");
	$updatenavorderid = $deletenavorder;
	$q2 = "select * from adminnavigation where adminnavsequence > \"$deletenavorder\" order by adminnavsequence";
	$r2 = mysql_query($q2);
	while ($rowz2 = mysql_fetch_array($r2))
		{
		$updateid = $rowz2["id"];
		$q3 = "update adminnavigation set adminnavsequence=\"$updatenavorderid\" where id=\"$updateid\"";
		$r3 = mysql_query($q3);
		$updatenavorderid = $updatenavorderid+1;
		} # while ($rowz2 = mysql_fetch_array($r2))
$q4 = "delete from adminnavigation where id=\"$deleteid\"";
$r4 = mysql_query($q4);
	} # if ($rows1 > 0)
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="80%">
<tr><td align="center" colspan="2"><div class="heading">Navigation Button "<?php echo $deletetitle ?>" Was Deleted</div></td></tr>
<tr><td colspan="2" align="center"><br><a href="editadminnavigation.php">RETURN</a></td></tr>
</table>
<br><br>
<?php
include "../footer.php";
exit;
} # if ($action == "deletenav")

if ($action == "editnav")
{
$editnavtitle = $_POST["editnavtitle"];
$editnavurl = $_POST["editnavurl"];
$editnavtarget = $_POST["editnavtarget"];
$editnavenabled = $_POST["editnavenabled"];
	if(!$editnavtitle)
	{
	$error .= "<li>Please return and enter the text that will appear on the new navigation button.</li>";
	}
	if(!$editnavurl)
	{
	$error .= "<li>Please return and add a URL that people will visit when they click the new navigation button.</li>";
	}
	if(!$error == "")
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="80%">
	<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
	<tr><td colspan="2" align="center"><br><?php echo $error ?></td></tr>
	<tr><td colspan="2" align="center"><br><a href="editadminnavigation.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
	}
$q1 = "update adminnavigation set adminnavtitle=\"$editnavtitle\",adminnavurl=\"$editnavurl\",adminnavwindow=\"$editnavtarget\",adminnavenabled=\"$editnavenabled\" where id=\"$editid\"";
$r1 = mysql_query($q1);
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="80%" align="center">
<tr><td align="center" colspan="2"><div class="heading">Navigation Button "<?php echo $editnavtitle ?>" Was Saved!</div></td></tr>
<tr><td colspan="2" align="center"><br><a href="editadminnavigation.php">RETURN</a></td></tr>
</table>
<br><br>
<!-- END PAGE CONTENT //-->
<?php 
include "../footer.php";
exit;
} # if ($action == "editnav")

if ($action == "savenav")
{
	if ($hiddenNodeIds == "")
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="80%">
	<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
	<tr><td colspan="2" align="center"><br>Please return to the form and try again.</td></tr>
	<tr><td colspan="2" align="center"><br><a href="editadminnavigation.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
	} # if ($hiddenNodeIds == "")

?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="80%">
<tr><td align="center" colspan="2"><div class="heading">Navigation Button Sequence Was Saved</div></td></tr>
<tr><td colspan='2'>
<?php
$hiddenNodeIds_array = explode("|", $hiddenNodeIds);
foreach( $hiddenNodeIds_array as $key => $value)
{
$navid_array = explode("-", $value);
$navid = $navid_array[0];
$newnavorder = $navid_array[1];
$keyplusone = $key+1;
$q = "update adminnavigation set adminnavsequence=\"$keyplusone\" where id=\"$navid\"";
$r = mysql_query($q);
} # foreach( $hiddenNodeIds_array as $key => $value)
?>
</td></tr>
<tr><td colspan="2" align="center"><br><a href="editadminnavigation.php">RETURN</a></td></tr>
</table>
<br><br>
<!-- END PAGE CONTENT //-->
<?php
include "../footer.php";
exit;
} # if ($action == "savenav")

?>
<!--[if !mso]>
<style>
v\:*         { behavior: url(#default#VML) }
o\:*         { behavior: url(#default#VML) }
.shape       { behavior: url(#default#VML) }
</style>
<![endif]--><!--[if gte mso 9]>
<xml><o:shapedefaults v:ext="edit" spidmax="1027"/>
</xml><![endif]-->
<SCRIPT LANGUAGE="JavaScript">
<!--
var oldtext
var newtext
var newlink
function shownewtext(thislink,thistext) {
  if (document.all) {
    newlink=eval("document.getElementById('"+thislink+"')")
    newtext=thistext
    oldtext=newlink.childNodes[0].nodeValue
    newlink.childNodes[0].nodeValue=thistext;
  }
}
function showoldtext() { 
  if (document.all) {
    newlink.childNodes[0].nodeValue=oldtext;
  }
}
var oldtext
var newtext
var newlink
function shownewtext(thislink,thistext) {
  if (document.all) {
    newlink=eval("document.getElementById('"+thislink+"')")
    newtext=thistext
    oldtext=newlink.childNodes[0].nodeValue
    newlink.childNodes[0].nodeValue=thistext;
  }
}
function showoldtext() { 
  if (document.all) {
    newlink.childNodes[0].nodeValue=oldtext;
  }
}

function Start(page) {
OpenWin = this.open(page, 'CtrlWindow', 'toolbar=no,menubar=no,location=no,scrollbars=yes,resizable=yes,width=425,height=400');
}

function submitonce(theform){
//if IE 4+ or NS 6+
if (document.all||document.getElementById){
//screen thru every element in the form, and hunt down "submit" and "reset"
for (i=0;i<theform.length;i++){
var tempobj=theform.elements[i]
if(tempobj.type.toLowerCase()=="submit"||tempobj.type.toLowerCase()=="reset")
//disable em
tempobj.disabled=true
}
}
}

function OpenWindow(strPage){
        window.open (strPage);
}

function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function textCounter(field, countfield, maxlimit) {
if (field.value.length > maxlimit) // if too long...trim it!
field.value = field.value.substring(0, maxlimit);
// otherwise, update 'characters left' counter
else 
countfield.value = maxlimit - field.value.length;
}
function stopError() {
  return true;
}
//window.onerror = stopError;
// -->
</SCRIPT>
<style type="text/css">
<!--
	.statusbox {
		font-size: 13px;
		font-family: Monaco, monospace;
		width: 15em;
	}
	ul.boxy li { margin: 0px; }
	#phonetics td {
		margin: 0px;
		padding: 0px 1em;
		vertical-align: top;
		width: 100px;
	}
	#phonetic1 li, #phonetic2 li, #phonetic3 li { margin: 0px; }
	#phonetic2 li {
		margin-bottom: 4px;
	}
	#phonetic3 { margin-top: -4px; }
	#phonetic3 li { margin-top: 4px; }
	#phoneticlong {
		margin-bottom: 1em;
	}
	#phoneticlong li, #buttons li {
		margin-bottom: 0px;
		margin-top: 4px;
	}

	#boxes {
		font-family: Arial, sans-serif;
		list-style-type: none;
		margin: 0px;
		padding: 0px;
		width: 300px;
	}
	#boxes li {
		cursor: move;
		position: relative;
		float: left;
		margin: 2px 2px 0px 0px;
		width: 33px;
		height: 28px;
		border: 1px solid #000;
		text-align: center;
		padding-top: 5px;
		background-color: #eeeeff;
	}

	#twolists td {
		width: 300px;
		vertical-align: top;
	}
	#twolists1 li {
		font-family: sans-serif;
	}
	#twolists2 {
		border: 1px dashed #fff;
	}
	#twolists2 li {
		font-family: serif;
		background-color: #eedddd;
	}
	.inspector {
		font-size: 11px;
	}
	//-->
</style>
	
<script language="JavaScript" type="text/javascript" src="<?php echo $domain ?>/jscripts/editnavigation/core.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo $domain ?>/jscripts/editnavigation/events.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo $domain ?>/jscripts/editnavigation/css.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo $domain ?>/jscripts/editnavigation/coordinates.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo $domain ?>/jscripts/editnavigation/drag.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo $domain ?>/jscripts/editnavigation/dragsort.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo $domain ?>/jscripts/editnavigation/cookies.js"></script>

<script language="JavaScript" type="text/javascript"><!--
	var dragsort = ToolMan.dragsort()
	var junkdrawer = ToolMan.junkdrawer()

	window.onload = function() {
		//junkdrawer.restoreListOrder("phoneticlong")

		dragsort.makeListSortable(document.getElementById("phoneticlong"),
				verticalOnly, saveOrder)
	}

	function verticalOnly(item) {
		item.toolManDragGroup.verticalOnly()
	}

	function speak(id, what) {
		var element = document.getElementById(id);
		element.innerHTML = 'Clicked ' + what;
	}

	function saveOrder(item) {
		var group = item.toolManDragGroup
		var list = group.element.parentNode
		var id = list.getAttribute("id")
		if (id == null) return
		group.register('dragend', function() {
			ToolMan.cookies().set("list-" + id, 
					junkdrawer.serializeList(list), 365)
		})
	}

	function saveArrangableNodes()
	{
		var nodes = document.getElementsByTagName('LI');
		var string = "";
		for(var no=0;no<nodes.length;no++){
			if(string.length>0)string = string + '|';
			string = string + nodes[no].id;		
		}
		
		document.forms[0].hiddenNodeIds.value = string;
		
		// Just for testing
		//document.getElementById('arrDebug').innerHTML = 'Ready to save these nodes:<br>' + string;	
		
		document.forms[0].submit(); // Remove the comment in front of this line when you have set an action to the form.
		
	}
	//-->
</script>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="80%">
<tr><td align="center" colspan="2"><div class="heading">Edit Admin Navigation Menu</div></td></tr>
<tr><td colspan="2"><br>For your Admin navigation menu, you can add, edit, or remove buttons and the URLs they go to when clicked. The first section below is so you may re-order buttons in the menu. The first section below is so you may re-order buttons in the menu. For
the horizontal menu option, the order goes from LEFT to RIGHT. When there is no more space in a horizontal row of buttons, the next ones are positioned in a new horizontal row.
<br>The second section beneath that is for you to add new buttons to the navigation menu.
<br>The last section on the page allows you to edit all URLs and button text currently shown on the admin navigation menu.</td></tr>

<tr><td align="center" colspan="2"><br>&nbsp;</td></tr>
<tr><td align="center" colspan="2"><div class="heading">Admin Navigation Button Order</div></td></tr>
<tr><td colspan="2" align="center"><br>Drag and Drop the existing buttons below to change the order that they are displayed.</td></tr>
<?php
$navq = "select * from adminnavigation order by adminnavsequence";
$navr = mysql_query($navq);
$navrow = mysql_num_rows($navr);
if ($navrow > 0)
{
?>
<tr><td colspan="2" align="center"><br>
<table cellpadding="0" cellspacing="0" border="0" align="center">
<tr><td align="center">
<ul id="phoneticlong" class="boxy" style="width: 250px;">
<?php
$buttonalternatecounter = 0;
while ($navrowz = mysql_fetch_array($navr))
	{
	$navid = $navrowz["id"];
	$navtitle = $navrowz["adminnavtitle"];
	$navtitle = ereg_replace(" ", "&nbsp;", $navtitle);
	$navurl = $navrowz["adminnavurl"];
	$navorder = $navrowz["adminnavsequence"];
	$navtarget = $navrowz["adminnavwindow"];
?>
<li itemID="<?php echo $navid?>-<?php echo $navorder ?>" id="<?php echo $navid?>-<?php echo $navorder ?>" style="background: #d3d3d3; width: 256px; height: 29px; list-style-type: none; color: #000000; font-family: 'Tahoma',sans-serif; font-size: 12px; text-align: center; vertical-align: middle; line-height: 29px;border: 1px solid #000000;" onmousedown="this.style.backgroundColor='#eeeeee'" onmouseover="this.style.backgroundColor='#eeeeee'" onmouseout="this.style.backgroundColor='#d3d3d3'"><?php echo $navtitle ?></li>
<?php
	} # while ($navrowz = mysql_fetch_array($navr))
?>
</ul>
<p><br>
<input class="sendit" type="button" value="Save Menu Order" onclick="saveArrangableNodes();return false"/>
</p>
<div id="movableNode"><ul></ul></div>	
<div id="arrDebug"></div>
<form method="post" action="editadminnavigation.php">
	<input type="hidden" name="hiddenNodeIds">
	<input type="hidden" name="action" value="savenav">
</form>
</td></tr></table>
</td></tr>
<?php
} # if ($navrow > 0)
if ($navrow < 1)
{
?>
<tr><td colspan="2" align="center"><br>There are no navigation buttons added yet to the admin area menu.</td></tr>
<?php
} # if ($navrow < 1)
?>
<tr><td align="center" colspan="2"><br>&nbsp;</td></tr>
<tr><td align="center" colspan="2"><div class="heading">Create New Admin Navigation Menu Button</div></td></tr>
<form method="post" action="editadminnavigation.php">
<tr><td align="right"><br>Button Title (text that appears on the button): </td><td><br><input type="text" class="typein" name="newnavtitle" maxlength="255" size="40"></td></tr>
<tr><td align="right">Button URL (url you go to when you click the button - don't forget http:// part of url!): </td><td><input type="text" class="typein" name="newnavurl" maxlength="255" size="40"></td></tr>
<tr><td align="right">Target Window: </td><td>
<select class="pickone" name="newnavtarget">
<option value="_top">URL Opens in the Same Window</option>
<option value="_blank">URL Opens in a New Window</option>
</select>
</td></tr>
<tr><td align="right">Enabled: </td><td>
<select class="pickone" name="newnavenabled">
<option value="yes">Yes</option>
<option value="no">No</option>
</select>
</td></tr>
<tr><td colspan="2" align="center"><br><input type="hidden" name="action" value="newnav"><input type="submit" class="sendit" value="Create Button"></td></tr>
</form>
<tr><td align="center" colspan="2"><br>&nbsp;</td></tr>
<tr><td align="center" colspan="2"><br><div class="heading">Edit or Delete Existing Buttons</div></td></tr>
<?php
$navq2 = "select * from adminnavigation order by adminnavsequence";
$navr2 = mysql_query($navq2);
$navrow2 = mysql_num_rows($navr2);
if ($navrow2 > 0)
{
?>
<tr><td align="center" colspan="2"><br>
<table cellspacing="2" cellpadding="4" border="0" align="center" width="800" class="sabrinatable">
<tr class="sabrinatrdark">
<td align="center"><font size="1"><u>Button Order</u></td><td align="center"><font size="1"><u>Button Title</u></td><td align="center"><font size="1"><u>Button URL</u></td><td align="center"><font size="1"><u>Target Window</u></td><td align="center"><font size="1"><u>Enabled</u></td><td align="center"><font size="1"><u>Save</u></td><td align="center"><font size="1"><u>Delete</u></td>
</tr>
<?php
while ($navrowz2 = mysql_fetch_array($navr2))
	{
	$navid2 = $navrowz2["id"];
	$navtitle2 = $navrowz2["adminnavtitle"];
	$navurl2 = $navrowz2["adminnavurl"];
	$navorder2 = $navrowz2["adminnavsequence"];
	$navtarget2 = $navrowz2["adminnavwindow"];
	$navenabled2 = $navrowz2["adminnavenabled"];
?>
<tr class="sabrinatrlight">
<form action="editadminnavigation.php" method="post" name="form<?php echo $navid2 ?>">
<td align="center"><?php echo $navorder2 ?></td>
<td align="center"><input type="text" class="typein" name="editnavtitle" value="<?php echo $navtitle2 ?>" maxlength="255" size="16"></td>
<td align="center"><input type="text" class="typein" name="editnavurl" value="<?php echo $navurl2 ?>" maxlength="255" size="16"></td>
<td align="center">
<select class="pickone" name="editnavtarget">
<option value="_top" <?php if ($navtarget2 == "_top") { echo "selected"; } ?>>Same Window</option>
<option value="_blank" <?php if ($navtarget2 != "_top") { echo "selected"; } ?>>New Window</option>
</select>
</td>
<td align="center">
<select class="pickone" name="editnavenabled">
<option value="yes" <?php if ($navenabled2 == "yes") { echo "selected"; } ?>>Yes</option>
<option value="no" <?php if ($navenabled2 != "yes") { echo "selected"; } ?>>No</option>
</select>
</td>
<td align="center"><input type="hidden" name="action" value="editnav"><input type="hidden" name="editid" value="<?php echo $navid2 ?>"><input type="hidden" name="editnavorder" value="<?php echo $navorder2 ?>"><input type="submit" class="sendit" value="SAVE" style="width: 99%; font-size: 10px;">
</td>
</form>
<form action="editadminnavigation.php" method="post">
<td align="center"><input type="hidden" name="action" value="deletenav"><input type="hidden" name="deleteid" value="<?php echo $navid2 ?>"><input type="hidden" name="deletetitle" value="<?php echo $navtitle2 ?>"><input type="submit" class="sendit" value="DELETE" style="width: 99%; font-size: 10px;">
</td>
</form>
</tr>
<?php
	} # while ($navrowz2 = mysql_fetch_array($navr2))
?>
</table></td></tr>
<?php
} # if ($navrow2 > 0)
if ($navrow2 < 1)
{
?>
<tr><td colspan="2" align="center"><br>There are no navigation buttons added yet to the admin area menu.</td></tr>
<?php
} # if ($navrow2 < 1)
?>
</table>
<br><br>
<?php
include "../footer.php";
exit;
?>
