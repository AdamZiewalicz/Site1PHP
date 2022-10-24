<?php
$database = array();
$database['host']="localhost";
$database['port']='3306';
$database['name']='forum';
$database['user']='root';
$database['password']='pass';

$link = mysqli_connect($database['host'], $database['user'], $database['password']);

?>
