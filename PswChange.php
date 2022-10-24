<html>
<head><title>Password change</title></head>
<body>
<div align="center">
<h1>Motorcycles</h1>
<h2>Change your password</h2>
<?php 
session_start();
$userlogged="NO USER";
$userlogged = $_SESSION['CurrentUser'];
$userloggedid = $_SESSION['CurrentUserId'];

echo "Logged in as ".$userlogged."<br/>"
?>			

<form action="change.php" method="POST" align="center"> 
Current password: <input type="text" name="currpass" placeholder="Password" /><br/>
New password: <input type="password" name="newpassword" placeholder="Password"/><br/>
<input type="submit" name="Change" value="Change Password" />

</body>
</html>