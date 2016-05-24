<?php

session_start();

$username = $_POST['username'];
$passwd = $_POST['passwd'];

require('mysql.php');
$mysql = new MySQL();
$mysql->connect_mysql();
$res = $mysql->has_person($username, $passwd);
$mysql->close_mysql();

if($res == true){
  $_SESSION['person'] = $username;
}
header("location:index.php");

?>
