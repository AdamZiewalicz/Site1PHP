<?php

$Id=$_POST['takeprivid'];
$Privilege='None';
$mysqli = new mysqli("localhost","root","pass","forum");
 $stmt = mysqli_prepare($mysqli, "UPDATE privileges SET Privileges = ? WHERE id = ? ;");//change to by ID
			 mysqli_stmt_bind_param($stmt,"si",$Privilege, $Id);
			 mysqli_stmt_execute($stmt); 
	$Release='No';
 $stmt =mysqli_prepare($mysqli, "UPDATE Privileges SET AskingForPrivilege = ? WHERE id = ?;");//change to by ID
 mysqli_stmt_bind_param($stmt, "si", $Release, $Id);
 mysqli_stmt_execute($stmt);
header("Location: access users.php");


?>