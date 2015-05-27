<?php
include "control.php";
include "header.php";
function formatDate($val) {
	$arr = explode("-", $val);
	return date("M d Y", mktime(0,0,0, $arr[1], $arr[2], $arr[0]));
}
$action = $_POST["action"];
if ($accounttype == "PAID")
{
$ar_howmanylists = $ar_howmanylistspaid;
$ar_howmanyprospectsperlist = $ar_howmanyprospectsperlistpaid;
$ar_maxprospectsmailedperlist = $ar_maxprospectsmailedperlistpaid;
$ar_maxautoresponderemails = $ar_maxautoresponderemailspaid;
$ar_bouncestoautounsubscribe = $ar_bouncestoautounsubscribepaid;
}
if ($accounttype != "PAID")
{
$ar_howmanylists = $ar_howmanylistsfree;
$ar_howmanyprospectsperlist = $ar_howmanyprospectsperlistfree;
$ar_maxprospectsmailedperlist = $ar_maxprospectsmailedperlistfree;
$ar_maxautoresponderemails = $ar_maxautoresponderemailsfree;
$ar_bouncestoautounsubscribe = $ar_bouncestoautounsubscribefree;
}
################################################################
if ($action == "deletemailinglist")
{
	$deletelistid = $_POST["deletelistid"];
	$deletelistname = $_POST["deletelistname"];
	$changetolistname = $_POST["changetolistname"];
	$q1 = "update autoresponders_prospects set listname=\"$changetolistname\" where userid=\"$userid\" and listname=\"$deletelistname\"";
	$r1 = mysql_query($q1);
	$q2 = "delete from autoresponders_lists where userid=\"$userid\" and listname=\"$deletelistname\"";
	$r2 = mysql_query($q2);
	$q3 = "delete from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$deletelistid\"";
	$r3 = mysql_query($q3);
	?>
	<!-- PAGE CONTENT //-->
	<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
	<tr><td align="center" colspan="2"><br><div class="heading">Mailing List <?php echo $deletelistname ?> Was Deleted!</div></td></tr>
	<tr><td align="center" colspan="2"><br>All prospects that were in that mailing list were reassigned to the <?php echo $changetolistname ?> list instead.</td></tr>
	<tr><td align="center" colspan="2"><br><a href="autoresponder_mailinglists.php">BACK TO AUTORESPONDER MAILING LISTS</a></td></tr>
	</table>
	<!-- END PAGE CONTENT //-->
	<?php
	include "footer.php";
	exit;
} # if ($action == "deletemailinglist")
################################################################
if ($action == "savemailinglist")
{
	$oldlistname = $_POST["oldlistname"];
	$savelistid = $_POST["savelistid"];
	$savelistname = $_POST["savelistname"];
	$savesubmitform_redirecturl = $_POST["savesubmitform_redirecturl"];
	$saveverification_redirecturl = $_POST["saveverification_redirecturl"];
	$saveverificationheaderbodyhtml = $_POST["saveverificationheaderbodyhtml"];
	$saveverificationheaderbodyhtml = addslashes($saveverificationheaderbodyhtml);
	$saveverificationheaderbodytext = $_POST["saveverificationheaderbodytext"];
	$saveverificationheaderbodytext = addslashes($saveverificationheaderbodytext);
	$saveverificationmessagehtml = $_POST["saveverificationmessagehtml"];
	$saveverificationmessagehtml = addslashes($saveverificationmessagehtml);
	$saveverificationmessagetext = $_POST["saveverificationmessagetext"];
	$saveverificationmessagetext = addslashes($saveverificationmessagetext);
	$saveverificationsubject = $_POST["saveverificationsubject"];
	$saveverificationsubject = addslashes($saveverificationsubject);
	$saveverificationfromfield = $_POST["saveverificationfromfield"];
	$saveverificationfromfield = addslashes($saveverificationfromfield);
	$saveverificationdisclaimerbodyhtml = $_POST["saveverificationdisclaimerbodyhtml"];
	$saveverificationdisclaimerbodyhtml = addslashes($saveverificationdisclaimerbodyhtml);
	$saveverificationdisclaimerbodytext = $_POST["saveverificationdisclaimerbodytext"];
	$saveverificationdisclaimerbodytext = addslashes($saveverificationdisclaimerbodytext);
	if(!$savelistname)
	{
	$error .= "<li>Please return and enter a name for the mailing list.</li>";
	}
	if(!$savesubmitform_redirecturl)
	{
	$error .= "<li>Please return and enter a URL to redirect prospects to after they submit your signup form.</li>";
	}
	if(!$saveverification_redirecturl)
	{
	$error .= "<li>Please return and enter a URL to redirect prospects to after they verify their email addresses.</li>";
	}
	if (!$saveverificationfromfield)
	{
	$error .= "<div>No from field name was entered for the verification email.</div>";
	}
	if (!$saveverificationsubject)
	{
	$error .= "<div>No subject was entered for the verification email.</div>";
	}
	if (($saveverificationmessagehtml == "") and ($saveverificationmessagetext == ""))
	{
	$error .= "<div>No message body was entered for the verification email.</div>";
	}
	if (($saveverificationmessagehtml != "") and ($saveverificationdisclaimerbodyhtml == ""))
	{
	$error .= "<div>You entered an HTML message body, but did not add an HTML disclaimer for the verification email.</div>";
	}
	if (($saveverificationmessagetext != "") and ($saveverificationdisclaimerbodytext == ""))
	{
	$error .= "<div>You entered a Plain Text message body, but did not add a Plain Text disclaimer for the verification email.</div>";
	}
	if ($savelistname != $oldlistname)
	{
	$dupq = "select * from autoresponders_lists where userid=\"$userid\" and listname=\"$savelistname\"";
	$dupr = mysql_query($dupq);
	$duprows = mysql_num_rows($dupr);
	if ($duprows > 0)
		{
		$error .= "<li>You already have a mailing list with the name " . $savelistname . ".</li>";
		}
	}
	if(!$error == "")
		{
		?>
		<!-- PAGE CONTENT //-->
		<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
		<tr><td align="center" colspan="2"><br><div class="heading">ERROR</div></td></tr>
		<tr><td colspan="2"><br>Please return to the form and correct the following problems:<br>
		<ul><?php echo $error ?></ul>
		</td></tr>
		<tr><td align="center" colspan="2"><br>
		<input type="button" value="Return To Form" onclick="javascript:history.back();" class="sendit">
		</td></tr>
		</table>
		<!-- END PAGE CONTENT //-->
		<?php
		include "footer.php";
		exit;
		}

		# system form fields
		$ar_firstname = $_POST["ar_firstname"];
		if ($ar_firstname == "yes")
			{
			$q1 = "delete from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$savelistid\" and fieldname=\"firstname\"";
			$r1 = mysql_query($q1);
			$q2 = "insert into autoresponder_userfields_forms (userid,listnameid,fieldname,type) values (\"$userid\",\"$savelistid\",\"firstname\",\"system\")";
			$r2 = mysql_query($q2);
			}
		if ($ar_firstname != "yes")
			{
			$q1 = "delete from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$savelistid\" and fieldname=\"firstname\"";
			$r1 = mysql_query($q1);
			}
		$ar_lastname = $_POST["ar_lastname"];
		if ($ar_lastname == "yes")
			{
			$q1 = "delete from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$savelistid\" and fieldname=\"lastname\"";
			$r1 = mysql_query($q1);
			$q2 = "insert into autoresponder_userfields_forms (userid,listnameid,fieldname,type) values (\"$userid\",\"$savelistid\",\"lastname\",\"system\")";
			$r2 = mysql_query($q2);
			}
		if ($ar_lastname != "yes")
			{
			$q1 = "delete from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$savelistid\" and fieldname=\"lastname\"";
			$r1 = mysql_query($q1);
			}
		$ar_email = $_POST["ar_email"];
		if ($ar_email == "yes")
			{
			$q1 = "delete from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$savelistid\" and fieldname=\"email\"";
			$r1 = mysql_query($q1);
			$q2 = "insert into autoresponder_userfields_forms (userid,listnameid,fieldname,type) values (\"$userid\",\"$savelistid\",\"email\",\"system\")";
			$r2 = mysql_query($q2);
			}
		if ($ar_email != "yes")
			{
			$q1 = "delete from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$savelistid\" and fieldname=\"email\"";
			$r1 = mysql_query($q1);
			}
		$ar_howfound = $_POST["ar_howfound"];
		if ($ar_howfound == "yes")
			{
			$q1 = "delete from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$savelistid\" and fieldname=\"howfound\"";
			$r1 = mysql_query($q1);
			$q2 = "insert into autoresponder_userfields_forms (userid,listnameid,fieldname,type) values (\"$userid\",\"$savelistid\",\"howfound\",\"system\")";
			$r2 = mysql_query($q2);
			}
		if ($ar_howfound != "yes")
			{
			$q1 = "delete from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$savelistid\" and fieldname=\"howfound\"";
			$r1 = mysql_query($q1);
			}
		# user custom form fields
		$auq = "select * from autoresponder_userfields where userid=\"$userid\" order by fieldname";
		$aur = mysql_query($auq);
		$aurows = mysql_num_rows($aur);
			if ($aurows > 0)
			{
				while ($aurowz = mysql_fetch_array($aur))
				{
				$au_fieldname = $aurowz["fieldname"];
				eval("\$au_fieldnamevalue = \$_POST[\"$au_fieldname\"];");
				$q1 = "delete from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$savelistid\" and fieldname=\"$au_fieldname\"";
				$r1 = mysql_query($q1);
				if ($au_fieldnamevalue == "yes")
					{
					$q2 = "insert into autoresponder_userfields_forms (userid,listnameid,fieldname,type) values (\"$userid\",\"$savelistid\",\"$au_fieldname\",\"member\")";
					$r2 = mysql_query($q2);				
					}
				} # while ($aurowz = mysql_fetch_array($aur))
			} # if ($aurows > 0)

	$q1 = "update autoresponders_lists set listname=\"$savelistname\",submitform_redirecturl=\"$savesubmitform_redirecturl\",verification_redirecturl=\"$saveverification_redirecturl\",verificationheaderbodyhtml=\"$saveverificationheaderbodyhtml\",verificationheaderbodytext=\"$saveverificationheaderbodytext\",verificationmessagehtml=\"$saveverificationmessagehtml\",verificationmessagetext=\"$saveverificationmessagetext\",verificationsubject=\"$saveverificationsubject\",verificationfromfield=\"$saveverificationfromfield\",verificationdisclaimerbodyhtml=\"$saveverificationdisclaimerbodyhtml\",verificationdisclaimerbodytext=\"$saveverificationdisclaimerbodytext\" where userid=\"$userid\" and listname=\"$oldlistname\"";
	$r1 = mysql_query($q1);
	$q2 = "update autoresponders_prospects set listname=\"$savelistname\" where userid=\"$userid\" and listname=\"$oldlistname\"";
	$r2 = mysql_query($q2);
	?>
	<!-- PAGE CONTENT //-->
	<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
	<tr><td align="center" colspan="2"><br><div class="heading">Mailing List <?php echo $savelistname ?> Was Saved!</div></td></tr>
	<tr><td align="center" colspan="2"><br><a href="autoresponder_mailinglists.php">BACK TO AUTORESPONDER MAILING LISTS</a></td></tr>
	</table>
	<!-- END PAGE CONTENT //-->
	<?php
	include "footer.php";
	exit;
} # if ($action == "savemailinglist")
################################################################
if ($action == "newcustomfield")
{
$newfieldname = $_POST["newfieldname"];
$newfieldtitle = $_POST["newfieldtitle"];
if (!$newfieldname)
{
$error .= "<li>Please return and enter a variable name for your new form field (alphabetical A-Z or a-z ONLY!). New prospects do not see this value.</li>";
}
if (!$newfieldtitle)
{
$error .= "<li>Please return and enter a short description for your new form field. This is the label for the form field that your prospects will see.</li>";
}
if (!ctype_alnum($newfieldname)) 
{
$error .= "<li>The variable name for your new form field must be alphanumeric characters ONLY. New prospects do not see this value.</li>";
}
if (!ctype_alpha($newfieldname[0]))
{
$error .= "<li>The FIRST character of your variable name for your new form field must be a letter (A-Z or a-z). New prospects do not see this value.</li>";
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
	include "footer.php";
	exit;
	}
$q = "insert into autoresponder_userfields (userid,fieldname,fieldtitle) values (\"$userid\",\"$newfieldname\",\"$newfieldtitle\")";
$r = mysql_query($q);
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">New Custom Signup Form Field Was Created!</div></td></tr>
<tr><td align="center" colspan="2"><br><a href="autoresponder_mailinglists.php">BACK TO AUTORESPONDER MAILING LISTS</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "footer.php";
exit;
} # if ($action == "newcustomfield")
################################################################
if ($action == "deletecustomfield")
{
$deletefieldid = $_POST["deletefieldid"];
$deletefieldname = $_POST["deletefieldname"];
$q1 = "delete from autoresponder_userfields where userid=\"$userid\" and id=\"$deletefieldid\"";
$r1 = mysql_query($q1);
$q2 = "delete from autoresponder_userfields_data where userid=\"$userid\" and fieldname=\"$deletefieldname\"";
$r2 = mysql_query($q2);
$q3 = "delete from autoresponder_userfields_forms where userid=\"$userid\" and fieldname=\"$deletefieldname\"";
$r3 = mysql_query($q3);
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">The Custom Field was Deleted</div></td></tr>
<tr><td align="center" colspan="2"><br><a href="autoresponder_mailinglists.php">BACK TO AUTORESPONDER MAILING LISTS</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "footer.php";
exit;
} # if ($action == "deletecustomfield")
################################################################
if ($action == "savecustomfield")
{
$savefieldid = $_POST["savefieldid"];
$savefieldname = $_POST["savefieldname"];
$oldfieldname = $_POST["oldfieldname"];
$savefieldtitle = $_POST["savefieldtitle"];
if (!$savefieldname)
{
$error .= "<li>Please return and enter a variable name for your form field (alphabetical A-Z or a-z ONLY!). New prospects do not see this value.</li>";
}
if (!$savefieldtitle)
{
$error .= "<li>Please return and enter a short description for your form field. This is the label for the form field that your prospects will see.</li>";
}
if (!ctype_alnum($savefieldname)) 
{
$error .= "<li>The variable name for your new form field must be alphanumeric characters ONLY. New prospects do not see this value.</li>";
}
if (!ctype_alpha($savefieldname[0]))
{
$error .= "<li>The FIRST character of your variable name for your new form field must be a letter (A-Z or a-z). New prospects do not see this value.</li>";
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
	include "footer.php";
	exit;
	}
$q1 = "update autoresponder_userfields set fieldname=\"$savefieldname\",fieldtitle=\"$savefieldtitle\" where userid=\"$userid\" and id=\"$savefieldid\"";
$r1 = mysql_query($q1);
$q2 = "update autoresponder_userfields_data set fieldname=\"$savefieldname\" where userid=\"$userid\" and fieldname=\"$oldfieldname\"";
$r2 = mysql_query($q2);
$q3 = "update autoresponder_userfields_forms set fieldname=\"$savefieldname\" where userid=\"$userid\" and fieldname=\"$oldfieldname\"";
$r3 = mysql_query($q3);
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">Your Custom Signup Form Field Was Saved!</div></td></tr>
<tr><td align="center" colspan="2"><br><a href="autoresponder_mailinglists.php">BACK TO AUTORESPONDER MAILING LISTS</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "footer.php";
exit;
} # if ($action == "savecustomfield")
################################################################
?>
<!-- PAGE CONTENT //-->
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
<script type="text/javascript" src="<?php echo $domain ?>/jscripts/jquery.js"></script>
<script type="text/javascript" src="<?php echo $domain ?>/jscripts/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo $domain ?>/jscripts/ckeditor4/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo $domain ?>/jscripts/ckeditor4/adapters/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $domain ?>/jscripts/jquery-ui.css"/>
<div id="previewdlg" title="Preview">
<div id="pvw">
</div>
</div>
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">YOUR AUTORESPONDER MAILING LISTS</div></td></tr>

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
$q = "select * from pages where name='Members Area - Autoresponder Mailing Lists Page'";
$r = mysql_query($q);
$rowz = mysql_fetch_array($r);
$htmlcode = $rowz["htmlcode"];
echo $htmlcode;
?>
</div>
</td></tr>
</table>
</td></tr>

<tr><td colspan="2"><br>&nbsp;</td></tr>

<tr><td align="center" colspan="2"><br>
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
<table width="800" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrdark"><td align="center" colspan="2">YOUR MAILING LISTS</td></tr>
<?php
$mlq = "select * from autoresponders_lists where userid=\"$userid\" order by listname";
$mlr = mysql_query($mlq);
$mlrows = mysql_num_rows($mlr);
if ($mlrows < 1)
{
	?>
	<tr class="sabrinatrdark"><td colspan="2">You haven't created any mailing list groups to organize your prospect list, so currently only have one default list for all prospects. Please create mailing list groups above.</td></tr>
	<?php
}
if ($mlrows > 0)
{
	while ($mlrowz = mysql_fetch_array($mlr))
	{
	$listid = $mlrowz["id"];
	$listname = $mlrowz["listname"];
	$submitform_redirecturl = $mlrowz["submitform_redirecturl"];
	$verification_redirecturl = $mlrowz["verification_redirecturl"];
	$verificationheaderbodyhtml = $mlrowz["verificationheaderbodyhtml"];
	$verificationheaderbodyhtml = stripslashes($verificationheaderbodyhtml);
	$verificationheaderbodyhtml = str_replace('\\', '', $verificationheaderbodyhtml); 
	$verificationheaderbodyhtml = htmlentities($verificationheaderbodyhtml, ENT_COMPAT, "ISO-8859-1");
	$verificationheaderbodytext = $mlrowz["verificationheaderbodytext"];
	$verificationheaderbodytext = stripslashes($verificationheaderbodytext);
	$verificationheaderbodytext = str_replace('\\', '', $verificationheaderbodytext); 
	$verificationmessagehtml = $mlrowz["verificationmessagehtml"];
	$verificationmessagehtml = stripslashes($verificationmessagehtml);
	$verificationmessagehtml = str_replace('\\', '', $verificationmessagehtml); 
	$verificationmessagehtml = htmlentities($verificationmessagehtml, ENT_COMPAT, "ISO-8859-1");
	$verificationmessagetext = $mlrowz["verificationmessagetext"];
	$verificationmessagetext = stripslashes($verificationmessagetext);
	$verificationmessagetext = str_replace('\\', '', $verificationmessagetext); 
	$verificationsubject = $mlrowz["verificationsubject"];
	$verificationsubject = stripslashes($verificationsubject);
	$verificationsubject = str_replace('\\', '', $verificationsubject); 
	$verificationfromfield = $mlrowz["verificationfromfield"];
	$verificationfromfield = stripslashes($verificationfromfield);
	$verificationfromfield = str_replace('\\', '', $verificationfromfield); 
	$verificationdisclaimerbodyhtml = $mlrowz["verificationdisclaimerbodyhtml"];
	$verificationdisclaimerbodyhtml = stripslashes($verificationdisclaimerbodyhtml);
	$verificationdisclaimerbodyhtml = str_replace('\\', '', $verificationdisclaimerbodyhtml); 
	$verificationdisclaimerbodyhtml = htmlentities($verificationdisclaimerbodyhtml, ENT_COMPAT, "ISO-8859-1");
	$verificationdisclaimerbodytext = $mlrowz["verificationdisclaimerbodytext"];
	$verificationdisclaimerbodytext = stripslashes($verificationdisclaimerbodytext);
	$verificationdisclaimerbodytext = str_replace('\\', '', $verificationdisclaimerbodytext); 

	$ar_firstnameq = "select * from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$listid\" and type=\"system\" and fieldname=\"firstname\"";
	$ar_firstnamer = mysql_query($ar_firstnameq);
	$ar_firstnamerows = mysql_num_rows($ar_firstnamer);
	if ($ar_firstnamerows > 0)
	{
	$ar_firstname = "yes";
	}
	if ($ar_firstnamerows < 1)
	{
	$ar_firstname = "no";
	}
	##
	$ar_lastnameq = "select * from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$listid\" and type=\"system\" and fieldname=\"lastname\"";
	$ar_lastnamer = mysql_query($ar_lastnameq);
	$ar_lastnamerows = mysql_num_rows($ar_lastnamer);
	if ($ar_lastnamerows > 0)
	{
	$ar_lastname = "yes";
	}
	if ($ar_lastnamerows < 1)
	{
	$ar_lastname = "no";
	}
	##
	$ar_emailq = "select * from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$listid\" and type=\"system\" and fieldname=\"email\"";
	$ar_emailr = mysql_query($ar_emailq);
	$ar_emailrows = mysql_num_rows($ar_emailr);
	if ($ar_emailrows > 0)
	{
	$ar_email = "yes";
	}
	if ($ar_emailrows < 1)
	{
	$ar_email = "no";
	}
	##
	$ar_howfoundq = "select * from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$listid\" and type=\"system\" and fieldname=\"howfound\"";
	$ar_howfoundr = mysql_query($ar_howfoundq);
	$ar_howfoundrows = mysql_num_rows($ar_howfoundr);
	if ($ar_howfoundrows > 0)
	{
	$ar_howfound = "yes";
	}
	if ($ar_howfoundrows < 1)
	{
	$ar_howfound = "no";
	}
	?>

<form action="autoresponder_mailinglists.php" method="post" name="theform<?php echo $listid ?>" id="theform<?php echo $listid ?>">
<tr class="sabrinatrlight"><td>
<table cellpadding="2" cellspacing="2" border="0" width="100%">
<tr><td style="float:left;"><img src="<?php echo $domain ?>/images/open.png" class="showstate" onclick="expandcontent(this, 'sc<?php echo $listid ?>')" width="20"></td>
<td>Mailing List Name:</td></tr></table>
</td><td><input type="text" name="savelistname" maxlength="255" size="95" value="<?php echo $listname ?>"></td></tr>

<tr><td id="sc<?php echo $listid ?>" class="switchcontent" style="display: none; width: 800px; padding: 0px;" colspan="2" style="border:0px;">
<table cellpadding="2" cellspacing="2" border="0" width="800" align="center">


<tr class="sabrinatrlight"><td>URL Prospects are Redirected to After Submitting your Subscribe Form:</td><td><input type="text" name="savesubmitform_redirecturl" maxlength="255" size="95" value="<?php echo $submitform_redirecturl ?>"></td></tr>
<tr class="sabrinatrlight">
<td valign="top">Fields for Mailing List's AutoResponder Signup Form Code:</td>
<td align="center">
HTML form code generated for this Mailing List may be copied and pasted into your HTML emails and web sites. Prospects who signup from your form code will be automatically joined to this Mailing List (and subscribed to all AutoResponders that send to it).<br>
<table cellpadding="2" cellspacing="2" border="0" class="sabrinatable" align="center" width="100%">
<tr class="sabrinatrdark"><td align="center">Field for Prospect to Enter</td><td align="center">Include in Form Code</td></tr>
<tr class="sabrinatrlight"><td>First Name:</td><td align="center"><select name="ar_firstname" id="ar_firstname"><option value="yes" <?php if ($ar_firstname == "yes") { echo "selected"; } ?>>YES</option><option value="no" <?php if ($ar_firstname != "yes") { echo "selected"; } ?>>NO</option></select></td></tr>
<tr class="sabrinatrlight"><td>Last Name:</td><td align="center"><select name="ar_lastname" id="ar_lastname"><option value="yes" <?php if ($ar_lastname == "yes") { echo "selected"; } ?>>YES</option><option value="no" <?php if ($ar_lastname != "yes") { echo "selected"; } ?>>NO</option></select></td></tr>
<tr class="sabrinatrlight"><td>Email:</td><td align="center">YES<input type="hidden" name="ar_email" id="ar_email" value="yes"></td></tr>
<tr class="sabrinatrlight"><td>How They Found Your Site:</td><td align="center"><select name="ar_howfound" id="ar_howfound"><option value="yes" <?php if ($ar_howfound == "yes") { echo "selected"; } ?>>YES</option><option value="no" <?php if ($ar_howfound != "yes") { echo "selected"; } ?>>NO</option></select></td></tr>
<?php
$auq = "select * from autoresponder_userfields where userid=\"$userid\" order by fieldname";
$aur = mysql_query($auq);
$aurows = mysql_num_rows($aur);
	if ($aurows > 0)
	{
		while ($aurowz = mysql_fetch_array($aur))
		{
		$au_fieldname = $aurowz["fieldname"];
		$au_fieldtitle = $aurowz["fieldtitle"];
		$au_fieldtitle = stripslashes($au_fieldtitle);
		$au_fieldtitle = str_replace('\\', '', $au_fieldtitle);
		$aufq = "select * from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$listid\" and fieldname=\"$au_fieldname\"";
		$aufr = mysql_query($aufq);
		$aufrows = mysql_num_rows($aufr);
		if ($aufrows > 0)
			{
			?>
			<tr class="sabrinatrlight"><td><?php echo $au_fieldtitle ?>:</td><td align="center"><select name="<?php echo $au_fieldname ?>" id="<?php echo $au_fieldname ?>"><option value="yes" selected>YES</option><option value="no">NO</option></select></td></tr>
			<?php
			}
		if ($aufrows < 1)
			{
			?>
			<tr class="sabrinatrlight"><td><?php echo $au_fieldtitle ?>:</td><td align="center"><select name="<?php echo $au_fieldname ?>" id="<?php echo $au_fieldname ?>"><option value="yes">YES</option><option value="no" selected>NO</option></select></td></tr>
			<?php
			}
		} # while ($aurowz = mysql_fetch_array($aur))
	} # if ($aurows > 0)
?>
</table>
</td>
</tr>
<?php
$varq = "select * from autoresponder_substitution_variables where userid=\"$userid\" or variabletype=\"system\" order by variabletype";
$varr = mysql_query($varq);
$varrows = mysql_num_rows($varr);
if ($varrows > 0)
{
?>
<tr class="sabrinatrlight"><td valign="top">Substitution Variables for your Prospects' Verification Emails:</td><td>
<table border="0" cellpadding="2" cellspacing="2" align="center" class="sabrinatable" width="100%">
<tr class="sabrinatrdark"><td align="center">Type Exactly as Shown</td><td align="center">Substitutes</td><td align="center">Type</td></tr>
<?php
	while ($varrowz = mysql_fetch_array($varr))
	{
	$variabletype = $varrowz["variabletype"];
	$variablename = $varrowz["variablename"];
	$variablevalue = $varrowz["variablevalue"];
	$variabledescription = $varrowz["variabledescription"];
	$variabledescription = stripslashes($variabledescription);
	$variabledescription = str_replace('\\', '', $variabledescription);
	if ($variabletype == "system")
		{
		$showvariablevalue = $variabledescription;
		$showtype = "System";
		}
	if ($variabletype != "system")
		{
		$showvariablevalue = $variablevalue;
		$showtype = "Created by You";
		}
	?>
	<tr class="sabrinatrlight"><td><?php echo $variablename ?></td><td><?php echo $showvariablevalue ?></td><td><?php echo $showtype ?></td></td>
	<?php
	}
?>
</table>
</td>
</tr>
<?php
}
?>
<tr class="sabrinatrlight"><td>URL Prospects are Redirected to After Verifying their Email Addresses:</td><td><input type="text" name="saveverification_redirecturl" maxlength="255" size="95" value="<?php echo $verification_redirecturl ?>"></td></tr>
<tr class="sabrinatrlight"><td>Your Name that shows in the From Field of your Verification Email:</td><td><input type="text" name="saveverificationfromfield" maxlength="255" size="95" value="<?php echo $verificationfromfield ?>"></td></tr>
<tr class="sabrinatrlight"><td>Your Verification Email Subject:</td><td><input type="text" name="saveverificationsubject" maxlength="255" size="95" value="<?php echo $verificationsubject ?>"></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your Verification Email HTML Header:</td><td><textarea class="ckeditor" rows="10" cols="95" name="saveverificationheaderbodyhtml"><?php echo $verificationheaderbodyhtml ?></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your Verification Email HTML Message Body (CAREFUL not to mix up the HTML and Plain Text message body fields!):</td><td><textarea class="ckeditor" name="saveverificationmessagehtml" rows="15" cols="95"><?php echo $verificationmessagehtml ?></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your Verification Email HTML Disclaimer (do NOT include a remove link because this is added automatically to the end of all the email):</td><td><textarea class="ckeditor" rows="10" cols="95" name="saveverificationdisclaimerbodyhtml"><?php echo $verificationdisclaimerbodyhtml ?></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your Verification Email PlainText Header:</td><td><textarea rows="10" cols="95" name="saveverificationheaderbodytext"><?php echo $verificationheaderbodytext ?></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your Verification Email PlainText Message Body:</td><td><textarea name="saveverificationmessagetext" rows="15" cols="95"><?php echo $verificationmessagetext ?></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your Verification Email PlainText Disclaimer (do NOT include a remove link because this is added automatically to the end of all the email):</td><td><textarea rows="10" cols="95" name="saveverificationdisclaimerbodytext"><?php echo $verificationdisclaimerbodytext ?></textarea></td></tr>
<!-- HTML for subscribe form for this mailing list -->
<tr class="sabrinatrlight"><td valign="top">Mailing List AutoResponder Form Code To Copy and Paste Into Your Pages and Emails:</td><td>
	<?php
	$ar_htmlformcode = "<div style=\"font-family:'Tahoma',sans-serif;font-size:12px;\">";
	$ar_htmlformcode .= "<form action=\"" . $domain . "/ar_submit.php\" method=\"post\">";
	# system fields.
	if ($ar_firstname == "yes")
		{
		$ar_htmlformcode .= "<p align=\"center\" >Your First Name: <input type=\"text\" name=\"firstname\"></p>";
		}
	if ($ar_firstname == "yes")
		{
		$ar_htmlformcode .= "<p align=\"center\" >Your Last Name: <input type=\"text\" name=\"lastname\"></p>";
		}
	if ($ar_email == "yes")
		{
		$ar_htmlformcode .= "<p align=\"center\" >Your Email Address: <input type=\"text\" name=\"email\"></p>";
		}
	if ($ar_howfound == "yes")
		{
		$ar_htmlformcode .= "<p align=\"center\" >Please Tell Us How You Found Us: <input type=\"text\" name=\"howfound\"></p>";
		}
	# user custom fields.
	$cusq = "select * from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$listid\" and type!=\"system\" order by fieldname"; 
	$cusr = mysql_query($cusq);
	$cusrows = mysql_num_rows($cusr);
	if ($cusrows > 0)
		{
		while ($cusrowz = mysql_fetch_array($cusr))
			{
			$custom_fieldname = $cusrowz["fieldname"];
			$cusq2 = "select * from autoresponder_userfields where userid=\"$userid\" and fieldname=\"$custom_fieldname\"";
			$cusr2 = mysql_query($cusq2);
			$cusrows2 = mysql_num_rows($cusr2);
			if ($cusrows2 > 0)
				{
				$custom_fieldtitle = mysql_result($cusr2,0,"fieldtitle");
				$ar_htmlformcode .= "<p align=\"center\" >" . $custom_fieldtitle . ": <input type=\"text\" name=\"" . $custom_fieldname . "\"></p>";
				}
			}
		} # if ($cusrows > 0)
	$ar_htmlformcode .= "<p align=\"center\" ><input type=\"hidden\" name=\"listid\" value=\"" . $listid . "\"><input type=\"submit\" value=\"Subscribe\"></p>";
	$ar_htmlformcode .= "</form></div>";
	?>
	<textarea rows="10" cols="90" name="formcode<?php echo $listid ?>" id="formcode<?php echo $listid ?>"><?php echo $ar_htmlformcode; ?></textarea><br>
	<center><a href="javascript: HighlightAll('theform<?php echo $listid ?>.formcode<?php echo $listid ?>')">copy all form code</a></center>
</td></tr>

<tr class="sabrinatrlight"><td valign="top">Active Verified Prospects In this Mailing List:<br>(does not include unverified, unsubscribed prospects, or those who have bounced so often they are on vacation. This is your "clean" mailing list.)</td><td>
<div style="width:98%;height: 250px; padding: 4px; overflow:auto; border-style: solid; border-size: 1px; border-color: #000000; background:#ffffff;">
<?php
$mlpq = "select * from autoresponders_prospects where userid=\"$userid\" and listname=\"$listname\" and verified=\"yes\" and vacation!=\"yes\" and unsubscribed!=\"yes\" order by email";
$mlpr = mysql_query($mlpq);
$mlprows = mysql_num_rows($mlpr);
if ($mlprows < 1)
	{
	?>
	There are no active verified prospects in this mailing list. 
	<?php
	}
if ($mlprows > 0)
	{
	?>
	<table cellpadding="2" cellspacing="2" border="0" width="100%" align="center" class="sabrinatable">
	<tr class="sabrinatrdark"><td align="center">Email</td><td align="center">Name</td><td align="center">Signed Up</td></tr>
	<?php
	$p_background = 0;
	while ($mlprowz = mysql_fetch_array($mlpr))
		{
		$p_email = $mlprowz["email"];
		$p_firstname = $mlprowz["firstname"];
		$p_lastname = $mlprowz["lastname"];
		$p_fullname = $p_firstname . " " . $p_lastname;
		$p_signupdate = $mlprowz["signupdate"];
		if (($p_signupdate == 0) or ($p_signupdate == "0000-00-00 00:00:00") or ($p_signupdate == ""))
		{
		$show_p_signupdate = "Not Recorded";
		}
		else
		{
		$show_p_signupdate = formatDate($p_signupdate);
		}
		if ($p_background == 0)
			{
			$p_bg = "#eeeeee";
			}
		if ($p_background != 0)
			{
			$p_bg = "#d3d3d3";
			}
		?>
		<tr bgcolor="<?php echo $p_bg ?>"><td><a href="mailto:<?php echo $p_email ?>"><?php echo $p_email ?></td><td><?php echo $p_fullname ?></td><td><?php echo $show_p_signupdate ?></td></tr>
		<?php
		if ($p_bg == "#eeeeee")
			{
			$p_background = 1;
			}
		if ($p_bg != "#d3d3d3")
			{
			$p_background = 0;
			}
		} # while ($mlprowz = mysql_fetch_array($mlpr))
	?>
	</table>
	<?php
	} # if ($mlprows > 0)
?>
</div>
</td></tr>

<tr class="sabrinatrdark">
	<td align="center" colspan="2">
	<table cellpadding="2" cellspacing="2" border="0" align="center" class="sabrinatable" width="100%">
	<tr class="sabrinatrdark"><td align="center">SAVE</td><td align="center">DELETE</td></tr>
	<tr class="sabrinatrlight"><td align="center">
	<input type="hidden" name="savelistid" value="<?php echo $listid ?>">
	<input type="hidden" name="oldlistname" value="<?php echo $listname ?>">
	<input type="hidden" name="action" value="savemailinglist">
	<input type="submit" value="SAVE" style="width:150px;"></form>
	</td>
	<form action="autoresponder_mailinglists.php" method="post">
	<td align="center">
	<?php
	$changeq = "select * from autoresponders_lists where userid=\"$userid\" and listname!=\"$listname\" order by listname";
	$changer = mysql_query($changeq);
	$changerows = mysql_num_rows($changer);
	if ($changerows < 1)
		{
		?>
		You cannot delete your only mailing list (default)
		<?php
		}
	if ($changerows > 0)
		{
		?>
		Change List For Existing Members To:&nbsp;
		<select name="changetolistname">
		<?php
		while ($changerowz = mysql_fetch_array($changer))
			{
			$changetoname = $changerowz["listname"];
			?>
			<option value="<?php echo $changetoname ?>"><?php echo $changetoname ?></option>
			<?php
			} # while ($changerowz = mysql_fetch_array($changer))
		?>
		</select>&nbsp;
		<input type="hidden" name="deletelistid" value="<?php echo $listid ?>">
		<input type="hidden" name="deletelistname" value="<?php echo $listname ?>">
		<input type="hidden" name="action" value="deletemailinglist">
		<input type="submit" value="DELETE" style="width:150px;"></form>
		<?php
		} # if ($changerows > 0)
	?>
	</td></tr>
	</table>
	</td>
</tr>

<tr bgcolor="#ffffff"><td align="center" colspan="2"><br>&nbsp;</td></tr>

</table></td></tr>
<?php
	} # while ($mlrowz = mysql_fetch_array($mlr))
} # if ($mlrows > 0)
?>
</table>
</td></tr>

<tr><td colspan="2"><br>&nbsp;</td></tr>





</table><br><br>&nbsp;
<!-- END PAGE CONTENT //-->
<?php
include "footer.php";
exit;
?>