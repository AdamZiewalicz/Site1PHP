<?php

$Id=$_POST['addprivid'];
$Privilege='Moderator';
$mysqli = new mysqli("localhost","root","pass","forum");

$sql="SELECT id, Privileges FROM privileges";//change to by ID and a whole other base 
 if ($result = $mysqli -> query($sql)) {
  while ($row = $result -> fetch_row()) {
	if($row[1]=='admin')
	{
		$currAdminId=$row[0];
		break;
	}
  }
  $result -> free_result();
}

 $stmt = mysqli_prepare($mysqli, "UPDATE privileges SET Privileges = ? WHERE id = ? ;");//change to by ID
			 mysqli_stmt_bind_param($stmt,"si",$Privilege, $Id);
			 mysqli_stmt_execute($stmt); 
	$Release='No';
	
 $stmt =mysqli_prepare($mysqli, "UPDATE privileges SET AskingForPrivilege = ? WHERE id = ?;");//change to by ID
 mysqli_stmt_bind_param($stmt, "si", $Release, $Id);
 mysqli_stmt_execute($stmt);
header("Location: access users.php");


?>