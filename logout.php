<?php 
session_start();
$_SESSION['CurrentUser'] = "NO USER";
$_SESSION['CurrentUserId'] = "0";
header("Location: home.php");
?>
