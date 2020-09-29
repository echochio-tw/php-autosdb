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
<?  require_once "head-link.php"; ?>
</head>
<body>
<div class="container">
<h1>Profile information</h1>
<p>First Name: <?php echo $row['first_name']; ?> </p>
<p>Last Name: <?php echo $row['last_name']; ?> </p>
<p>Email: <?php echo $row['email']; ?> </p>
<p>Headline:<br/> <?php echo $row['headline']; ?> </p>
<p>Summary:<br/><?php echo $row['summary']; ?> </p>
<?
// SELECT year,name FROM Education JOIN Institution ON Education.institution_id = Institution.institution_id WHERE profile_id = 18 ORDER BY rank
$stmt = $pdo->prepare("SELECT year,name FROM Education JOIN Institution ON Education.institution_id = Institution.institution_id WHERE profile_id = :prof ORDER BY rank");
$stmt->execute(array(":prof" => $_GET['profile_id']));
$rows = $stmt->fetchall(PDO::FETCH_ASSOC);
if ( $row != false ) {
  echo '<p>Education</p><ul>';
  foreach($rows as $row){
    echo '<li>'.$row['year'].':'.$row['name'].'</li>';
  }
  echo '</ul>';
}

$stmt = $pdo->prepare("SELECT * FROM Position where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$rows = $stmt->fetchall(PDO::FETCH_ASSOC);
if ( $row != false ) {
  echo '<p>Position</p><ul>';
  foreach($rows as $row){
    echo '<li>'.$row['year'].':'.$row['description'].'</li>';
  }
  echo '</ul>';
}
?>
<p>
</p>
<a href="index.php">Done</a>
</div>
</html>
