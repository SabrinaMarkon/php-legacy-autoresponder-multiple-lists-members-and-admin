<?php 
if(!isset($_SESSION))
{
session_start();
}
include "../db.php";
if ($_POST["loginusernameadmin"])
{
$_SESSION["loginusernameadmin"] = $_POST["loginusernameadmin"];
$_SESSION["loginpasswordadmin"] = $_POST["loginpasswordadmin"];
}
if(($_SESSION['loginusernameadmin'] != $adminuserid) or ($_SESSION['loginpasswordadmin'] != $adminpassword))
{
unset($_SESSION["loginusernameadmin"]);
unset($_SESSION["loginpasswordadmin"]);
$adminloggedin = "no";
$show = "<div class=\"message\">Incorrect Login</div>";
@header("Location: " . $domain . "/admin/index.php?show=" . $show);
exit;
}
$adminloggedin = "yes";
?>
