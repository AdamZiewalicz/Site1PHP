<?php 
include("connect.php");

$drop1= "DROP TABLE forum.users;";
$res= mysqli_query($link, $drop1	);
$drop2= "DROP TABLE forum.friends;";
$drop3= "DROP TABLE forum.privileges;";
$drop4= "DROP TABLE forum.passwords;";
$drop5= "DROP TABLE forum.chats;";
$drop6= "DROP TABLE forum.lastmsgseen;";
$drop7= "DROP TABLE forum.MessagesSent;";
$drop8= "DROP TABLE forum.threads;";
$resdrop5= mysqli_query($link,$drop5);
$resdrop2= mysqli_query($link,$drop2);
$resdrop4= mysqli_query($link,$drop4);
$resdrop3 = mysqli_query($link,$drop3);
$resdrop6=mysqli_query($link,$drop6);
$resdrop7 = mysqli_query($link, $drop7);
$resdrop8= mysqli_query($link, $drop8);
$res4= mysqli_query($link,$drop2);
if($res){echo "Table cleared<br/>";}
$sql2="CREATE TABLE forum.users(
id INT NOT NULL AUTO_INCREMENT,
username VARCHAR(100) NOT NULL,
PRIMARY KEY (id));
";
$sql6= "CREATE TABLE forum.passwords(
id INT NOT NULL AUTO_INCREMENT,
password VARCHAR(100) NOT NULL,
PRIMARY KEY (id));";
$res6=mysqli_query($link,$sql6);
$sql5="CREATE TABLE forum.privileges
(
id INT NOT NULL AUTO_INCREMENT,
Privileges VARCHAR(100),
AskingForPrivilege VARCHAR(100),
PRIMARY KEY (id)
);";
$sql3="CREATE TABLE forum.friends(
id INT NOT NULL,
Friend VARCHAR(100) NOT NULL,
StatusOrRequest VARCHAR(100))
;";
$sql8="CREATE TABLE forum.chats(
MsgId INT NOT NULL AUTO_INCREMENT,
id INT NOT NULL,
ReceiverId INT NOT NULL,
Time TIMESTAMP NOT NULL,
content VARCHAR(100),
PRIMARY KEY(MsgId)
);";
$sql9="CREATE TABLE forum.LastMSGSeen(
idUser INT NOT NULL,
idChat INT NOT NULL,
MessageNumber INT NOT NULL
);";
$sql10="CREATE TABLE forum.MessagesSent(
idUser INT NOT NULL,
idChat INT NOT NULL,
MessageNumber INT NOT NULL
);";
$sql11="
CREATE TABLE forum.threads
(
idThread INT NOT NULL AUTO_INCREMENT,
idUser INT NOT NULL,
Title VARCHAR(200),
Content VARCHAR(1000),

PRIMARY KEY(idThread)
)
;";
$res9=mysqli_query($link,$sql9);
$res8=mysqli_query($link,$sql8);
$res3=mysqli_query($link,$sql3);
$res2= mysqli_query($link, $sql2);
$res5 = mysqli_query($link, $sql5);
$res10=mysqli_query($link, $sql10);
if($res2){echo "Table ready to be used again<br/>";}
if($res3){echo "Friends table ready<br/>";}
$sql3="INSERT INTO forum.users(username)
VALUES ('admin');";
$sql7="INSERT INTO forum.passwords(password) VALUES ('admin');";
$res7=mysqli_query($link,$sql7);
$sql4="INSERT INTO forum.privileges(
Privileges, AskingForPrivilege
) VALUES ('admin','No');";

$res4= mysqli_query($link, $sql4);
$res3= mysqli_query($link, $sql3);
if($res3&&$res4){echo "admin account recreated successfully";}
echo "<br/>";
echo "<a href=loggedinhomepage.php>Go back to homepage</a>";
?> 