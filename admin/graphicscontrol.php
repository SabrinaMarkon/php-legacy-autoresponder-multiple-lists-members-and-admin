<?php
include "control.php";
include "../header.php";
if ($action == "upload")
{
$uploadfile = $_POST["uploadfile"];
$uploadfile_name = $_FILES["uploadfile"]["name"];
$uploadfile_type = $_FILES["uploadfile"]["type"];

	if ($uploadfile_name != "")
	{
	$type = $uploadfile_type;
	if(($type != "image/gif") and ($type != "image/bmp") and ($type != "image/png") and ($type != "image/jpg") and ($type != "image/pjpeg") and ($type != "image/jpeg") and ($type != "image/x-icon"))
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">
	<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
	<tr><td colspan="2" align="center"><br>The photo file is of a type not permitted for upload (only upload jpeg, jpg, pjpeg, gif, png, or bmp).</td></tr>
	<tr><td colspan="2" align="center"><br><a href="graphicscontrol.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
	}

	$uploadtemp = "../images/" . $uploadfile_name;
	if (@file_exists($uploadtemp))
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">
	<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
	<tr><td colspan="2" align="center"><br>The file <?php echo $uploadfile ?> already exists on the server.</td></tr>
	<tr><td colspan="2" align="center"><br><a href="graphicscontrol.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
	}

	if(@move_uploaded_file($_FILES['uploadfile']['tmp_name'], $uploadtemp)) 
	{
	@chmod($uploadtemp, 0777);
	$uploadfileurl = $domain . "/images/" . $uploadfile_name;
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">
	<tr><td align="center" colspan="2"><div class="heading">File Uploaded</div></td></tr>
	<tr><td colspan="2" align="center"><br>The file <?php echo $uploadfile_name ?> was uploaded to the server.</td></tr>
	<tr><td colspan="2" align="center">The URL to the file is now: <a href="<?php echo $uploadfileurl ?>" target="_blank"><?php echo $uploadfileurl ?></a></td></tr>
	<tr><td colspan="2" align="center"><br><a href="graphicscontrol.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
	}
	else
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">
	<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
	<tr><td colspan="2" align="center"><br>There was an unknown error, possibly due to file permissions on the server.</td></tr>
	<tr><td colspan="2" align="center"><br><a href="graphicscontrol.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
	}

	} # if ($uploadfile_name != "")
} # if ($action == "upload")
########################
if ($action == "delete")
{
$deletefile = $_POST["deletefile"];
$deletetemp = "../images/" . $deletefile;
	if (@file_exists($deletetemp))
	{
	@chmod($deletetemp, 0777);
	@unlink($deletetemp);
	}

	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">
	<tr><td align="center" colspan="2"><div class="heading">File Deleted</div></td></tr>
	<tr><td colspan="2" align="center"><br>The file <?php echo $deletefile ?> was deleted from the server.</td></tr>
	<tr><td colspan="2" align="center"><br><a href="graphicscontrol.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
} # if ($action == "delete")
########################
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
<tr><td align="center" colspan="2"><div class="heading"><?php echo $sitename ?> Graphics Control</div></td></tr>

<tr><td align="center" colspan="2"><br>
<table cellpadding="2" cellspacing="2" border="0" align="center" class="sabrinatable" width="600">
<tr class="sabrinatrdark"><td align="center" colspan="2"><div class="heading">Upload New Image</div></td></tr>
<form action="graphicscontrol.php" method="post" enctype="multipart/form-data">
<tr class="sabrinatrlight"><td>Select File: </td><td><input type="file" name="uploadfile" size="35" class="typein"><input type="hidden" name="action" value="upload">&nbsp;<input type="submit" value="UPLOAD" class="sendit"></form></td></tr>

<tr><td align="center" colspan="2"></td></tr>

<tr class="sabrinatrdark"><td align="center" colspan="2"><div class="heading">Your Images</div></td></tr>


<tr class="sabrinatrlight"><td align="center" colspan="2"><table cellpadding="2" cellspacing="2" border="0" align="center" class="sabrinatable" width="600">
<tr class="sabrinatrlight"><td align="center">Image</td><td align="center">URL to File</td><td align="center">Delete</td></tr>
<?php
foreach(glob('../images/*.*') as $filename)
{
$data = getimagesize($filename);
$width = $data[0];
$height = $data[1];
$filename = str_replace("../images/","",$filename);
if($filename != "." and $filename != ".." and $filename != "index.php" and $filename != "index.html")
	{
	$fileurl = $domain . "/images/" . $filename;
	if ($width > 199)
		{
		$showwidth = "200";
		}
	else
		{
		$showwidth = $width;
		}
	?>
	<tr class="sabrinatrlight">
	<td align="center"><a href="<?php echo $fileurl ?>" target="_blank"><img src="<?php echo $fileurl ?>" border="0" width="<?php echo $showwidth ?>"></a></td>
	<td align="center"><a href="<?php echo $fileurl ?>" target="_blank"><?php echo $fileurl ?></a></td>
	<form action="graphicscontrol.php" method="post">
	<td align="center">
	<input type="hidden" name="deletefile" value="<?php echo $filename ?>">
	<input type="hidden" name="action" value="delete">
	<input type="submit" value="DELETE FILE">
	</form>
	</td>
	</tr>
	<?php
	} 
}
?>
</table></td></tr>


</table>
</td></tr>

</table>
<br><br>
<?php
include "../footer.php";
exit;
?>