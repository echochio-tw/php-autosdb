<?php
require_once "pdo.php";
session_start();

if (!isset($_SESSION['id_email'])) {
  die("ACCESS DENIED");
}

if ( isset($_POST['delete']) && isset($_POST['profile_id']) ) {
  if ($_POST['delete'] == "Delete") {
   $_SESSION['profile_id'] = $_POST['profile_id'];
   $_SESSION['delete'] = 'delete';
   // error_log("post delete ".$_SESSION['profile_id']);
   header( 'Location: delete.php') ;
   return;
  }
}

if (isset($_SESSION['profile_id']) && isset($_SESSION['delete'])){
 unset ($_SESSION['delete']);
 $profile_id = $_SESSION['profile_id'];
 error_log("session delete ".$profile_id);
 unset($_SESSION['profile_id']);
 $stmt = $pdo->prepare("DELETE FROM Profile WHERE profile_id = :zip");
 $stmt->execute(array(':zip' => $profile_id));
 $_SESSION["error"] = '<p style="color: green;">Profile deleted</p>';
 header( "Location: index.php", true, 303 );
 return;
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
<?  require_once "head-link.php"; ?>
</head>
<body>
<div class="container">
<p>Confirm: Deleting 
<?php
echo '<p></p>';
echo 'first_name : '.$row['first_name'];
echo '<p></p>';
echo 'last_name : '.$row['last_name'];
?></p>

<form method="post">
<input type="hidden" name="profile_id" value="<?= $row['profile_id'] ?>">
<input type="submit" value="Delete" name="delete">
<a href="index.php">Cancel</a>
</form>
</body>