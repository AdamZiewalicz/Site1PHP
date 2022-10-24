
<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];

$mysqli = new mysqli("localhost","root","pass","forum");

if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
$userlogged="NO USER";
$sql = "SELECT username, id FROM users";
if ($result = $mysqli -> query($sql)) {
  while ($row = $result -> fetch_row()) {
	$condition=0;
	if($username==$row[0]){$currentId=$row[1];}
  }
  $result -> free_result();
}if($currentId){
$sql= "SELECT id, password FROM passwords";
if($result = $mysqli -> query($sql))
{
	while($row = $result -> fetch_row())
	{
		if($row[0]==$currentId)
		{
			if($row[1]==$password){$userlogged=$username; $userloggedid=$currentId;}
		}
		
	}
	$result ->free_result();
}}

if($userlogged=="NO USER"){echo "WRONG USERNAME OR PASSWORD"."<br/>";
echo "<a href=home.php>Go back</a>";
}
else {
$_SESSION['CurrentUser'] = $userlogged;	 //change to by ID
$_SESSION['CurrentUserId'] = $userloggedid;
	header('Location: loggedinhomepage.php');}

$mysqli -> close();
?>
