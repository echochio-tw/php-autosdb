<?php
require_once "pdo.php";
session_start();
if ($_POST) {
  if (isset($_POST['logout'])) {
    if ($_POST['logout'] == "Logout") {
      $_SESSION['logout'] = 'logout';
    }
  }
  if (isset($_POST['add'])) {
    if ($_POST['add'] == "Add New") {
      $_SESSION['move'] = 'add';
      echo $_SESSION['move'];
    }
  }
  header( "Location: {$_SERVER['REQUEST_URI']}", true, 303 );
}

if (isset($_SESSION['logout'])){
  header( "Location: logout.php", true, 303 );
}

if (isset($_SESSION['move'])){
  unset($_SESSION['cancel']);
  unset($_SESSION['move']);
  unset($_SESSION["error"]);
  header( "Location: add.php", true, 303 );
}

if (!isset($_SESSION['email'])) {
  die("Not logged in");
}
$name = $_SESSION['email']; 
  $out = '';
  $stmt = $pdo->query("SELECT make, year, mileage FROM autos");
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $out = '';
  foreach ( $rows as $row ) {
    $out = $out.'<li>'.$row['year'].' '.$row['make'].' / '.$row['mileage'].'</li>';
  }
?>
<!DOCTYPE html>
<html>
<head>
<title>Echochio's Automobile Tracker 80de80d9</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
</head>
<body>
<div class="container">
<h1>Tracking Autos for <?php echo $name?></h1>
<?php 
if ( isset($_SESSION["error"]) ) {
  echo($_SESSION["error"]);
  unset($_SESSION["error"]);
}
?>
<h2>Automobiles</h2>
<ul>
<p>
</p>
<?php echo $out; ?>
</ul>
<p>
<a href="add.php">Add New</a> |
<a href="logout.php">Logout</a>
</p>
</form>
</html>
