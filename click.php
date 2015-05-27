<?php
include "db.php";
$userid = $_GET["userid"];
$id = $_GET["id"];
$q = "select * from adminemails where id=\"$id\"";
$r = mysql_query($q);
$rows = mysql_num_rows($r);
if ($rows < 1)
{
include "header.php";
echo "Invalid Link";
include "footer.php";
exit;
}
if ($rows > 0)
{
	$url = mysql_result($r,0,"url");
	$q2 = "update adminemails set clicks=clicks+1 where id=\"$id\"";
	$r2 = mysql_query($q2);
	@header("Location: " . $url);
	exit;
}
?>