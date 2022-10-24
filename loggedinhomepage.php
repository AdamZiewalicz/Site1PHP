<html>
<head>
<title>Homepage</title>
</head>
<body onload="checkForNotifications()">
<?php 
session_start();
$userlogged="NO USER";
$userlogged = $_SESSION['CurrentUser'];
$userloggedid = $_SESSION['CurrentUserId'];//change to by ID
$mysqli = new mysqli("localhost","root","pass","forum");
?>
<h1 align="center">Motorcycles</h1>
<h1 align="center"><a href="motocykle-i-quady.php">Find on otomoto(No filters yet)</a></h1>
<h1 align="center"><a href="threads.php">Search threads</a></h1>
<div align="right"><br/>



<?php
$lastSeenFromUser=array();$userLastSeenFrom=array();
$lastSentFromUser=array();$userLastSentFrom=array();  //FOR FUTURE USE - 
$usercount=0;
$unseenmessages=0;
$unseenfromwho=array();
$unseenhowmany=array();;
$NameOfId=array();

$CheckNames="SELECT id, username FROM users";
if($result = $mysqli -> query($CheckNames))
{
	while($row = $result -> fetch_row())
	{
		$NameOfId[$row[0]]=$row[1];
	}
	$result -> free_result();
}


$CheckLastSent="SELECT idChat,MessageNumber FROM forum.messagessent WHERE (idUser='$userloggedid')";//ile od idUser do mnie bylo wyslane
if($result = $mysqli -> query($CheckLastSent))
{
while ($row = $result -> fetch_row())
	{
	$lastSentFromUser[]=$row[1];
	$userLastSentFrom[]=$row[0];
	$usercount++;
	}
	  $result -> free_result();
}

$CheckLastSeen="SELECT idChat,MessageNumber FROM forum.lastmsgseen WHERE (idUser='$userloggedid')";//ile przeczytałem od idUser
if($result = $mysqli -> query($CheckLastSeen))
{
while ($row = $result -> fetch_row())
	{
	$lastSeenFromUser[]=$row[1];
	$userLastSeenFrom[]=$row[0];
	}
	  $result -> free_result();
}
$i=0;
while($i<$usercount)
{
	
	if($lastSeenFromUser[$i]!=$lastSentFromUser[$i])
	{$unseenmessages++;
	$unseenfromwho[]=$userLastSeenFrom[$i];
	$unseenhowmany[]=$lastSentFromUser[$i]-$lastSeenFromUser[$i];
} $i++;
	
}
?>
<h2 id=notifications>Chat Notifications: 
<?php
$i=0;
if($unseenmessages>0)
{
while($i<$unseenmessages)
{
	echo $unseenhowmany[$i]." unseen messages from ".$NameOfId[$unseenfromwho[$i]]."<br/>";
	$i++;
}} else{ echo "0<br/>";}

?></h2>

<?php echo "user logged in as <br/>".$userlogged."<br/>" ;

?>
<a href="logout.php">Log out</a><br/>
<a href="chats.php">Access chats</a>
</div>
<div align="left">
<?php

$sql="SELECT Id, Privileges FROM privileges"; 
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




 if($userloggedid==$currAdminId){
	 echo"<a href=MakeUsersForTests.php>Make 10 users</a><br/>";
	 echo"<a href=reset_users.php>Reset users</a><br/>";
 $currentprivilege="admin";
 $modrequestspending=0;
 $sql = "SELECT AskingForPrivilege FROM privileges";
 if ($result = $mysqli -> query($sql)) {
  while ($row = $result -> fetch_row()) {
	if($row[0]=="Moderator")
	{$modrequestspending++;}
  }
  $result -> free_result();
}
echo "Moderator requests pending: ".$modrequestspending."<br/";
 }
 
 $sql = "SELECT id, Privileges FROM privileges";
 if ($result = $mysqli -> query($sql)) {
  while ($row = $result -> fetch_row()) {
	if($row[0]==$userloggedid)
	{$currentprivilege=$row[1];
	break;}
  }
  $result -> free_result();
}
if($currentprivilege!='None'){
	
	echo"<a href=access users.php>Access users</a><br/>";}
  $askingforprivilege="No";
 if($currentprivilege=="None")
 {
	 
	 echo "<br/>
<a href='askprivilege.php'>
   <button>Ask for Moderator</button>
</a>
<br/>";

	  $_SESSION['PrivilegeAsked']="Moderator";
	 $sql = "SELECT id, AskingForPrivilege FROM privileges";
	  if ($result = $mysqli -> query($sql)) {
  while ($row = $result -> fetch_row()) {
	if($row[0]==$userloggedid){$askingforprivilege=$row[1]; break;}
  }
  $result -> free_result();
}

if($askingforprivilege=="Moderator")
{
	echo "<br/>Moderator request pending<br/>";
	
}
 }
 
 
 ?>
<a href="PswChange.php">Change your password</a><br/>
<a href="nameChange.php">Change your username</a><br/>
</div>
</body>
</html>