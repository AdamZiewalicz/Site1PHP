<?php
$mysqli = new mysqli("localhost","root","pass","forum");
include("connect.php");


$names=array();
$name[]="user1";
$name[]="user2";
$name[]="user3";
$name[]="user4";
$name[]="user5";
$name[]="user6";
$name[]="user7";
$name[]="user8";
$name[]="user9";
$name[]="user10";
$z=0;
$password="pass";
while($z<10)
{$findusers = "SELECT username,id FROM users";

$allId=array();
$usercount=0;
if ($result = $mysqli -> query($findusers)) {
  while ($row = $result -> fetch_row()) {
	$allId[]=$row[1];
	$currentId=$row[1];
	$usercount++;
  }
  $result -> free_result();
}
$currentId++;

$sql= "INSERT INTO forum.users(username)
	VALUES ('$name[$z]');";
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
$z++;
}


?>