<?php
require_once "pdo.php";
session_start();

if (!isset($_SESSION['email'])) {
  die("ACCESS DENIED");
}

  if (isset($_POST['cancel'])) {
    if ($_POST['cancel'] == "Cancel") {
      $_SESSION['cancel'] = 'index';
      error_log("to index in post");
      header( "Location: {$_SERVER['REQUEST_URI']}", true, 303 );
      return;
    }
  }

  if (isset($_SESSION['cancel'])) {
    unset($_SESSION["cancel"]);
    unset($_SESSION["error"]);
    error_log("to index in session");
    header( "Location: index.php", true, 303 );
    return;
  }

  if (isset($_POST['add'])) {
    if ($_POST['add'] == "Add") {
      error_log("in post Add");
      if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])){
        $_SESSION['make'] = htmlentities($_POST['make']);
        $_SESSION['model'] = htmlentities($_POST['model']);
        $_SESSION['year'] = htmlentities($_POST['year']);
        $_SESSION['mileage'] = htmlentities($_POST['mileage']);
        header( "Location: add.php", true, 303 );
        return;
      }
    }
  }


if (isset($_SESSION['make']) && isset($_SESSION['model']) && isset($_SESSION['year']) && isset($_SESSION['mileage'])){
  $make =  $_SESSION['make'];
  $model = $_SESSION['model'];
  $year =  $_SESSION['year'];
  $mileage = $_SESSION['mileage'];
  unset($_SESSION["make"]);
  unset($_SESSION["model"]);
  unset($_SESSION["year"]);
  unset($_SESSION["mileage"]);
  unset($_SESSION["error"]);
  if (($make=='') || ($model=='') || ($year=='') || ($mileage=='')) {
    $_SESSION["error"] ='<p style="color: red;">All fields are required</p>';
    } elseif (!is_numeric($year)) {
      $_SESSION["error"] = '<p style="color: red;">Year must be numeric</p>';
    } elseif (!is_numeric($mileage)) {
      $_SESSION["error"] = '<p style="color: red;">Mileage must be numeric</p>';
    } else{
    $stmt = $pdo->prepare('INSERT INTO autos (make, model, year, mileage) VALUES ( :mk, :mo, :yr, :mi)');
    $stmt->execute(array(':mk' => $make, ':mo' =>$model, ':yr' => $year,':mi' => $mileage));
    $_SESSION["error"] = '<p style="color: green;">Record added</p>';
    header( "Location: index.php", true, 303 );
    return;
  }
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Echochio Automobile Tracker 7b923ff2</title>

<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" 
    crossorigin="anonymous">

<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" 
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" 
    crossorigin="anonymous">

<link rel="stylesheet" 
    href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css">

<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>

<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
  integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
  crossorigin="anonymous"></script>

</head>
<body>
<div class="container">
<h1>Tracking Automobiles for <a>
<?php
echo $_SESSION["email"];
echo '</a></h1>';
if (isset($_SESSION["error"]) ) {
  error_log("in html ".$_SESSION["error"]);
  echo($_SESSION["error"]);
}

?>
<form method="post">
<p>Make:
<input type="text" name="make" size="40"/></p>
<p>Model:
<input type="text" name="model" size="40"/></p>
<p>Year:
<input type="text" name="year" size="10"/></p>
<p>Mileage:
<input type="text" name="mileage" size="10"/></p>

<input type="submit" name='add' value="Add">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
</div>
</html>
