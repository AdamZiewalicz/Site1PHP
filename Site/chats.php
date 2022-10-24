<?php
session_start();
$mysqli = new mysqli("localhost","root","pass","forum");
include("connect.php");
$_SESSION['MessagesToShow']=0;
$_SESSION['chooseChatReceiver']=0;
$currentId=$_SESSION['CurrentUserId'];
$myFriendsId=array();
$myFriendsName=array();
$friendscount=0;

$showFriends="SELECT Friend FROM friends WHERE (id ='$currentId' AND StatusOrRequest='Friend')";
if ($result = $mysqli -> query($showFriends)) {
  while ($row = $result -> fetch_row()) {
	$myFriendsId[]=$row[0];
	$friendscount++;	
  }
  $result -> free_result();
}

$i=0;
while($i<$friendscount)
{$fetchNames="SELECT username FROM users WHERE id=$myFriendsId[$i];";
if ($result = $mysqli -> query($fetchNames)) {
  while ($row = $result -> fetch_row()) {
	$myFriendsName[$i]=$row[0];
	echo"
	<form action=chat.php method=POST >
			<input type=hidden name=chooseChat value=".$myFriendsId[$i].">
			<input type=submit value='Chat with ".$myFriendsName[$i]."'></form>
	
	";
  }
  $result -> free_result();
$i++;
}

}
echo"<br/>
			<a href=loggedinhomepage.php align=left>Go back to homepage</a><br/>"

?>