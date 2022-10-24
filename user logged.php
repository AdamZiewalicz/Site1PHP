<?php
session_start();
$userlogged="NO USER";
$userlogged = $_SESSION['CurrentUser'];//change to by ID
$userloggedid = $_SESSION['CurrentUserId'];
?>