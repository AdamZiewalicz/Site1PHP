<?php

include("connect.php");
$sql="UPDATE friends SET StatusOrRequest ='0'";
$res=mysqli_query($link,$sql);

?>