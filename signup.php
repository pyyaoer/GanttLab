<?php
  session_start();
  if(isset($_SESSION['username'])){
	session_start();
	session_destroy();
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Bootstrap 101 Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="gantti/styles/css/screen.css" />
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
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
      font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
      font-size: 14px;
      line-height: 22px;
      background: #fdf6e3;
      color: #657b83;
      padding: 50px 0; }

    h2 {
      color: #b58900;
      font-weight: normal;
      margin-bottom: 10px; }

    </style>

    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
  </head>
  <body>

    <div class="container">

      <form class="form-signin" method="post" action="checksignup.php">
        <h2 class="form-signup-heading">Register</h2>
        <input type="text" name="username" class="input-block-level" placeholder="User name">
        <input type="password" name="passwd" class="input-block-level" placeholder="Password">
        <input type="text" name="email" class="input-block-level" placeholder="Email Address">
        <button class="btn btn-large btn-primary" name="submit" type="submit">Register</button>
        <button class="btn btn-large" name="signin" type="button"><a href="login.php" style="text-decoration:none">Sign in</a></button>
      </form>

    </div>

    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>