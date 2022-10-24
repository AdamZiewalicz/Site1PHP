<?php
session_start();
$userlogged="NO USER";
$userlogged = $_SESSION['CurrentUser'];
$userloggedid = $_SESSION['CurrentUserId'];
$mysqli = new mysqli("localhost","root","pass","forum");
 
 
 $sql="SELECT id, Privileges FROM privileges"; //change to by ID
 if ($result = $mysqli -> query($sql)) {
  while ($row = $result -> fetch_row()) {
	if($row[0]==$userloggedid)
	{$currentprivilege=$row[1];
	break;}
  }
  $result -> free_result();
}//privilege checked
if($currentprivilege!="None")
{
		echo "You already have moderator or higher privilege";
}
else
{$privilegeasked=$_SESSION['PrivilegeAsked'];
if($privilegeasked!="None")
{
	$stmt=mysqli_prepare($mysqli, "UPDATE privileges SET AskingForPrivilege = ? WHERE id = ?");//change to by ID
mysqli_stmt_bind_param($stmt,"ss",$privilegeasked, $userloggedid);
			 mysqli_stmt_execute($stmt);
}

}
header("Location: loggedinhomepage.php");



?>