<html>
<head><title>User database</title>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 50%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: center;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>
<div align="center">
<h1>Users</h1>
<h2 align="right">Logged in as <?php include("user logged.php"); echo $userlogged; ?></h2>
<?php
$mysqli = new mysqli("localhost","root","pass","forum");
$checkprivilege="SELECT id, Privileges FROM privileges;";
if($result = $mysqli ->query($checkprivilege)) {
while($row = $result -> fetch_row()) 
{
if($row[0]==$userloggedid)
{
	$currentPrivilege=$row[1];//change to by ID
}
}
}
echo "
<table>
<tr>
	<th>Username</th>
	<th>Privileges</th>
	<th>Friend status</th>";
	if($currentPrivilege=="admin")
	{echo "<th>Asking for privilege?</th>";
		echo "<th>Add moderator privilege</th>";
	echo"<th>Take away moderator privilege</th>";
	echo"<th>Set as new admin</th>";
	echo"<th>Devtool</th>";
	}
echo "
	</tr>
		
";

$sql = "SELECT username, id FROM users";//change to by ID

$usernames = array();
$id = array();
$privileges = array();
$asking = array();
$usercount=0;

if ($result = $mysqli -> query($sql))
{
	while ($row = $result -> fetch_row()) 
  {
	$usernames[]=$row[0];
	$id[]=$row[1];
	$usercount++;
  }
  $result -> free_result();
}
$i=0;
$sql = "SELECT id, Privileges, AskingForPrivilege FROM privileges";


if($result = $mysqli -> query($sql)){
while ($row = $result -> fetch_row()) {
	
	if($row[0]==$id[$i]){$privileges[$i]=$row[1];$asking[$i]=$row[2];}
	$i++;
}
  $result -> free_result();
}	
// usernames, id, privileges, asking 

$i=0;
  while ($i<$usercount) {

	echo "<tr>
	<td>".$usernames[$i]."</td>
	<td>".$privileges[$i]."</td>";
	if($id[$i]==$userloggedid){echo"<td> </td>";}
	else{ 
	
	$sql = "SELECT id, Friend, StatusOrRequest FROM friends WHERE (id = '$userloggedid' AND Friend = '$id[$i]')";
if($result = $mysqli -> query($sql)){
while ($row = $result -> fetch_row()) {
	if($row[0]==$userloggedid)
	{
		if($row[1]==$id[$i]&&$row[2]=="Friend")
		{
			echo"<td>Friend
			<form name removefriend action=removeFriend.php method=POST>
			<input type=hidden name=removeFriendId value=".$id[$i].">
			<input type=submit value='Remove friend'></form>
			</td>"; //jesli jest friended to wypisz friend i tyle 
			break;
			
		}else
		if($row[1]==$id[$i]&&$row[2]==$userloggedid)						//jesli jest request ode mnie
		{
		 	echo"<td>Request pending
			<form name cancelrequest action=cancelRequest.php method=POST>
			<input type=hidden name=CancelRequestId value=".$id[$i].">
			<input type=submit value='Cancel request'></form>
			
			</td>";break;
		}else
		if($row[1]==$id[$i]&&$row[2]==$id[$i])							//jesli jest request ode mnie 
		{
			echo
			"
			<td>
			<form name acceptrequest action=acceptRequest.php method=POST>
			<input type=hidden name=acceptFriendId value=".$id[$i].">
			<input type=submit value='Accept request'></form>
			</td>
			";break;
		}else
			{echo "
	<td>
	<form name=addingfriend action=addFriend.php method=POST>
	<input type=hidden name=addFriendId value=".$id[$i].">
	<input type=submit value='Add friend'></form>
	</td>";	//jeśli jest friend daj Friend}
	break;
	}
}
  
	}$result -> free_result();
	}	
	
	
	}						//jeśli jest request w którąś strone to pending albo accept form 
	if($currentPrivilege=="admin") //else daj add friend form; chwilowo wystarczy add friend form tylko 
	{echo "<td>".$asking[$i]."</td>";
		if($privileges[$i]=="None")
		{   
			
			echo "<td>
			<form name=addingprivilege action=addPrivilege.php method=POST>
			<input type=hidden name=addprivid value=".$id[$i].">
			<input type=submit value=Add> 
		     </form></td> ";
			 echo "<td>No privilege to take</td>";
		}
		else if($privileges[$i]!="None")
		{
			echo "<td>Already moderator or higher</td>";
			if($privileges[$i]!="admin") 
			{echo "<td>
			<form name=takinggprivilege action=TakePrivilege.php method=POST>
			<input type=hidden name=takeprivid value=".$id[$i].">
			<input type=submit value=Take> 
			</form></td> ";} //Take away mod
			else
			{
				echo"<td> </td>";
			}
		}
if($currentPrivilege=="admin")
{
	if($privileges[$i]!="admin")
		{
			echo"
			<td>
			
			<form name=settingadmin action=SetNewAdmin.php method=POST>
			<input type=hidden name=setadminid value=".$id[$i].">
			<input type=submit value=Set>
			</form>
			</td> 
			<td>
			<form name devtool action=devTool.php method=POST>
			<input type=hidden name=devtool value=".$id[$i].">
			<input type=submit value='Force friend'>
			</form>
			</td>";
		}
else
	{
		echo"<td> </td>";
		echo"<td> </td>";
	}
}
}
echo "</tr>";
$i++;
  }
  echo "
	</table>
	";

echo "<a href=loggedinhomepage.php>Go back to homepage</a>";
?> 
</div>
</body>
</html>