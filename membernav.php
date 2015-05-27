<?php
$membernavq = "select * from membernavigation where membernavenabled='yes' order by membernavsequence";
$membernavr = mysql_query($membernavq);
$membernavrows = mysql_num_rows($membernavr);
if ($membernavrows > 0)
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
while ($membernavrowz = mysql_fetch_array($membernavr))
	{
	$membernavtitle = $membernavrowz["membernavtitle"];
	$membernavtitle = str_replace(" ","&nbsp;",$membernavtitle);
	$membernavurl = $membernavrowz["membernavurl"];
	$membernavwindow = $membernavrowz["membernavwindow"];
?>
<li class="navmenubutton" onclick="window.open('<?php echo $membernavurl ?>','<?php echo $membernavwindow ?>');"><?php echo $membernavtitle ?></li>
<?php
	}
?>
</ul>
</div>
</center>
<!--END OF EDIT-->
<?php
}
?>
