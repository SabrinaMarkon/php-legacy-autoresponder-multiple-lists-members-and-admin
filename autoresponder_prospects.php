<?php
include "control.php";
include "header.php";
function formatDate($val) {
	$arr = explode("-", $val);
	return date("M d Y", mktime(0,0,0, $arr[1], $arr[2], $arr[0]));
}
function unique_id($l = 8)
{
$better_token = md5(uniqid(rand(), true));
$rem = strlen($better_token)-$l;
$unique_code = substr($better_token, 0, -$rem);
$uniqueid = $unique_code;
return $uniqueid;
}
$action = $_REQUEST["action"];
$searchfor = $_REQUEST["searchfor"];
$searchby = $_REQUEST["searchby"];
$orderedby = $_REQUEST["orderedby"];
if ($orderedby == "listname")
{
$orderedbyq = "listname";
}
elseif ($orderedby == "firstname")
{
$orderedbyq = "firstname";
}
elseif ($orderedby == "lastname")
{
$orderedbyq = "lastname";
}
elseif ($orderedby == "email")
{
$orderedbyq = "email";
}
elseif ($orderedby == "signupip")
{
$orderedbyq = "signupip";
}
elseif ($orderedby == "signupdate")
{
$orderedbyq = "signupdate desc";
}
elseif ($orderedby == "howfound")
{
$orderedbyq = "howfound";
}
elseif ($orderedby == "referringpage")
{
$orderedbyq = "referringpage";
}
elseif ($orderedby == "howmanydays")
{
$orderedbyq = "howmanydays";
}
elseif ($orderedby == "verified")
{
$orderedbyq = "verified desc";
}
elseif ($orderedby == "verifieddate")
{
$orderedbyq = "verifieddate desc";
}
elseif ($orderedby == "verifiedip")
{
$orderedbyq = "verifiedip";
}
elseif ($orderedby == "bounces")
{
$orderedbyq = "bounces desc";
}
elseif ($orderedby == "bouncelastdate")
{
$orderedbyq = "bouncelastdate desc";
}
elseif ($orderedby == "bouncelasterror")
{
$orderedbyq = "bouncelasterror";
}
elseif ($orderedby == "vacation")
{
$orderedbyq = "vacation desc";
}
elseif ($orderedby == "vacationdate")
{
$orderedbyq = "vacationdate desc";
}
elseif ($orderedby == "unsubscribed")
{
$orderedbyq = "unsubscribed desc";
}
elseif ($orderedby == "unsubscribedate")
{
$orderedbyq = "unsubscribedate desc";
}
else
{
$orderedbyq = "listname,email";
}
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
<tr><td align="center" colspan="2"><br><a href="autoresponder_prospects.php?orderedby=<?php echo $orderedby ?>&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">BACK TO YOUR PROSPECT LIST</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "footer.php";
exit;
} # if ($action == "delete")
####################################################################
if ($action == "save")
{
$saveid = $_POST["saveid"];
$savelistname = $_POST["savelistname"];
$saveemail = $_POST["saveemail"];
$savefirstname = $_POST["savefirstname"];
$savelastname = $_POST["savelastname"];
$savesignupip = $_POST["savesignupip"];
$savehowfound = $_POST["savehowfound"];
$savereferringpage = $_POST["savereferringpage"];
$savehowmanydays = $_POST["savehowmanydays"];
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
	include "footer.php";
	exit;
	}
$customq = "select * from autoresponder_userfields where userid=\"$userid\" order by fieldname";
$customr = mysql_query($customq);
$customrows = mysql_num_rows($customr);
if ($customrows > 0)
	{
	while ($customrowz = mysql_fetch_array($customr))
		{
		$customfieldname = $customrowz["fieldname"];
		eval("\$customfieldnamevalue = \$_POST[\"$customfieldname\"];");
		$customq2 = "select * from autoresponder_userfields_data where fieldname=\"$customfieldname\" and userid=\"$userid\" and prospectid=\"$saveid\"";
		$customr2 = mysql_query($customq2);
		$customrows2 = mysql_num_rows($customr2);
		if ($customrows2 > 0)
			{
			$customq3 = "update autoresponder_userfields_data set fieldvalue=\"$customfieldnamevalue\" where fieldname=\"$customfieldname\" and userid=\"$userid\" and prospectid=\"$saveid\"";
			$customr3 = mysql_query($customq3);
			}
		if ($customrows2 < 1)
			{
			$customq3 = "insert into autoresponder_userfields_data (userid,prospectid,fieldname,fieldvalue) values (\"$userid\",\"$saveid\",\"$customfieldname\",\"$customfieldnamevalue\")";
			$customr3 = mysql_query($customq3);
			}		
		} # while ($customrowz = mysql_fetch_array($customr))
	} # if ($customrows > 0)
$q = "update autoresponders_prospects set listname=\"$savelistname\",email=\"$saveemail\",firstname=\"$savefirstname\",lastname=\"$savelastname\",signupip=\"$savesignupip\",howfound=\"$savehowfound\",referringpage=\"$savereferringpage\",howmanydays=\"$savehowmanydays\",verified=\"$saveverified\",verifiedip=\"$saveverifiedip\",bounces=\"$savebounces\",bouncelasterror=\"$savebouncelasterror\",vacation=\"$savevacation\",unsubscribed=\"$saveunsubscribed\" where id=\"$saveid\"";
$r = mysql_query($q);
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">Prospect ID <?php echo $saveid ?> With Email <?php echo $saveemail ?> Was Saved</div></td></tr>
<tr><td align="center" colspan="2"><br><a href="autoresponder_prospects.php?orderedby=<?php echo $orderedby ?>&searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>">BACK TO YOUR PROSPECT LIST</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "footer.php";
exit;
} # if ($action == "save")
####################################################################
if ($action == "sortsearchresultsintomailinglist")
{
$mailinglisttoputinto = $_POST["mailinglisttoputinto"];
$keepcurrentmailinglist = $_POST["keepcurrentmailinglist"];
$sortsearchby_array = explode("|",$searchby);
$sortsearchbyvar = $sortsearchby_array[0];
$sortsearchbytype = $sortsearchby_array[1];
	if ($searchfor != "")
	{
		if ($sortsearchbytype == "system")
		{
		$sortq = "select * from autoresponders_prospects where $sortsearchbyvar like \"%$searchfor%\" and userid=\"$userid\" order by $orderedbyq";
		$sortr = mysql_query($sortq);
		$sortrows = mysql_num_rows($sortr);
		}
		if ($sortsearchbytype != "system")
		{
		$sortprospects_to_get = "";
		$sortpreq = "select * from autoresponder_userfields_data where fieldname=\"$sortsearchbyvar\" and fieldvalue like \"%$searchfor%\" and userid=\"$userid\" order by id";
		$sortprer = mysql_query($sortpreq);
		while ($sortprerowz = mysql_fetch_array($sortprer))
			{
			$sortprospectid = $sortprerowz["prospectid"];
			$sortprospects_to_get = $sortprospects_to_get . "id=\"$sortprospectid\" or ";
			}
			$sortprospects_to_get = substr($sortprospects_to_get, 0, -3);
				if ($sortprospects_to_get != "")
				{
				$sortprospects_to_get = " and (" . $sortprospects_to_get . ")";
				$sortq = "select * from autoresponders_prospects where userid=\"$userid\" $sortprospects_to_get order by $orderedbyq";
				$sortr = mysql_query($sortq);
				$sortrows = mysql_num_rows($sortr);
				}
				if ($sortprospects_to_get == "")
				{
				$sortprospects_to_get = "";
				$sortrows = 0;
				}
		} # if ($sortsearchbytype != "system")
	} # if ($searchfor != "")
	if ($searchfor == "")
	{
	$sortq = "select * from autoresponders_prospects where userid=\"$userid\" order by $orderedbyq";
	$sortr = mysql_query($sortq);
	$sortrows = mysql_num_rows($sortr);
	}
	###
	while ($sortrowz = mysql_fetch_array($sortr))
	{
	$sortid = $sortrowz["id"];
	$sortlistname = $rowz["listname"];
	$sortfirstname = $rowz["firstname"];
	$sortlastname = $rowz["lastname"];
	$sortemail = $rowz["email"];
	$sorthowfound = $rowz["howfound"];
	$sortreferringpage = $rowz["referringpage"];
	$sorthowmanydays = $rowz["howmanydays"];
	$sortsignupdate = $rowz["signupdate"];
	$sortsignupip = $rowz["signupip"];
	$sortverified = $rowz["verified"];
	$sortverifieddate = $rowz["verifieddate"];
	$sortverifiedip = $rowz["verifiedip"];
	$sortbounces = $rowz["bounces"];
	$sortbouncelastdate = $rowz["bouncelastdate"];
	$sortbouncelasterror = $rowz["bouncelasterror"];
	$sortbouncelasterror = stripslashes($sortbouncelasterror);
	$sortbouncelasterror = str_replace('\\', '', $sortbouncelasterror);
	$sortvacation = $rowz["vacation"];
	$sortvacationdate = $rowz["vacationdate"];
	$sortunsubscribed = $rowz["unsubscribed"];
	$sortunsubscribedate = $rowz["unsubscribedate"];
	# insert into new list
		$verifiedcode = unique_id();
		$pidq = "select * from autoresponders_prospects order by id desc limit 1";
		$pidr = mysql_query($pidq);
		$pidrows = mysql_num_rows($pidr);
		if ($pidrows > 0)
		{
		$lastid = mysql_result($pidr,0,"id");
		$newid = $lastid+1;
		}
		if ($pidrows < 1)
		{
		$newid = 1;
		}
		$sortbouncelasterror = addslashes($sortbouncelasterror);
		$prospectq = "insert into autoresponders_prospects (id,userid,firstname,lastname,email,howfound,referringpage,howmanydays,signupdate,signupip,listname,verifiedcode,verified,verifiedip,verifieddate,bounces,bouncelastdate,bouncelasterror,vacation,vacationdate,unsubscribed,unsubscribedate) values (\"$newid\",\"$userid\",\"$sortfirstname\",\"$sortlastname\",\"$sortemail\",\"$sorthowfound\",\"$sortreferringpage\",\"0\",NOW(),\"$sortsignupip\",\"$mailinglisttoputinto\",\"$verifiedcode\",\"$sortverified\",\"$sortverifiedip\",\"$sortverifieddate\",\"$sortbounces\",\"$sortbouncelastdate\",\"$sortbouncelasterror\",\"$sortvacation\",\"$sortvacationdate\",\"$sortunsubscribed\",\"$sortunsubscribedate\")";
		$prospectr = mysql_query($prospectq) or die(mysql_error());
		## SAVE CUSTOM USER FIELD DATA
		$listidq = "select * from autoresponders_lists where userid=\"$userid\" and listname=\"$mailinglisttoputinto\"";
		$listidr = mysql_query($listidq);
		$listidrows = mysql_num_rows($listidr);
		if ($listidrows > 0)
			{
			$nextlistid = mysql_result($listidr,0,"id");
				$cq2 = "select * from autoresponder_userfields_forms where userid=\"$userid\" and listnameid=\"$nextlistid\" order by fieldname";
				$cr2 = mysql_query($cq2);
				$crows2 = mysql_num_rows($cr2);
				if ($crows2 > 0)
				{
					while ($crowz2 = mysql_fetch_array($cr2))
					{
						$cfieldname = $crowz2["fieldname"];
						$ctype = $crowz2["type"];
						$cq3 = "select * from autoresponder_userfields_data where userid=\"$userid\" and prospectid=\"$sortid\" and fieldname=\"$cfieldname\"";
						$cr3 = mysql_query($cq3);
						$crrows3 = mysql_num_rows($cr3);
						if ($crrows3 > 0)
						{
							$cfieldnamevalue = mysql_result($cr3,0,"fieldvalue");
							if (($cfieldnamevalue != "") and ($ctype != "system"))
							{
								$cq3 = "insert into autoresponder_userfields_data (userid,prospectid,fieldname,fieldvalue) values (\"$userid\",\"$newid\",\"$cfieldname\",\"$cfieldnamevalue\")";
								$cr3 = mysql_query($cq3);
							} # if (($cfieldnamevalue != "") and ($ctype != "system"))
						}
					} # while ($crowz2 = mysql_fetch_array($cr2))
				} # if ($crows2 > 0)
			} # if ($listidrows > 0)	
	if ($keepcurrentmailinglist != "yes")
		{
		# delete all lists and custom user fields except ones for this new list the prospect is assigned to now.
		$delq1 = "delete from autoresponders_prospects where userid=\"$userid\" and email=\"$email\" and listname!=\"$mailinglisttoputinto\"";
		$delr1 = mysql_query($delq1);
		$delq2 = "delete from autoresponder_userfields_data where userid=\"$userid\" and prospectid!=\"$newid\"";
		$delr2 = mysql_query($delq2);
		} # if ($keepcurrentmailinglist != "yes")
	} # while ($sortrowz = mysql_fetch_array($sortr))
?>
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center">
<tr><td align="center" colspan="2"><br><div class="heading">Prospects Matching Search Results Were Put Into the <?php echo $mailinglisttoputinto ?> Mailing List</div></td></tr>
<tr><td align="center" colspan="2"><br><a href="autoresponder_prospects.php?orderedby=<?php echo $orderedby ?>">BACK TO YOUR PROSPECT LIST</a></td></tr>
</table>
<!-- END PAGE CONTENT //-->
<?php
include "footer.php";
exit;
} # if ($action == "sortsearchresultsintomailinglist")
####################################################################
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
<!-- PAGE CONTENT //-->
<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">

<tr><td align="center" colspan="2"><br><div class="heading">YOUR AUTORESPONDER PROSPECTS</div></td></tr>

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
$htmlq = "select * from pages where name='Members Area - Autoresponder Prospects Page'";
$htmlr = mysql_query($htmlq);
$htmlrowz = mysql_fetch_array($htmlr);
$htmlcode = $htmlrowz["htmlcode"];
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
$searchby_array = explode("|",$searchby);
$searchbyvar = $searchby_array[0];
$searchbytype = $searchby_array[1];
if ($searchfor != "")
{
	if ($searchbytype == "system")
	{
	$q = "select * from autoresponders_prospects where $searchbyvar like \"%$searchfor%\" and userid=\"$userid\" order by $orderedbyq";
	$r = mysql_query($q);
	$rows = mysql_num_rows($r);
	}
	if ($searchbytype != "system")
	{
	$prospects_to_get = "";
	$preq = "select * from autoresponder_userfields_data where fieldname=\"$searchbyvar\" and fieldvalue like \"%$searchfor%\" and userid=\"$userid\" order by id";
	$prer = mysql_query($preq);
	while ($prerowz = mysql_fetch_array($prer))
		{
		$prospectid = $prerowz["prospectid"];
		$prospects_to_get = $prospects_to_get . "id=\"$prospectid\" or ";
		}
		$prospects_to_get = substr($prospects_to_get, 0, -3);
			if ($prospects_to_get != "")
			{
			$prospects_to_get = " and (" . $prospects_to_get . ")";
			$q = "select * from autoresponders_prospects where userid=\"$userid\" $prospects_to_get order by $orderedbyq";
			$r = mysql_query($q);
			$rows = mysql_num_rows($r);
			}
			if ($prospects_to_get == "")
			{
			$prospects_to_get = "";
			$rows = 0;
			}
	} # if ($searchbytype != "system")
} # if ($searchfor != "")
if ($searchfor == "")
{
$q = "select * from autoresponders_prospects where userid=\"$userid\" order by $orderedbyq";
$r = mysql_query($q);
$rows = mysql_num_rows($r);
}

if ($rows < 1)
{
	if ($searchfor == "")
	{
	echo "Sorry, you don't have any verified signups to your AutoResponder mailing lists yet.";
	}
	if ($searchfor != "")
	{
	echo "No search results found.<br><br><a href=\"autoresponder_prospects.php\">Return to Main Prospect List</a><br><br>";
	}
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
	$pagetext = "<center>Total Prospects Found: " . $rows . "<br>";

	if($rows > $pagesize){ // show the page bar
		$pagecount = ceil($rows/$pagesize);
		$pagetext .= "<div class='pagination'> ";
		if($page>1){ //show previoust link
			if ($searchfor == "")
			{
			$pagetext .= "<a href='?p=".($page-1)."&orderedby=$orderedby' title='previous page'>previous</a>";
			}
			if ($searchfor != "")
			{
			$pagetext .= "<a href='?p=".($page-1)."&searchfor=$searchfor&searchby=$searchby&orderedby=$orderedby' title='previous page'>previous</a>";
			}
		}
		for($i=1;$i<=$pagecount;$i++){
			if($page == $i){
				$pagetext .= "<span class='current'>".$i."</span>";
			}else{
				if ($searchfor == "")
				{
				$pagetext .= "<a href='?p=".$i."&orderedby=$orderedby'>".$i."</a>";
				}
				if ($searchfor != "")
				{
				$pagetext .= "<a href='?p=".$i."&searchfor=$searchfor&searchby=$searchby&orderedby=$orderedby'>".$i."</a>";
				}
			}
		}
		if($page<$pagecount){ //show previoust link
			if ($searchfor == "")
			{
			$pagetext .= "<a href='?p=".($page+1)."&orderedby=$orderedby' title='next page'>next</a>";
			}
			if ($searchfor != "")
			{
			$pagetext .= "<a href='?p=".($page+1)."&searchfor=$searchfor&searchby=$searchby&orderedby=$orderedby' title='next page'>next</a>";
			}
		}			
		$pagetext .= " </div><br>";
	}
################################################################
?>
<table cellpadding="2" cellspacing="2" border="0" align="center" class="sabrinatable" width="800">

<form action="autoresponder_prospects.php" method="post">
<tr class="sabrinatrdark"><td align="center" colspan="8">Search For:&nbsp;<input type="text" name="searchfor" size="15" maxlength="255">&nbsp;&nbsp;In:&nbsp;
<select name="searchby">
<option value="listname|system">Mailing List</option>
<option value="email|system">Email</option>
<option value="firstname|system">First Name</option>
<option value="lastname|system">Last Name</option>
<option value="howfound|system">How Found</option>
<option value="referringpage|system">Referring Webpage</option>
<option value="howmanydays|system">Days Since Subscribed</option>
<option value="signupip|system">IP Address</option>
<option value="verified|system">Verified</option>
<option value="vacation|system">Vacation</option>
<option value="bounces|system">Bounces</option>
<?php
	$uq = "select * from autoresponder_userfields where userid=\"$userid\" order by fieldname";
	$ur = mysql_query($uq);
	$urows = mysql_num_rows($ur);
	if ($urows > 0)
	{
		while ($urowz =mysql_fetch_array($ur))
		{
		$ufieldname = $urowz["fieldname"];
		?>
		<option value="<?php echo $ufieldname ?>|user"><?php echo $ufieldname ?></option>
		<?php
		}
	}
?>
</select>
&nbsp;&nbsp;
<input type="hidden" name="orderedby" value="<?php echo $orderedby ?>">
<input type="submit" value="SEARCH"></form></td></tr>

<tr class="sabrinatrlight"><td colspan="8" align="center"><div style="width:800px;overflow:auto;" align="center"><?php echo $pagetext ?></div></td></tr>

<?php
$sortq = "select * from autoresponders_lists where userid=\"$userid\" order by listname";
$sortr = mysql_query($sortq);
$sortrows = mysql_num_rows($sortr);
if ($sortrows > 0)
{
?>
<form action="autoresponder_prospects.php" method="post">
<tr class="sabrinatrlight"><td colspan="8" align="center">
<table cellpadding="2" cellspacing="2" border="0" align="center" class="sabrinatable" width="800">
<tr class="sabrinatrlight"><td>Put Prospects found from the Search Results into the Mailing List:</td>
<td>
<select name="mailinglisttoputinto">
<?php
while ($sortrowz = mysql_fetch_array($sortr))
	{
	$sortlistname = $sortrowz["listname"];
?>
<option value="<?php echo $sortlistname ?>"><?php echo $sortlistname ?></option>
<?php
	}
?>
</select>
</td>
<td>
<select name="keepcurrentmailinglist" style="width:150px;">
<option value="yes">Keep these prospects in the Mailing Lists they are already in as well as subscribing them to this new list</option>
<option value="no">Remove prospects from the Mailing Lists they are already in, so they are ONLY in this new list</option>
</select>
</td>
<td align="center">
<input type="hidden" name="action" value="sortsearchresultsintomailinglist">
<input type="hidden" name="searchby" value="<?php echo $searchby ?>">
<input type="hidden" name="searchfor" value="<?php echo $searchfor ?>">
<input type="hidden" name="orderedby" value="<?php echo $orderedby ?>">
<input type="submit" value="SORT INTO MAILING LIST">
</form>
</td>
</table>
</td></tr>
<?php
} # if ($sortrows > 0)
?>

<tr class="sabrinatrdark">
<td align="center"></td>
<td align="center"><a href="autoresponder_prospects.php?searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>&orderedby=listname">Mailing&nbsp;List</a></td>
<td align="center"><a href="autoresponder_prospects.php?searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>&orderedby=email">Email</a></td>
<td align="center"><a href="autoresponder_prospects.php?searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>&orderedby=firstname">First&nbsp;Name</a></td>
<td align="center"><a href="autoresponder_prospects.php?searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>&orderedby=lastname">Last&nbsp;Name</a></td>
<td align="center"><a href="autoresponder_prospects.php?searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>&orderedby=signupdate">Signed&nbsp;Up</a></td>
<td align="center"><a href="autoresponder_prospects.php?searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>&orderedby=signupip">Signup IP</a></td>
<td align="center"><a href="autoresponder_prospects.php?searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>&orderedby=verified">Verified</a></td>
</tr>
<?php
while ($rowz = mysql_fetch_array($resultexclude))
	{
$lid = $rowz["id"];
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
	$lverifiedbg = "#99cc99";
	}
	if ($lverified != "yes")
	{
	$lverifiedbg = "#ff9999";
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
<form action="autoresponder_prospects.php" method="post">
<td align="center"><img src="<?php echo $domain ?>/images/open.png" class="showstate" onclick="expandcontent(this, 'sc<?php echo $lid ?>')" width="20"></td>
<td align="center"><select name="savelistname" class="pickone">
<?php
$pq = "select * from autoresponders_lists where userid=\"$userid\" order by listname";
$pr = mysql_query($pq);
$prows = mysql_num_rows($pr);
if ($prows > 0)
{
while ($prowz = mysql_fetch_array($pr))
	{
	$plistname = $prowz["listname"];
?>
<option value="<?php echo $plistname ?>" <?php if ($plistname == $llistname) { echo "selected"; } ?>><?php echo $plistname ?></option>
<?php
	}
}
?>
</select></td>
<td align="center"><input type="text" name="saveemail" class="typein" size="15" maxlength="255" value="<?php echo $lemail ?>"></td>
<td align="center"><input type="text" name="savefirstname" class="typein" size="15" maxlength="255" value="<?php echo $lfirstname ?>"></td>
<td align="center"><input type="text" name="savelastname" class="typein" size="15" maxlength="255" value="<?php echo $llastname ?>"></td>
<td align="center"><?php echo $showsignupdate ?></td>
<td align="center"><input type="text" name="savesignupip" class="typein" size="15" maxlength="255" value="<?php echo $lsignupip ?>"></td>
<td align="center" bgcolor="<?php echo $lverifiedbg ?>">
<select name="saveverified" class="pickone">
<option value="yes" <?php if ($lverified == "yes") { echo "selected"; } ?>>YES</option>
<option value="no" <?php if ($lverified != "yes") { echo "selected"; } ?>>NO</option>
</select>
</td>
</tr>

<tr class="sabrinatrlight"><td id="sc<?php echo $lid ?>" class="switchcontent" style="display: none; width: 800px; padding: 0px;" colspan="8" style="border:0px;" align="center">
<table cellpadding="2" cellspacing="2" border="0" align="center" class="sabrinatable" width="800">
<tr class="sabrinatrlight"><td><a href="autoresponder_prospects.php?searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>&orderedby=howfound">How They Found Your Website</a>:</td><td><input type="text" name="savehowfound" class="typein" size="95" maxlength="255" value="<?php echo $lhowfound ?>"></td></tr>
<tr class="sabrinatrlight"><td><a href="autoresponder_prospects.php?searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>&orderedby=referringpage">Referring Webpage</a>:</td><td><input type="text" name="savereferringpage" class="typein" size="95" maxlength="255" value="<?php echo $lreferringpage ?>"></td></tr>
<tr class="sabrinatrlight">
<td><a href="autoresponder_prospects.php?searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>&orderedby=howmanydays">Days Since Subscribed</a>:</td><td>
<select name="savehowmanydays" class="pickone">
<?php
for($i=0;$i<=100;$i++)
{
?>
<option value="<?php echo $i ?>" <?php if ($i == $lhowmanydays) { echo "selected"; } ?>><?php echo $i ?></option>
<?php
}
?>
</select>
</td>
</tr>
<tr class="sabrinatrlight"><td><a href="autoresponder_prospects.php?searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>&orderedby=verifieddate">Date Verified</a>:</td><td><?php echo $showverifieddate ?></td></tr>
<tr class="sabrinatrlight"><td><a href="autoresponder_prospects.php?searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>&orderedby=verifiedip">Verify IP</a>:</td><td><input type="text" name="savesignupip" class="typein" size="95" maxlength="255" value="<?php echo $lverifiedip ?>"></td></tr>
<tr class="sabrinatrlight"><td><a href="autoresponder_prospects.php?searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>&orderedby=bounces">Bounces</a>:</td>
<td>
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
</tr>
<tr class="sabrinatrlight"><td><a href="autoresponder_prospects.php?searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>&orderedby=bouncelastdate">Last Bounce</a>:</td><td><?php echo $showbouncelastdate ?></td></tr>
<tr class="sabrinatrlight"><td valign="top"><a href="autoresponder_prospects.php?searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>&orderedby=bouncelasterror">Last Bounce Error</a>:</td><td><textarea name="savebouncelasterror" cols="95" rows="5"><?php echo $lbouncelasterror ?></textarea></td></tr>
<tr bgcolor="<?php echo $lvacationbg ?>"><td><a href="autoresponder_prospects.php?searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>&orderedby=vacation">Vacation (from bouncing)</a>:</td>
<td>
<select name="savevacation" class="pickone">
<option value="yes" <?php if ($lvacation == "yes") { echo "selected"; } ?>>YES</option>
<option value="no" <?php if ($lvacation != "yes") { echo "selected"; } ?>>NO</option>
</select>
</td>
</tr>
<tr class="sabrinatrlight"><td><a href="autoresponder_prospects.php?searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>&orderedby=vacationdate">Vacation Date</a>:</td><td><?php echo $showvacationdate ?></td></tr>
<tr bgcolor="<?php echo $lunsubscribedbg ?>"><td><a href="autoresponder_prospects.php?searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>&orderedby=unsubscribed">Unsubscribed</a>:</td>
<td>
<select name="saveunsubscribed" class="pickone">
<option value="yes" <?php if ($lunsubscribed == "yes") { echo "selected"; } ?>>YES</option>
<option value="no" <?php if ($lunsubscribed != "yes") { echo "selected"; } ?>>NO</option>
</select>
</td>
</tr>
<tr class="sabrinatrlight"><td><a href="autoresponder_prospects.php?searchfor=<?php echo $searchfor ?>&searchby=<?php echo $searchby ?>&orderedby=unsubscribedate">Unsubscribe Date</a>:</td><td><?php echo $showunsubscribedate ?></td></tr>
<?php
$colq = "select * from autoresponder_userfields where userid=\"$userid\" order by fieldname";
$colr = mysql_query($colq);
$colrows = mysql_num_rows($colr);
if ($colrows > 0)
	{
	while ($colrowz = mysql_fetch_array($colr))
		{
		$fieldname = $colrowz["fieldname"];
		$colq2 = "select * from autoresponder_userfields_data where userid=\"$userid\" and prospectid=\"$lid\" and fieldname=\"$fieldname\"";
		$colr2 = mysql_query($colq2);
		$colrows2 = mysql_num_rows($colr2);
		?>
		<tr class="sabrinatrlight"><td><?php echo $fieldname ?> (custom):</td><td>
		<?php
		if ($colrows2 > 0)
			{
			$fieldvalue = mysql_result($colr2,0,"fieldvalue");
			?>
			<input type="text" name="<?php echo $fieldname ?>" value="<?php echo $fieldvalue ?>" size="95" maxlength="255">
			<?php
			}
		if ($colrows2 < 1)
			{
			?>
			<input type="text" name="<?php echo $fieldname ?>" value="" size="95" maxlength="255">
			<?php
			}
		?>
		</td></tr>
		<?php
		}
	} # if ($colrows > 0)
?>
<tr class="sabrinatrdark"><td colspan="8" align="center">
	<table cellpadding="2" cellspacing="2" border="0" align="center" class="sabrinatable" width="100%">
	<tr class="sabrinatrdark"><td align="center">SAVE</td><td align="center">DELETE</td></tr>	
	<tr class="sabrinatrlight">
	<td align="center">
	<input type="hidden" name="action" value="save">
	<input type="hidden" name="saveid" value="<?php echo $lid ?>">
	<input type="hidden" name="searchby" value="<?php echo $searchby ?>">
	<input type="hidden" name="searchfor" value="<?php echo $searchfor ?>">
	<input type="hidden" name="orderedby" value="<?php echo $orderedby ?>">
	<input type="submit" value="SAVE">
	</form>	
	</td>
	<form action="autoresponder_prospects.php" method="post">
	<td align="center">
	<input type="hidden" name="action" value="delete">
	<input type="hidden" name="deleteid" value="<?php echo $lid ?>">
	<input type="hidden" name="deleteemail" value="<?php echo $lemail ?>">
	<input type="hidden" name="deletefirstname" value="<?php echo $lfirstname ?>">
	<input type="hidden" name="deletelastname" value="<?php echo $llastname ?>">
	<input type="hidden" name="searchby" value="<?php echo $searchby ?>">
	<input type="hidden" name="searchfor" value="<?php echo $searchfor ?>">
	<input type="hidden" name="orderedby" value="<?php echo $orderedby ?>">
	<input type="submit" value="DELETE">
	</form>
	</td>
	</tr>
	</table>
</td></tr>

<tr bgcolor="#ffffff"><td colspan="8"><br>&nbsp;</td></tr>

</table>
</td></tr>

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