<?php
require_once "pdo.php";
session_start();
require_once "validatePos.php";

if (!isset($_SESSION['id_email'])) {
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
      error_log("in post save");
      if (isset($_POST['first_name']) && isset($_POST['last_name']) && 
          isset($_POST['email']) && isset($_POST['headline'])  && 
          isset($_POST['summary']) ) {
          $a = validatePos();
          if (is_string($a)){
            $_SESSION['error'] = $a;
            return; 
          }
        $_SESSION['first_name'] = htmlentities($_POST['first_name']);
        $_SESSION['last_name'] = htmlentities($_POST['last_name']);
        $_SESSION['email'] = htmlentities($_POST['email']);
        $_SESSION['headline'] = htmlentities($_POST['headline']);
        $_SESSION['summary'] = htmlentities($_POST['summary']);
        $_SESSION['profile_id'] = htmlentities($_POST['profile_id']);
        error_log("add post ".$_SESSION['email']);
        header( "Location: add.php", true, 303 );
        return;
      }
    }
  }


if (isset($_SESSION['first_name']) && isset($_SESSION['last_name']) && isset($_SESSION['email']) 
  && isset($_SESSION['headline']) && isset($_SESSION['summary'])) {
  $ui = $_SESSION['user_id'];
  $fn = $_SESSION['first_name'];
  $ln = $_SESSION['last_name'];
  $em = $_SESSION['email'];
  $he = $_SESSION['headline'];
  $su = $_SESSION['summary'];
  $pro = $_SESSION['profile_id'];
  $profile_id = $pro;
  unset($_SESSION['first_name']);
  unset($_SESSION["last_name"]);
  unset($_SESSION["email"]);
  unset($_SESSION["headline"]);
  unset($_SESSION["summary"]);
  unset($_SESSION["error"]);
  if ( ($fn=='') || ($ln=='') || ($em=='') || ($he=='') || ($su=='') ) {
      $_SESSION["error"] ='<p style="color: red;">All fields are required</p>';
    } elseif  (strpos($em, '@') == false) {
      $_SESSION["error"] = '<p style="color: red;">Email address must contain @</p>';
    } else{
    $stmt = $pdo->prepare('UPDATE Profile SET user_id = :ui, first_name=:fn, last_name=:ln, email=:em, headline=:he, summary=:su WHERE profile_id=:id');
    $stmt->execute(array(':ui' => $ui, ':fn' => $fn, ':ln' => $ln, ':em' => $em, ':he' => $he, ':su' => $su, ':id' => $pro));
    // $profile_id = $pdo->lastInsertId();
    for($i=1; $i<=9; $i++) {
      if ( ! isset($_SESSION['year'.$i]) ) continue;
      if ( ! isset($_SESSION['desc'.$i]) ) continue;
      $stmt = $pdo->prepare('UPDATE Position SET (rank = :rank , year = :year , description = :desc WHERE profile_id = :pid');
      $stmt->execute(array(':pid' => $profile_id, ':rank' => $i, ':year' => $_SESSION['year'.$i],':desc' => $_SESSION['desc'.$i]));
      unset($_SESSION['year'.$i]);
      unset($_SESSION['desc'.$i]);
    }  
    $_SESSION["error"] = '<p style="color: green;">Record update</p>';
    header( "Location: index.php", true, 303 );
    return;
  }
}

if (isset($_GET['profile_id'])){
  $_SESSION['profile_id'] = $_GET['profile_id'];
  $stmt = $pdo->prepare("SELECT * FROM Profile where profile_id = :xyz");
  $stmt->execute(array(":xyz" => $_GET['profile_id']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( "Location: index.php", true, 303 );
    return;
}
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Echochio Automobile Tracker 9ada6f78</title>

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
<h1>Editing Profile for <? echo $_SESSION["user_name"]; ?></h1>
<?php
if (isset($_SESSION["error"]) ) {  
  error_log("in html ".$_SESSION["error"]);
  echo($_SESSION["error"]);
} ?>
<form method="post" action="edit.php">
<p>First Name: <input type="text" name="first_name" size="60" value="<? echo $row['first_name']; ?>"/></p>
<p>Last Name: <input type="text" name="last_name" size="60" value="<? echo $row['last_name']; ?>" /></p>
<p>Email: <input type="text" name="email" size="30" value="<? echo $row['email']; ?>"/></p>
<p>Headline:<br/><input type="text" name="headline" size="80" value="<? echo $row['headline']; ?>"/></p>
<p>Summary:<br/><textarea name="summary" rows="8" cols="80"><? echo $row['summary']; ?></textarea><p>
<p> <input type="hidden" name="profile_id" value="<? echo $row['profile_id']; ?>"/>
Position: <input type="submit" id="addPos" value="+">
<div id="position_fields">
</div>
</p>
<p>
<input type="submit" name="save" value="Save">
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
<?php require_once "javascript-add.php"; ?>
</body>