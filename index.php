<?php

require('gantti/lib/gantti.php'); 
require('mysql.php');

date_default_timezone_set('PRC');
setlocale(LC_ALL, '');

$project = "Auditory";
$person = "xiaoyang";
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

  <link rel="stylesheet" href="gantti/styles/css/screen.css" />
  <link rel="stylesheet" href="gantti/styles/css/gantti.css" />

  <!--[if lt IE 9]>
  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

</head>

<body>

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
