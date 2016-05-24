<?php

session_start();

$username = $_POST['username'];
$passwd = $_POST['passwd'];
$email = $_POST['email'];

require('mysql.php');
$mysql = new MySQL();
$mysql->connect_mysql();
$res = $mysql->new_person($username, $email, "", $passwd);
if($res == true){
  $_SESSION['person'] = $username;
}
$mysql->close_mysql();

header("location:index.php");

?>
