<?php
  session_start();

  if(!isset($_SESSION['person'])){
    header("location:signin.php");
  }
  require('gantti/lib/gantti.php');
  require('mysql.php');
  
  date_default_timezone_set('PRC');
  setlocale(LC_ALL, '');
  
  $person = $_SESSION['person'];
  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>GanttLab</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link rel="stylesheet" href="gantti/styles/css/gantti.css" />
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
        background: #fdf6e3;
      }
      h1 {
        font-size: 30px;
        margin-bottom: 10px;
        text-transform: uppercase;
        color: #d33682; }
  
      h2 {
        color: #b58900;
        font-weight: normal;
        margin-bottom: 10px; }
      </style>
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../assets/ico/favicon.png">
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="./index.php">GanttLab</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="./index.php">Home</a></li>
              <li class="active"><a href="./projects.php">Projects</a></li>
              <li><a href="./join.php">Join Project</a></li>
              <li><a href="./newpoj.php">Create Project</a></li>
            </ul>
            <form class="navbar-form pull-right" method="post" action="signout.php">
              <button type="submit" class="btn">Sign Out</button>
            </form>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

<?php

  $project = "Auditory";
  $mysql = new MySQL();
  
  $mysql->connect_mysql();
  
  $pojs = $mysql->show_projects($person);
  foreach($pojs as $project_id){
    $mysql->info_project($project_id, $project, $info);
    echo "<br/><br/>";
    echo "<header>";
    echo "<h1>".$project."</h1>";
    echo "<h2>".$info."</h2>";
    echo "</header>";
  
    $mysql->flush_project($project);
    $data = $mysql->show_events($project);
  
    if (sizeof($data) != 0){
      $gantti = new Gantti($data, array(
        'title'      => $project,
        'cellwidth'  => 25,
        'cellheight' => 35,
        'today'      => true
      ));
      echo $gantti;
    }
  }
  
  $mysql->close_mysql();
  
?>

    </div> <!-- /container -->

  </body>
</html>

