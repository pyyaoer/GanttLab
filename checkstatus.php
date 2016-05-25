<?php
  session_start();

  if(!isset($_SESSION['person'])){
    header("location:signin.php");
  }

  require('mysql.php');
  $person = $_SESSION['person'];

  $mysql = new MySQL();
  $mysql->connect_mysql();
  foreach ($_POST['event'] as $event_id){
    $mysql->change_status($event_id);
  }
  $mysql->close_mysql();

  header("location:status.php");

?>

