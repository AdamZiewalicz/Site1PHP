<?php

$id=$_POST['setadminid'];
$Privilege='admin';
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
 //check current admin name
 
 $stmt = mysqli_prepare($mysqli, "UPDATE privileges SET Privileges = ? WHERE id = ? ;");//change to by ID
			 mysqli_stmt_bind_param($stmt,"si",$Privilege, $id);
			 mysqli_stmt_execute($stmt); 
	//update user chosen as admin
	$Release='No';
	
 $stmt =mysqli_prepare($mysqli, "UPDATE privileges SET AskingForPrivilege = ? WHERE id = ?;");//change to by ID
 mysqli_stmt_bind_param($stmt, "si", $Release, $id);
 mysqli_stmt_execute($stmt);
	//asking for privilege for user chosen revoked
 $Release2="None";
 
  $stmt =mysqli_prepare($mysqli, "UPDATE privileges SET Privileges = ? WHERE id = ?;");//change to by ID
 mysqli_stmt_bind_param($stmt, "si", $Release2, $currAdminId);
 mysqli_stmt_execute($stmt);	//admin privilege taken away 
 
header("Location: access users.php");


?>