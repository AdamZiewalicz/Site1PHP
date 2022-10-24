<?php
session_start();
$mysqli = new mysqli("localhost","root","pass","forum");
include("connect.php");
$currentId=$_SESSION['CurrentUserId'];
$id=$currentId;
echo "<style> h3,h6{
  border: 1px #dddddd;
  padding: 8px;
}</style>";
if(isset($_POST['chooseChat']))
{$_SESSION['chooseChatReceiver']=$_POST['chooseChat'];
$ReceiverId=$_SESSION['chooseChatReceiver'];
}
if(isset($_SESSION['chooseChatReceiver']))
{
	$ReceiverId=$_SESSION['chooseChatReceiver'];
	
}
$MSG=array();
$sentbywho=array();
$MSGTIME=array();
$counter=0;
$sentToMeCounter=0;
$checkReceiverName="SELECT username,id FROM users WHERE id='$ReceiverId'";
if ($result = $mysqli -> query($checkReceiverName)) {
  while ($row = $result -> fetch_row()) {
	if($ReceiverId==$row[1]){$ReceiverName=$row[0];}
  }
  $result -> free_result();
}

//Checking Messages
$messagessentbyme=0;
$findMessages="SELECT content,Time,id FROM forum.chats WHERE ((id='$id' AND ReceiverId='$ReceiverId')OR(id='$ReceiverId' AND ReceiverId='$id')) ORDER BY Time";
if ($result = $mysqli -> query($findMessages)) {
  while ($row = $result -> fetch_row()) {
	if($row[2]==$id){$sentbywho[]="user";$MSG[]=$row[0];$MSGTIME[]=$row[1];$counter++;$messagessentbyme++;}
	if($row[2]==$ReceiverId){$sentbywho[]="Receiver";$MSG[]=$row[0];$MSGTIME[]=$row[1];$counter++;$sentToMeCounter++;}
  }
 
}//są messages osobno od receivera i ode mnie posortowane gdzie pierwsza jest najstarsza ostatnia najnowsza.

//Checking Messages

$HowManyMessagesToShow=0;
$perform=1;
if($sentToMeCounter>1)//jak bylo cos wyslane do mnie 
{
 $stmt = mysqli_prepare($mysqli, "UPDATE forum.lastmsgseen SET MessageNumber = ? WHERE (idUser = ? AND idChat = ?) ;");//change to by ID
			 mysqli_stmt_bind_param($stmt,"iii",$sentToMeCounter, $id ,$ReceiverId );
			 mysqli_stmt_execute($stmt); 
}
	else if($sentToMeCounter==1)
	{
		$checkIfInserted="SELECT idUser, idChat, MessageNumber FROM forum.lastmsgseen WHERE (idUser='$id' AND idChat='$ReceiverId')";
		if($result = $mysqli ->query($checkIfInserted))
		{
			while($row = $result -> fetch_row())
			{
				if($row[2]==1)
				{
					$perform=0;
				}
			}
			if($perform==1){$LastSeen="INSERT INTO forum.LastMSGSeen(idUser, idChat, MessageNumber) VALUES('$id','$ReceiverId','$sentToMeCounter');"; //jesli to pierwsza rzecz wyslana
			$Insert=mysqli_query($link,$LastSeen);	}
	
		}
		}
		
	






if($counter<=5)
{	if(!isset($_SESSION['MessagesToShow'])||$_SESSION['MessagesToShow']==0||$_SESSION['MessagesToShow']<=5)
	{$_SESSION['MessagesToShow']=$counter; }
	$HowManyMessagesToShow=$counter;
}else//jesli jest wiadomosci 5 lub mniej pokaz wszystkie
{	if(!isset($_SESSION['MessagesToShow'])||$_SESSION['MessagesToShow']==0)//jesli wiadomosci jest wiecej ale wyswietlane 1 raz pokaz 5
	{$_SESSION['MessagesToShow']=5;}
else //jesli wiecej niz 5 wiadomosci 
{																												
	if(isset($_POST['fiveMoreMsgs']))// jesli bylo poproszone o wiecej w ostatniej stronie a w sesji jest juz 5
	{	
		if(($counter-$_SESSION['MessagesToShow'])>=5) //jesli jest wiecej do wyswietlenia niz 5
		{
			$_SESSION['MessagesToShow']+=5;//wyswietl 5 wiecej
		}else 
		{
			$_SESSION['MessagesToShow']=$counter;
		}
	}else if(isset($_POST['fiveLessMsgs']))
	{	if(($_SESSION['MessagesToShow']-5)<5&&$counter>5)
	{$_SESSION['MessagesToShow']=5;}
else 
{		$_SESSION['MessagesToShow']-=5;}		
	}
}
}

if($_SESSION['MessagesToShow']!=$counter) //jesli pokazuje mniej niz wszystko 
{
echo"
<form align=center method=POST>
<input type=hidden name=fiveMoreMsgs value=5>
<input type=submit value='Show older messages'>
</form>

";}
if($_SESSION['MessagesToShow']>5)
{echo "
<form align=center method=POST>
<input type=hidden name=fiveLessMsgs value=5>
<input type=submit value='Show less messages'>
</form>
";
}
if(isset($_SESSION['MessagesToShow']))
{
	$HowManyMessagesToShow=$_SESSION['MessagesToShow'];
}

//$counter - liczba wiadomosci total
//$HowManyMessagesToShow - liczba do wyswietlenia.
//wyswietlam od $counter-$HowManyMessagesToShow do $counter 
if($result&&$HowManyMessagesToShow>5){	//jesli mam pokazac wiecej niz 5 wiadomosci 
for($i=$counter-$HowManyMessagesToShow;$i<$counter;$i++)
{
	if($sentbywho[$i]=="user")
	{
		echo"<div align=right> 
		<h3>".$MSG[$i]."</h3><h5>Sent at ".$MSGTIME[$i]." by me</h5><br/></div>";
	}else
		if($sentbywho[$i]=="Receiver")
		{
			echo"<div align=center>
		<h3>".$MSG[$i]."</h3><h5>Sent at ".$MSGTIME[$i]." by ".$ReceiverName."</h5><br/></div>";
			
		}
	
}
}else if($result&&$HowManyMessagesToShow>0&&$HowManyMessagesToShow<5)
{$i=0;
	while($i<$HowManyMessagesToShow)
	{if($sentbywho[$i]=="user")
	{
		echo"<div align=right> 
		<h3>".$MSG[$i]."</h3><h5>Sent at ".$MSGTIME[$i]."<br/> by me</h5></div>";
	}else
		if($sentbywho[$i]=="Receiver")
		{
			echo"<div align=center>
		<h3>".$MSG[$i]."</h3><h5>Sent at ".$MSGTIME[$i]." by ".$ReceiverName."</h5><br/></div>";
			
	}
	$i++;
	}
}else if($result&&$HowManyMessagesToShow==5)
{
	$i=$counter-5;
	while($i<$counter)
	{if($sentbywho[$i]=="user")
	{
		echo"<div align=right> 
		<h3>".$MSG[$i]."</h3><h5>Sent at ".$MSGTIME[$i]."<br/> by me</h5></div>";
	}else
		if($sentbywho[$i]=="Receiver")
		{
			echo"<div align=center>
		<h3>".$MSG[$i]."</h3><h5>Sent at ".$MSGTIME[$i]." by ".$ReceiverName."</h5><br/></div>";
			
	}
	$i++;
	}
}	
$_SESSION['LastMSGSeen']=$counter;
	$time = date('Y-m-d H:i:s');
	echo"
	<form align=right method=POST>
	<input type=text id=message name=message>
	<input type=submit value=Send>
	</form>
	<div align=right>
	<a href=loggedinhomepage.php >Go back to homepage</a><br/>
	<a href=chats.php>Go back to chats</a><br/></div>
	";
if(isset($_POST['message'])){
	$message=$_POST['message'];
	$insertmessage="INSERT INTO forum.chats(id, ReceiverId, Time, content) VALUES('$id','$ReceiverId',now(),'$message');";
$insertmessage=mysqli_query($link,$insertmessage);	
$messagessentbyme++;

if($messagessentbyme>1)//jak cos juz wyslalem wczesniej  
{
 $stmt = mysqli_prepare($mysqli, "UPDATE forum.messagessent SET MessageNumber = ? WHERE (idUser = ? AND idChat = ?) ;");
			 mysqli_stmt_bind_param($stmt,"iii",$messagessentbyme, $ReceiverId ,$id );
			 mysqli_stmt_execute($stmt); 
}
	//jesli wysylam w tym momencie pierwszą 
	else if($messagessentbyme==1)//jesli wysylam w tym momencie pierwszą 
	{$LastSent="INSERT INTO forum.messagessent(idUser, idChat, MessageNumber) VALUES('$ReceiverId','$id','$messagessentbyme');"; //jesli to pierwsza rzecz wyslana
	$Insert=mysqli_query($link,$LastSent);	}


$_SESSION['MessagesToShow']=0;
header("Location: chat.php");
}
	
?>