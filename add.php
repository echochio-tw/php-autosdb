<?php
require_once "pdo.php";
session_start();
  if (isset($_POST['cancel'])) {
    if ($_POST['cancel'] == "Cancel") {
      $_SESSION['cancel'] = 'view';
      error_log("to view in post");
      header( "Location: {$_SERVER['REQUEST_URI']}", true, 303 );
    }
  }

  if (isset($_POST['add'])) {
    if ($_POST['add'] == "Add") {
      error_log("in post Add");
      if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])){
        unset($_SESSION["make"]);
        unset($_SESSION["year"]);
        unset($_SESSION["mileage"]);
        $_SESSION['make'] = htmlentities($_POST['make']);
        $_SESSION['year'] = htmlentities($_POST['year']);
        $_SESSION['mileage'] = htmlentities($_POST['mileage']);
        error_log("in post ".$_SESSION['make']);
        error_log("in post ".$_SESSION['year']);
        error_log("in post ".$_SESSION['mileage']);
        header( "Location: {$_SERVER['REQUEST_URI']}", true, 303 );
      }
    }
  }

if (isset($_SESSION['cancel'])) {
  unset($_SESSION["cancel"]);
  unset($_SESSION["error"]);
  error_log("to view in session");
  header( "Location: view.php", true, 303 );
}

if (!isset($_SESSION['email'])) {
  die("Not logged in");
}

if (isset($_SESSION['make']) && isset($_SESSION['year']) && isset($_SESSION['mileage'])){
  $mk =  $_SESSION['make'];
  $year =  $_SESSION['year'];
  $mileage = $_SESSION['mileage'];
  error_log("in session ".$_SESSION['make']);
  error_log("in session ".$_SESSION['year']);
  error_log("in session ".$_SESSION['mileage']);
  unset($_SESSION["make"]);
  unset($_SESSION["year"]);
  unset($_SESSION["mileage"]);
  if ($mk=='') {
    $_SESSION["error"] ='<p style="color: red;">Make is required</p>';
  } elseif (!is_numeric($year)) {
    $_SESSION["error"] = '<p style="color: red;">Mileage and year must be numeric</p>';
  } elseif (!is_numeric($mileage)) {
    $_SESSION["error"] = '<p style="color: red;">Mileage and year must be numeric</p>';
  } else{
    $stmt = $pdo->prepare('INSERT INTO autos  (make, year, mileage) VALUES ( :mk, :yr, :mi)');
    $stmt->execute(array(':mk' => $mk,':yr' => $year,':mi' => $mileage));
    $_SESSION["error"] = '<p style="color: green;">Record inserted</p>';
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: view.php');
  }
  error_log("in session".$_SESSION["error"]);
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
<h1>Tracking Autos for <?php echo $_SESSION['email']?></h1>
<?php
if (isset($_SESSION["error"]) ) {
  error_log("in html ".$_SESSION["error"]);
  echo($_SESSION["error"]);
  //unset($_SESSION["error"]);
}
?>
<form method="post">
<p>Make:
<input type="text" name="make" size="60"/></p>
<p>Year:
<input type="text" name="year"/></p>
<p>Mileage:
<input type="text" name="mileage"/></p>
<input type="submit" name="add" value="Add">
<input type="submit" name="cancel" value="Cancel">
</form>

</html>
