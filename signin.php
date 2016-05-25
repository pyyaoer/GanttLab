<?php
  session_start();

  if(isset($_SESSION['person'])){
    header("location:index.php");
  }
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
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
        background: #fdf6e3;
      }
      .hero-unit {
        background: #ffebcd;
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
              <li class="active"><a href="./index.php">Home</a></li>
              <li><a href="./projects.php">Projects</a></li>
              <li><a href="./join.php">Join Project</a></li>
              <li><a href="./newpoj.php">Create Project</a></li>
              <li><a href="./status.php">Change Status</a></li>
            </ul>
            <form class="navbar-form pull-right" method="post" action="checksignin.php">
              <input class="span2" type="text" name="username" placeholder="Username">
              <input class="span2" type="password" name="passwd" placeholder="Password">
              <button type="submit" class="btn">Sign in</button>
              <button type="button" class="btn"><a href="signup.php" style="text-decoration:none">Sign up</a></button>
            </form>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Gantt Lab</h1>
        <p>A Gantt chart is a type of bar chart, adapted by Karol Adamiecki in 1896 and independently by Henry Gantt in the 1910s, that illustrates a project schedule. Gantt charts illustrate the start and finish dates of the terminal elements and summary elements of a project. Modern Gantt charts also show the dependency (i.e., precedence network) relationships between activities.</p>
       <p>This is a Gantt Lab for a common usage. Just manage your life in a Gantt way!</p>
       <p><a href="https://en.wikipedia.org/wiki/Gantt_chart" class="btn btn-primary btn-large">Learn more &raquo;</a></p>
      </div>

      <!-- Example row of columns -->
      <div class="row">
        <div class="span4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
        <div class="span4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
       </div>
        <div class="span4">
          <h2>Heading</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
          <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
      </div>

    </div> <!-- /container -->

  </body>
</html>

