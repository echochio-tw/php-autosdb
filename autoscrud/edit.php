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

  if (isset($_POST['save'])) {
    if ($_POST['save'] == "Save") {
      error_log("in post Save");
      if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'] )){
        $_SESSION['make'] = htmlentities($_POST['make']);
        $_SESSION['model'] = htmlentities($_POST['model']); 
        $_SESSION['year'] = htmlentities($_POST['year']);
        $_SESSION['mileage'] = htmlentities($_POST['mileage']);
        $_SESSION['autos_id'] = htmlentities($_POST['autos_id']);
        error_log("in post ".$_SESSION['make']);
        error_log("in post ".$_SESSION['model']);
        error_log("in post ".$_SESSION['year']);
        error_log("in post ".$_SESSION['mileage']);
        error_log("in post ".$_SESSION['autos_id']);
        header( "Location: edit.php", true, 303 );
        return;
      }
    }
  }

  if (isset($_SESSION['autos_id']) && isset($_SESSION['make']) && isset($_SESSION['model']) && isset($_SESSION['year']) && isset($_SESSION['mileage'])){
    $id = $_SESSION['autos_id'];
    $make =  $_SESSION['make'];
    $model = $_SESSION['model'];
    $year =  $_SESSION['year'];
    $mileage = $_SESSION['mileage'];
    error_log("in session make ".$id);
    error_log("in session make ".$make);
    error_log("in session model ".$model);
    error_log("in session year ".$year);
    error_log("in session mileage ".$mileage);
    unset($_SESSION["autos_id"]);
    unset($_SESSION["make"]);
    unset($_SESSION["model"]);
    unset($_SESSION["year"]);
    unset($_SESSION["mileage"]);
    //unset($_SESSION["error"]);
    if (($make=='') || ($model=='') || ($year=='') || ($mileage=='')) {
      error_log("All fields are required");
      $_SESSION["error"] ='<p style="color: red;">All fields are required</p>';
      header( "Location: edit.php?autos_id=".$id, true, 303 );
      return;
      } elseif (!is_numeric($year)) {
        error_log("Year must be numeric");
        $_SESSION["error"] = '<p style="color: red;">Year must be numeric</p>';
        header( "Location: edit.php?autos_id=".$id, true, 303 );
        return;
      } elseif (!is_numeric($mileage)) {
        error_log("Mileage must be numeric");
        $_SESSION["error"] = '<p style="color: red;">Mileage must be numeric</p>';
        header( "Location: edit.php?autos_id=".$id, true, 303 );
        return;
      } else{
      $stmt = $pdo->prepare("UPDATE autos SET make=:mk,  model=:mo, year=:yr, mileage=:mi WHERE autos_id=:id");
      $stmt->execute(array(':mk' => $make, ':mo' =>$model, ':yr' => $year, ':mi' => $mileage, ':id' => $id));
      $_SESSION["error"] = '<p style="color: green;">Record updated</p>';
      error_log("Record updated");
      header( "Location: index.php", true, 303 );
      return;
    }
    error_log("in session".$_SESSION["error"]);
  }

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = '<p style="color: red;">Bad value for id</p>';
  header( "Location: index.php", true, 303 );
  return;
} else {
  $stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
  $stmt->execute(array(":xyz" => $_GET['autos_id']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if ( $row === false ) {
    $_SESSION['error'] = '<p style="color: red;">Bad value for id</p>';
    header( "Location: index.php", true, 303 );
    return;
  }
}
// Flash pattern

$mk = htmlentities($row['make']);
$mo = htmlentities($row['model']);
$ye = htmlentities($row['year']);
$mi = htmlentities($row['mileage']);
$id = $row['autos_id'];
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
<h1>Editing Automobile</h1>
<?php
if (isset($_SESSION["error"]) ) {  
  error_log("in html ".$_SESSION["error"]);
  echo($_SESSION["error"]);
} ?>
<form method="post">
<p>Make<input type="text" name="make" size="40"  value="<?= $mk ?>"></p>
<p>Model<input type="text" name="model" size="40" value="<?= $mo ?>"></p>
<p>Year<input type="text" name="year" size="10" value="<?= $ye ?>"></p>
<p>Mileage<input type="text" name="mileage" size="10" value="<?= $mi ?>"></p>
<input type="hidden" name="autos_id" value="<?= $id ?>">
<input type="submit" name="save" value="Save">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
</div>
</body>
</html>