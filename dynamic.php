<?php
include "db.php";
include "header.php";
$page = $_REQUEST["page"];
$query1 = "select * from pagesdynamic where tag='$page'";
$result1 = mysql_query($query1);
$line1 = mysql_fetch_array($result1);
$pagename = $line1["name"];
$htmlcode = $line1["htmlcode"];
?>
<table cellpadding="0" cellspacing="0" border="0" align="center" width="90%" >
<tr><td colspan="2"><br>
<div style="text-align: center;">
<?php
echo $htmlcode;
?>
</div> 
</td></tr>
</table><br>&nbsp;<br>&nbsp;
<?php
include "footer.php";
?>