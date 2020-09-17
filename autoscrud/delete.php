<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['delete']) && isset($_POST['autos_id']) ) {
  if (isset($_POST['delete']) == "Delete") {
   $_SESSION['id'] = $_POST['autos_id'];
   error_log("post delete ".$_SESSION['id']);
   header( 'Location: delete.php?autos_id='.$_POST['autos_id']) ;
   return;
  }
}

if (isset($_SESSION['id'])){
 $autos_id = $_SESSION['id'];
 error_log("session delete ".$autos_id);
 unset($_SESSION['id']);
 $stmt = $pdo->prepare("DELETE FROM autos WHERE autos_id = :zip");
 $stmt->execute(array(':zip' => $autos_id));
 $_SESSION["error"] = '<p style="color: green;">Record deleted</p>';
 header( "Location: index.php", true, 303 );
 return;
}

if ( ! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Missing user_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT make, autos_id FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( "Location: index.php", true, 303 );
    return;
}

?>
<p>Confirm: Deleting <?= htmlentities($row['make']) ?></p>

<form method="post">
<input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">
<input type="submit" value="Delete" name="delete">
<a href="index.php">Cancel</a>
</form>
