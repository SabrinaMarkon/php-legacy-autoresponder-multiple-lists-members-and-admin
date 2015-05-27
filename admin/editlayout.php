<?php
include "control.php";
include "../header.php";
$action = $_POST["action"];
$show = "";
if ($action == "saveheader")
{
##############################################################
$headercontent = $_POST["headercontent"];
$headerfile = fopen("../header.php","w");
fwrite($headerfile, $headercontent);
fclose($headerfile);
$show = "Your header.php file was saved!";
} # if ($action == "saveheader")
##############################################################
if ($action == "savefooter")
{
$footercontent = $_POST["footercontent"];
$footerfile = fopen("../footer.php","w");
fwrite($footerfile, $footercontent);
fclose($footerfile);
$show = "Your footer.php file was saved!";
} # if ($action == "savefooter")
##############################################################
if ($action == "saveadminnav")
{
$adminnavcontent = $_POST["adminnavcontent"];
$adminnavfile = fopen("adminnav.php","w");
fwrite($adminnavfile, $adminnavcontent);
fclose($adminnavfile);
$show = "Your adminnav.php file was saved!";
} # if ($action == "saveadminnav")
##############################################################
if ($action == "savemembernav")
{
$membernavcontent = $_POST["membernavcontent"];
$membernavfile = fopen("../membernav.php","w");
fwrite($membernavfile, $membernavcontent);
fclose($membernavfile);
$show = "Your membernav.php file was saved!";
} # if ($action == "savemembernav")
##############################################################
if ($action == "savestyles")
{
$stylescontent = $_POST["stylescontent"];
$stylesfile = fopen("../styles.css","w");
fwrite($stylesfile, $stylescontent);
fclose($stylesfile);
$show = "Your styles.css file was saved!";
} # if ($action == "savestyles")
##############################################################
if ($action == "savesplash")
{
$splashcontent = $_POST["splashcontent"];
$splashfile = fopen("../splashpage.php","w");
fwrite($splashfile, $splashcontent);
fclose($splashfile);
$show = "Your splashpage.php file was saved!";
} # if ($action == "savestyles")
##############################################################
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
<tr><td align="center" colspan="2"><div class="heading">Edit&nbsp;Layout</div></td></tr>
<?php
if ($show != "")
{
?>
<tr><td align="center" colspan="2"><br><?php echo $show ?></td></tr>
<?php
}

$header = "../header.php";
$headerfp = @fopen($header, "r");
$header = fread($headerfp, filesize($header));
$header = htmlspecialchars($header);
fclose($headerfp);

$footer = "../footer.php";
$footerfp = @fopen($footer, "r");
$footer = fread($footerfp, filesize($footer));
$footer = htmlspecialchars($footer);
fclose($footerfp);

$adminnav = "adminnav.php";
$adminnavfp = @fopen($adminnav, "r");
$adminnav = fread($adminnavfp, filesize($adminnav));
$adminnav = htmlspecialchars($adminnav);
fclose($adminnavfp);

$membernav = "../membernav.php";
$membernavfp = @fopen($membernav, "r");
$membernav = fread($membernavfp, filesize($membernav));
$membernav = htmlspecialchars($membernav);
fclose($membernavfp);

$styles = "../styles.css";
$stylesfp = @fopen($styles, "r");
$styles = fread($stylesfp, filesize($styles));
$styles = htmlspecialchars($styles);
fclose($stylesfp);

$splash = "../splashpage.php";
$splashfp = @fopen($splash, "r");
$splash = fread($splashfp, filesize($splash));
$splash = htmlspecialchars($splash);
fclose($splashfp);
?>
<tr><td align="center" colspan="2"><br>
<form action="editlayout.php" method="post">
<table width="600" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrdark"><td align="center">Edit header.php File</td></tr>
<tr class="sabrinatrlight"><td align="center"><textarea rows="40" cols="80" name="headercontent"><?php echo $header ?></textarea></td></tr>
<tr class="sabrinatrdark"><td align="center"><input type="hidden" name="action" value="saveheader">
<input type="submit" value="SAVE" class="sendit"></form>
</td></tr>
</table>
</td></tr>

<tr><td align="center" colspan="2"><br>&nbsp;</td></tr>

<tr><td align="center" colspan="2"><br>
<form action="editlayout.php" method="post">
<table width="600" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrdark"><td align="center">Edit footer.php File</td></tr>
<tr class="sabrinatrlight"><td align="center"><textarea rows="40" cols="80" name="footercontent"><?php echo $footer ?></textarea></td></tr>
<tr class="sabrinatrdark"><td align="center"><input type="hidden" name="action" value="savefooter">
<input type="submit" value="SAVE" class="sendit"></form>
</td></tr>
</table>
</td></tr>

<tr><td align="center" colspan="2"><br>&nbsp;</td></tr>

<tr><td align="center" colspan="2"><br>
<form action="editlayout.php" method="post">
<table width="600" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrdark"><td align="center">Edit adminnav.php File</td></tr>
<tr class="sabrinatrlight"><td align="center"><textarea rows="40" cols="80" name="adminnavcontent"><?php echo $adminnav ?></textarea></td></tr>
<tr class="sabrinatrdark"><td align="center"><input type="hidden" name="action" value="saveadminnav">
<input type="submit" value="SAVE" class="sendit"></form>
</td></tr>
</table>
</td></tr>

<tr><td align="center" colspan="2"><br>&nbsp;</td></tr>

<tr><td align="center" colspan="2"><br>
<form action="editlayout.php" method="post">
<table width="600" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrdark"><td align="center">Edit membernav.php File</td></tr>
<tr class="sabrinatrlight"><td align="center"><textarea rows="40" cols="80" name="membernavcontent"><?php echo $membernav ?></textarea></td></tr>
<tr class="sabrinatrdark"><td align="center"><input type="hidden" name="action" value="savemembernav">
<input type="submit" value="SAVE" class="sendit"></form>
</td></tr>
</table>
</td></tr>

<tr><td align="center" colspan="2"><br>&nbsp;</td></tr>

<tr><td align="center" colspan="2"><br>
<form action="editlayout.php" method="post">
<table width="600" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrdark"><td align="center">Edit styles.css File</td></tr>
<tr class="sabrinatrlight"><td align="center"><textarea rows="40" cols="80" name="stylescontent"><?php echo $styles ?></textarea></td></tr>
<tr class="sabrinatrdark"><td align="center"><input type="hidden" name="action" value="savestyles">
<input type="submit" value="SAVE" class="sendit"></form>
</td></tr>
</table>
</td></tr>

<tr><td align="center" colspan="2"><br>&nbsp;</td></tr>

<tr><td align="center" colspan="2"><br>
<form action="editlayout.php" method="post">
<table width="600" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrdark"><td align="center">Edit splashpage.php File</td></tr>
<tr class="sabrinatrlight"><td align="center"><textarea rows="40" cols="80" name="splashcontent"><?php echo $splash ?></textarea></td></tr>
<tr class="sabrinatrdark"><td align="center"><input type="hidden" name="action" value="savesplash">
<input type="submit" value="SAVE" class="sendit"></form>
</td></tr>
</table>
</td></tr>

</table>
<br><br>
<?php
include "../footer.php";
exit;
?>