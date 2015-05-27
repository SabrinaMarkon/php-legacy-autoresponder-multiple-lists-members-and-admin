<?php
include "control.php";
include "header.php";
function formatDate($val) {
	$arr = explode("-", $val);
	return date("M d Y", mktime(0,0,0, $arr[1], $arr[2], $arr[0]));
}
$action = $_POST["action"];
$error = "";
$show = "";
##############################################
if ($action == "new")
{
	$reminderenabled = $_POST["reminderenabled"];
	$remindertitle = $_POST["remindertitle"];
	$remindermessage = $_POST["remindermessage"];
	$remindersubject = $_POST["remindersubject"];
	$reminderfromfield = $_POST["reminderfromfield"];
	$reminderurl = $_POST["reminderurl"];
	$remindereventstart = $_POST["remindereventstart"];
	$remindereventend = $_POST["remindereventend"];
	$remindertime = $_POST["remindertime"];
	$reminderhowmanytimes = $_POST["reminderhowmanytimes"];
	$reminderhowmanytimesinterval = $_POST["reminderhowmanytimesinterval"];
	if (!$remindertitle)
	{
	$error .= "<div>No title for your reminder was entered.</div>";
	}
	if (!$reminderfromfield)
	{
	$error .= "<div>No from field name was entered.</div>";
	}
	if (!$remindersubject)
	{
	$error .= "<div>No subject was entered.</div>";
	}
	if (!$remindermessage)
	{
	$error .= "<div>No subject was entered.</div>";
	}
	if (!$remindertime)
	{
	$error .= "<div>No time for your reminder was entered.</div>";
	}
	if(!$error == "")
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="80%">
	<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
	<tr><td align="center" colspan="2"><br><?php echo $error ?></td></tr>
	<tr><td colspan="2" align="center"><br><a href="autoresponder_reminders.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "footer.php";
	exit;
	}
$remindermessage = stripslashes($remindermessage);
$remindermessage = str_replace('\\', '', $remindermessage);
$remindermessage = mysql_real_escape_string($remindermessage);
$remindersubject = stripslashes($remindersubject);
$remindersubject = str_replace('\\', '', $remindersubject); 
$remindersubject = mysql_real_escape_string($remindersubject);
$q = "insert into autoresponder_reminders (userid,reminderenabled,remindertitle,remindermessage,remindersubject,reminderfromfield,reminderurl,remindereventstart,remindereventend,remindertime,reminderhowmanytimes,reminderhowmanytimesinterval,remindernextsent) values ('$userid','$reminderenabled','$remindertitle','$remindermessage','$remindersubject','$reminderfromfield','$reminderurl','$remindereventstart','$remindereventend','$remindertime','$reminderhowmanytimes','$reminderhowmanytimesinterval','$remindertime')";
$r = mysql_query($q) or die(mysql_error());
$show = "New Reminder was Created!";
} # if ($action == "new")
##############################################
if ($action == "delete")
{
$deleteid = $_POST["deleteid"];
$delq = "delete from autoresponder_reminders where userid=\"$userid\" and id=\"$deleteid\"";
$delr = mysql_query($delq);
$show = "The Reminder was Deleted.";
}
##############################################
if ($action == "save")
{
	$saveid = $_POST["saveid"];
	$reminderenabled = $_POST["reminderenabled"];
	$remindertitle = $_POST["remindertitle"];
	$remindermessage = $_POST["remindermessage"];
	$remindersubject = $_POST["remindersubject"];
	$reminderfromfield = $_POST["reminderfromfield"];
	$reminderurl = $_POST["reminderurl"];
	$remindereventstart = $_POST["remindereventstart"];
	$remindereventend = $_POST["remindereventend"];
	$remindertime = $_POST["remindertime"];
	$oldremindertime = $_POST["oldremindertime"];
	$reminderhowmanytimes = $_POST["reminderhowmanytimes"];
	$reminderhowmanytimesinterval = $_POST["reminderhowmanytimesinterval"];
	if (!$remindertitle)
	{
	$error .= "<div>No title for your reminder was entered.</div>";
	}
	if (!$reminderfromfield)
	{
	$error .= "<div>No from field name was entered.</div>";
	}
	if (!$remindersubject)
	{
	$error .= "<div>No subject was entered.</div>";
	}
	if (!$remindermessage)
	{
	$error .= "<div>No subject was entered.</div>";
	}
	if (!$remindertime)
	{
	$error .= "<div>No time for your reminder was entered.</div>";
	}
	if(!$error == "")
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="80%">
	<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
	<tr><td align="center" colspan="2"><br><?php echo $error ?></td></tr>
	<tr><td colspan="2" align="center"><br><a href="autoresponder_reminders.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "footer.php";
	exit;
	}
$remindermessage = stripslashes($remindermessage);
$remindermessage = str_replace('\\', '', $remindermessage);
$remindermessage = mysql_real_escape_string($remindermessage);
$remindersubject = stripslashes($remindersubject);
$remindersubject = str_replace('\\', '', $remindersubject); 
$remindersubject = mysql_real_escape_string($remindersubject);

if ($remindertime == $oldremindertime)
	{
	$q = "update autoresponder_reminders set reminderenabled=\"$reminderenabled\",remindertitle=\"$remindertitle\",remindermessage=\"$remindermessage\",remindersubject=\"$remindersubject\",reminderfromfield=\"$reminderfromfield\",reminderurl=\"$reminderurl\",remindereventstart=\"$remindereventstart\",remindereventend=\"$remindereventend\",reminderhowmanytimes=\"$reminderhowmanytimes\",reminderhowmanytimesinterval=\"$reminderhowmanytimesinterval\" where userid=\"$userid\" and id=\"$saveid\"";
	}
if ($remindertime != $oldremindertime)
	{
	$q = "update autoresponder_reminders set reminderenabled=\"$reminderenabled\",remindertitle=\"$remindertitle\",remindermessage=\"$remindermessage\",remindersubject=\"$remindersubject\",reminderfromfield=\"$reminderfromfield\",reminderurl=\"$reminderurl\",remindereventstart=\"$remindereventstart\",remindereventend=\"$remindereventend\",reminderhowmanytimes=\"$reminderhowmanytimes\",reminderhowmanytimesinterval=\"$reminderhowmanytimesinterval\",remindertime=\"$remindertime\",remindernextsent=\"$remindertime\",totalmailed=\"0\" where userid=\"$userid\" and id=\"$saveid\"";
	}
$r = mysql_query($q) or die(mysql_error());
$show = "Your Reminder was Saved!";
} # if ($action == "save")
########################################################################## SABRINA MARKON 2012 PearlsOfWealth.com
?>
<style type="text/css">
.showstate{ /*Definition for state toggling image */
cursor:hand;
cursor:pointer;
float: right;
margin-top: 2px;
margin-right: 3px;
}
.switchcontent{
width: 750px;
border: 1px solid black;
border-top-width: 0;
}
</style>
<script language="Javascript">
<!--
/***********************************************
* Switch Content script II- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use. Last updated April 2nd, 2005.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

var enablepersist="off" //Enable saving state of content structure using session cookies? (on/off)
var memoryduration="1" //persistence in # of days

var contractsymbol='<?php echo $domain ?>/images/close.png' //Path to image to represent contract state.
var expandsymbol='<?php echo $domain ?>/images/open.png' //Path to image to represent expand state.

/////No need to edit beyond here //////////////////////////

function getElementbyClass(rootobj, classname){
var temparray=new Array()
var inc=0
var rootlength=rootobj.length
for (i=0; i<rootlength; i++){
if (rootobj[i].className==classname)
temparray[inc++]=rootobj[i]
}
return temparray
}

function sweeptoggle(ec){
var inc=0
while (ccollect[inc]){
ccollect[inc].style.display=(ec=="contract")? "none" : ""
inc++
}
revivestatus()
}


function expandcontent(curobj, cid){
if (ccollect.length>0){
document.getElementById(cid).style.display=(document.getElementById(cid).style.display!="none")? "none" : ""
curobj.src=(document.getElementById(cid).style.display=="none")? expandsymbol : contractsymbol
}
}

function revivecontent(){
selectedItem=getselectedItem()
selectedComponents=selectedItem.split("|")
for (i=0; i<selectedComponents.length-1; i++)
document.getElementById(selectedComponents[i]).style.display="none"
}

function revivestatus(){
var inc=0
while (statecollect[inc]){
if (ccollect[inc].style.display=="none")
statecollect[inc].src=expandsymbol
else
statecollect[inc].src=contractsymbol
inc++
}
}

function get_cookie(Name) { 
var search = Name + "="
var returnvalue = "";
if (document.cookie.length > 0) {
offset = document.cookie.indexOf(search)
if (offset != -1) { 
offset += search.length
end = document.cookie.indexOf(";", offset);
if (end == -1) end = document.cookie.length;
returnvalue=unescape(document.cookie.substring(offset, end))
}
}
return returnvalue;
}

function getselectedItem(){
if (get_cookie(window.location.pathname) != ""){
selectedItem=get_cookie(window.location.pathname)
return selectedItem
}
else
return ""
}

function saveswitchstate(){
var inc=0, selectedItem=""
while (ccollect[inc]){
if (ccollect[inc].style.display=="none")
selectedItem+=ccollect[inc].id+"|"
inc++
}
if (get_cookie(window.location.pathname)!=selectedItem){ //only update cookie if current states differ from cookie's
var expireDate = new Date()
expireDate.setDate(expireDate.getDate()+parseInt(memoryduration))
document.cookie = window.location.pathname+"="+selectedItem+";path=/;expires=" + expireDate.toGMTString()
}
}

function do_onload(){
uniqueidn=window.location.pathname+"firsttimeload"
var alltags=document.all? document.all : document.getElementsByTagName("*")
ccollect=getElementbyClass(alltags, "switchcontent")
statecollect=getElementbyClass(alltags, "showstate")
if (enablepersist=="on" && get_cookie(window.location.pathname)!="" && ccollect.length>0)
revivecontent()
if (ccollect.length>0 && statecollect.length>0)
revivestatus()
}

if (window.addEventListener)
window.addEventListener("load", do_onload, false)
else if (window.attachEvent)
window.attachEvent("onload", do_onload)
else if (document.getElementById)
window.onload=do_onload

if (enablepersist=="on" && document.getElementById)
window.onunload=saveswitchstate

/***********************************************
* END SWITCH CONTENT SCRIPT
***********************************************/
-->
</script>
<script type="text/javascript" src="<?php echo $domain ?>/jscripts/jquery.js"></script>
<script type="text/javascript" src="<?php echo $domain ?>/jscripts/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo $domain ?>/jscripts/ckeditor4/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo $domain ?>/jscripts/ckeditor4/adapters/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $domain ?>/jscripts/jquery-ui.css"/>
<div id="previewdlg" title="Preview">
<div id="pvw">
</div>
</div>
<link type="text/css" rel="stylesheet" href="<?php echo $domain ?>/jscripts/datetimepicker/anytime.css" />
<script type="text/javascript" src="<?php echo $domain ?>/jscripts/datetimepicker/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo $domain ?>/jscripts/datetimepicker/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="<?php echo $domain ?>/jscripts/datetimepicker/anytime.js"></script>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">
<?php
if ($show != "")
{
?>
<tr><td align="center" colspan="2"><br><?php echo $show ?></td></tr>
<?php
}
?>
<tr><td align="center" colspan="2"><br><div class="heading">YOUR REMINDERS</div></td></tr>

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
$q = "select * from pages where name='Members Area - Autoresponder Reminders Page'";
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
<table width="800" cellpadding="4" cellspacing="2" border="0" align="center" class="sabrinatable">
<tr class="sabrinatrlight"><td align="center">Current Server Time:</td>
<td>
<?php
date_default_timezone_set('America/Edmonton');
$current_date = date('l, F d, Y H:i:s');
echo $current_date;
?>
</td></tr>
</table>
</td></tr>

<?php
$savedq = "select * from autoresponder_reminders where userid=\"$userid\" order by reminderenabled desc,remindertime asc";
$savedr = mysql_query($savedq);
$savedrows = mysql_num_rows($savedr);
if ($savedrows > 0)
{
?>
<tr><td align="center" colspan="2"><br>
<table width="800" cellpadding="4" cellspacing="2" border="0" align="center" class="sabrinatable">
<tr class="sabrinatrdark"><td align="center" colspan="2">YOUR REMINDERS</td></tr>
<?php
while ($savedrowz = mysql_fetch_array($savedr))
	{
	$reminderid = $savedrowz["id"];
	$reminderenabled = $savedrowz["reminderenabled"];
	$remindertitle = $savedrowz["remindertitle"];
	$remindertitle = stripslashes($remindertitle);
	$remindertitle = str_replace('\\', '', $remindertitle); 
	$remindermessage = $savedrowz["remindermessage"];
	$remindermessage = stripslashes($remindermessage);
	$remindermessage = str_replace('\\', '', $remindermessage);
	$remindermessage = htmlentities($remindermessage, ENT_COMPAT, "ISO-8859-1");
	$remindersubject = $savedrowz["remindersubject"];
	$remindersubject = stripslashes($remindersubject);
	$remindersubject = str_replace('\\', '', $remindersubject); 
	$reminderfromfield = $savedrowz["reminderfromfield"];
	$reminderfromfield = stripslashes($reminderfromfield);
	$reminderfromfield = str_replace('\\', '', $reminderfromfield); 
	$reminderurl = $savedrowz["reminderurl"];
	$remindereventstart = $savedrowz["remindereventstart"];
	$remindereventend = $savedrowz["remindereventend"];
	$remindertime = $savedrowz["remindertime"];
	$reminderhowmanytimes = $savedrowz["reminderhowmanytimes"];
	$reminderhowmanytimesinterval = $savedrowz["reminderhowmanytimesinterval"];
	$reminderlastsent = $savedrowz["reminderlastsent"];
	if (($reminderlastsent == 0) or ($reminderlastsent == "0000-00-00 00:00:00") or ($reminderlastsent == ""))
	{
	$showreminderlastsent = "N/A";
	}
	else
	{
	#$showreminderlastsent = formatDate($reminderlastsent);
	$showreminderlastsent = $reminderlastsent;
	}
	$remindernextsent = $savedrowz["remindernextsent"];
	if (($remindernextsent == 0) or ($remindernextsent == "0000-00-00 00:00:00") or ($remindernextsent == "") or ($reminderhowmanytimes < 2))
	{
	$showremindernextsent = "N/A";
	}
	else
	{
	#$showremindernextsent = formatDate($remindernextsent);
	$showremindernextsent = $remindernextsent;
	}
	$totalmailed = $savedrowz["totalmailed"];
	$statusq = "select * from autoresponder_reminders where id=\"$reminderid\" and remindertime<NOW()";
	$statusr = mysql_query($statusq);
	$statusrows = mysql_num_rows($statusr);
	if ($statusrows > 0)
		{
		# time already past.
		$statusbg = "#ff9999";
		$status = "Reminder Time has Passed!";
		}
	if ($statusrows < 1)
		{
		# time not past yet.
		$statusbg = "#99cc99";
		$status = "Reminder Time has not passed yet";
		}
	?>
<form action="autoresponder_reminders.php" method="post">
<tr class="sabrinatrlight"><td>
<table cellpadding="2" cellspacing="2" border="0" width="100%">
<tr><td style="float:left;"><img src="<?php echo $domain ?>/images/open.png" class="showstate" onclick="expandcontent(this, 'sc<?php echo $reminderid ?>')" width="20"></td>
<td>Name:</td></tr></table>
</td><td><input type="text" name="remindertitle" value="<?php echo $remindertitle ?>" size="95" maxlength="255"></td></tr>
<tr bgcolor="<?php echo $statusbg ?>"><td>Status:</td><td><?php echo $status ?></td></tr>

<tr><td id="sc<?php echo $reminderid ?>" class="switchcontent" style="display: none; width: 800px; padding: 0px;" colspan="2" style="border:0px;">
<table cellpadding="2" cellspacing="2" border="0" width="800" align="center">

	<tr class="sabrinatrlight"><td>Enabled</td><td><select name="reminderenabled"><option value="yes" <?php if ($reminderenabled == "yes") { echo "selected"; } ?>>YES</option><option value="no" <?php if ($reminderenabled != "yes") { echo "selected"; } ?>>NO</option></select></td></tr>
	<tr class="sabrinatrlight"><td>Time to Send Reminder Email:</td><td><input id="remindertime<?php echo $reminderid ?>" name="remindertime" type="text" size="25" value="<?php echo $remindertime ?>"><script>AnyTime.picker('remindertime<?php echo $reminderid ?>');</script></td></tr>
	<tr class="sabrinatrlight"><td>How Often to Send Reminder Email (after reminder time has passed):</td>
	<td>
	Once Every&nbsp;
	<select name="reminderhowmanytimesinterval">
	<?php
		for($i=1;$i<=24;$i++)
		{
		?>
		<option value="<?php echo $i ?>" <?php if ($i == $reminderhowmanytimesinterval) { echo "selected"; } ?>><?php echo $i ?></option>
		<?php
		}
	?>
	</select>&nbsp;Hours, for&nbsp;
	<select name="reminderhowmanytimes">
	<?php
		for($j=1;$j<=24;$j++)
		{
		?>
		<option value="<?php echo $j ?>" <?php if ($j == $reminderhowmanytimes) { echo "selected"; } ?>><?php echo $j ?></option>
		<?php
		}
	?>
	</select>&nbsp;Hours
	</td></tr>
	<tr class="sabrinatrlight"><td>Event Start Time (optional):</td><td><input id="remindereventstart<?php echo $reminderid ?>" name="remindereventstart" type="text" size="25" value="<?php echo $remindereventstart ?>"><script>AnyTime.picker('remindereventstart<?php echo $reminderid ?>');</script></td></tr>
	<tr class="sabrinatrlight"><td>Event End Time (optional):</td><td><input id="remindereventend<?php echo $reminderid ?>" name="remindereventend" type="text" size="25" value="<?php echo $remindereventend ?>"><script>AnyTime.picker('remindereventend<?php echo $reminderid ?>');</script></td></tr>
	<tr class="sabrinatrlight"><td>URL:</td><td><input type="text" name="reminderurl" value="<?php echo $reminderurl ?>" size="95" maxlength="255"></td></tr>
	<tr class="sabrinatrlight"><td>From Field:</td><td><input type="text" name="reminderfromfield" value="<?php echo $reminderfromfield ?>" size="95" maxlength="255"></td></tr>
	<tr class="sabrinatrlight"><td>Subject:</td><td><input type="text" name="remindersubject" value="<?php echo $remindersubject ?>" size="95" maxlength="255"></td></tr>
	<tr class="sabrinatrlight"><td valign="top">Message:</td><td><textarea class="ckeditor" name="remindermessage" rows="15" cols="95"><?php echo $remindermessage ?></textarea></td></tr>
	<tr class="sabrinatrlight"><td>Number Emailed:</td><td><?php echo $totalmailed ?></td></tr>
	<tr class="sabrinatrlight"><td>Reminder Last Email Time:</td><td><?php echo $showreminderlastsent ?></td></tr>
	<tr class="sabrinatrlight"><td>Reminder Next Email Time:</td><td><?php echo $showremindernextsent ?></td></tr>
	<tr class="sabrinatrdark">
	<td align="center" colspan="2">
	<table cellpadding="2" cellspacing="2" border="0" align="center" class="sabrinatable" width="100%">
	<tr class="sabrinatrdark"><td align="center">SAVE</td><td align="center">DELETE</td></tr>	
	<tr class="sabrinatrlight"><td align="center"><input type="hidden" name="saveid" value="<?php echo $reminderid ?>"><input type="hidden"name="oldremindertime" value="<?php echo $remindertime ?>"><input type="hidden" name="action" value="save"><input type="submit" value="SAVE"></form></td>
	<form action="autoresponder_reminders.php" method="post">
	<td align="center"><input type="hidden" name="deleteid" value="<?php echo $reminderid ?>"><input type="hidden" name="action" value="delete"><input type="submit" value="DELETE"></form></td></tr>
	</table>
	</td>
	</tr>

	<tr bgcolor="#ffffff"><td align="center" colspan="2"></td></tr>

	</table></td></tr>
	<?php
	} # while ($savedrowz = mysql_fetch_array($savedr))
?>
</table>
</td></tr>
<?php		
} # if ($savedrows > 0)
?>

<tr><td align="center" colspan="2"><br>&nbsp;</td></tr>

<tr><td align="center" colspan="2"><br>
<table width="600" cellpadding="4" cellspacing="2" border="0" align="center" class="sabrinatable">
<tr class="sabrinatrdark"><td align="center" colspan="2">CREATE NEW REMINDER</td></tr>
<form action="autoresponder_reminders.php" method="post">
	<tr class="sabrinatrlight"><td>Name:</td><td><input type="text" name="remindertitle" size="95" maxlength="255"></td></tr>
	<tr class="sabrinatrlight"><td>Enabled</td><td><select name="reminderenabled"><option value="yes">YES</option><option value="no">NO</option></select></td></tr>
	<tr class="sabrinatrlight"><td>Time to Send Reminder Email:</td><td><input id="remindertime" name="remindertime" type="text" size="25"><script>AnyTime.picker('remindertime');</script></td></tr>
	<tr class="sabrinatrlight"><td>How Often to Send Reminder Email (after reminder time has passed):</td>
	<td>
	Once Every&nbsp;
	<select name="reminderhowmanytimesinterval">
	<?php
		for($i=1;$i<=24;$i++)
		{
		?>
		<option value="<?php echo $i ?>"><?php echo $i ?></option>
		<?php
		}
	?>
	</select>&nbsp;Hours, for&nbsp;
	<select name="reminderhowmanytimes">
	<?php
		for($j=1;$j<=24;$j++)
		{
		?>
		<option value="<?php echo $j ?>"><?php echo $j ?></option>
		<?php
		}
	?>
	</select>&nbsp;Hours
	</td></tr>
	<tr class="sabrinatrlight"><td>Event Start Time (optional):</td><td><input id="remindereventstart" name="remindereventstart" type="text" size="25"><script>AnyTime.picker('remindereventstart');</script></td></tr>
	<tr class="sabrinatrlight"><td>Event End Time (optional):</td><td><input id="remindereventend" name="remindereventend" type="text" size="25"><script>AnyTime.picker('remindereventend');</script></td></tr>
	<tr class="sabrinatrlight"><td>URL:</td><td><input type="text" name="reminderurl" size="95" maxlength="255"></td></tr>
	<tr class="sabrinatrlight"><td>From Field:</td><td><input type="text" name="reminderfromfield" size="95" maxlength="255"></td></tr>
	<tr class="sabrinatrlight"><td>Subject:</td><td><input type="text" name="remindersubject" size="95" maxlength="255"></td></tr>
	<tr class="sabrinatrlight"><td valign="top">Message:</td><td><textarea class="ckeditor" name="remindermessage" rows="15" cols="95"></textarea></td></tr>
	<tr class="sabrinatrdark"><td align="center" colspan="2"><input type="hidden" name="action" value="new"><input type="submit" value="CREATE"></form></td></tr>
</table>
</td></tr>

<tr><td align="center" colspan="2"><br>&nbsp;</td></tr>

</table>
<br><br>
<?php
include "footer.php";
exit;
?>
