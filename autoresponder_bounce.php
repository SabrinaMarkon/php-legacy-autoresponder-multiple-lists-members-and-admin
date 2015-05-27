#!/usr/local/bin/php -q
<?php
include "/home/phpsites/public_html/demos/demoautorespondermm/db.php";
// Reading in the email
$fd = fopen("php://stdin", "r");
while (!feof($fd)) {
  $email .= fread($fd, 1024);
}
fclose($fd);

// Parsing the email
$lines = explode("\n", $email);
$stillheaders=true;
for ($i=0; $i < count($lines); $i++) {
  if ($stillheaders) {
    // this is a header
    $headers .= $lines[$i]."\n";

    // look out for special headers
    if (preg_match("/^Subject: (.*)/", $lines[$i], $matches)) {
      $subject = $matches[1];
    }
    if (preg_match("/^From: (.*)/", $lines[$i], $matches)) {
      $from = $matches[1];
    }
    if (preg_match("/^To: (.*)/", $lines[$i], $matches)) {
      $to = $matches[1];
    }
  } else {
    // not a header, but message
    #break;
    #Optionally you can read out the message also, instead of the break:
    $message .= $lines[$i]."\n";
  }

  if (trim($lines[$i])=="") {
    // empty line, header section has ended
    $stillheaders = false;
  }
}

list($part1,$dum1) = explode("-$ar_bounceemail", trim($to) );
list($dum2,$part2) = explode("user-", $part1);
//
// user-12345-bounce@yoursite.com
// $part2 now contains the user id "12345" in the example

$bounceduserid = $part2;
$bouncedemail = trim($to);

if ($bounceduserid != "")
{
$bouncemessage = addslashes($message);
$q1 = "select * from autoresponders_prospects where id=\"$bounceduserid\"";
$r1 = mysql_query($q1);
$rows1 = mysql_num_rows($r1);
if ($rows1 > 0)
	{
	# member the bouncing prospect belongs to
	$userid = mysql_result($r1,0,"userid");
	$bounces = mysql_result($r1,0,"bounces");
	$bounces_now = $bounces+1;
	$q2 = "update autoresponders_prospects set bounces=bounces+1,bouncelastdate=NOW(),bouncelasterror='".$bouncemessage."' where id=\"$bounceduserid\"";
	$r2 = mysql_query($q2);
	# has this prospect reached the maximum bounce count
	$q3 = "select * from members where userid=\"$userid\"";
	$r3 = mysql_query($q3);
	$rows3 = mysql_num_rows($r3);
		if ($rows3 > 0)
		{
		$accounttype = mysql_result($r3,0,"accounttype");
			if ($accounttype == "PAID")
			{
			$ar_bouncestoautounsubscribe = $ar_bouncestoautounsubscribepaid;
			}
			if ($accounttype != "PAID")
			{
			$ar_bouncestoautounsubscribe = $ar_bouncestoautounsubscribefree;
			}
		} # if ($rows3 > 0)
		if ($rows3 < 1)
		{
		$ar_bouncestoautounsubscribe = $ar_bouncestoautounsubscribefree;
		}
	if ($bounces_now >= $ar_bouncestoautounsubscribe)
		{
		$q4 = "update autoresponders_prospects set vacation=\"yes\",vacationdate=NOW() where id=\"$bounceduserid\"";
		$r4 = mysql_query($q4);
		}
	} # if ($rows1 > 0)
} # if ($bounceduserid != "")
?>