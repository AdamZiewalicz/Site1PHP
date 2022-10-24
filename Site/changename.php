<?php 
include("connect.php");
session_start();
$userlogged="NO USER";
$userlogged = $_SESSION['CurrentUser'];
$userloggedid = $_SESSION['CurrentUserId'];


$mysqli = new mysqli("localhost","root","pass","forum");

$findPassword="SELECT id, username, password FROM users"; //change to by ID
$foundpassword="";
$currentid=0;
if ($result = $mysqli -> query($findPassword)) {
  while ($row = $result -> fetch_row()) {
	if($row[1]==$userloggedid)
	{	$currentid=$row[0];
		$foundpassword=$row[2];
	}
	
  }
  $result -> free_result();
}//current password, name found. check password now

$password=$_POST['password'];
$newname=$_POST['newname'];
if($password!=$foundpassword){echo "Current password doesnt match <br/>";
echo "<a href=nameChange.php>Try again</a><br/>";
echo "<a href=loggedinhomepage.php>Go back to homepage</a>";}
else
{
	if(!$link){echo "what?? <br/>";}
            
            $stmt = mysqli_prepare($mysqli, "UPDATE users SET username = ?
               WHERE id = ?");
			 mysqli_stmt_bind_param($stmt,"si",$newname, $currentid);
			 mysqli_stmt_execute($stmt);
           

echo "<br/>Username updated successfully<br/>";
echo "<a href=home.php>Go back to homepage</a><br/>";
$userlogged=$newname;
$_SESSION['CurrentUser'] = $userlogged;	
$_SESSION['CurrentUserId'] = $userloggedid;
}
?>

