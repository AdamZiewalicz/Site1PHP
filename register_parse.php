<html>
<head><title>Registration</title>
<body>
<?php 
$mysqli = new mysqli("localhost","root","pass","forum");
$findusers = "SELECT username,id FROM users";
include("connect.php");
$username = $_POST['username'];
$password = $_POST['password'];
$allId=array();
$isItTaken=0;
$usercount=0;
if ($result = $mysqli -> query($findusers)) {
  while ($row = $result -> fetch_row()) {
	$allId[]=$row[1];
	$currentId=$row[1];
	$usercount++;
	if($username==$row[0]){$isItTaken=1;
	echo $username." ".$row[0];
	
	}
  }
  $result -> free_result();
}
$currentId++;
if($isItTaken==0)
{
if($username=="" || $password=="")

  {echo "Username or password can't be empty";}

else 
  {
	$sql= "INSERT INTO forum.users(username)
	VALUES ('$username');";
	$res= mysqli_query($link, $sql);
	$sql2= "INSERT INTO forum.privileges(Privileges, AskingForPrivilege) VALUES ('None', 'No');";
	$sql3= "INSERT INTO forum.passwords(password) VALUES ('$password');";
	$i=0;
  while ($i<$usercount) {
	$sql4= "INSERT INTO forum.friends(id,friend) VALUES ('$currentId','$allId[$i]');";
	$sql5= "INSERT INTO forum.friends(id,friend) VALUES ('$allId[$i]','$currentId');";
	$res= mysqli_query($link,$sql4);
	$res1= mysqli_query($link,$sql5);
	$i++;
	}
   
	
	
	$res3= mysqli_query($link,$sql3);
	$res2= mysqli_query($link, $sql2);
	
	
	
	
	if($res&&$res2)
	{echo "success <br/>";}
  }
}
else
{echo "This username is already taken<br/>";}
?>
</br>
<a href="home.php">Return to homepage</a><br/>
<a href="register.php">Return to registration</a>
</body>
</html>