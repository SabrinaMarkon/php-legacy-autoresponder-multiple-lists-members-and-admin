<?php
include "control.php";
include "header.php";
$action = $_REQUEST["action"];
################################################################
if ($action == "saveautoresponder")
{
$saveid = $_POST["saveid"];
$saveautorespondertitle = $_POST["saveautorespondertitle"];
$saveautorespondertitle = addslashes($saveautorespondertitle);
$saveautoresponderfromemail = $_POST["saveautoresponderfromemail"];
$saveautoresponderfromfield = $_POST["saveautoresponderfromfield"];
$saveautoresponderfromfield = addslashes($saveautoresponderfromfield);
$saveemailclick_redirecturl = $_POST["saveemailclick_redirecturl"];
$saveautorespondersubject = $_POST["saveautorespondersubject"];
$saveautorespondersubject = addslashes($saveautorespondersubject);
$saveheaderbodyhtml = $_POST["saveheaderbodyhtml"];
$saveheaderbodyhtml = addslashes($saveheaderbodyhtml);
$saveautorespondermessagehtml = $_POST["saveautorespondermessagehtml"];
$saveautorespondermessagehtml = addslashes($saveautorespondermessagehtml);
$savedisclaimerbodyhtml = $_POST["savedisclaimerbodyhtml"];
$savedisclaimerbodyhtml = addslashes($savedisclaimerbodyhtml);
$saveheaderbodytext = $_POST["saveheaderbodytext"];
$saveheaderbodytext = addslashes($saveheaderbodytext);
$saveautorespondermessagetext = $_POST["saveautorespondermessagetext"];
$saveautorespondermessagetext = addslashes($saveautorespondermessagetext);
$savedisclaimerbodytext = $_POST["savedisclaimerbodytext"];
$savedisclaimerbodytext = addslashes($savedisclaimerbodytext);
$savelists = $_POST["savelists"];
$saveautoresponderdays = $_POST["saveautoresponderdays"];
$savenextlists  = $_POST["savenextlists"];
$saveautoresponderenabled = $_POST["saveautoresponderenabled"];
if (!$saveautorespondertitle)
{
$error .= "<li>Please return and enter a name for your autoresponder email or campaign.</li>";
}
if (!$saveautoresponderfromemail)
{
$error .= "<li>Please return and enter an email address that your autoresponder message will be sent from.</li>";
}
if (!$saveautoresponderfromfield)
{
$error .= "<li>Please return and enter your name or company name for the from field of your autoresponder email.</li>";
}
if (!$saveemailclick_redirecturl)
{
$error .= "<li>Please return and enter the click redirect URL for your autoresponder email. This is the website people will visit after clicking the tracking link at the bottom of your emails (you may include other urls in the message body too).</li>";
}
if (!$saveautorespondersubject)
{
$error .= "<li>Please return and enter the subject for your autoresponder email.</li>";
}
if (($saveautorespondermessagehtml == "") and ($saveautorespondermessagetext == ""))
{
$error .= "<li>Please return and enter a message body for your autoresponder email. You need at least ONE of either the HTML or Plain Text versions, but both are recommended for maximum compatibility with recipient email programs.</li>";
}
if (($saveautorespondermessagehtml == "") and ($savedisclaimerbodyhtml == ""))
{
$error .= "<li>You entered an HTML message body for your autoresponder, but left the HTML disclaimer blank.</li>";
}
if (($saveautorespondermessagetext == "") and ($savedisclaimerbodytext == ""))
{
$error .= "<li>You entered a Plain Text message body for your autoresponder, but left the Plain Text disclaimer blank.</li>";
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
if ($savelists != "")
	{
	$sendtolists = "";
	foreach ($savelists as $thislist)
		{
		$sendtolists = $sendtolists . "~" . $thislist;	
		}
	}

if ($savenextlists != "")
	{
	$nextliststosubscribeto = "";
	foreach ($savenextlists as $nextlist)
		{
		$nextliststosubscribeto = $nextliststosubscribeto . "~" . $nextlist;
		}
	}
$saveautorespondermessagehtml = str_replace("&Acirc;&#160;","",$saveautorespondermessagehtml);
$savedisclaimerbodyhtml = str_replace("&Acirc;&#160;","",$savedisclaimerbodyhtml);
$q = "update autoresponders set userid=\"$userid\",autorespondertitle=\"$saveautorespondertitle\",autoresponderfromemail=\"$saveautoresponderfromemail\",autoresponderfromfield=\"$saveautoresponderfromfield\",autorespondersubject=\"$saveautorespondersubject\",autorespondermessagehtml=\"$saveautorespondermessagehtml\",autorespondermessagetext=\"$saveautorespondermessagetext\",disclaimerbodyhtml=\"$savedisclaimerbodyhtml\",disclaimerbodytext=\"$savedisclaimerbodytext\",headerbodyhtml=\"$saveheaderbodyhtml\",headerbodytext=\"$saveheaderbodytext\",emailclick_redirecturl=\"$saveemailclick_redirecturl\",sendtoprospectlists=\"$sendtolists\",liststosubscribetoaftersendingthismessage=\"$nextliststosubscribeto\",autoresponderdays=\"$saveautoresponderdays\",autoresponderenabled=\"$saveautoresponderenabled\" where id=\"$saveid\"";
$r = mysql_query($q);
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">THE AUTORESPONDER MESSAGE WAS SAVED!</div></td></tr>
<tr><td align="center" colspan="2"><br><a href="autoresponder_campaigns.php">BACK TO AUTORESPONDER CAMPAIGNS</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "footer.php";
exit;
} # if ($action == "saveautoresponder")
################################################################
if ($action == "deleteautoresponder")
{
$deleteid = $_POST["deleteid"];
$q = "delete from autoresponders where id=\"$deleteid\"";
$r = mysql_query($q);
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">THE AUTORESPONDER EMAIL CAMPAIGN WAS DELETED</div></td></tr>
<tr><td align="center" colspan="2"><br><a href="autoresponder_campaigns.php">BACK TO AUTORESPONDER CAMPAIGNS</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "footer.php";
exit;
} # if ($action == "deleteautoresponder")
################################################################
?>
<!-- PAGE CONTENT //-->
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
<tr><td align="center" colspan="2"><br><div class="heading">YOUR AUTORESPONDER CAMPAIGNS</div></td></tr>

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
$q = "select * from pages where name='Members Area - Autoresponder Campaigns Page'";
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

<tr><td colspan="2" align="center">
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
<tr class="sabrinatrdark"><td colspan="2" align="center"><div class="heading">EXISTING AUTORESPONDER CAMPAIGNS</div></td></tr>
<?php
$pq = "select * from autoresponders_lists where userid=\"$userid\" order by listname";
$pr = mysql_query($pq);
$prows = mysql_num_rows($pr);
if ($prows < 1)
{
?>
<tr class="sabrinatrlight"><td align="center" colspan="2">You haven't created any mailing lists for prospects to join and receive AutoResponder emails.</td></tr>
<?php
}
if ($prows > 0)
{
$arq = "select * from autoresponders order by autorespondertitle";
$arr = mysql_query($arq);
$arrows = mysql_num_rows($arr);
if ($arrows < 1)
{
?>
<tr class="sabrinatrlight"><td align="center" colspan="2">You haven't created any AutoResponders yet.</td></tr>
<?php
}
if ($arrows > 0)
{
	while ($arrowz = mysql_fetch_array($arr))
	{
	$id = $arrowz["id"];
	$autorespondertitle = $arrowz["autorespondertitle"];
	$autorespondertitle = stripslashes($autorespondertitle);
	$autorespondertitle = str_replace('\\', '', $autorespondertitle);
	$headerbodyhtml = $arrowz["headerbodyhtml"];
	$headerbodyhtml = stripslashes($headerbodyhtml);
	$headerbodyhtml = str_replace('\\', '', $headerbodyhtml);
	$autorespondermessagehtml = $arrowz["autorespondermessagehtml"];
	$autorespondermessagehtml = stripslashes($autorespondermessagehtml);
	$autorespondermessagehtml = str_replace('\\', '', $autorespondermessagehtml);
	$disclaimerbodyhtml = $arrowz["disclaimerbodyhtml"];
	$disclaimerbodyhtml = stripslashes($disclaimerbodyhtml);
	$disclaimerbodyhtml = str_replace('\\', '', $disclaimerbodyhtml);
	$headerbodytext = $arrowz["headerbodytext"];
	$headerbodytext = stripslashes($headerbodytext);
	$headerbodytext = str_replace('\\', '', $headerbodytext);
	$autorespondermessagetext = $arrowz["autorespondermessagetext"];
	$autorespondermessagetext = stripslashes($autorespondermessagetext);
	$autorespondermessagetext = str_replace('\\', '', $autorespondermessagetext);
	$disclaimerbodytext = $arrowz["disclaimerbodytext"];
	$disclaimerbodytext = stripslashes($disclaimerbodytext);
	$disclaimerbodytext = str_replace('\\', '', $disclaimerbodytext);
	$autorespondersubject = $arrowz["autorespondersubject"];
	$autorespondersubject = stripslashes($autorespondersubject);
	$autorespondersubject = str_replace('\\', '', $autorespondersubject);
	$autoresponderfromemail = $arrowz["autoresponderfromemail"];
	$autoresponderfromfield = $arrowz["autoresponderfromfield"];
	$autoresponderfromfield = stripslashes($autoresponderfromfield);
	$autoresponderfromfield = str_replace('\\', '', $autoresponderfromfield);
	$autoresponderdays = $arrowz["autoresponderdays"];
	$liststosubscribetoaftersendingthismessage  = $arrowz["liststosubscribetoaftersendingthismessage"];
	$autoresponderenabled = $arrowz["autoresponderenabled"];
	$totalmailed = $arrowz["totalmailed"];
	$totalclicked = $arrowz["totalclicked"];
	$emailclick_redirecturl = $arrowz["emailclick_redirecturl"];
	$sendtoprospectlists = $arrowz["sendtoprospectlists"];
?>
<form action="autoresponder_campaigns.php" method="post">
<tr class="sabrinatrlight"><td>
<table cellpadding="2" cellspacing="2" border="0" width="100%">
<tr><td style="float:left;"><img src="<?php echo $domain ?>/images/open.png" class="showstate" onclick="expandcontent(this, 'sc<?php echo $id ?>')" width="20"></td>
<td>AutoResponder Campaign:</td></tr></table>
</td><td><input type="text" name="saveautorespondertitle" maxlength="255" size="95" value="<?php echo $autorespondertitle ?>"></td></tr>

<tr><td id="sc<?php echo $id ?>" class="switchcontent" style="display: none; width: 800px; padding: 0px;" colspan="2" style="border:0px;">
<table cellpadding="2" cellspacing="2" border="0" width="800" align="center">

<tr class="sabrinatrlight"><td>Enable:</td><td><select name="saveautoresponderenabled"><option value="yes" <?php if ($autoresponderenabled == "yes") { echo "selected"; } ?>>YES</option><option value="no" <?php if ($autoresponderenabled != "yes") { echo "selected"; } ?>>NO</option></select></td></tr>
<tr class="sabrinatrlight"><td>Total Emailed:</td><td><?php echo $totalmailed ?></td></tr>
<tr class="sabrinatrlight"><td>Total Clicked:</td><td><?php echo $totalclicked ?></td></tr>
<tr class="sabrinatrlight"><td>Email Address This AutoResponder is Sent From:</td><td><input type="text" name="saveautoresponderfromemail" maxlength="255" size="95" value="<?php echo $autoresponderfromemail ?>"></td></tr>
<tr class="sabrinatrlight"><td>Your Name that shows in the From Field:</td><td><input type="text" name="saveautoresponderfromfield" maxlength="255" size="95" value="<?php echo $autoresponderfromfield ?>"></td></tr>
<tr class="sabrinatrlight"><td>URL Prospects are Redirected to When Clicking the Bottom Tracking Link in your AutoResponder Email (you may include additional links in your message body too):</td><td><input type="text" name="saveemailclick_redirecturl" maxlength="255" size="95" value="<?php echo $emailclick_redirecturl ?>"></td></tr>
<tr class="sabrinatrlight"><td>Your AutoResponder Subject:</td><td><input type="text" name="saveautorespondersubject" maxlength="255" size="95" value="<?php echo $autorespondersubject ?>"></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your HTML Header:</td><td><textarea class="ckeditor" rows="10" cols="95" name="saveheaderbodyhtml"><?php echo $headerbodyhtml ?></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your AutoResponder HTML Message Body (CAREFUL not to mix up the HTML and Plain Text message body fields!):</td><td><textarea class="ckeditor" name="saveautorespondermessagehtml" rows="15" cols="95"><?php echo $autorespondermessagehtml ?></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your HTML Disclaimer (do NOT include a remove link because this is added automatically to the end of all the email):</td><td><textarea class="ckeditor" rows="10" cols="95" name="savedisclaimerbodyhtml"><?php echo $disclaimerbodyhtml ?></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your Plain Text Header:</td><td><textarea rows="10" cols="95" name="saveheaderbodytext"><?php echo $headerbodytext ?></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your AutoResponder Plain Text Message Body:</td><td><textarea name="saveautorespondermessagetext" rows="15" cols="95"><?php echo $autorespondermessagetext ?></textarea></td></tr>
<tr class="sabrinatrlight"><td valign="top">Your Plain Text Disclaimer (do NOT include a remove link because this is added automatically to the end of all the email):</td><td><textarea rows="10" cols="95" name="savedisclaimerbodytext"><?php echo $disclaimerbodytext ?></textarea></td></tr>
<tr class="sabrinatrlight"><td>Mailing Lists To Send To:</td></td><td>
<?php
$pq = "select * from autoresponders_lists where userid=\"$userid\" order by listname";
$pr = mysql_query($pq);
$prows = mysql_num_rows($pr);
$sendtoprospectlists_array = explode("~",$sendtoprospectlists);
while ($prowz = mysql_fetch_array($pr))
	{
	$prospectlistname = $prowz["listname"];
	if (in_array($prospectlistname, $sendtoprospectlists_array))
		{
		?>
		<input type="checkbox" name="savelists[]" value="<?php echo $prospectlistname ?>" checked> <?php echo $prospectlistname ?><br>
		<?php
		}
	else
		{
		?>
		<input type="checkbox" name="savelists[]" value="<?php echo $prospectlistname ?>"> <?php echo $prospectlistname ?><br>
		<?php
		}
	} # while ($prowz = mysql_fetch_array($pr))
?>
</td></tr>
<tr class="sabrinatrlight"><td>Send After How Many Days? (select 0 for immediately after signup!):</td><td>
<select name="saveautoresponderdays" class="pickone">
<?php
for($i=0;$i<=100;$i++)
{
?>
<option value="<?php echo $i ?>" <?php if ($i == $autoresponderdays) { echo "selected"; } ?>><?php echo $i ?></option>
<?php
}
?>
</select>
</td></tr>
<?php
$listsq2 = "select * from autoresponders_lists where userid=\"$userid\" order by listname";
$listsr2 = mysql_query($listsq2);
$listsrows2 = mysql_num_rows($listsr2);
if ($listsrows2 > 0)
	{
	?>
	<tr class="sabrinatrlight"><td>After being sent this AutoResponder email, auto-subscribe prospects in mailing lists that receive this message to mailing list(s):</td></td><td>
	<?php
		$autosubscribe_array = explode("~",$liststosubscribetoaftersendingthismessage);
		while ($listsrowz2 = mysql_fetch_array($listsr2))
		{
		$newid2 = $listsrowz2["id"];
		$newlistname2 = $listsrowz2["listname"];
		if (in_array($newlistname2, $autosubscribe_array))
			{
			?>
			<input type="checkbox" name="savenextlists[]" value="<?php echo $newlistname2 ?>" checked> <?php echo $newlistname2 ?><br>
			<?php
			}
		else
			{
			?>
			<input type="checkbox" name="savenextlists[]" value="<?php echo $newlistname2 ?>"> <?php echo $newlistname2 ?><br>
			<?php
			}
		}
	?>
	</td></tr>
	<?php
	} # if ($listsrows2 > 0)
?>

<tr class="sabrinatrdark">
<td align="center" colspan="2">
<table cellpadding="2" cellspacing="2" border="0" align="center" class="sabrinatable" width="100%">
<tr class="sabrinatrdark"><td align="center">SAVE</td><td align="center">DELETE</td></tr>
<tr class="sabrinatrlight"><td align="center">
<input type="hidden" name="action" value="saveautoresponder">
<input type="hidden" name="saveid" value="<?php echo $id ?>">
<input type="submit" value="SAVE">
</form>
</td>
<form method="POST" action="autoresponder_campaigns.php">
<td align="center">
<input type="hidden" name="action" value="deleteautoresponder">
<input type="hidden" name="deleteid" value="<?php echo $id ?>">
<input type="submit" value="DELETE">
</form>
</td>
</tr>
</table>
</td>
</tr>

<tr bgcolor="#ffffff"><td colspan="2" align="center"><br>&nbsp;</td></tr>

</table></td></tr>
<?php
	} # while ($arrowz = mysql_fetch_array($arr))
} # if ($arrows > 0)
} # if ($prows > 0)
?>
</table></td></tr>

<tr><td colspan="2"><br>&nbsp;</td></tr>

</table><br><br>&nbsp;
<!-- END PAGE CONTENT //-->
<?php
include "footer.php";
exit;
?>