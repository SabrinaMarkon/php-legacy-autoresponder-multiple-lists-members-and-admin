<?php
include "db.php";
$arid = $_GET["arid"];
$type = $_GET["type"];
if ($type == "ar")
{
$q = "select * from autoresponders where id=\"$arid\"";
$r = mysql_query($q);
$rows = mysql_num_rows($r);
if ($rows < 1)
	{
	$url = $ar_defaultredirecturlafterclickingaremaillink;
	}
if ($rows > 0)
	{
	$url = mysql_result($r,0,"emailclick_redirecturl");
	}
$cq = "update autoresponders set totalclicked=totalclicked+1 where id=\"$arid\"";
$cr = mysql_query($cq);
}
if ($type != "ar")
{
$q = "select * from autoresponder_directmail where id=\"$arid\"";
$r = mysql_query($q);
$rows = mysql_num_rows($r);
if ($rows < 1)
	{
	$url = $ar_defaultredirecturlafterclickingaremaillink;
	}
if ($rows > 0)
	{
	$url = mysql_result($r,0,"url");
	}
$cq = "update autoresponder_directmail set clicks=clicks+1 where id=\"$arid\"";
$cr = mysql_query($cq);
}
@header("Location: " . $url);
?>