<?php
  session_start();

  if(!isset($_SESSION['person'])){
    header("location:signin.php");
  }

  require('mysql.php');
  $person = $_SESSION['person'];
  $project = $_POST['pojname'];
  $event = $_POST['eventname'];

  $mysql = new MySQL();
  $mysql->connect_mysql();
  $res = $mysql->new_pp($person, $project);
  $ress = $mysql->new_pe($person, $event, $project);
  $mysql->close_mysql();

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

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

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
              <li><a href="./index.php">Home</a></li>
              <li><a href="./projects.php">Projects</a></li>
              <li class="active"><a href="./join.php">Join Project</a></li>
              <li><a href="./newpoj.php">Create Project</a></li>
              <li><a href="./status.php">Change Status</a></li>
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
  if ($ress == true && res == true){
      echo "<div class='alert alert-success'>";
      echo "<button type='button' class='close' data-dismiss='alert'>×</button>";
      echo "Successfully join Event ".$event." @ Project ".$project."!";
      echo "<div>";
  } else if ($res == true){
      echo "<div class='alert alert-block'>";
      echo "<button type='button' class='close' data-dismiss='alert'>×</button>"
;
      echo "Successfully join Project ".$project.", but have some errors while joining Event ".$event."!";
      echo "<div>";
  } else{
      echo "<div class='alert alert-error'>";
      echo "<button type='button' class='close' data-dismiss='alert'>×</button>";
      echo "Cannot join Project ".$project."!";
      echo "<div>";
  }

?>

    </div> <!-- /container -->

  </body>
</html>

