<?php
require_once "pdo.php";
$error = '';

if (isset($_POST['logout'])) {
  if ($_POST['logout'] == "Logout") {
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: index.php');
  }
}

if (!isset($_GET['name'])) {
  die("Name parameter missing");
}
else{
  $name =  $_GET['name'];
  if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
    $mk =  htmlentities($_POST['make']);
    $year =  htmlentities($_POST['year']);
    $mileage = htmlentities($_POST['mileage']);
    if ($mk=='') {
      $error = '<p style="color: red;">Make is required</p>';
    } elseif (!is_numeric($year)) {
      $error = '<p style="color: red;">Mileage and year must be numeric</p>';
    } elseif (!is_numeric($mileage)) {
      $error = '<p style="color: red;">Mileage and year must be numeric</p>';
    } else {
      $stmt = $pdo->prepare('INSERT INTO autos  (make, year, mileage) VALUES ( :mk, :yr, :mi)');
      $stmt->execute(array(':mk' => $mk,':yr' => $year,':mi' => $mileage));
      $error = '<p style="color: green;">Record inserted</p>';
      }
    }
  }
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
<title>Echochio's Automobile Tracker 25315d7e</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
</head>
<body>
<div class="container">
<h1>Tracking Autos for <?php echo $name?></h1>
<?php echo $error; ?>
<form method="post">
<p>Make:
<input type="text" name="make" size="60"/></p>
<p>Year:
<input type="text" name="year"/></p>
<p>Mileage:
<input type="text" name="mileage"/></p>
<input type="submit" value="Add">
<input type="submit" name="logout" value="Logout">
</form>

<h2>Automobiles</h2>
<ul>
<p>
</p>
<?php echo $out; ?>
</ul>
</html>
