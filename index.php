<?php

session_start();

if (!isset($_SESSION['person'])){
  header("location:login.php");
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
  
  <title>Gantt Lab</title>
  <meta charset="utf-8" />

  <link rel="stylesheet" href="gantti/styles/css/gantti.css" />
  <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

  <style type="text/css">
    body {
      font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
      font-size: 14px;
      line-height: 22px;
      background: #fdf6e3;
      color: #657b83;
      padding: 50px 0; }

    header, article {
      width: 500px;
      margin: 0 auto;
      padding: 50px 20px; }

    figure {
      font-size: 12px;
      line-height: 18px; }

    h1 {
      font-size: 30px;
      margin-bottom: 10px;
      text-transform: uppercase;
      color: #d33682; }

    h2 {
      color: #b58900;
      font-weight: normal;
      margin-bottom: 10px; }

    p {
      margin-bottom: 20px; }

    article {
      padding-bottom: 100px; }
  </style>

  <!--[if lt IE 9]>
  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

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
              <li class="">
                <a href="./index.php">Home</a>
              </li>
              <li class="">
                <a href="./index.php">Account</a>
              </li>
              <li class="">
                <a href="./index.php">New project</a>
              </li>
            </ul>
            <ul class="nav pull-right">
              <li class="">
                <a href="./logout.php">Logout</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>


<?php

$project = "Auditory";
$mysql = new MySQL();

$mysql->connect_mysql();

$pojs = $mysql->show_projects($person);
foreach($pojs as $project_id){
  $mysql->info_project($project_id, $project, $info);
  echo "<header>";
  echo "<h1>".$project."</h1>";
  echo "<h2>".$info."</h2>";
  echo "</header>";
  
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


</body>

</html>
