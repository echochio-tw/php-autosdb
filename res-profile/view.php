<?php
require_once "pdo.php";
session_start();

if (!isset($_SESSION['id_email'])) {
  die("ACCESS DENIED");
}

 if ( ! isset($_GET['profile_id']) ) {
    $_SESSION['error'] = "Missing profile_id";
    header('Location: index.php');
    return;
  }

$stmt = $pdo->prepare("SELECT * FROM Profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( "Location: index.php", true, 303 );
    return;
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Echochio Profile View</title>
<!-- bootstrap.php - this is HTML -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" 
    crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" 
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" 
    crossorigin="anonymous">

</head>
<body>
<div class="container">
<h1>Profile information</h1>
<p>First Name: <?php echo $row['first_name']; ?> </p>
<p>Last Name: <?php echo $row['last_name']; ?> </p>
<p>Email: <?php echo $row['email']; ?> </p>
<p>Headline:<br/> <?php echo $row['headline']; ?> </p>
<p>Summary:<br/><?php echo $row['summary']; ?> </p>
</p>
<a href="index.php">Done</a>
</div>
</html>
