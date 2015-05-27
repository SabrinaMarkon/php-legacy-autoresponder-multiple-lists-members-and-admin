<?php
$adminnavq = "select * from adminnavigation where adminnavenabled='yes' order by adminnavsequence";
$adminnavr = mysql_query($adminnavq);
$adminnavrows = mysql_num_rows($adminnavr);
if ($adminnavrows > 0)
{
?>
<!--EDIT BELOW HTML AND STYLES FOR YOUR OWN MENU COLORS, FONTS, ETC.-->
<style>
#navmenucontainer {
    text-align: center;
    padding: 10px;
	width: 920px;
}

.navmenubutton {
    display: inline-block;
	font-size: 10px;
	background: #000;
	border: 1px solid #a44ac6;
	color: #fff;
	width: 150px;
	height: 15px;
	cursor: pointer;
	padding: 4px;
	margin-top: 4px;
	line-height: 15px;
    /* for ie7 */
    zoom: 1;
    *display: inline;
}
.navmenubutton:hover {
	background: #a44ac6;
	color: #fff;
}
</style>
<center>
<div style="width:920px;">
<ul id="#navmenucontainer">
<?php
while ($adminnavrowz = mysql_fetch_array($adminnavr))
	{
	$adminnavtitle = $adminnavrowz["adminnavtitle"];
	$adminnavtitle = str_replace(" ","&nbsp;",$adminnavtitle);
	$adminnavurl = $adminnavrowz["adminnavurl"];
	$adminnavwindow = $adminnavrowz["adminnavwindow"];
?>
<li class="navmenubutton" onclick="window.open('<?php echo $adminnavurl ?>','<?php echo $adminnavwindow ?>');"><?php echo $adminnavtitle ?></li>
<?php
	}
?>
</ul>
</div>
<br><br>
</center>
<!--END OF EDIT-->
<?php
}
?>
