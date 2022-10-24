<?php
session_start();
$currentId=$_SESSION['CurrentUserId'];
$friendRequestId=$_POST['addFriendId'];

$mysqli = new mysqli("localhost","root","pass","forum");

 $stmt = mysqli_prepare($mysqli, "UPDATE friends SET StatusOrRequest = ?
               WHERE (Friend= ? AND Id=?)");
			 mysqli_stmt_bind_param($stmt,"iii",$currentId, $friendRequestId,$currentId);
			 mysqli_stmt_execute($stmt);
			 
 $stmt = mysqli_prepare($mysqli, "UPDATE friends SET StatusOrRequest = ?
               WHERE (Friend= ? AND id= ?)");
			 mysqli_stmt_bind_param($stmt,"iii",$currentId, $currentId,$friendRequestId);
			 mysqli_stmt_execute($stmt);			 
header("Location: access users.php");

?>