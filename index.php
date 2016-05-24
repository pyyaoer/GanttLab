<?php

session_start();

if (!isset($_SESSION['person'])){
  header("location:login.php");
}

require('gantti/lib/gantti.php'); 
require('mysql.php');

date_default_timezone_set('PRC');
setlocale(LC_ALL, '');

$project = "Auditory";
$person = $_SESSION['person'];
$mysql = new MySQL();
$info = "";

$mysql->connect_mysql();

$mysql->info_project($project, $info);
$data = $mysql->show_events($project);

$mysql->close_mysql();

$gantti = new Gantti($data, array(
  'title'      => $project,
  'cellwidth'  => 25,
  'cellheight' => 35,
  'today'      => true
));

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

<header>

<?php

echo "<h1>".$project."</h1>";
echo "<h2>".$info."</h2>";

?>

</header>

<?php

echo $gantti;

?>


</body>

</html>
