<?php 
include "db.php";
if(isset($_REQUEST["referid"]))
{
$referid = $_REQUEST["referid"];
}
else
{
$referid = $adminmemberuserid;
}
$refq = "select * from members where userid=\"$referid\"";
$refr = mysql_query($refq);
$refrows =  mysql_num_rows($refr);
if ($refrows < 1)
{
$referid = $adminmemberuserid;
}
?>
<html>
<head>
<title>Join <?php echo $sitename ?>!</title>
</head>
<body> 
<center>
<a href="<?php echo $domain ?>/index.php?referid=<?php echo $referid ?>" target="_blank"><img src="<?php echo $domain ?>/images/600-300.gif" border="0"></a>
<br>
Your Click Will Open A New Window
</center>
</body>

</html> 