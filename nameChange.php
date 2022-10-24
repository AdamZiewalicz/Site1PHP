<html>
<head><title>Name change</title></head>
<body>
<div align="center">
<h1>Motorcycles</h1>
<h2>Change your name</h2>
<?php 
session_start();
$userlogged="NO USER";
$userlogged = $_SESSION['CurrentUser'];
$userloggedid = $_SESSION['CurrentUserId'];

echo "Logged in as ".$userlogged."<br/>"
?>			

<form action="changename.php" method="POST" align="center"> 
Password: <input type="password" name="password" placeholder="Password" /><br/>
New name: <input type="text" name="newname" placeholder="New name"/><br/>
<input type="submit" name="Change" value="Change name" />
<a href="loggedinhomepage.php">Go back to homepage</a>

</body>
</html>