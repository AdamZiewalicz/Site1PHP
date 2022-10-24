<?php 
include("connect.php");
session_start();
$userlogged="NO USER";
$userlogged = $_SESSION['CurrentUser'];
$userloggedid = $_SESSION['CurrentUserId'];

$mysqli = new mysqli("localhost","root","pass","forum");

$findPassword="SELECT id, password FROM users"; //change to by ID
$foundpassword="";
if ($result = $mysqli -> query($findPassword)) {
  while ($row = $result -> fetch_row()) {
	if($row[0]==$userloggedid)
	{
		$foundpassword=$row[1];
	}
	
  }
  $result -> free_result();
}//current password, id found. check password now

$oldpassword=$_POST['currpass'];
$newpassword=$_POST['newpassword'];
if($oldpassword!=$foundpassword){echo "Current password doesnt match <br/>";
echo "<a href=PswChange.php>Try again</a>";}
else
{
	if(!$link){echo "what?? <br/>";}
 $newpassword = $_POST['newpassword'];//change to by ID
            
            
            $stmt = mysqli_prepare($mysqli, "UPDATE users SET password = ?
               WHERE id= ?");
			 mysqli_stmt_bind_param($stmt,"si",$newpassword, $userloggedid);
			 mysqli_stmt_execute($stmt);
           

echo "<br/>Password updated successfully<br/>";
echo "<a href=home.php>Go back to homepage</a><br/>";
}
?>

