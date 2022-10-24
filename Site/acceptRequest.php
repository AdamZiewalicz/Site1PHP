<?php
session_start();
$currentId=$_SESSION['CurrentUserId'];
$friendRequestId=$_POST['acceptFriendId'];
$mysqli = new mysqli("localhost","root","pass","forum");
$Accept="Friend";
 $stmt = mysqli_prepare($mysqli, "UPDATE friends SET StatusOrRequest = ?
               WHERE (Friend= ? AND Id=?)");
			 mysqli_stmt_bind_param($stmt,"sii",$Accept, $friendRequestId,$currentId);
			 mysqli_stmt_execute($stmt);
			 
 $stmt = mysqli_prepare($mysqli, "UPDATE friends SET StatusOrRequest = ?
               WHERE (Friend= ? AND id= ?)");
			 mysqli_stmt_bind_param($stmt,"sii",$Accept, $currentId,$friendRequestId);
			 mysqli_stmt_execute($stmt);			 
header("Location: access users.php");

?>