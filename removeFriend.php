<?php
session_start();
$currentId=$_SESSION['CurrentUserId'];
$friendId=$_POST['removeFriendId'];
$mysqli = new mysqli("localhost","root","pass","forum");

$Status=0;

 $stmt = mysqli_prepare($mysqli, "UPDATE friends SET StatusOrRequest = ?
               WHERE (Friend= ? AND Id=?)");
			 mysqli_stmt_bind_param($stmt,"iii",$Status, $friendId,$currentId);
			 mysqli_stmt_execute($stmt);
			 
 $stmt = mysqli_prepare($mysqli, "UPDATE friends SET StatusOrRequest = ?
               WHERE (Friend= ? AND id= ?)");
			 mysqli_stmt_bind_param($stmt,"iii",$Status, $currentId,$friendId);
			 mysqli_stmt_execute($stmt);			 
header("Location: access users.php");

?>